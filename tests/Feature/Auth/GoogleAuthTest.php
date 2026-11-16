<?php

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

test('Existing Google user can log in', function () {

    $user = User::factory()->create([
        'google_id' => 'google-test-123',
    ]);

    // Create a fake Google user to simulate the data returned by Google.
    $googleUser = Mockery::mock(SocialiteUser::class);

    $googleUser->shouldReceive('getId')->andReturn('google-test-123');

    // Create a fake Google authentication driver.
    $googleDriver = Mockery::mock();

    $googleDriver->shouldReceive('user')
        ->once()
        ->andReturn($googleUser);

    // Mock Socialite to return fake Google driver instead of contacting Google
    Socialite::shouldReceive('driver')
        ->once()
        ->with('google')
        ->andReturn($googleDriver);

    // Simulate Google redirecting the user back to our callback route.
    $response = $this->get(route('auth.google.callback'));

    // Verify that successful Google authentication redirects to the user's profile.
    $response->assertRedirect(route('profile.show'));

    // Verify that Laravel logged in the existing user, not a different account.
    $this->assertAuthenticatedAs($user);

});

test('New Google user is redirected to complete registration', function () {
    $googleUser = Mockery::mock(SocialiteUser::class);

    $googleUser->shouldReceive('getId')
        ->andReturn('google-id-12345');

    $googleUser->shouldReceive('getName')
        ->andReturn('Jane Smith');

    $googleUser->shouldReceive('getEmail')
        ->andReturn('jane@example.com');

    $googleDriver = Mockery::mock();

    $googleDriver->shouldReceive('user')
        ->once()
        ->andReturn($googleUser);

    Socialite::shouldReceive('driver')
        ->once()
        ->with('google')
        ->andReturn($googleDriver);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('auth.google.complete'));

    $this->assertGuest();

    $response->assertSessionHas('google_registration.google_id', 'google-id-12345');
    $response->assertSessionHas('google_registration.name', 'Jane Smith');
    $response->assertSessionHas('google_registration.email', 'jane@example.com');
});

test('Google login is rejected when email is already registered', function () {
    // create an existing InstaNest user whose account is not linked to Google.
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'google_id' => null,
    ]);

    $googleUser = Mockery::mock(SocialiteUser::class);

    $googleUser->shouldReceive('getId')
        ->andReturn('google-new-23766532');

    $googleUser->shouldReceive('getName')
        ->andReturn('Jane Smith');

    $googleUser->shouldReceive('getEmail')
        ->andReturn('jane@example.com');

    $googleDriver = Mockery::mock();

    $googleDriver->shouldReceive('user')
        ->once()
        ->andReturn($googleUser);

    Socialite::shouldReceive('driver')
        ->once()
        ->with('google')
        ->andReturn($googleDriver);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('login'));

    $response->assertSessionHasErrors(['google']);

    $this->assertGuest();
});

test('New Google user can complete registration', function () {
    // Simulate Google registration data saved during the OAuth callback.
    $this->withSession([
        'google_registration' => [
            'google_id' => 'google-new-456',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ],
    ]);

    // Submit the registration form with the user's chosen details.
    $response = $this->post(route('auth.google.complete.store'), [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'username' => 'janesmith456',
    ]);

    $response->assertRedirect(route('profile.show'));

    $this->assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'google_id' => 'google-new-456',
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'username' => 'janesmith456',
    ]);

    $user = User::where('email', 'jane@example.com')->firstOrFail();

    $this->assertAuthenticatedAs($user);

    // Verify that temporary Google registration data has been cleared.
    $response->assertSessionMissing('google_registration');
});

test('Google registration requires a valid session', function () {
    // Attempt to complete registration without authenticating through Google.
    $response = $this->post(route('auth.google.complete.store'), [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'username' => 'janesmith456',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('users', [
        'username' => 'janesmith456',
    ]);

    $this->assertGuest();
});

test('Google registration rejects an existing username', function () {
    // Create an existing user who already owns the requested username.
    User::factory()->create([
        'username' => 'janesmith456',
    ]);

    // Simulate a new Google user's pending registration.
    $this->withSession([
        'google_registration' => [
            'google_id' => 'google-new-789',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ],
    ]);

    // Try to register using the username already taken.
    $response = $this->post(route('auth.google.complete.store'), [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'username' => 'janesmith456',
    ]);

    $response->assertSessionHasErrors(['username']);

    $this->assertDatabaseMissing('users', [
        'google_id' => 'google-new-789',
    ]);

    $this->assertGuest();
});
