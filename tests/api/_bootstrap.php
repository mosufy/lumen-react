<?php

// Here you can initialize variables that will be available to your tests

use Codeception\Util\Fixtures;

Fixtures::add('client_id', '6fC2745co07D4yW7X9saRHpJcE0sm0MT');
Fixtures::add('client_secret', 'KLqMw5D7g1c6KX23I72hx5ri9d16GJDW');
Fixtures::add('client_scope', 'role.app');

Fixtures::add('username', 'email@mail.com');
Fixtures::add('password', 'password');
Fixtures::add('user_scope', 'role.user');