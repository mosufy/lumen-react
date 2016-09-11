<?php
/**
 * Class ImportIndexCest
 *
 * @date      11/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

class ImportIndexCest
{
    public function testImportIndexCommand(FunctionalTester $I)
    {
        $I->am('the server administrator');
        $I->wantTo('import indexes to elasticsearch');
        $I->runShellCommand("php artisan elasticsearch:importIndex");

        $I->canSeeInShellOutput('Importing Index: Preparing documents to index.');
        $I->canSeeInShellOutput('Importing Index: 3/3 indexes imported.');
    }
}