<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('products')->truncate();


        $isimler=['Furkan','Ahmet','Arslan','İsmail','Kamil'];
        $faker= Faker::create();
        for($i=0; $i<=10; $i++) {
            DB::table('products')->insert([
                 
                'name'=>$faker->name,   //faker kütüp. isim ekler
                'slug'=>$faker->name,
                'description' =>$faker->text,
                'price'=>rand(18,60),
            
      
              ]);

        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
