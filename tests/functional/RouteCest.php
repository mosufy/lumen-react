<?php
/**
 * Class RouteCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

class RouteCest
{
    public function openPingServiceByRoute(FunctionalTester $I)
    {
        $I->wantTo('test route to ping service');
        $I->amOnRoute('services.ping');

        $I->seeCurrentUrlEquals('/v1/services/ping');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.timestamp.date');
    }
}