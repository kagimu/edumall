<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index()
    {
        session(['title' => 'Laboratory Items']);
        $labs = Lab::all();
        return view('labs.index', compact('labs'));
    }

    public function create()
    {
        return view('labs.create');
    }


    public function store(Request $request)
    {
        try {
            \Log::info('Received lab creation request from web interface');

            $validated = $request->validate([
                'name' => 'required|string',
                'category' => 'required|in:apparatus,specimen,chemical',
                'avatar' => 'nullable|image|max:10240',
                'avatar_url' => 'nullable|url', // ✅ Add this
                'color' => 'nullable|string',
                'rating' => 'nullable|string',
                'in_stock' => 'nullable|string',
                'condition' => 'required|in:new,old',
                'price' => 'required|string',
                'unit' => 'nullable|string',
                'desc' => 'nullable|string',
                'purchaseType' => 'nullable|string',
            ], [
                'category.in' => 'The category must be either apparatus, specimen, or chemical.',
                'condition.in' => 'The condition must be either new or old.',
                'avatar.image' => 'The avatar must be an image file.',
                'avatar_url.url' => 'The avatar URL must be a valid URL.', // ✅
                'images.*.image' => 'All uploaded images must be image files.',
                'images.*.mimes' => 'All uploaded images must be of type: jpeg, png, jpg, webp, gif.',
            ]);

            // Set default values
            $validated['rating'] = $validated['rating'] ?? '0';
            $validated['in_stock'] = $validated['in_stock'] ?? '1';
            $validated['purchaseType'] = $validated['purchaseType'] ?? 'purchase';

            $lab = new Lab();
            $lab->fill($validated);

            // ✅ Use avatar_url if no file was uploaded
            if (!$request->hasFile('avatar') && $request->filled('avatar_url')) {
                $lab->avatar = $request->input('avatar_url');
                \Log::info('Using external avatar URL: ' . $lab->avatar);
            }

            // ✅ Handle avatar file upload
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

            // ✅ Handle multiple images
           // ✅ Handle multiple images (uploaded + URLs)
                $allImages = [];

                // Handle uploaded image files
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $index => $image) {
                        \Log::info('Processing uploaded image file:', [
                            'index' => $index,
                            'original_name' => $image->getClientOriginalName(),
                            'mime_type' => $image->getMimeType(),
                            'size' => $image->getSize()
                        ]);

                        $path = $image->store('images/labs', 'public');
                        if ($path) {
                            $allImages[] = $path;
                        }
                    }
                }

                // Handle external image URLs
                if ($request->filled('images_url')) {
                    $urls = array_map('trim', explode(',', $request->input('images_url')));
                    $validUrls = array_filter($urls, fn($url) => filter_var($url, FILTER_VALIDATE_URL));
                    $allImages = array_merge($allImages, $validUrls);
                }

                $lab->images = $allImages;


            $lab->save();
            \Log::info('Lab item created successfully:', ['id' => $lab->id]);

            return redirect()->route('labs.index')
                ->with('success', 'Laboratory item created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Lab validation error: ' . json_encode($e->errors()));
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Lab creation error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating laboratory item: ' . $e->getMessage());
        }
    }


    public function show(Lab $lab)
    {
        return view('labs.show', compact('lab'));
    }

    public function edit(Lab $lab)
    {
        return view('labs.edit', compact('lab'));
    }

    public function update(Request $request, Lab $lab)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:apparatus,specimen,chemical',
            'avatar' => 'nullable|image|max:10240',
            'avatar_url' => 'nullable|url', // ✅ Added validation for avatar_url
            'color' => 'nullable|string',
            'rating' => 'nullable|string',
            'in_stock' => 'nullable|string',
            'condition' => 'required|in:new,old',
            'price' => 'required|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'purchaseType' => 'nullable|string',
        ]);

        $lab->fill($validated);

        // ✅ Use avatar_url if no new file is uploaded
        if (!$request->hasFile('avatar') && $request->filled('avatar_url')) {
            // Delete old storage image if it exists and isn't a URL
            if ($lab->avatar && !filter_var($lab->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($lab->avatar);
            }
            $lab->avatar = $request->input('avatar_url');
            \Log::info('Updated using external avatar URL: ' . $lab->avatar);
        }

        // ✅ Handle new avatar file upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored in storage
            if ($lab->avatar && !filter_var($lab->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($lab->avatar);
            }

            $path = $request->file('avatar')->store('images/labs', 'public');
            $lab->avatar = $path;
        }

        // ✅ Handle multiple images update
       // ✅ Handle multiple images (uploaded + URLs) on update
        $allImages = [];

        // Delete old images (only local ones)
        if (!empty($lab->images)) {
            foreach ($lab->images as $oldImage) {
                if (!filter_var($oldImage, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        // Handle uploaded image files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/labs', 'public');
                if ($path) {
                    $allImages[] = $path;
                }
            }
        }

        // Handle external image URLs
        if ($request->filled('images_url')) {
            $urls = array_map('trim', explode(',', $request->input('images_url')));
            $validUrls = array_filter($urls, fn($url) => filter_var($url, FILTER_VALIDATE_URL));
            $allImages = array_merge($allImages, $validUrls);
        }

        $lab->images = $allImages;


        $lab->save();

        return redirect()->route('labs.index')->with('status', 'Lab updated successfully.');
    }

    public function destroy(Lab $lab)
    {
        if ($lab->avatar) {
            Storage::disk('public')->delete($lab->avatar);
        }

        if (!empty($lab->images)) {
            foreach ($lab->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab deleted successfully.');
    }
}
