<?php

use Illuminate\Database\Seeder;

class BWRealtionsTableSeeder extends Seeder
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
        for($i=0;$i<30;$i++){
         $data[$i] = [
          'book_id' => $faker->numberBetween($min = 31, $max = 60),
          'writer_id' => $faker->numberBetween($min = 1, $max = 10)
         ];
        }
        DB::table('bw_relations')->insert($data);
    }
}
