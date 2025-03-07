<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

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

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);


        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'verification_code' => $verificationCode, // Do not hash the verification code here
        ]);

        $user->notify(new VerifyEmail($verificationCode));

        return response()->json([
            'message' => 'Registration successful. Check your email for verification code.',
            'email' => $user->email,
            'verification_code' => $verificationCode,
        ]);
    }


    public function login(Request $request)
    {
        try {
            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response([
                    'message' => 'Invalid credentials!'
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = Auth::user();

            // Check if the user's email is verified
            if (!$user->email_verified_at) {
                // Generate a new verification code
                $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $user->verification_code = $verificationCode;
                $user->save();

                // Send verification email
                $user->notify(new VerifyEmail($verificationCode));

                return response()->json([
                    'error' => 'Account not verified',
                    'redirect' => '/verify-email',
                    'email' => $user->email,
                    'message' => 'A new verification email has been sent to your email address.'
                ], 200);
            }

            // Refresh shops data from DB (important after delete)
            $user->load('shops'); // ✅ Load fresh 'shops' relationship data

            // Check if the user has a shop
            $hasShop = $user->shops()->exists(); // ✅ Re-check the shop existence

            // If the user's email is verified, generate and return a token
            $token = $user->createToken('token')->plainTextToken;

            // Return response with redirect path based on shop existence
            return response([
                'user' => $user,
                'token' => $token,
                'redirect' => $hasShop ? '/dashboard' : '/createshop',
            ]);
        } catch (\Exception $e) {
            // Catch any exceptions and return a proper response
            return response(['error' => 'Something went wrong. Please try again.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }





    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return response()->json(['message' => 'User already verified!'], 400);
        }

        // Check if the user requested a resend within the last 2 minutes
        $cacheKey = 'resend_verification_' . $user->email;
        if (Cache::has($cacheKey)) {
            return response()->json(['message' => 'Please wait 2 minutes before requesting a new code.'], 429);
        }

        // Generate a new verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->verification_code = $verificationCode;
        $user->save();

        // Send email
        $user->notify(new VerifyEmail($verificationCode));

        // Store the request time in cache for 2 minutes
        Cache::put($cacheKey, true, now()->addMinutes(2));

        return response()->json(['message' => 'New verification email sent!']);
    }


    /**
     * Log the user out and revoke the access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Logout successful']);
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
            'email' => 'required|email',
            'verification_code' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$user->email_verified_at == '') {
            return response()->json(['message' => 'User already verified!'], 404);
        }

        if ($user->verification_code !== $request->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 422);
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        $token = auth()->login($user);

        return response()->json(['token' => $token, 'message' => 'User verified successfully']);
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function reset(Request $request): JsonResponse
    {

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
