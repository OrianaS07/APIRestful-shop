<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\User as UserResource;
use App\Mail\UserCreatedMailable;
use App\Mail\PasswordRecoverMailable;
use App\Mail\NewPasswordMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    // mostrar un usuario
    public function index(){
        return new UserCollection(User::paginate());
    }

    //Verifica si el usuario esta autentificado - JWT
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!$validator->fails()){
           try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return $this->errorResponse('invalid_credentials',400) ;
                }
            } catch (JWTException $e) {
                return $this->errorResponse('could_not_create_token',500);
                
            } 
        }
            
        return response()->json(compact('token'));
    }
    
    public function verify($token){
        $user = User::where('verification_token',$token)->firstOrFail();
        $user->verified = User::USUARIO_VERIFICADO;
        $user->verification_token = null;

        $user->save();
        $user->assignRole('user');
        return $this->showMenssage('The account was successfully verified');
    }

    // registra o crea un usuario y crea el token JWT
    public function register(Request $request){
        $validated =  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // si hay un error laravel envia automarticamente
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'verified' => User::USUARIO_NO_VERIFICADO,
            'verification_token' => User::generarVerificationToken()
        ]);

        //$token = JWTAuth::fromUser($user);
        $userR = new UserResource($user);
        return $this->showOne($userR);
    }

    // Muestra el Usuario
    public function show(User $user){
        $usu = new UserResource($user);
        return $this->showOne($usu,201);
    }

    //Verifica si el usuario ingrasado existe y retorna un ususario - JWT
    public function getAuthenticatedUser(){
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->errorResponse('user_not_found', 404);
            }
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('token_expired', $e);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('token_invalid', $e);
        } catch (JWTException $e) {
            return $this->errorResponse('token_absent', $e);
        }
            return response()->json(compact('user'));
    }
    
    //Actualiza el ususario
    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'. $user->id,
            'password' => 'string|min:6|confirmed',
        ]);

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }
        
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if(!$user->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $user->save();
        return $this->showOne(new UserResource($user));

    }

    //Elimina el usuario
    public function destroy(User $user){
        $user->delete();
        $userR = new UserResource($user);
        return $this->showOne($userR,204);
    }

    public function resend(User $user){
        if($user->esVerificado()){
            return $this->errorResponse('Este usuario ya ha sido verificado',400);
        }

        retry(5, function () use ($user){
            Mail::to($user)->send(new UserCreatedMailable($user));
        }, 100);
        

        return $this->showMenssage('El correo de Verficacion se ha reenviado');
    }   
    // REFRESCAR EL TOKEN jwt
    public function refresToken(){
        $token = JWTAuth::getToken();
        try {

            $token = JWTAuth::refresh($token);
            return response()->json(compact('token'));

        } catch (TokenExpiredException $e) {
            return $this->errorResponse('token_expired', 401);
        } catch (TokenBlacklistedException $e) {
            return $this->errorResponse('Need_to_login_again', 422);
        }
    }

    // rompimiento del token JWT
    public function logout(){
        $token = JWTAuth::getToken();

        try {
            JWTAuth::Invalidate($token);
            return $this->showMenssage('Logout successful',200);
        } catch (JWTException $e) {
            return $this->errorResponse('Failed logout',422);
        }
    }

    public function emailRecover(Request $request)
    {
        $credentials = $request->only('email');
        
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
        ]);
        
        if(!$validator->fails()){
           
           $user = User::where('email', $request->email)->first();
           $code = rand(100000,999999);
           $u = User::find($user->id);
           $u->password_code = $code;
           $u->save();
            if($u){
                Mail::to($user)->send(new PasswordRecoverMailable($u));
                return $this->showMenssage('Correo de recuperación enviado');
            }else{
                return $this->showMenssage('Este correo no se encuentra registrado');
            }
        }
    }

    public function resetPassword(Request $request, User $user)
    {
        $credentials = $request->only('email','code');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'code' => 'required|min:6'
        ]);
        
        if(!$validator->fails()){
            
                $new_password = Str::random(8);
                $user->password = Hash::make($new_password);
                $user->password_code = null;
                
                if($user->save()){
                    // se envia correo de que la contraseña ha sido cambida y se envia la contraseña
                    Mail::to($user)->send(new NewPasswordMailable($user,$new_password));
                    return $this->showMenssage('New Password send');
                }else{
                    return $this->showMenssage('No se ha podido restablecer la contraseña');
                }      
                       
        }
  
    }

}
