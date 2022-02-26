
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


    @if ( session('error') )
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="row">
        <div class="col-lg-8">


            <div class="card elevation mb-4">
                <div class="card-header"> Edit </div>
                <div class="card-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data" >


                        <div class="mb-3 row">
                            <label class="col-form-label col-md-2 text-md-end" for="name">Name</label>
                            <div class="col-md-10">
                                <input type="text" id="name" class="form-control" placeholder="Name" name="name"
                                    value="{{ ( isset( $post['name'] ) ? $post['name'] : $user->name ) }}" required >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-2 text-md-end" for="email">E-mail</label>
                            <div class="col-md-10">
                                <input type="text" id="email" class="form-control" placeholder="E-mail"
                                    value="{{ $user->email }}" readonly >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div> <!-- / .card -->


            <div class="card elevation mb-4">
                <div class="card-header"> Password </div>
                <div class="card-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data" >


                        <div class="mb-3 row">
                            <label class="col-form-label col-md-2 text-md-end" for="password">Password</label>
                            <div class="col-md-10">
                                <input type="text" id="password" class="form-control" placeholder="Password" name="password" required >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-2 text-md-end" for="confirm">Confirm Password</label>
                            <div class="col-md-10">
                                <input type="text" id="confirm" class="form-control" placeholder="Confirm Password" name="confirm" required >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-success">Change</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div> <!-- / .card -->


        </div> <!-- / .col-md-8 -->
    </div> <!-- / .row -->

@endsection
