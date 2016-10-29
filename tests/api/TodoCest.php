<?php

/**
 * Class TodoCest
 *
 * @date      5/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

use \Codeception\Util\Fixtures;

/**
 * Class TodoCest
 */
class TodoCest
{
    protected $user_access_token;

    public function _before(ApiTester $I)
    {
        $I->sendPOST('/oauth/access_token/client', [
            "grant_type"    => "client_credentials",
            "client_id"     => Fixtures::get('client_id'),
            "client_secret" => Fixtures::get('client_secret'),
            "scope"         => Fixtures::get('client_scope')
        ]);

        $client_access_token = json_decode($I->grabResponse(), true)['access_token'];

        $I->amBearerAuthenticated($client_access_token);
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

    /**
     * Checks if paginated data success response is correctly formatted
     *
     * @param ApiTester $I
     */
    public function getTodos(ApiTester $I)
    {
        $I->wantTo('test get all todos');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        // paginated data response
        $I->seeResponseJsonMatchesJsonPath('$.meta.filter');
        $I->seeResponseJsonMatchesJsonPath('$.meta.total');
        $I->seeResponseJsonMatchesJsonPath('$.meta.per_page');
        $I->seeResponseJsonMatchesJsonPath('$.meta.current_page');
        $I->seeResponseJsonMatchesJsonPath('$.meta.last_page');
        $I->seeResponseJsonMatchesJsonPath('$.meta.next_page_url');
        $I->seeResponseJsonMatchesJsonPath('$.meta.prev_page_url');
        $I->seeResponseJsonMatchesJsonPath('$.meta.from');
        $I->seeResponseJsonMatchesJsonPath('$.meta.to');

        $I->seeResponseJsonMatchesJsonPath('$.data[0].type');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.uid');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.title');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.description');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.category_id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.user_id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.created_at');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.updated_at');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].attributes.deleted_at');

        // response data check
        $I->seeResponseContainsJson([
            "per_page" => 25
        ]);
        $I->seeResponseContainsJson([
            "type" => 'todo'
        ]);
    }

    public function getPaginatedTodo(ApiTester $I)
    {
        $I->wantTo('test get todos with pagination');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos', [
            'page'  => 1,
            'limit' => 2,
            'sort'  => 'created_at'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "page"  => 1,
            "limit" => 2,
            "sort"  => "created_at"
        ]);

        $I->seeResponseContainsJson([
            "per_page" => 2
        ]);
    }

    public function getTodosWithCachedData(ApiTester $I)
    {
        $I->wantTo('test get todos with cached data');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos', [
            'page'  => 1,
            'limit' => 2,
            'sort'  => 'created_at'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getPaginatedTodoSortDescending(ApiTester $I)
    {
        $I->wantTo('test get todos with sort descending');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos', [
            'page'  => 1,
            'limit' => 2,
            'sort'  => '-created_at'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getTodoByUid(ApiTester $I)
    {
        $I->wantTo('test get todo by uid');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos/' . Fixtures::get('todo_uid'));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->dontSeeResponseJsonMatchesJsonPath('$.meta.filter');

        $I->seeResponseContainsJson([
            "uid"         => Fixtures::get('todo_uid'),
            "title"       => Fixtures::get('todo_title'),
            "description" => Fixtures::get('todo_description'),
        ]);
    }

    public function getTodoByMissingUid(ApiTester $I)
    {
        $I->wantTo('test get todo by missing uid');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos/invalid_uid');

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->dontSeeResponseJsonMatchesJsonPath('$.meta.filter');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[0].type');
        $I->seeResponseJsonMatchesJsonPath('$.errors.[0].status');

        $I->seeResponseContainsJson([
            "code"   => 40400000,
            "source" => "/v1/todos/invalid_uid",
        ]);
    }

    public function getTodoBySearch(ApiTester $I)
    {
        $I->wantTo('test get todo by search');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos', [
            'q'            => 'Learn',
            'category_ids' => '1,2'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'q'            => 'Learn',
            'category_ids' => '1,2'
        ]);

        $I->seeResponseContainsJson([
            'uid'   => Fixtures::get('todo_uid'),
            'title' => Fixtures::get('todo_title')
        ]);
    }

    public function getTodoBySearchNoResults(ApiTester $I)
    {
        $I->wantTo('test get todo by search with no results');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendGET('/todos', [
            'category_ids' => '99'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->dontSeeResponseContainsJson([
            'uid' => Fixtures::get('todo_uid')
        ]);
    }

    public function createTodo(ApiTester $I)
    {
        $I->wantTo('test create todo');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendPOST('/todos', [
            "title"       => "New TODO Title",
            "description" => "New TODO Description",
            "category_id" => 1
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "title"       => "New TODO Title",
            "description" => "New TODO Description",
            "category_id" => 1
        ]);
    }

    // TODO: category_id is no longer required
    /*public function createTodoWithMissingCategoryId(ApiTester $I)
    {
        $I->wantTo('test create todo with missing category_id');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendPOST('/todos', [
            "title"       => "New TODO Title",
            "description" => "New TODO Description"
        ]);

        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "code"   => 50001001,
            "detail" => "Exception thrown while trying to create todo"
        ]);
    }*/

    public function updateTodo(ApiTester $I)
    {
        $I->wantTo('test update todo');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendPUT('/todos/' . Fixtures::get('todo_uid'), [
            "title"       => "Update TODO Title",
            "description" => "Update TODO Description",
            "category_id" => 2
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "uid"         => Fixtures::get('todo_uid'),
            "title"       => "Update TODO Title",
            "description" => "Update TODO Description",
            "category_id" => 2
        ]);
    }

    public function updateTodoWithInvalidUid(ApiTester $I)
    {
        $I->wantTo('test update todo with invalid uid');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendPUT('/todos/invalid-uid', [
            "title"       => "Update TODO Title",
            "description" => "Update TODO Description"
        ]);

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "code"   => 40400000,
            "detail" => "Todo not found"
        ]);
    }

    public function deleteTodo(ApiTester $I)
    {
        $I->wantTo('test delete todo');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendDELETE('/todos/' . Fixtures::get('todo_uid'));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "type"       => 'todo',
            "id"         => null,
            "attributes" => null
        ]);
    }

    public function deleteTodoWithInvalidUid(ApiTester $I)
    {
        $I->wantTo('test delete todo with invalid uid');
        $I->amBearerAuthenticated($this->user_access_token);
        $I->sendDELETE('/todos/invalid-uid');

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            "code"   => 40400000,
            "detail" => "Todo not found"
        ]);
    }
}
