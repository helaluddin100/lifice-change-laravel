<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use App\Notifications\VerifyEmail;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Generate verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'verification_code' => $verificationCode, // Store verification code in the database
        ]);

        $user->notify(new VerifyEmail($verificationCode));

        return response()->json([
            'message' => 'Registration successful. Check your email for verification code.',
            'email' => $user->email,
            'verification_code' => $verificationCode,
        ]);
    }


    /**
     * Log the user in and return a JWT token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = JWTAuth::fromUser(Auth::user());

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    /**
     * Log the user out and revoke the access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Verify the user's email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || $user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Invalid user or email already verified.'], 422);
        }

        // Verify the code here
        $code = $request->input('code');

        if ($code != $user->verification_code) {
            return response()->json(['message' => 'Invalid verification code.'], 422);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Log the user in after email verification
        $token = JWTAuth::fromUser($user);

        return response()->json(['message' => 'Email successfully verified', 'token' => $token]);
    }
}
