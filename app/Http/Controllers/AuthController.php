<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\Role;
use App\Models\School;
use App\Models\TeacherPasscode;


class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
 public function register(Request $request)
{
    $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',

        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',

        'accountType' => 'required|in:individual,institution',
        'phone' => 'required|string|max:15',

        'institution_name' => 'required_if:accountType,institution',
        'centre_number' => 'required_if:accountType,institution',
        'adminName' => 'required_if:accountType,institution',
        'adminEmail' => 'required_if:accountType,institution',
        'adminPhone' => 'required_if:accountType,institution',
    ]);

    // 🔑 Determine role
    if ($request->accountType === 'institution') {
        $role = Role::where('name', 'admin')->first();
    } else {
        // individual user (Parent)
        $role = Role::where('name', 'parent')->first();
    }

    if (!$role) {
        return response()->json([
            'message' => 'Role not configured. Contact admin.'
        ], 500);
    }

    // Create school for institution users
    $schoolId = null;
    if ($request->accountType === 'institution') {
        $school = School::create([
            'name' => $request->institution_name,
            'centre_number' => $request->centre_number,
            'district' => $request->district,
            'subcounty' => $request->subcounty,
            'parish' => $request->parish,
            'village' => $request->village,
            'admin_name' => $request->adminName,
            'admin_email' => $request->adminEmail,
            'admin_phone' => $request->adminPhone,
            'role_id' => 1, // Link to admin role
        ]);
        $schoolId = $school->id;
    }

    $user = User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,

        'role_id' => $role->id, // ✅ REQUIRED
        'school_id' => $schoolId,
        'is_school_admin' => $request->accountType === 'institution', // ✅ NEW: Mark as school admin

        'bankAccount' => $request->bankAccount,
        'mobileMoneyNumber' => $request->mobileMoneyNumber,
        'paymentMethods' => $request->paymentMethods,

        'userType' => $request->userType, // optional (legacy)
        'customUserType' => $request->customUserType,

        'email' => $request->email,
        'password' => Hash::make($request->password),

        'accountType' => $request->accountType,
        'phone' => $request->phone,

        'institution_name' => $request->accountType === 'institution' ? $request->institution_name : null,
        'centre_number' => $request->accountType === 'institution' ? $request->centre_number : null,

        'district' => $request->district,
        'subcounty' => $request->subcounty,
        'parish' => $request->parish,
        'village' => $request->village,

        'adminName' => $request->accountType === 'institution' ? $request->adminName : null,
        'customDesignation' => $request->designation === 'Other'
            ? $request->customDesignation
            : $request->designation,

        'adminEmail' => $request->accountType === 'institution' ? $request->adminEmail : null,
        'adminPhone' => $request->accountType === 'institution' ? $request->adminPhone : null,
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
            'password' => 'sometimes|string|min:6',
            'passcode' => 'sometimes|string',
        ]);

        // First, try admin login with email and password
        if ($request->has('password')) {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user()->load('school', 'role');

                // Check if school is active for institution users
                if ($user->school && !$user->school->isActive()) {
                    return response()->json(['message' => 'Your school account has been deactivated. Please contact support.'], 403);
                }

                $token = $user->createToken('authToken')->plainTextToken;

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

            // Find active passcode
            $passcode = TeacherPasscode::where('school_id', $school->id)
                ->where('passcode', $request->passcode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->first();

            if (!$passcode) {
                return response()->json(['message' => 'Invalid credentials.'], 401);
            }

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

            // Create a token for the teacher (using a dummy user or custom token)
            // For simplicity, create a token with teacher data
            $token = 'teacher_' . $passcode->id . '_' . now()->timestamp; // Simple token, in production use proper JWT

            return response()->json([
                'message' => 'Login successful.',
                'user' => $teacherUser,
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
                'user' => $user->load('school'),
            ], 200);
        }

        return response()->json(['message' => 'No user is logged in.'], 401);
    }

    /**
 * Get all registered users (admin use).
 */
    public function getAllUsers()
    {
        $users = User::all();

        return response()->json([
            'message' => 'All users retrieved successfully.',
            'users' => $users,
        ], 200);
    }

    public function getAllUsersTable()
        {
            $users = User::all();

            return view('users.index', compact('users'));
        }

    /**
     * Handle forgot password request.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Return success to prevent email enumeration
            return response()->json(['message' => 'If an account with that email exists, a password reset link has been sent.'], 200);
        }

        // Only allow school admins to reset password
        if (!$user->is_school_admin) {
            return response()->json(['message' => 'Password reset is only available for school administrators.'], 400);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'If an account with that email exists, a password reset link has been sent.'], 200)
            : response()->json(['message' => 'Unable to send reset link.'], 400);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(null);

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'], 200)
            : response()->json(['message' => 'Invalid token or email.'], 400);
    }

}
