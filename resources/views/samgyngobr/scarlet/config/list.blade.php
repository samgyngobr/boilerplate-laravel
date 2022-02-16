
@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">Configuration</h1>

        <a href="{{ $skUrl . 'config/create' }}" class="pull-left btn btn-primary">
            <i class="fas fa-plus-circle"></i>
        </a>

    </div>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card elevation mb-4">
    <div class="card-body has-table">
      <div class="table-responsive">
        <table class="table">

          <thead class="card-header" >
            <tr>
              <th>#</th>
              <th>{{ __('scarlet.title')   }}</th>
              <th>{{ __('scarlet.type')    }}</th>
              <th>{{ __('scarlet.gallery') }}</th>
              <th>{{ __('scarlet.enabled') }}</th>
              <th>{{ __('scarlet.details') }}</th>
            </tr>
          </thead>

          <tbody>

            @foreach ($list as $item)

              <tr>
                <td>{{ $item->id    ?? '' }}</td>
                <td>{{ $item->label ?? '' }}</td>
                <td>
                  {{ ( $item->multiple == 1 ) ? __('scarlet.multiple') : __('scarlet.unique') }}
                </td>
                <td>
                  @if ( $item->gallery == 1 )
                    <i class="far fa-check-circle text-success"></i>
                  @else
                    <i class="far fa-times-circle text-danger"></i>
                  @endif
                </td>
                <td>
                  @if ( $item->status == 1 )
                    <a href="{{$skUrl}}config/disable/{{$item->url}}"><i class="fas fa-check text-success"></i></a>
                  @else
                    <a href="{{$skUrl}}config/enable/{{$item->url}}"><i class="fas fa-times text-danger"></i></a>
                  @endif
                </td>
                <td>
                  <a href="{{ $skUrl . 'config/' . $item->url }}">
                    <i class="fas fa-search"></i>
                  </a>
                </td>
              </tr>

            @endforeach

          </tbody>

        </table>
      </div>
    </div>
  </div>

@endsection
