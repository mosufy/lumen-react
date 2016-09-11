<?php
/**
 * Class AppLogCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

class AppLogCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function testInfoLog(UnitTester $I)
    {
        $I->wantTo('test writing info log');

        \App\Models\AppLog::info(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'TestCest info log', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'info',
            'message' => 'TestCest info log'
        ]);
    }

    public function testNoticeLog(UnitTester $I)
    {
        $I->wantTo('test writing notice log');

        \App\Models\AppLog::notice(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'TestCest notice log', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'notice',
            'message' => 'TestCest notice log'
        ]);
    }

    public function testEmergencyLog(UnitTester $I)
    {
        $I->wantTo('test writing emergency log');

        \App\Models\AppLog::emergency(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'TestCest emergency log', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'emergency',
            'message' => 'TestCest emergency log'
        ]);
    }

    public function testAlertLog(UnitTester $I)
    {
        $I->wantTo('test writing alert log');

        \App\Models\AppLog::alert(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'TestCest alert log', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'alert',
            'message' => 'TestCest alert log'
        ]);
    }

    public function testCriticalLog(UnitTester $I)
    {
        $I->wantTo('test writing critical log');

        \App\Models\AppLog::critical(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'TestCest critical log', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'critical',
            'message' => 'TestCest critical log'
        ]);
    }

    public function testLogWithoutMessage(UnitTester $I)
    {
        $I->wantTo('test writing log without message');

        \App\Models\AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__, [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->dontSeeRecord('applogs', [
            'message' => 'TestCest debug log'
        ]);
    }

    public function testLogWithoutFormatting(UnitTester $I)
    {
        $I->wantTo('test writing log without formatted logging');

        \App\Models\AppLog::debug('TestCest No Format', [
            'paramA' => 'A',
            'paramB' => 'B'
        ]);

        $I->seeRecord('applogs', [
            'type'    => 'debug',
            'message' => 'TestCest No Format'
        ]);
    }
}
