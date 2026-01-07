<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * ============================
     * REGISTER INSTITUTION (ADMIN)
     * ============================
     */


    public function register(Request $request)
    {
        // 1️⃣ Validate the form data
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'centre_number'    => 'required|string|max:50|unique:schools,data->centre_number',
            'district'         => 'required|string|max:255',
            'adminName'        => 'required|string|max:255',
            'adminEmail'       => 'required|email|unique:users,email',
            'adminPhone'       => 'required|string|max:50',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user = null;
        $school = null;

        // 2️⃣ Wrap creation in a transaction
        \DB::transaction(function () use ($request, &$school, &$user) {
            // 3️⃣ Create the school (tenant)
            $school = School::create([
                'id'   => \Illuminate\Support\Str::uuid(),
                'name' => $request->institution_name,
                'data' => [
                    'name'             => $request->institution_name,
                    'centre_number'    => $request->centre_number,
                    'district'         => $request->district,
                    'admin_name'       => $request->adminName,
                    'admin_email'      => $request->adminEmail,
                    'admin_phone'      => $request->adminPhone,
                    'status'           => 'active',
                    'paymentMethods'   => $request->paymentMethods ?? [],
                    'mobileMoneyNumber'=> $request->mobileMoneyNumber ?? null,
                    'bankAccount'      => $request->bankAccount ?? null,
                    'designation'      => $request->designation ?? null,
                    'customDesignation'=> $request->customDesignation ?? null,
                ],
            ]);

            // 4️⃣ Create the admin user
            $user = User::create([
                'firstName'       => $request->adminName,
                'lastName'        => '', // optional
                'email'           => $request->adminEmail,
                'phone'           => $request->adminPhone,
                'password'        => \Hash::make($request->password),
                'tenant_id'       => $school->id,
                'role_id'         => 1, // Admin role
                'is_school_admin' => true,
            ]);
        });

        // 5️⃣ Return a clean response with token
        return response()->json([
            'message' => 'Registration successful',
            'user'    => $user,
            'school'  => $school,
            'token'   => $user->createToken('API Token')->plainTextToken,
        ]);
    }




    /**
     * ============
     * LOGIN USER
     * ============
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }


        if ($user->school && $user->school->status !== 'active') {
            return response()->json(['message' => 'Institution account is not active'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'message' => 'Login successful',
            'user'    => $this->authUserResponse($user),
            'token'   => $token,
        ]);
    }

    /**
     * ============
     * LOGOUT
     * ============
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * ============================
     * GET ALL USERS
     * ============================
     */
    public function getAllUsers()
    {
        $users = User::with('school')->get();

        return response()->json([
            'users' => $users->map(function ($user) {
                return [
                    'id'              => $user->id,
                    'firstName'       => $user->firstName,
                    'lastName'        => $user->lastName,
                    'email'           => $user->email,
                    'role_id'         => $user->role_id,
                    'is_school_admin' => (bool) $user->is_school_admin,
                    'tenant_id'       => $user->tenant_id,
                    'accountType'     => 'institution',
                    'school' => $user->school ? [
                        'id'     => $user->school->id,
                        'name'   => $user->school->name,
                        'status' => $user->school->status,
                    ] : null,
                ];
            }),
        ]);
    }

    /**
     * ============================
     * STANDARD AUTH RESPONSE
     * ============================
     */
    /**
 * Standard auth response including full school data
 */
private function authUserResponse(User $user): array
{
    return [
        'id'              => $user->id,
        'firstName'       => $user->firstName,
        'lastName'        => $user->lastName,
        'email'           => $user->email,
        'role_id'         => $user->role_id,
        'is_school_admin' => (bool) $user->is_school_admin,
        'tenant_id'       => $user->tenant_id,
        'accountType'     => 'institution',

        'school' => $user->school ? [
            'id'     => $user->school->id,
            'name'   => $user->school->name,
            'status' => $user->school->status,
        ] : null,
    ];
}


}
