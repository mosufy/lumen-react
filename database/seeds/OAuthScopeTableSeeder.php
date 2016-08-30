<?php
/**
 * Class OAuthScopeTableSeeder
 *
 * @date      30/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Illuminate\Database\Seeder;

/**
 * Class OAuthScopeTableSeeder
 *
 * Seeds OAuth Table.
 */
class OAuthScopeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\OAuthScope::class)->create([
            'id'          => 'role.app',
            'description' => 'App Role'
        ]);

        factory(App\Models\OAuthScope::class)->create([
            'id'          => 'role.user',
            'description' => 'User Role'
        ]);
    }
}
