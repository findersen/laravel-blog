@extends('layouts.app')

@section('title', 'Galleries List')

@section('content')

    <div class="row mt-5">
        @foreach($list as $item)
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" alt="" src="{{ asset('storage/'. $item->photo->filename) }}" style="height: 225px; width: 100%; display: block; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="mb-0">
                            <a class="text-dark" href="{{ $item->url }}">{{ $item->title }}</a>
                        </h3>
                        <p class="card-text">{{ str_limit($item->description, 120, '...') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ $item->url }}" class="btn btn-outline-secondary">View gallery</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
