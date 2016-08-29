<?php
/**
 * Class OAuthClientTableSeeder
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Illuminate\Database\Seeder;

/**
 * Class OAuthClientTableSeeder
 *
 * Seeds OAuth Table.
 */
class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed app client 1
        factory(App\Models\OAuthClient::class)->create([
            'id'     => '6fC2745co07D4yW7X9saRHpJcE0sm0MT',
            'secret' => 'KLqMw5D7g1c6KX23I72hx5ri9d16GJDW',
            'name'   => 'App 1'
        ]);

        // Seed app client 2
        factory(App\Models\OAuthClient::class)->create([
            'id'     => '4dJn65Dwvau4cj97a9BFEGrpJPl5E4t3',
            'secret' => '8d5LY0WDd4S26Wlbgb6JFcvh0OJ52ENu',
            'name'   => 'App 2'
        ]);
    }
}
