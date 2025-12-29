<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\TeacherPasscode;
use App\Models\LabAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login user with email/password or passcode.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|string',
            'passcode' => 'nullable|string',
        ]);

        // 1️⃣ Standard password login
        if ($request->filled('password')) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();

                // Check if user has a school and if it's active
                $school = School::where('admin_email', $user->email)->first();
                if ($school && $school->status !== 'active') {
                    Auth::logout(); // Logout the user
                    return response()->json(['message' => 'Account not activated. Please contact admin.'], 403);
                }

                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }
        }

        // 2️⃣ Lab access code login
        if ($request->filled('passcode')) {
            $school = School::where('admin_email', $request->email)->first();
            if (!$school) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Check if school is active
            if ($school->status !== 'active') {
                return response()->json(['message' => 'Account not activated. Please contact admin.'], 403);
            }

            // Lab access code
            $accessCode = LabAccessCode::where('school_id', $school->id)
                ->where('access_code', $request->passcode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })->first();

            if ($accessCode) {
                return $this->temporaryUserResponse($accessCode, 'lab_user', $school);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Helper to return temporary user response for passcode users
     */
    /**
 * Helper to return temporary user response for passcode users
 */
private function temporaryUserResponse($userObject, $role, $school)
{
    // Build school object for frontend
    $schoolData = [
        'id' => $school->id,
        'name' => $school->name,
        'centre_number' => $school->centre_number,
        'district' => $school->district,
        'admin_name' => $school->admin_name ?? null,
        'admin_email' => $school->admin_email,
        'admin_phone' => $school->admin_phone,
        'status' => $school->status ?? 'active',
    ];

    // Build user object
    $user = [
        'id' => $role . '_' . $userObject->id,
        'name' => $role === 'teacher' ? $userObject->teacher_name : $userObject->user_name,
        'email' => $school->admin_email,
        'accountType' => $role,
        'type' => $role,
        'role' => $role,
        'permissions' => $userObject->permissions,
        'school_id' => $school->id,
        'school' => $schoolData,
        'institution_name' => $school->name,
        'temporary' => true, // Flag for React frontend
    ];

    // Add passcode or access_code ID
    if ($role === 'teacher') {
        $user['passcode_id'] = $userObject->id;
    } else {
        $user['access_code_id'] = $userObject->id;
    }

    // Feature flags for frontend
    $user['featureFlags'] = [
        'labManagementEnabled' => in_array($role, ['teacher', 'lab_user']),
    ];

    // Generate temporary token
    $token = $role . '_' . $userObject->id . '_' . now()->timestamp;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token,
    ], 200);
}


    /**
     * Register a new institution with only one admin allowed.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|string|max:255',
            'centre_number' => 'required|string|max:100|unique:schools,centre_number',
            'district' => 'required|string|max:100',
            'adminName' => 'required|string|max:255',
            'adminEmail' => 'required|email|unique:users,email',
            'adminPhone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Enforce only one admin per institution
        if (School::where('centre_number', $request->centre_number)->exists()) {
            return response()->json([
                'message' => 'This institution is already registered',
                'errors' => ['centre_number' => ['An admin already exists for this institution.']],
            ], 409);
        }

        // 1️⃣ Create admin user
        $user = User::create([
            'firstName' => explode(' ', $request->adminName)[0],
            'lastName' => explode(' ', $request->adminName, 2)[1] ?? 'Admin',
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'password' => Hash::make($request->password),
            'role_id' => 1, // Admin role
        ]);

        // 2️⃣ Create school
        $school = School::create([
            'name' => $request->institution_name,
            'centre_number' => $request->centre_number,
            'district' => $request->district,
            'admin_name' => $request->adminName,
            'admin_email' => $request->adminEmail,
            'admin_phone' => $request->adminPhone,
            'status' => 'pending',
        ]);

        // 3️⃣ Auto-login after registration
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'school' => $school,
            'token' => $token,
        ], 201);
    }

    /**
     * Logout user and revoke token
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // Optional: Placeholder methods for future implementation
    public function forgotPassword(Request $request)
    {
        return response()->json(['message' => 'Forgot password not implemented'], 501);
    }

    public function resetPassword(Request $request)
    {
        return response()->json(['message' => 'Reset password not implemented'], 501);
    }

    public function getAllUsers(Request $request)
    {
        return response()->json(['message' => 'Get all users not implemented'], 501);
    }

    public function getAllUsersTable(Request $request)
    {
        return response()->json(['message' => 'Get all users table not implemented'], 501);
    }

    /**
     * Get all schools for admin management
     */
    public function getSchools(Request $request)
    {
        $schools = School::all();
        return response()->json($schools);
    }

    /**
     * Activate or deactivate a school
     */
    public function updateSchoolStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending,suspended',
        ]);

        $school = School::findOrFail($id);
        $school->status = $request->status;
        $school->save();

        return response()->json([
            'message' => 'School status updated successfully',
            'school' => $school,
        ]);
    }

    /**
     * Show schools management page (Blade view)
     */
    public function schoolsManagement()
    {
        $schools = School::all();
        return view('admin.schools', compact('schools'));
    }
}
