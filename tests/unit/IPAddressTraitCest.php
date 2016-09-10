<?php

use App\Traits\IPAddressTrait;
use Codeception\Util\Fixtures;

class IPAddressTraitCest
{
    use IPAddressTrait;

    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function testGetClientHostname(UnitTester $I)
    {
        $I->wantTo('test getting client hostname by ip address');
        $I->assertEquals(Fixtures::get('hostname'), $this->getClientHostname(Fixtures::get('ip_address')));

        // test the cache
        $I->assertEquals(Fixtures::get('hostname'), $this->getClientHostname(Fixtures::get('ip_address')));
    }

    public function testGetGeoIP(UnitTester $I)
    {
        $I->wantTo('test getting geoip by ip address');

        $geoip = $this->getGeoIP(Fixtures::get('ip_address'));
        $I->assertArrayHasKey('country_code', $geoip);
        $I->assertArrayHasKey('country_name', $geoip);
        $I->assertEquals($geoip['country_code'], Fixtures::get('ip_country_code'));

        // test the cache
        $geoip = $this->getGeoIP(Fixtures::get('ip_address'));
        $I->assertArrayHasKey('country_code', $geoip);
        $I->assertArrayHasKey('country_name', $geoip);
        $I->assertEquals($geoip['country_code'], Fixtures::get('ip_country_code'));
    }

    public function testGetIPCountry(UnitTester $I)
    {
        $I->wantTo('test getting country name of ip address');

        $country_name = $this->getIPCountry(Fixtures::get('ip_address'));
        $I->assertEquals($country_name, Fixtures::get('ip_country'));

        // test the cache
        $country_name = $this->getIPCountry(Fixtures::get('ip_address'));
        $I->assertEquals($country_name, Fixtures::get('ip_country'));
    }

    public function testGetIPCountryCode(UnitTester $I)
    {
        $I->wantTo('test getting country code of ip address');

        $country_code = $this->getIPCountryCode(Fixtures::get('ip_address'));
        $I->assertEquals($country_code, Fixtures::get('ip_country_code'));
    }

    public function testGetIPCountryEmptyResponse(UnitTester $I)
    {
        $I->wantTo('test getting country name with invalid ip address');

        $country_name = $this->getIPCountry('127.0.0.1');
        $I->assertEmpty($country_name);
    }

    public function testGetIPCountryCodeEmptyResponse(UnitTester $I)
    {
        $I->wantTo('test getting country code with invalid ip address');

        $country_code = $this->getIPCountryCode('127.0.0.1');
        $I->assertEmpty($country_code);
    }
}
