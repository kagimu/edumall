<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Lab;
    use Illuminate\Http\Request;

    class LabApiController extends Controller
    {
        public function index()
        {
            $labs = Lab::all();

            return response()->json([
            'message' => 'Labs retrieved successfully.',
            'data' => $labs,
        ], 200)->header('Content-Type', 'application/json');
        }

        public function store(Request $request)
        {
            try {
                \Log::info('Received lab creation request with data:', [
                    'request_data' => $request->all(),
                    'has_files' => $request->hasFile('avatar') || $request->hasFile('images'),
                ]);

                $rules = [
                    'name' => 'required|string',
                    'category' => 'required|in:apparatus,specimen,chemical',
                    'color' => 'nullable|string',
                    'rating' => 'nullable|string',
                    'in_stock' => 'nullable|string',
                    'condition' => 'required|in:new,old',
                    'price' => 'required|string',
                    'unit' => 'nullable|string',
                    'desc' => 'nullable|string',
                    'purchaseType' => 'nullable|string',
                ];

                // Only validate files if they are present in the request
                if ($request->hasFile('avatar')) {
                    $rules['avatar'] = 'required|file|image|mimes:jpeg,png,jpg,gif|max:10240';
                }

                if ($request->hasFile('images')) {
                    $rules['images'] = 'required|array';
                    $rules['images.*'] = 'required|file|image|mimes:jpeg,png,jpg,gif|max:10240';
                }

                $validated = $request->validate($rules);

                // Set default values
                $validated['rating'] = $validated['rating'] ?? '0';
                $validated['in_stock'] = $validated['in_stock'] ?? '1';
                $validated['purchaseType'] = $validated['purchaseType'] ?? 'purchase';

                $lab = new Lab($validated);

                // Handle avatar upload
                if ($request->hasFile('avatar')) {
                    try {
                        $avatarFile = $request->file('avatar');
                        \Log::info('Processing avatar file:', [
                            'original_name' => $avatarFile->getClientOriginalName(),
                            'mime_type' => $avatarFile->getMimeType(),
                            'size' => $avatarFile->getSize()
                        ]);

                        $path = $avatarFile->store('images/labs', 'public');
                        if (!$path) {
                            throw new \Exception('Failed to store avatar file');
                        }
                        $lab->avatar = $path;

                        \Log::info('Avatar uploaded successfully:', ['path' => $path]);
                    } catch (\Exception $e) {
                        \Log::error('Avatar upload error:', [
                            'error' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine()
                        ]);
                        throw new \Exception('Failed to upload avatar image: ' . $e->getMessage());
                    }
                }

                // Handle multiple images
                if ($request->hasFile('images')) {
                    try {
                        $uploadedImages = [];
                        foreach ($request->file('images') as $index => $image) {
                            \Log::info('Processing image file:', [
                                'index' => $index,
                                'original_name' => $image->getClientOriginalName(),
                                'mime_type' => $image->getMimeType(),
                                'size' => $image->getSize()
                            ]);

                            $path = $image->store('images/labs', 'public');
                            if (!$path) {
                                throw new \Exception("Failed to store image at index {$index}");
                            }
                            $uploadedImages[] = $path;
                        }

                        $lab->images = $uploadedImages;
                        \Log::info('All images uploaded successfully:', ['paths' => $uploadedImages]);
                    } catch (\Exception $e) {
                        \Log::error('Multiple images upload error:', [
                            'error' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine()
                        ]);
                        throw new \Exception('Failed to upload one or more images: ' . $e->getMessage());
                    }
                }

                $lab->save();

                return response()->json([
                    'message' => 'Lab created successfully.',
                    'data' => $lab
                ], 201)->header('Content-Type', 'application/json');

            } catch (\Illuminate\Validation\ValidationException $e) {
                \Log::error('Lab validation error: ' . json_encode($e->errors()));
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422)->header('Content-Type', 'application/json');

            } catch (\Exception $e) {
                \Log::error('Lab creation error: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Error creating laboratory item',
                    'error' => $e->getMessage()
                ], 500)->header('Content-Type', 'application/json');
            }
        }
    }
