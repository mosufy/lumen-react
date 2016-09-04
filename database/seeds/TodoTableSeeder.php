<?php
/**
 * Class TodoTableSeeder
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Illuminate\Database\Seeder;

/**
 * Class TodoTableSeeder
 *
 * Seed todos table
 */
class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed default Todos to use in Postman / Unit Testing
        factory(App\Models\Todo::class)->create([
            'title'       => 'Learn to draw',
            'description' => 'Learn to draw an animal',
            'category_id' => 1,
            'user_id'     => 1
        ]);

        factory(App\Models\Todo::class)->create([
            'title'       => 'Learn french',
            'description' => 'Learn another language',
            'category_id' => 1,
            'user_id'     => 1
        ]);

        factory(App\Models\Todo::class)->create([
            'title'       => 'Cook a meal',
            'description' => 'Cook a meal for my family',
            'category_id' => 2,
            'user_id'     => 1
        ]);
    }
}
