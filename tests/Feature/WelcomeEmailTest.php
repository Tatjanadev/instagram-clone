<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

test('sends a welcome email when a user registers', function () {
    Mail::fake();

    $user = User::factory()->make([
        'first_name' => 'Sarah',
        'email' => 'sarah@example.com',
    ]);
    // pretends user registered
    event(new Registered($user));

    Mail::assertSent(WelcomeEmail::class, function (WelcomeEmail $mail) use ($user) {
        return $mail->hasTo($user->email)
        && $mail->firstName === $user->first_name;
    });
});
