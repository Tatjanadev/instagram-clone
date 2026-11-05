<x-mail::message>
# Hi {{ $firstName }}!

We received a request to reset your InstaNest password.

<x-mail::button :url="$resetUrl">
Reset Password
</x-mail::button>

This password reset link will expire in {{ $expiration }} minutes.

If you did not request this, you can safely ignore this email.

Regards,  
The InstaNest Team
</x-mail::message>