<?php

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

test('user receives custom password reset notification', function () {
    Notification::fake();

    $user = User::factory()->create();

    // Ask Laravel to send the password reset notification.
    $user->sendPasswordResetNotification('test-token');

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        fn (ResetPasswordNotification $notification) => $notification->token === 'test-token'
    );
});

test('password reset email contains correct information', function () {
    $user = User::factory()->make([
        'first_name' => 'Sarah',
        'email' => 'sarah@example.com',
    ]);

    $notification = new ResetPasswordNotification('test-token');

    $mail = $notification->toMail($user);

    expect($mail->subject)->toBe('Reset your InstaNest password');
    expect($mail->markdown)->toBe('emails.reset-password');
    expect($mail->viewData['firstName'])->toBe('Sarah');
    expect($mail->viewData['expiration'])->toBe(
        config('auth.passwords.users.expire')
    );

    expect($mail->viewData['resetUrl'])->toContain('test-token');
});
