<?php

/**
 * Class AccountCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use \Codeception\Util\Fixtures;

class AccountCest
{
    protected $client_access_token, $user_access_token;

    public function _before(ApiTester $I)
    {
        $I->sendPOST('/oauth/access_token/client', [
            "grant_type"    => "client_credentials",
            "client_id"     => Fixtures::get('client_id'),
            "client_secret" => Fixtures::get('client_secret'),
            "scope"         => Fixtures::get('client_scope')
        ]);

        $this->client_access_token = json_decode($I->grabResponse(), true)['access_token'];

        $I->amBearerAuthenticated($this->client_access_token);
        $I->sendPOST('/oauth/access_token', [
            "username"      => Fixtures::get('username'),
            "password"      => Fixtures::get('password'),
            "grant_type"    => "password",
            "client_id"     => Fixtures::get('client_id'),
            "client_secret" => Fixtures::get('client_secret'),
            "scope"         => Fixtures::get('user_scope')
        ]);

        $this->user_access_token = json_decode($I->grabResponse(), true)['access_token'];
    }

    public function _after(ApiTester $I)
    {
    }

    public function testSignup(ApiTester $I)
    {
        $I->wantTo('test account signup');
        $I->amBearerAuthenticated($this->client_access_token);
        $I->sendPOST('/account', [
            "email"    => "mail2@email.com",
            "password" => "password",
            "name"     => "John Doe"
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "email" => "mail2@email.com",
            "name"  => "John Doe"
        ]);
    }

    public function testSignupWithExistingEmail(ApiTester $I)
    {
        $I->wantTo('test account signup with existing email');
        $I->amBearerAuthenticated($this->client_access_token);
        $I->sendPOST('/account', [
            "email"    => Fixtures::get('username'),
            "password" => "password",
            "name"     => "John Doe 2"
        ]);

        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "title"  => "Failed to create user",
            "detail" => "Email already exist. Please try a different email"
        ]);
    }

    public function testGetAccount(ApiTester $I)
    {
        $I->wantTo('test get account');

        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/account');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "email" => Fixtures::get('username')
        ]);
    }
}
