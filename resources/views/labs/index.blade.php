@extends('layouts.master')

@section('content')


<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{session('title')}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a class="btn btn-success" href="{{ route('labs.create') }}"> Add Product</a>

    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Products</div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true"></button>
                    {{Session::get('message')}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">title</th>
                                <th class="wd-15p border-bottom-0">category</th>
                                <th class="wd-15p border-bottom-0">price</th>
                                <th class="wd-15p border-bottom-0">cover image</th>
                                <th class="wd-15p border-bottom-0">Category</th>
                                <th class="wd-15p border-bottom-0">Subcategory</th>
                                <th class="wd-15p border-bottom-0">DATE</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($labs as $opportunity)
                            <tr>
                                <td>{{$opportunity->id}}</td>
                                <td>{{$opportunity->name}}</td>
                                <td>{!! nl2br(wordwrap($opportunity->category, 20, "\n", true)) !!}</td>
                                <td>UGX {{$opportunity->price}}</td>
                                <td>
                                                                @php
                                    $avatar = $opportunity->avatar;
                                    $isExternal = filter_var($avatar, FILTER_VALIDATE_URL);
                                    $imageSrc = $isExternal
                                        ? $avatar
                                        : asset('storage/' .($avatar));
                                @endphp

                                @if(!empty($avatar))
                                    <img src="{{ $imageSrc }}" alt="Avatar" width="100" height="100">
                                @else
                                    No image available
                                @endif

                                </td>
                                <td>{{$opportunity->category}}</td>
                                <td>{{$opportunity->subcategory}}</td>
                                <td>{{$opportunity->created_at}}</td>
                                <td>
                                         <a href="{{ route('labs.edit', $opportunity->id) }}" class="btn btn-primary mb-1">
                                                Edit
                                         </a>
                                        <form action="{{ route('labs.destroy', $opportunity->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light" onclick="return confirm('Are you sure you want to delete this blog?')">
                                                Delete
                                            </button>
                                        </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <!-- End Row -->
    <!--End Page header-->

    @endsection
