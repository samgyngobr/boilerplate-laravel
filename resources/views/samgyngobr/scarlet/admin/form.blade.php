
@extends('layouts.admin')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-start mb-4">

        @if ( $area->multiple == 1 )

            <a href="{{$skUrl}}{{ $url ?? '' }}" class="btn btn-primary mr-4" >
                <i class="fas fa-chevron-left"></i>
            </a>

            <h1 class="h3 mb-0 text-gray-800">{{ $area->label ?? '' }}</h1>

        @else

            @if ( $area->gallery == 1 )
              <a href="{{ $skUrl . $area->url . '/gallery/' . $id }}" class="btn btn-primary mr-4" >
                <i class="fas fa-image"></i>
              </a>
            @endif

            <h1 class="h3 mb-0 text-gray-800">{{ $area->label ?? '' }}</h1>

        @endif

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

                <div class="card-header"> {{ __('scarlet.form') }} </div>

                <div class="card-body">

                    <?= formGen( $config['fields'], 'new' ); ?>

                </div>

            </div> <!-- / .card -->
        </div> <!-- / .col-md-8 -->
    </div> <!-- / .row -->

@endsection
