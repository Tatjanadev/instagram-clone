<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('user.edit'));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('user.update'), [
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'bio' => 'This is a test bio.',
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('user.edit'));

    $user->refresh();

    expect($user->first_name)->toBe('Test');
    expect($user->last_name)->toBe('User');
    expect($user->username)->toBe('testuser');
    expect($user->email)->toBe('test@example.com');
    expect($user->bio)->toBe('This is a test bio.');
    expect($user->gender)->toBe('male');
    expect($user->date_of_birth->toDateString())->toBe('2000-01-01');
    expect($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('user.update'), [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('user.edit'));

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete(route('user.destroy'), [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('home'));

    $this->assertGuest();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from(route('user.edit'))
        ->delete(route('user.destroy'), [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect(route('user.edit'));

    expect($user->fresh())->not->toBeNull();
});
