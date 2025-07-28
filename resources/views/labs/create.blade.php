@extends('layouts.master')

@section('content')


<!-- End Row-->

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Product</h4>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('labs.index') }}"> Back</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-1 mt-1">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('labs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="">
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc" class="form-label">Description:</label>
                    <textarea name="desc" rows="4" cols="30" class="form-control tinymce-editor"></textarea>
                    @error('desc')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Select the Category of the Product:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="" disabled selected>Select a category</option>
                        <option value="apparatus">Apparatus</option>
                        <option value="specimen">Specimen</option>
                        <option value="chemical">Chemical</option>
                    </select>
                    @error('category')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color" class="form-label">Product Color:</label>
                    <input type="text" name="color" class="form-control" placeholder="">
                    @error('color')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating" class="form-label">Product rating scale from 1 to 5:</label>
                    <input type="text" name="rating" class="form-control" placeholder="">
                    @error('rating')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="in_stock" class="form-label">Number of Available pieces in stock:</label>
                    <input type="text" name="in_stock" class="form-control" placeholder="">
                    @error('in_stock')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Product price:</label>
                    <input type="text" name="price" class="form-control" placeholder="">
                    @error('price')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="purchaseType" class="form-label">Is the Product for purchase or hire?</label>
                    <input type="text" name="purchaseType" class="form-control" placeholder="">
                    @error('purchaseType')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit" class="form-label">Product unit (piece, kg, packet):</label>
                    <input type="text" name="unit" class="form-control" placeholder="">
                    @error('unit')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="condition" class="form-label">whats the condition of the Product:</label>
                    <select name="condition" id="condition" class="form-control">
                        <option value="" disabled selected>Select a condition</option>
                        <option value="new">New</option>
                        <option value="old">Old</option>
                    </select>
                    @error('condition')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-10">
                    <label for='avatar' class="form-label">Select Product Main Image:</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" />
                    @error('avatar')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-10">
                    <label for="images" class="form-label">Upload Additional Images:</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple />
                    @error('images')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary mt-5 mb-0">Upload Product</button>

            </form>
        </div>
    </div>
</div>

<!-- End Row -->

@endsection
