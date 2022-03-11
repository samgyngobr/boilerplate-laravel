
@extends('layouts.admin', [
    'includes' => [ 'dataTables' ]
    ])

@section('content')


    <div class="d-sm-flex align-items-center justify-content-start mb-4">

        <a href="/admin/users/create" class="btn btn-primary mr-4" >
            <i class="fas fa-plus-circle"></i>
        </a>

        <h1 class="h3 mb-0 text-gray-800">Users</h1>

    </div>


    @if ( session('success') )
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ( session('error') )
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ( session('errors') )
        <div class="alert alert-danger">
            @foreach(session('errors')->getMessages() as $this_error)
                <div>{{$this_error[0]}}</div>
            @endforeach
        </div>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Id.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Id.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        @foreach ($users as $user)

                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a class="text-info"   href="/admin/users/{{$user->id}}/edit"   ><i class="fas fa-fw fa-edit"  ></i></a>
                                <a class="text-danger" href="/admin/users/{{$user->id}}/delete" ><i class="fas fa-fw fa-trash" ></i></a>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@stop
