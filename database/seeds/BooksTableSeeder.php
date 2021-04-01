<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
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
          'book_title' => $faker->realText($maxNbChars = 200, $indexSize = 2),
          'book_page' => $faker->numberBetween($min = 100, $max = 1000),
          'book_release' => $faker->dateTime($max = 'now', $timezone = null),
          'book_contents' => $faker->text($maxNbChars = 100),
          'writer_id' => $faker->numberBetween($min = 1, $max = 10),
         ];
        }
        DB::table('books')->insert($data);
    }
}
