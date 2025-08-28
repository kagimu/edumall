<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    // Define subcategories per category
    private $subcategories = [
        'laboratory' => ['apparatus', 'specimen', 'chemical'],
        'textbooks' => ['textbook', 'revision guide', 'novel'],
        'stationery' => ['scholastic', 'paper'],
        'school_accessories' => ['accessories', 'schoolwear'],
        'boardingSchool' => ['dormitory', 'toiletries'],
        'sports' => ['equipment', 'wear'],
        'food' => ['snacks', 'beverages'],
        'technology' => ['devices', 'accessories'],
        'furniture' => ['chairs', 'tables', 'storage'],
        'health' => ['hygieneTools ', 'firstaid']
    ];

    public function index()
    {
        session(['title' => 'Products']);
        $labs = Lab::all();
        return view('labs.index', compact('labs'));
    }

    public function create()
    {
        return view('labs.create', ['subcategories' => $this->subcategories]);
    }

   public function store(Request $request)
    {
        try {
            \Log::info('Received lab creation request');

            // Base validation rules
            $rules = [
                'name' => 'required|string',
                'category' => 'required|in:laboratory,textbooks,stationery,school_accessories,boardingSchool,sports,food,health,furniture,technology',
                'avatar' => 'nullable|image|max:10240',
                'avatar_url' => 'nullable|url',
                'color' => 'nullable|string',
                'rating' => 'nullable|string',
                'in_stock' => 'nullable|string',
                'condition' => 'required|in:new,old',
                'price' => 'required|string',
                'unit' => 'nullable|string',
                'desc' => 'nullable|string',
                'purchaseType' => 'nullable|string',
            ];

            // Dynamic subcategory validation
            $category = $request->input('category');
            if (isset($this->subcategories[$category])) {
                $rules['subcategory'] = 'required|in:' . implode(',', $this->subcategories[$category]);
            } else {
                $rules['subcategory'] = 'nullable|string';
            }

            $validated = $request->validate($rules);

            // Set default values
            $validated['rating'] = $validated['rating'] ?? '0';
            $validated['in_stock'] = $validated['in_stock'] ?? '1';
            $validated['purchaseType'] = $validated['purchaseType'] ?? 'purchase';

            $lab = new Lab();
            $lab->fill($validated);

            // Handle avatar
            if ($request->hasFile('avatar')) {
                $lab->avatar = $request->file('avatar')->store('images/labs', 'public');
            } elseif ($request->filled('avatar_url')) {
                $lab->avatar = $request->input('avatar_url');
            }

            // Handle multiple images (uploaded + URLs)
            $newImages = [];

            // Uploaded files
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images/labs', 'public');
                    if ($path) $newImages[] = $path;
                }
            }

            // URLs from textarea
            if ($request->filled('images_url')) {
                $urls = array_map('trim', explode(',', $request->input('images_url')));
                $urls = array_filter($urls, fn($url) => filter_var($url, FILTER_VALIDATE_URL));
                $newImages = array_merge($newImages, $urls);
            }

            // Remove duplicates
            $lab->images = array_unique($newImages);
            $lab->save();

            return redirect()->route('labs.index')->with('success', 'Lab item created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Lab creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error creating lab item: ' . $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        return view('labs.show', compact('lab'));
    }

    public function edit(Lab $lab)
    {
        return view('labs.edit', ['lab' => $lab, 'subcategories' => $this->subcategories]);
    }

   public function update(Request $request, Lab $lab)
    {
        try {
            // Base validation rules (same as store)
            $rules = [
                'name' => 'required|string',
                'category' => 'required|in:laboratory,textbooks,stationery,school_accessories,boardingSchool,sports,food,health,furniture,technology',
                'avatar' => 'nullable|image|max:10240',
                'avatar_url' => 'nullable|url',
                'color' => 'nullable|string',
                'rating' => 'nullable|string',
                'in_stock' => 'nullable|string',
                'condition' => 'required|in:new,old',
                'price' => 'required|string',
                'unit' => 'nullable|string',
                'desc' => 'nullable|string',
                'purchaseType' => 'nullable|string',
            ];

            // Dynamic subcategory validation
            $category = $request->input('category');
            if (isset($this->subcategories[$category])) {
                $rules['subcategory'] = 'required|in:' . implode(',', $this->subcategories[$category]);
            } else {
                $rules['subcategory'] = 'nullable|string';
            }

            $validated = $request->validate($rules);

            // Set default values
            $validated['rating'] = $validated['rating'] ?? '0';
            $validated['in_stock'] = $validated['in_stock'] ?? '1';
            $validated['purchaseType'] = $validated['purchaseType'] ?? 'purchase';

            $lab->fill($validated);

            // Handle avatar
            if ($request->hasFile('avatar')) {
                if ($lab->avatar && !filter_var($lab->avatar, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($lab->avatar);
                }
                $lab->avatar = $request->file('avatar')->store('images/labs', 'public');
            } elseif ($request->filled('avatar_url')) {
                if ($lab->avatar && !filter_var($lab->avatar, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($lab->avatar);
                }
                $lab->avatar = $request->input('avatar_url');
            }

            // Handle multiple images (merge old + new)
            $newImages = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images/labs', 'public');
                    if ($path) $newImages[] = $path;
                }
            }

            if ($request->filled('images_url')) {
                $urls = array_map('trim', explode(',', $request->input('images_url')));
                $urls = array_filter($urls, fn($url) => filter_var($url, FILTER_VALIDATE_URL));
                $newImages = array_merge($newImages, $urls);
            }

            // Merge old images with new, remove duplicates
            $lab->images = array_unique(array_merge($lab->images ?? [], $newImages));
            $lab->save();

            return redirect()->route('labs.index')->with('status', 'Lab updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating lab item: ' . $e->getMessage());
        }
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
