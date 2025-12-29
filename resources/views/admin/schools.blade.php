<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schools Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-active { background-color: #d4edda; color: #155724; }
        .status-inactive { background-color: #f8d7da; color: #721c24; }
        .status-pending { background-color: #cce7ff; color: #004085; }
        .status-suspended { background-color: #fff3cd; color: #856404; }
        button { padding: 5px 10px; margin: 2px; cursor: pointer; }
        .btn-activate { background-color: #28a745; color: white; }
        .btn-deactivate { background-color: #dc3545; color: white; }
        .btn-suspend { background-color: #ffc107; color: black; }
    </style>
</head>
<body>
    <h1>Schools Management</h1>
    <table id="schools-table">
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
                <td>{{ $school->user ? $school->user->firstName . ' ' . $school->user->lastName : 'N/A' }}</td>
                <td>{{ $school->user ? $school->user->email : $school->admin_email }}</td>
                <td><span class="status-{{ $school->status }}">{{ ucfirst($school->status) }}</span></td>
                <td>
                    <button class="btn-activate" onclick="updateStatus({{ $school->id }}, 'active')" {{ $school->status === 'active' ? 'disabled' : '' }}>Activate</button>
                    <button class="btn-deactivate" onclick="updateStatus({{ $school->id }}, 'inactive')" {{ $school->status === 'inactive' ? 'disabled' : '' }}>Deactivate</button>
                    <button class="btn-suspend" onclick="updateStatus({{ $school->id }}, 'suspended')" {{ $school->status === 'suspended' ? 'disabled' : '' }}>Suspend</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function updateStatus(schoolId, status) {
            $.ajax({
                url: '/api/schools/' + schoolId,
                type: 'PUT',
                data: { status: status },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update the row
                    var row = $('tr[data-id="' + schoolId + '"]');
                    row.find('.status-active, .status-inactive, .status-pending, .status-suspended').removeClass().addClass('status-' + status).text(status.charAt(0).toUpperCase() + status.slice(1));

                    // Update buttons
                    row.find('button').prop('disabled', false);
                    if (status === 'active') row.find('.btn-activate').prop('disabled', true);
                    else if (status === 'inactive') row.find('.btn-deactivate').prop('disabled', true);
                    else if (status === 'suspended') row.find('.btn-suspend').prop('disabled', true);
                },
                error: function(xhr) {
                    alert('Error updating status: ' + xhr.responseJSON.message);
                }
            });
        }

        // Realtime polling every 5 seconds
        setInterval(function() {
            $.ajax({
                url: '/api/schools',
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
                            '<td>' + (school.user ? school.user.firstName + ' ' + school.user.lastName : 'N/A') + '</td>' +
                            '<td>' + (school.user ? school.user.email : school.admin_email) + '</td>' +
                            '<td><span class="status-' + school.status + '">' + school.status.charAt(0).toUpperCase() + school.status.slice(1) + '</span></td>' +
                            '<td>' +
                                '<button class="btn-activate" onclick="updateStatus(' + school.id + ', \'active\')" ' + (school.status === 'active' ? 'disabled' : '') + '>Activate</button>' +
                                '<button class="btn-deactivate" onclick="updateStatus(' + school.id + ', \'inactive\')" ' + (school.status === 'inactive' ? 'disabled' : '') + '>Deactivate</button>' +
                                '<button class="btn-suspend" onclick="updateStatus(' + school.id + ', \'suspended\')" ' + (school.status === 'suspended' ? 'disabled' : '') + '>Suspend</button>' +
                            '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                }
            });
        }, 5000);
    </script>
</body>
</html>