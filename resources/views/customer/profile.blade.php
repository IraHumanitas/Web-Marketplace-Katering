@extends('layout/layout')

@section('space-work')
<div class="container">
    <h1>Profil Customer</h1>

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo">Foto Profil</label>
            <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photo" name="photo">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($customer->photo)
                <img src="{{ asset('image/'.$customer->photo) }}" alt="Foto Profil" style="max-width: 100px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
