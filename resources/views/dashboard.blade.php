@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{session('title')}}</h4>
    </div>
</div>
<!--End Page header-->


<div class="row">
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-teal">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Laboratory Products</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{ $labs ?? '0' }}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-file-text-o fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-indigo">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Staff</h6>
                        <h2 class="text-white m-0 font-weight-bold">Soon to come</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-users fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-teal">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Registered Schools</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{$schoolsCount ?? '0'}}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-school fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-indigo">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Clients</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{ $users ?? '0' }}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-th-list fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Schools</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>School ID</th>
                            <th>School Name</th>
                            <th>Centre Number</th>
                            <th>District</th>
                            <th>Admin Name</th>
                            <th>Admin Email</th>
                            <th>Admin Phone</th>
                            <th>Status</th>
                            <th>Registered Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                            <tr>
                                <td>#{{ $school->id }}</td>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->centre_number }}</td>
                                <td>{{ $school->district }}</td>
                                <td>{{ $school->admin_name }}</td>
                                <td>{{ $school->admin_email }}</td>
                                <td>{{ $school->admin_phone }}</td>
                                <td>
                                    @if($school->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($school->status === 'inactive')
                                        <span class="badge badge-warning">Inactive</span>
                                    @elseif($school->status === 'suspended')
                                        <span class="badge badge-danger">Suspended</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $school->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $school->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($school->status === 'active')
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="inactive">
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to deactivate this school?')">Deactivate</button>
                                            </form>
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="suspended">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to suspend this school?')">Suspend</button>
                                            </form>
                                        @elseif($school->status === 'inactive')
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to activate this school?')">Activate</button>
                                            </form>
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="suspended">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to suspend this school?')">Suspend</button>
                                            </form>
                                        @elseif($school->status === 'suspended')
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to activate this school?')">Activate</button>
                                            </form>
                                            <form action="{{ route('schools.update', $school) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="inactive">
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to deactivate this school?')">Deactivate</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($schools->isEmpty())
                            <tr>
                                <td colspan="13" class="text-center text-muted">No schools registered.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $schools->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>


</div>



</div>

@endsection
