<?php

namespace App\Services;

use App\Exceptions\SocialAuth\GoogleEmailAlreadyRegisteredException;
use App\Exceptions\SocialAuth\InvalidGoogleEmailException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Exceptions\SocialAuth\GoogleRegistrationSessionExpiredException;

class SocialAuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function findGoogleUser(SocialiteUser $googleUser): ?User
    {
        // provides the unique Google ID of the person who just signed in with Google
        $googleId = $googleUser->getId();

        return $this->userRepository->findByGoogleId($googleId);
    }

    public function findExistingEmail(SocialiteUser $googleUser): ?User
    {
        $email = $googleUser->getEmail();

        if (empty($email)) {
            return null;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        return $this->userRepository->findByEmail($email);
    }

    public function authenticateGoogleUser(SocialiteUser $googleUser): ?User
    {
        // Check if this Google account is already linked to InstaNest
        $user = $this->findGoogleUser($googleUser);

        if ($user !== null) {
            return $user;
        }

        $email = $googleUser->getEmail();

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidGoogleEmailException(
                __('social_auth.invalid_google_email')
            );
        }

        // Check whether the email is already used by an InstaNest account.
        $existingUser = $this->findExistingEmail($googleUser);

        if ($existingUser !== null) {
            throw new GoogleEmailAlreadyRegisteredException(
                __('social_auth.google_email_already_registered')
            );
        }

        return null;
    }

    // temporarily stores Google's information in the session.
    public function prepareGoogleRegistration(SocialiteUser $googleUser): void
    {
        Session::put('google_registration', [
            'google_id' => $googleUser->getId(),
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
        ]);
    }

    // retrieve the info stored in session and create the InstaNest user after profile completion

    /**
     * @param  array{first_name: string, last_name: string, username: string}  $data
     */
    public function completeGoogleRegistration(array $data): User
    {
        $googleData = Session::get('google_registration');

        if (! is_array($googleData)) {
            throw new  GoogleRegistrationSessionExpiredException(
        __('social_auth.google_registration_session_expired')
    );
        }

        $googleId = $googleData['google_id'] ?? null;
        $email = $googleData['email'] ?? null;

        // Make sure the required Google information is present.
        if (
            ! is_string($googleId) ||
            $googleId === '' ||
            ! is_string($email) ||
            ! filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new InvalidGoogleEmailException(
                __('social_auth.invalid_google_email')
            );
        }
        if (
            $this->userRepository->findByGoogleId($googleId) !== null ||
            $this->userRepository->findByEmail($email) !== null
        ) {
            throw new GoogleEmailAlreadyRegisteredException(
                __('social_auth.google_email_already_registered')
            );
        }
        // Create the new InstaNest user.
        $user = $this->userRepository->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $email,
            'google_id' => $googleId,
            'password' => Hash::make(Str::random(64)),
        ]);

        // Registration is complete, so remove the temporary Google data.
        Session::forget('google_registration');

        return $user;

    }
}
