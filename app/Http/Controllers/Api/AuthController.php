<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
     /**
     * Login Users
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))

            return response()->json([
                'message' => 'Invalid Email or Password'
            ], 401);

            $user = Auth::user();
            $token = $user->createToken('appToken')->accessToken;

            return response()->json([
              'token' => $token,
              'token_type' => 'bearer',
              'expires_at' => Carbon::now()->addWeeks(1)->toDateTimeString()
          ]);
    }

    /**
     * Register Users
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json($user, 201);
    }

    public function logout()
    {
      if (!Auth::user())

        return response()->json([
            'message' => 'Unable to Logout'
        ]);

        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'message' => 'Logout successfully'
      ]);
     
        
      
     }
}
