<?php
/**
 * Class UserCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use Codeception\Util\Fixtures;

class UserCest
{
    protected $userRepository;

    public function _before(UnitTester $I)
    {
        $this->userRepository = app(\App\Repositories\UserRepository::class);
    }

    public function _after(UnitTester $I)
    {
    }

    public function testGetUserByUid(UnitTester $I)
    {
        $I->wantTo('test get user by its uid');
        $user = $this->userRepository->getUserByUid(Fixtures::get('user_uid'));
        $I->assertEquals(Fixtures::get('user_uid'), $user->uid);
    }

    public function testGetUserByInvalidUid(UnitTester $I)
    {
        $I->wantTo('test get user by invalid uid');
        $I->expectException(\App\Exceptions\UserException::class, function () {
            $this->userRepository->getUserByUid('invalid-uid');
        });
    }
}
