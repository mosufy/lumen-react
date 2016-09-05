<?php

// Here you can initialize variables that will be available to your tests

use Codeception\Util\Fixtures;

Fixtures::add('client_id', '6fC2745co07D4yW7X9saRHpJcE0sm0MT');
Fixtures::add('client_secret', 'KLqMw5D7g1c6KX23I72hx5ri9d16GJDW');
Fixtures::add('client_scope', 'role.app');

Fixtures::add('username', 'email@mail.com');
Fixtures::add('password', 'password');
Fixtures::add('user_scope', 'role.user');

Fixtures::add('todo_uid', 'c79be7ff-599b-35cd-a271-c497dd1d65ad');
Fixtures::add('todo_title', 'Learn to draw');
Fixtures::add('todo_description', 'Learn to draw an animal');