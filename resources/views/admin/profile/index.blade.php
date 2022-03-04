
@extends('layouts.admin')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Profile</h1>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>

                <div class="card-body">
                    <form method="post" action="" >

                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}" >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{Auth::user()->email}}" readonly >
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
                    <form method="post" action="" >

                        @csrf

                        <div class="mb-3">
                            <label for="old-pw" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="old-pw" name="old-pw" >
                        </div>

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

@stop

