<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $users = User::all();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Display view to create a new user.
     *
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            //
        ]);
    }

    /**
     * Store a newly created user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request): RedirectResponse|Redirector
    {
        $request->validate([
            'prefixname' => [Rule::in(['Mr', 'Mrs', 'Ms'])],
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'nullable|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'photo' => 'nullable|image'
        ]);

        $user = User::create([
            'prefixname' => $request->prefixname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffixname' => $request->suffixname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();

            $file->storeAs('public/profile_images', $filename);

            $user->photo = 'profile_images/' . $filename;
            $user->save();
        }

        return redirect(route('users.index'));
    }

    /**
     * Display view to edit a selected user.
     *
     * @return \Inertia\Response
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Store updated details for selected user.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request): RedirectResponse|Redirector
    {
        $request->validate([
            'prefixname' => [Rule::in(['Mr', 'Mrs', 'Ms'])],
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'nullable|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image'
        ]);

        $user->update([
            'prefixname' => $request->prefixname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffixname' => $request->suffixname,
            'email' => $request->email
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();

            $file->storeAs('public/profile_images', $filename);

            $user->photo = 'profile_images/' . $filename;
            $user->save();
        }

        return redirect(route('users.index'));
    }

    /**
     * Display details for a selected user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Soft delete selected user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user): RedirectResponse|Redirector
    {
        $user->delete();

        return redirect(route('users.index'));
    }

    /**
     * Show users that have been soft deleted.
     *
     * @return \Inertia\Response
     */
    public function trashed(): Response
    {
        $users = User::onlyTrashed()->get();

        return Inertia::render('Users/Trashed', [
            'users' => $users
        ]);
    }

    /**
     * Restore selected user that was soft deleted.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($user): RedirectResponse|Redirector
    {
        User::withTrashed()->find($user)->restore();

        return redirect(route('users.index'));
    }

    /**
     * Delete selected user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($user): RedirectResponse|Redirector
    {
        User::withTrashed()->find($user)->forceDelete();

        return redirect(route('users.index'));
    }
}
