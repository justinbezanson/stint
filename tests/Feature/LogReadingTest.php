<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $this->get(route('log-reading'))->assertRedirect(route('login'));
});

test('authenticated users can visit the log reading page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('log-reading'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('LogReading')
            ->where('test', 'Hello, world!'),
        );
});
