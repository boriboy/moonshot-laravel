<?php

namespace App\Http\Controllers;

use App\AccountMovement;
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
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        // todo: input validation & return errors
        /** @var User $user */
        $user = $request->user();

        // update model properties
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // commit changes to db
        $user->save();

        return redirect('/home');
    }

    public function balance(Request $request) {
        // todo input validation
        $amount = $request->input('amount', 0);
        $isDeposit = $request->input('deposit');
        $isWithdraw = $request->input('withdraw');

        // get user instance
        /** @var User $user */
        $user = $request->user()->load('balance');
        $accountMovementType = $isDeposit ? AccountMovement::TYPE_DEPOSIT : AccountMovement::TYPE_WITHDRAW;

        if ($amount > 0) {
            try {
                // attempts deposit / withdraw
                $user->balance->initiateOperation($user, $amount, $accountMovementType);
            } catch (\Exception $exception) {
                return view('home', ['user' => $user, 'errors' => collect([
                    'amount' => $exception->getMessage()
                ])]);
            }
        }

        // return redirect home (info will be updated)
        return redirect('/home');
    }
}
