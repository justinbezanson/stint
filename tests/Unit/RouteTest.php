<?php

use Illuminate\Support\Facades\Route;

test('home route resolves to /', function () {
    expect(parse_url(route('home'), PHP_URL_PATH) ?: '/')->toBe('/');
});

test('dashboard route resolves to /dashboard', function () {
    expect(parse_url(route('dashboard'), PHP_URL_PATH))->toBe('/dashboard');
});

test('log-reading route resolves to /log-reading', function () {
    expect(parse_url(route('log-reading'), PHP_URL_PATH))->toBe('/log-reading');
});

test('profile edit route resolves to /settings/profile', function () {
    expect(parse_url(route('profile.edit'), PHP_URL_PATH))->toBe('/settings/profile');
});

test('profile update route resolves to /settings/profile', function () {
    expect(parse_url(route('profile.update'), PHP_URL_PATH))->toBe('/settings/profile');
});

test('profile destroy route resolves to /settings/profile', function () {
    expect(parse_url(route('profile.destroy'), PHP_URL_PATH))->toBe('/settings/profile');
});

test('security edit route resolves to /settings/security', function () {
    expect(parse_url(route('security.edit'), PHP_URL_PATH))->toBe('/settings/security');
});

test('user password update route resolves to /settings/password', function () {
    expect(parse_url(route('user-password.update'), PHP_URL_PATH))->toBe('/settings/password');
});

test('appearance edit route resolves to /settings/appearance', function () {
    expect(parse_url(route('appearance.edit'), PHP_URL_PATH))->toBe('/settings/appearance');
});

test('settings route uri exists in registered routes', function () {
    $routes = Route::getRoutes()->getRoutesByMethod()['GET'] ?? [];
    $uris = array_map(fn ($route) => $route->uri(), $routes);

    expect(in_array('settings', $uris))->toBeTrue();
});

test('all named routes are registered', function () {
    $expectedRoutes = [
        'home',
        'dashboard',
        'log-reading',
        'profile.edit',
        'profile.update',
        'profile.destroy',
        'security.edit',
        'user-password.update',
        'appearance.edit',
    ];

    $registeredRoutes = collect(Route::getRoutes()->getRoutesByName())->keys()->toArray();

    foreach ($expectedRoutes as $route) {
        expect(in_array($route, $registeredRoutes))->toBeTrue("Route [{$route}] is not registered.");
    }
});
