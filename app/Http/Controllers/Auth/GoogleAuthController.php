<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SocialAuth\GoogleEmailAlreadyRegisteredException;
use App\Exceptions\SocialAuth\GoogleRegistrationSessionExpiredException;
use App\Exceptions\SocialAuth\InvalidGoogleEmailException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteGoogleRegistrationRequest;
use App\Services\SocialAuthService;
use App\Services\UsernameSuggestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GoogleAuthController extends Controller
{
    public function __construct(
        private SocialAuthService $socialAuthService,
        private UsernameSuggestionService $usernameSuggestionService
    ) {}

    // redirect users from InstaNest to Google
    public function redirectToGoogle(): SymfonyRedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): SymfonyRedirectResponse
    {
        try {
            // Get the authenticated user's information from Google.
            $googleUser = Socialite::driver('google')->user();

            $user = $this->socialAuthService->authenticateGoogleUser($googleUser);

            if ($user !== null) {
                Auth::login($user);
                // regenerates the session ID for security after login.
                $request->session()->regenerate();

                return redirect()->route('profile.show');
            }
            $this->socialAuthService->prepareGoogleRegistration($googleUser);

            return redirect()->route('auth.google.complete');
        } catch (InvalidGoogleEmailException|GoogleEmailAlreadyRegisteredException $exception) {
            return redirect()->route('login')->withErrors([
                'google' => $exception->getMessage(),
            ]);
        }
    }

    public function showCompleteRegistration(Request $request): Response|SymfonyRedirectResponse
    {
        $googleData = $request->session()->get('google_registration');

        // Checks whether the registration session exists and contains an array.
        if (! is_array($googleData)) {
            return redirect()->route('login');
        }

        $name = $googleData['name'] ?? '';

        if (! is_string($name)) {
            $name = '';
        }

        return Inertia::render('auth/CompleteGoogleRegistration', [
            'googleName' => $name,
            'email' => $googleData['email'] ?? '',
            'usernameSuggestions' => $this->usernameSuggestionService->suggestUsernames($name),
        ]);
    }

    public function completeRegistration(CompleteGoogleRegistrationRequest $completeGoogleRegistrationRequest): SymfonyRedirectResponse
    {
        $data = $completeGoogleRegistrationRequest->validated();

        try {
            $user = $this->socialAuthService->completeGoogleRegistration($data);

            Auth::login($user);

            $completeGoogleRegistrationRequest->session()->regenerate();

            return redirect()->route('profile.show');
        } catch (
            GoogleRegistrationSessionExpiredException|
            InvalidGoogleEmailException|
            GoogleEmailAlreadyRegisteredException $exception
        ) {
            return redirect()->route('login')->withErrors([
                'google' => $exception->getMessage(),
            ]);
        }
    }
}
