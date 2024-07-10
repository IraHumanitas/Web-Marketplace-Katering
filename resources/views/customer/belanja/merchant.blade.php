
@extends('layout/layout')

@section('space-work')
    <div class="container">
        <h1>Semua Merchant</h1>

        <div class="row">
            @foreach ($merchants as $merchant)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('image/'.$merchant->photo) }}" class="card-img-top" alt="{{ $merchant->company_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $merchant->company_name }}</h5>
                            <p class="card-text">{{ $merchant->description }}</p>
                            <p class="card-text">Rating: {{ $merchant->rating }}</p>
                            <a href="{{ route('merchant.menus', $merchant->id) }}" class="btn btn-primary">Lihat Menu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
