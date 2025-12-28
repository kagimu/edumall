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
