<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'accountType' => 'required|in:individual,institution',
        'phone_number' => 'required|string|max:15',
        'institution_name' => 'required_if:accountType,institution|string|max:255',
        'centre_number' => 'required_if:accountType,institution|string|max:255',
        'district' => 'nullable|string|max:255',
        'subcounty' => 'nullable|string|max:255',
        'parish' => 'nullable|string|max:255',
        'village' => 'nullable|string|max:255',
        'admin_name' => 'required_if:accountType,institution|string|max:255',
        'admin_designation' => 'required_if:accountType,institution|string|max:255',
        'admin_email' => 'required_if:accountType,institution|email|max:255',
        'admin_number' => 'required_if:accountType,institution|string|max:15',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'accountType' => $request->accountType,
        'phone_number' => $request->phone_number,
        'institution_name' => $request->accountType === 'institution' ? $request->institution_name : null,
        'centre_number' => $request->accountType === 'institution' ? $request->centre_number : null,
        'district' => $request->district,
        'subcounty' => $request->subcounty,
        'parish' => $request->parish,
        'village' => $request->village,
        'admin_name' => $request->accountType === 'institution' ? $request->admin_name : null,
        'admin_designation' => $request->accountType === 'institution' ? $request->admin_designation : null,
        'admin_email' => $request->accountType === 'institution' ? $request->admin_email : null,
        'admin_number' => $request->accountType === 'institution' ? $request->admin_number : null,
    ]);

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully.',
        'user' => $user,
        'token' => $token,
    ], 201);
}
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'User logged out successfully.'], 200);
}

        return response()->json(['message' => 'No user is logged in.'], 401);
    }
    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        $user = Auth::user();
        if ($user) {           
            return response()->json([
                'user' => $user,
            ], 200);
        }

        return response()->json(['message' => 'No user is logged in.'], 401);
    }
}