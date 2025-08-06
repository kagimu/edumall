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
                'images' => 'nullable|image|array',
                'images.*' => 'nullable|image|max:10240',
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
                'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg, gif.',
                'images.*.image' => 'All uploaded images must be image files.',
                'images.*.mimes' => 'All uploaded images must be of type: jpeg, png, jpg, gif.',
            ]);

            // Set default values
            $validated['rating'] = $validated['rating'] ?? '0';
            $validated['in_stock'] = $validated['in_stock'] ?? '1';
            $validated['purchaseType'] = $validated['purchaseType'] ?? 'purchase';

            $lab = new Lab();
            $lab->fill($validated);

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

        // Handle avatar update
        if ($request->hasFile('avatar')) {
            if ($lab->avatar) {
                Storage::disk('public')->delete($lab->avatar);
            }
            $lab->avatar = $request->file('avatar')->store('images/labs', 'public');
        }

        // Handle images update
        if ($request->hasFile('images')) {
            if (!empty($lab->images)) {
                foreach ($lab->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $images = collect($request->file('images'))->map(function ($image) {
                return $image->store('images/labs', 'public');
            });

            $lab->images = $images->toArray();
        }

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
