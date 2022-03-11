
@extends('layouts.admin')

@section('content')


    <div class="d-sm-flex align-items-center justify-content-start mb-4">

        <a href="/admin/users" class="btn btn-primary mr-4" >
            <i class="fas fa-chevron-left"></i>
        </a>

        <h1 class="h3 mb-0 text-gray-800">User - {{ $user->name ?? '' }}</h1>

    </div>


    @if ( session('success') )
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if ( session('errors') )
        <div class="alert alert-danger">
            @foreach(session('errors')->getMessages() as $this_error)
                <div>{{$this_error[0]}}</div>
            @endforeach
        </div>
    @endif


    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>

                <div class="card-body">
                    <form method="post" action="/admin/users/{{$user->id}}" >

                        @csrf
                        @method( 'PUT' )

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="{{ ( isset( $post['name'] ) ? $post['name'] : $user->name ) }}" name="name" >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly >
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>
                </div>

            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                </div>

                <div class="card-body">
                    <form method="post" action="/admin/users/{{$user->id}}/change-password" >

                        @csrf
                        @method( 'PUT' )

                        <div class="mb-3">
                            <label for="new-pw" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new-pw" name="new-pw" >
                        </div>

                        <div class="mb-3">
                            <label for="confirm-pw" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-pw" name="confirm-pw" >
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection
