@extends('layouts.master')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Product</h4>
        </div>
        <div class="pull-right mb-3">
            <a class="btn btn-primary" href="{{ route('labs.index') }}"> Back</a>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('labs.update', $lab->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" name="name" class="form-control" 
                           value="{{ old('name', $lab->name) }}">
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc" class="form-label">Description:</label>
                    <textarea name="desc" rows="4" class="form-control tinymce-editor">{{ old('desc', $lab->desc) }}</textarea>
                    @error('desc')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="apparatus" {{ old('category', $lab->category) == 'apparatus' ? 'selected' : '' }}>Apparatus</option>
                        <option value="specimen" {{ old('category', $lab->category) == 'specimen' ? 'selected' : '' }}>Specimen</option>
                        <option value="chemical" {{ old('category', $lab->category) == 'chemical' ? 'selected' : '' }}>Chemical</option>
                    </select>
                    @error('category')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color" class="form-label">Product Color:</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color', $lab->color) }}">
                    @error('color')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating" class="form-label">Product rating scale from 1 to 5:</label>
                    <input type="text" name="rating" class="form-control" value="{{ old('rating', $lab->rating) }}">
                    @error('rating')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="in_stock" class="form-label">Number of Available pieces in stock:</label>
                    <input type="text" name="in_stock" class="form-control" value="{{ old('in_stock', $lab->in_stock) }}">
                    @error('in_stock')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Product price:</label>
                    <input type="text" name="price" class="form-control" value="{{ old('price', $lab->price) }}">
                    @error('price')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="purchaseType" class="form-label">Is the Product for purchase or hire?</label>
                    <input type="text" name="purchaseType" class="form-control" value="{{ old('purchaseType', $lab->purchaseType) }}">
                    @error('purchaseType')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit" class="form-label">Product unit (piece, kg, packet):</label>
                    <input type="text" name="unit" class="form-control" value="{{ old('unit', $lab->unit) }}">
                    @error('unit')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="condition" class="form-label">Condition of the Product:</label>
                    <select name="condition" id="condition" class="form-control">
                        <option value="new" {{ old('condition', $lab->condition) == 'new' ? 'selected' : '' }}>New</option>
                        <option value="old" {{ old('condition', $lab->condition) == 'old' ? 'selected' : '' }}>Old</option>
                    </select>
                    @error('condition')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-10">
                    <label for="avatar" class="form-label">Main Image (change if you want):</label><br>
                    @if($lab->avatar)
                        <img src="{{ asset('storage/' . $lab->avatar) }}" alt="Current Image" width="150" class="mb-2">
                    @endif
                    <input type="file" name="avatar" id="avatar" class="form-control" />
                    @error('avatar')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-10">
                    <label for="images" class="form-label">Additional Images (replace if you want):</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple />
                    @error('images')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-5 mb-0">Update Product</button>

            </form>
        </div>
    </div>
</div>

@endsection
