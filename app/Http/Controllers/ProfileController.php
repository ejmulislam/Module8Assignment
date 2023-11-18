<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    //profile requiest id with name and age indexing
    //Task 1
    //=================================================================================
    // public function index(Request $request) {
    //        $name = "Donal Trump";
    //        $age = "75";
           
    //         return response(" $name, $age");
    
    
    // }


    //Task 2
    //=================================================================================

    // public function index(Request $request, $id) {
    //     $data = [
    //         'id' => $id,
    //         'name' => "Donald Trump",
    //         'age' => "75"
    //     ];
    //     return response()->json([
    //         $data
    //     ]);
    // }


    //Task 3
    //=================================================================================

    public function index(Request $request) {
        $name = "access_token";
        $value = "123-XYZ";
        $expTime = 60;
        $path = '/';
        $domain = $_SERVER['SERVER_NAME'];
        $secure = false;
        $httpOnly = true;

        return response("Cockie Set Success")->cookie($name, $value, $expTime, $path, $domain, $secure, $httpOnly, 200); 
    }




























    

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
