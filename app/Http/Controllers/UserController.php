<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        // enforces authentication to access controller
        $this->middleware('auth');
    }

    /**
     * Updates a user's profile
     * @param Request $request
     */
    public function update(Request $request) {
        // todo: input validation
        /** @var User $user */
        $user = $request->user();

        // update model properties
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // commit changes to db
        $user->save();

        return redirect('/home');
    }
}
