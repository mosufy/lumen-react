<?php

class ServiceCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * Ping service test
     *
     * Ping test checks for a number of basic setup in place.
     * Checks if the success response is correctly formatted.
     *
     * @param ApiTester $I
     */
    public function testPing(ApiTester $I)
    {
        $I->wantTo('test ping');
        $I->sendGET('/services/ping');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains("data");
        $I->seeResponseJsonMatchesJsonPath('$.data[*].type');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes');
        $I->seeResponseJsonMatchesJsonPath('$.data[*].attributes.timestamp');
    }

    /**
     * Endpoint not found test
     *
     * Ping test to test for error responses.
     *
     * @param ApiTester $I
     */
    public function testEndpointNotFound(ApiTester $I)
    {
        $I->wantTo('test endpoint not found');
        $I->sendGET('/services/ping2');

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContains("errors");
        $I->seeResponseJsonMatchesJsonPath('$.errors[0].status');
        $I->seeResponseJsonMatchesJsonPath('$.errors[0].code');
        $I->seeResponseJsonMatchesJsonPath('$.errors[0].source');
        $I->seeResponseJsonMatchesJsonPath('$.errors[0].title');
        $I->seeResponseJsonMatchesJsonPath('$.errors[0].detail');
    }
}
