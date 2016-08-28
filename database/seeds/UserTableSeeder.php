<?php
/**
 * Class UserTableSeeder
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder
 *
 * Seeds users table.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed default user to use in Postman / Unit Testing
        factory(App\Models\User::class)->create([
            'email' => 'email@mail.com',
            'name'  => 'User A',
            'uid'   => '6cb5db55-3f7a-46f8-9e1d-da47ddce7f86'
        ]);

        // Create other sandbox users
        factory(App\Models\User::class, 3)->create();
    }
}
