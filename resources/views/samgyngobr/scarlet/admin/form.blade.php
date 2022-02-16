
@extends('samgyngobr.scarlet.app')


@section('header')

  @if ( $area->multiple == 1 )

    <i class="dec fas fa-edit"></i>

    <div class="d-flex gap-3">

      <a href="{{$skUrl}}{{ $url ?? '' }}" class="pull-left d-flex align-items-center text-white mr-4">
        <i class="fas fa-chevron-left"></i>
      </a>

      <span>{{ $area->label ?? '' }}</span>

    </div>

  @else

    <i class="dec fas fa-edit"></i>

    <span>{{ $area->label ?? '' }}</span>

    @if ( $area->gallery == 1 )
      <a href="{{ $skUrl . $area->url . '/gallery/' . $id }}" class="pull-left d-flex align-items-center text-white ">
        <i class="fas fa-image"></i>
      </a>
    @endif

  @endif

@endsection


@section('content')

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
