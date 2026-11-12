<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GoogleAuthController extends Controller
{
    // redirect users from InstaNest to Google
    public function redirectToGoogle(): SymfonyRedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): SymfonyRedirectResponse
    {
        // Get the authenticated user's information from Google.
        $googleUser = Socialite::driver('google')->user();

        logger()->info('Google authentication callback received');

        return redirect()->route('login');
    }
}
