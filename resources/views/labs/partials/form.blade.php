<div class="form-group">
    <label>Product Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $lab->name ?? '') }}">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="desc" class="form-control tinymce-editor">{{ old('desc', $lab->desc ?? '') }}</textarea>
    @error('desc') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Category</label>
    <select name="category" class="form-control">
        <option value="" disabled {{ !isset($lab) ? 'selected' : '' }}>Select category</option>
        @foreach(['apparatus', 'specimen', 'chemical'] as $option)
            <option value="{{ $option }}" {{ (old('category', $lab->category ?? '') == $option) ? 'selected' : '' }}>
                {{ ucfirst($option) }}
            </option>
        @endforeach
    </select>
    @error('category') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Color</label>
    <input type="text" name="color" class="form-control" value="{{ old('color', $lab->color ?? '') }}">
    @error('color') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Rating (1-5)</label>
    <input type="text" name="rating" class="form-control" value="{{ old('rating', $lab->rating ?? '') }}">
    @error('rating') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>In Stock</label>
    <input type="text" name="in_stock" class="form-control" value="{{ old('in_stock', $lab->in_stock ?? '') }}">
    @error('in_stock') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Price</label>
    <input type="text" name="price" class="form-control" value="{{ old('price', $lab->price ?? '') }}">
    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Purchase Type</label>
    <input type="text" name="purchaseType" class="form-control" value="{{ old('purchaseType', $lab->purchaseType ?? '') }}">
    @error('purchaseType') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Unit (e.g. piece, kg)</label>
    <input type="text" name="unit" class="form-control" value="{{ old('unit', $lab->unit ?? '') }}">
    @error('unit') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Condition</label>
    <select name="condition" class="form-control">
        <option value="" disabled {{ !isset($lab) ? 'selected' : '' }}>Select condition</option>
        @foreach(['new', 'old'] as $option)
            <option value="{{ $option }}" {{ (old('condition', $lab->condition ?? '') == $option) ? 'selected' : '' }}>
                {{ ucfirst($option) }}
            </option>
        @endforeach
    </select>
    @error('condition') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Main Image</label>
    <input type="file" name="avatar" class="form-control">
    @if(isset($lab) && $lab->avatar)
        <img src="{{ asset('storage/' . $lab->avatar) }}" width="100" class="mt-2 rounded">
    @endif
    @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Additional Images</label>
    <input type="file" name="images[]" multiple class="form-control">
    @error('images') <small class="text-danger">{{ $message }}</small> @enderror
</div>
