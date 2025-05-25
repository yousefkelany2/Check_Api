<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $guard;

    public function __construct()
    {
        $this->guard = 'api';
    }

    public function register(UserRequest $request)
    {
       try {
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type ?? 'user',
        ]);

        $token = auth($this->guard)->login($user);

        return $this->respondWithToken($token);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Registration failed.',
            'error' => $e->getMessage()
        ], 500);
    }

    }

    public function login()
    {
        try {
        $credentials = request(['phone', 'password']);

        if (! $token =  auth($this->guard)->attempt($credentials)) {
            return response()->json(['message' => 'Invalid phone or password.'], 401);
        }

        return $this->respondWithToken($token);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Login failed.',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   /*  public function me()
    {
        return response()->json([
            'data' => auth($this->guard)->user(),
        ]);
    }
    public function updateProfile(Request $request)
    {
    $user = auth($this->guard)->user();

    $request->validate([
        'name' => 'sometimes|string|max:255',
        'phone' => 'sometimes|email|unique:users,phone,' . $user->id,
        'password' => 'nullable|min:6',
    ]);

    if ($request->filled('name')) {
        $user->name = $request->name;
    }

    if ($request->filled('phone')) {
        $user->phone = $request->phone;
    }

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return response()->json([
        'message' => 'Profile updated successfully.',
        'data' => $user
    ]);
   } */

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
  /*   public function logout()
    {
        auth($this->guard)->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
 */
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
     public function refresh()
   {
    $newToken = auth($this->guard)->refresh();
    auth($this->guard)->setToken($newToken);

    return $this->respondWithToken($newToken);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60,
            'user' => auth($this->guard)->user(),
        ]);
    }

}
