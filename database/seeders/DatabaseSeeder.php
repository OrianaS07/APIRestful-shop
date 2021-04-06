<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\ProductObserver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Product::truncate();
        Category::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Product::flushEventListeners();
        Category::flushEventListeners();
        Transaction::flushEventListeners();

        $this->call(RoleSeeder::class);

        User::factory(100)->create();

        $productos = Product::factory(300)->create();
        Transaction::factory(200)->create();
        Category::factory(30)->create();

        foreach($productos as $producto){
            $producto->categories()->attach(
                rand(1,5)
            );
        }        
                
        
    }
}
