@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">REGISTERED USERS</h4>
    </div>

</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All users</div>
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
                                <th class="wd-15p border-bottom-0">Account Type</th>
                                <th class="wd-15p border-bottom-0">ROLE</th>
                                <th class="wd-15p border-bottom-0">email</th>
                                <th class="wd-15p border-bottom-0">Phone Number</th>
                                <th class="wd-15p border-bottom-0">DATE created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $opportunity)
                            <tr>
                                <td>{{$opportunity->id}}</td>
                                <td>{{$opportunity->firstName}} {{$opportunity->lastName}}</td>
                                <td>{{$opportunity->accountType}}</td>
                                <td>{{$opportunity->role}}</td>
                                 <td>{{$opportunity->email}}</td>
                                 <td>{{$opportunity->phone}}</td>
                                <td>{{$opportunity->created_at}}</td>
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
