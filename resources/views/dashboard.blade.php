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
            <h3 class="card-title">Schools Management</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="schools-table" class="table table-bordered text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Centre Number</th>
                            <th>District</th>
                            <th>Admin Name</th>
                            <th>Admin Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                        <tr data-id="{{ $school->id }}">
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->centre_number }}</td>
                            <td>{{ $school->district }}</td>
                            <td>{{ $school->admin_name }}</td>
                            <td>{{ $school->admin_email }}</td>
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
                            <td>
                                <button class="btn btn-sm btn-success" onclick="updateStatus({{ $school->id }}, 'active')" {{ $school->status === 'active' ? 'disabled' : '' }}>Activate</button>
                                <button class="btn btn-sm btn-warning" onclick="updateStatus({{ $school->id }}, 'inactive')" {{ $school->status === 'inactive' ? 'disabled' : '' }}>Deactivate</button>
                                <button class="btn btn-sm btn-danger" onclick="updateStatus({{ $school->id }}, 'suspended')" {{ $school->status === 'suspended' ? 'disabled' : '' }}>Suspend</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>

<script>
function updateStatus(schoolId, status) {
    $.ajax({
        url: '/schools/' + schoolId,
        type: 'PUT',
        data: { status: status, _token: '{{ csrf_token() }}' },
        success: function(response) {
            // Update the row
            var row = $('tr[data-id="' + schoolId + '"]');
            var statusCell = row.find('td:nth-child(6)');
            statusCell.html(getStatusBadge(status));

            // Update buttons
            row.find('button').prop('disabled', false);
            if (status === 'active') row.find('.btn-success').prop('disabled', true);
            else if (status === 'inactive') row.find('.btn-warning').prop('disabled', true);
            else if (status === 'suspended') row.find('.btn-danger').prop('disabled', true);
        },
        error: function(xhr) {
            alert('Error updating status: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Unknown error'));
        }
    });
}

function getStatusBadge(status) {
    if (status === 'active') return '<span class="badge badge-success">Active</span>';
    if (status === 'inactive') return '<span class="badge badge-warning">Inactive</span>';
    if (status === 'suspended') return '<span class="badge badge-danger">Suspended</span>';
    return '<span class="badge badge-secondary">' + status + '</span>';
}

// Realtime polling every 5 seconds
setInterval(function() {
    $.ajax({
        url: '/schools',
        type: 'GET',
        success: function(data) {
            // Update the table with new data
            var tbody = $('#schools-table tbody');
            tbody.empty();
            data.forEach(function(school) {
                var row = '<tr data-id="' + school.id + '">' +
                    '<td>' + school.name + '</td>' +
                    '<td>' + school.centre_number + '</td>' +
                    '<td>' + (school.district || 'N/A') + '</td>' +
                    '<td>' + school.admin_name + '</td>' +
                    '<td>' + school.admin_email + '</td>' +
                    '<td>' + getStatusBadge(school.status) + '</td>' +
                    '<td>' +
                        '<button class="btn btn-sm btn-success" onclick="updateStatus(' + school.id + ', \'active\')" ' + (school.status === 'active' ? 'disabled' : '') + '>Activate</button> ' +
                        '<button class="btn btn-sm btn-warning" onclick="updateStatus(' + school.id + ', \'inactive\')" ' + (school.status === 'inactive' ? 'disabled' : '') + '>Deactivate</button> ' +
                        '<button class="btn btn-sm btn-danger" onclick="updateStatus(' + school.id + ', \'suspended\')" ' + (school.status === 'suspended' ? 'disabled' : '') + '>Suspend</button>' +
                    '</td>' +
                    '</tr>';
                tbody.append(row);
            });
        }
    });
}, 5000);
</script>

</div>

@endsection
