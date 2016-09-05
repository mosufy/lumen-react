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
            'uid'         => 'c79be7ff-599b-35cd-a271-c497dd1d65ad',
            'title'       => 'Learn to draw',
            'description' => 'Learn to draw an animal',
            'category_id' => 1,
            'user_id'     => 1
        ]);

        factory(App\Models\Todo::class)->create([
            'uid'         => 'aaae67d2-fe5c-32ae-b73e-88cc38775e32',
            'title'       => 'Learn french',
            'description' => 'Learn another language',
            'category_id' => 1,
            'user_id'     => 1
        ]);

        factory(App\Models\Todo::class)->create([
            'uid'         => 'e3ef6b87-2817-3c6a-be30-2aab3748c779',
            'title'       => 'Cook a meal',
            'description' => 'Cook a meal for my family',
            'category_id' => 2,
            'user_id'     => 1
        ]);
    }
}
