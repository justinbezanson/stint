<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('settings')->assertRedirect(route('login'));
});

test('authenticated users are redirected to the profile page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('settings')
        ->assertRedirect(route('profile.edit'));
});
