
@extends('layouts.admin')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-start mb-4">

        <a href="{{ $skUrl . $area->url . '/new' }}" class="btn btn-primary mr-4" >
            <i class="fas fa-plus-circle"></i>
        </a>

        <h1 class="h3 mb-0 text-gray-800">{{ $area->label ?? '' }}</h1>

    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card elevation mb-4">
        <div class="card-body has-table">
            <div class="table-responsive">

                <?= listGen( $config['data'], $config['fieldLabels'], $config['area'], $skUrl ); ?>

            </div>
        </div>
    </div>

@endsection
