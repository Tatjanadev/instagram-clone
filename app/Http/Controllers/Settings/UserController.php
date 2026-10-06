<?php

namespace App\Http\Controllers\Settings;

use App\DTOs\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileDeleteRequest;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request): Response
    {
        $user = $this->userService->getUser($request->user()->id);

        return Inertia::render('Profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        Gate::authorize('update', $user);

        $updateUserDTO = UpdateUserDTO::fromArray(
            $request->validated()
        );

        $this->userService->update(
            $user,
            $updateUserDTO
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Profile updated.'),
        ]);

        return to_route('user.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {
        $user = $request->user();

        Gate::authorize('delete', $user);

        Auth::logout();

        $this->userService->delete($user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
