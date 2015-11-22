<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(UsersTableSeeder::class);

        //Model::reguard();
        /*
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'created_at' => date('m-d-Y'),
            'updated_at' => date('m-d-Y'),
        ]);
        */

        //CUSTOMERS
        /*
        $faker = Faker::create();
            foreach (range(1,10) as $index) {
                DB::table('customers')->insert([
                    'first_name' => ucfirst($faker->firstname),
                    'last_name' => ucfirst($faker->lastName),
                    'email' => $faker->email,
                    'address' => ucfirst($faker->city .', '. $faker->city),
                    'created_at' => date('m-d-Y'),
                    'updated_at' => date('m-d-Y'),
                ]);
            }
        */

        //PRODUCTS
        /*        
        $i = 0;
        for($i=0; $i<=59;$i++) {
            DB::table('products')->insert([
                'sku' => strtoupper(str_random(10)),
                'product_name' => $this->getRandomWord(15),
                'product_description' => $this->getRandomWord(60),
                'stock_level' => rand(10, 60),
                'low_level_stock' => 5,
                'bin_location' =>strtoupper(str_random(3)),
                'created_at' => date('m-d-Y'),
                'updated_at' => date('m-d-Y'),
            ]);            
        }    
        */
        /*
        $faker = Faker::create();
            $x=1;
            foreach (range(1,10) as $index) {
                DB::table('products')->insert([
                    'sku' => strtoupper(str_random(10)),
                    'product_name' => ucfirst($faker->city .' '. $faker->city),
                    'product_description' => ucfirst($faker->paragraph),
                    'stock_level' => rand(10, 60),
                    'low_level_stock' => 5,
                    'bin_location' =>'F'.$x,                    
                    'created_at' => date('m-d-Y'),
                    'updated_at' => date('m-d-Y'),
                ]);
            $x++; 
            }
        */

    }

    public function getRandomWord($len = 60) {
        if ($len <= 15) {
            $word = array_merge(range('a', 'z'), range('A', 'Z'));
            shuffle($word);
            return substr(implode($word), 0, $len);
        } else {
            $newstr = str_shuffle('The quick brown fox jumps over the lazy dog does the moon shine on Paris');    
            return  $newstr;       
        }
    }  

}

