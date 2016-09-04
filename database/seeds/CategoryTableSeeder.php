<?php
/**
 * Class CategoryTableSeeder
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Illuminate\Database\Seeder;

/**
 * Class CategoryTableSeeder
 *
 * Seed category table
 */
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed default categories to use in Postman / Unit Testing
        factory(App\Models\Category::class)->create([
            'name'        => 'Learning',
            'description' => 'learning',
            'user_id'     => 1
        ]);

        factory(App\Models\Category::class)->create([
            'name'        => 'Cooking',
            'description' => 'coking',
            'user_id'     => 1
        ]);

        factory(App\Models\Category::class)->create([
            'name'        => 'Teaching',
            'description' => 'teaching',
            'user_id'     => 1
        ]);
    }
}
