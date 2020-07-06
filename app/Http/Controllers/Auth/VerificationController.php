<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
     */

    // use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request, User $user)
    {
        // check if the url is a valid signed url
        if (!URL::hasValidSignature($request)) {
            return response()->json(['errors' => ['message' => "Invalid verification"]], 403);
        }

        // check if the user has already verified the account
        if ($user->hasVerifiedEmail()) {
            return response()->json(['errors' => ['message' => "Email address already verified"]], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'Email succesfully verified'], 200);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $this->validate($request, ['email' => ['email', 'required']]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(["errors" => [
                'email' => 'No user could be found with this email address',
            ]], 403);
        }

        // check if the user has already verified the account
        if ($user->hasVerifiedEmail()) {
            return response()->json(['errors' => [
                'message' => "Email address already verified",
            ]], 403);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => 'Verification link resent']);

    }
}
