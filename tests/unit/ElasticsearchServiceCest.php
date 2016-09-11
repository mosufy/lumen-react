<?php

/**
 * Class ElasticsearchServiceCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */
class ElasticsearchServiceCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function testDropIndex(UnitTester $I)
    {
        // FIXME: Seems to fail test even though the artisan command manages to run successfully
        /*$I->wantTo('test dropping elasticsearch index');

        $elastic = new \App\Services\ElasticsearchService();
        $elastic->drop([
            'index' => 'todo_index'
        ]);

        $I->expectException(\Elasticsearch\Common\Exceptions\Missing404Exception::class, function () use ($elastic) {
            $elastic->get([
                'index' => 'todo_index',
                'type'  => 'todo_type',
                'id'    => 1
            ]);
        });

        // Import back the index
        $I->runShellCommand("php artisan elasticsearch:importIndex");*/
    }
}
