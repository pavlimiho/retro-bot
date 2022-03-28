<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Home'), route('home'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Users'), route('users.index'));
});

Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->name, route('users.edit', $user));
});

Breadcrumbs::for('members', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Roster'), route('members.index'));
});

Breadcrumbs::for('members.create', function ($trail) {
    $trail->parent('members');
    $trail->push(__('Create'), route('members.create'));
});

Breadcrumbs::for('members.edit', function ($trail, $member) {
    $trail->parent('members');
    $trail->push($member->name, route('members.edit', $member));
});
