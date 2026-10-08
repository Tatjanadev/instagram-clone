<?php

namespace App\Http\Controllers\Settings;

use App\DTOs\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileDeleteRequest;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Repositories\PostRepository;
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
    public function __construct(
        private UserService $userService,
        private PostRepository $postRepository
    ) {
        
    }

    /**
     * Show all user profiles
     */
    public function index(): Response
    {
        $users = $this->userService->getOtherUsers(Auth::id());
        $posts = $this->postRepository->getLatestPostPerUser(Auth::id());

        return Inertia::render('users/Index', [
            'users' => $users,
            'posts' => $posts,
            'currentUserId' => Auth::id(),
        ]);
    }

    /**
     * Show user profile page
     */
    public function show(Request $request): Response
    {
        $user = $this->userService->getUser($request->user()->id);

        return Inertia::render('users/Show', [
            'user' => $user,
            'isOwnProfile' => true,
        ]);
    }

    /**
     * Show other user Profile
     */
    public function showPublic(string $username): Response
    {
        $user = $this->userService->getUserByUsername($username);

        return Inertia::render('users/Show', [
            'user' => $user,
            'isOwnProfile' => false,
        ]);
    }

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('users/Edit', [
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
