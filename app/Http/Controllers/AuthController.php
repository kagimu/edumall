<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\TeacherPasscode;
use App\Models\LabAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|string',
            'passcode' => 'nullable|string',
        ]);

        // First try regular user login if password provided
        if ($request->has('password') && $request->password) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful.',
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }
        }

        // If password login failed or no password, try passcode login
        if ($request->has('passcode')) {
            // Find school by admin email
            $school = School::where('admin_email', $request->email)->first();
            if (!$school) {
                return response()->json(['message' => 'Invalid credentials.'], 401);
            }

            // First try teacher passcode
            $passcode = TeacherPasscode::where('school_id', $school->id)
                ->where('passcode', $request->passcode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($passcode) {
                // Create a temporary user-like object for teacher
                $teacherUser = [
                    'id' => 'teacher_' . $passcode->id,
                    'name' => $passcode->teacher_name,
                    'email' => $request->email,
                    'accountType' => 'teacher',
                    'role' => 'teacher',
                    'school_id' => $school->id,
                    'permissions' => $passcode->permissions,
                    'passcode_id' => $passcode->id,
                ];

                // Create a token for the teacher
                $token = 'teacher_' . $passcode->id . '_' . now()->timestamp;

                return response()->json([
                    'message' => 'Login successful.',
                    'user' => $teacherUser,
                    'token' => $token,
                ], 200);
            }

            // If teacher passcode not found, try lab access code
            $accessCode = LabAccessCode::where('school_id', $school->id)
                ->where('access_code', $request->passcode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($accessCode) {
                // Create a user-like object for lab user
                $labUser = [
                    'id' => 'lab_' . $accessCode->id,
                    'name' => $accessCode->user_name,
                    'email' => $request->email,
                    'accountType' => 'lab_user',
                    'role' => $accessCode->role,
                    'school_id' => $school->id,
                    'permissions' => $accessCode->permissions,
                    'access_code_id' => $accessCode->id,
                    'institution_name' => $school->name,
                ];

                // Create a token for the lab user
                $token = 'lab_' . $accessCode->id . '_' . now()->timestamp;

                return response()->json([
                    'message' => 'Login successful.',
                    'user' => $labUser,
                    'token' => $token,
                ], 200);
            }

            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'institution_name' => 'required|string|max:255',
        'centre_number'    => 'required|string|max:100',
        'district'         => 'required|string|max:100',

        'adminName'  => 'required|string|max:255',
        'adminEmail' => 'required|email|unique:users,email',
        'adminPhone' => 'required|string|max:20',

        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    // 1️⃣ Create User (Admin)
    $user = User::create([
        'firstName' => explode(' ', $request->adminName)[0],
        'lastName'  => explode(' ', $request->adminName, 2)[1] ?? 'Admin',
        'email'     => $request->adminEmail,
        'phone'     => $request->adminPhone,
        'password'  => Hash::make($request->password),

        // 🔐 Automatically assign Admin role
        'role_id'   => 1,
    ]);

    // 2️⃣ Create School
    $school = School::create([
        'name'        => $request->institution_name,
        'centre_no'   => $request->centre_number,
        'district'    => $request->district,
        'admin_email' => $request->adminEmail,
        'admin_phone' => $request->adminPhone,
        'user_id'     => $user->id,
    ]);

    // 3️⃣ Create token
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'message' => 'Registration successful',
        'user'    => $user,
        'school'  => $school,
        'token'   => $token,
    ], 201);
}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request)
    {
        // Implement forgot password
        return response()->json(['message' => 'Forgot password not implemented'], 501);
    }

    public function resetPassword(Request $request)
    {
        // Implement reset password
        return response()->json(['message' => 'Reset password not implemented'], 501);
    }

    public function getAllUsers(Request $request)
    {
        // Implement get all users
        return response()->json(['message' => 'Get all users not implemented'], 501);
    }

    public function getAllUsersTable(Request $request)
    {
        // Implement get all users table
        return response()->json(['message' => 'Get all users table not implemented'], 501);
    }
}
