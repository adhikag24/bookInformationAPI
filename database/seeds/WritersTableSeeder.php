<?php

use Illuminate\Database\Seeder;

class WritersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $faker = Faker\Factory::create();
        for($i=0;$i<10;$i++){
         $data[$i] = [
          'writer_name' => $faker->name
         ];
        }
        DB::table('writers')->insert($data);
    }
}
