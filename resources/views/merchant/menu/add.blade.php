@extends('layout/layout')
@section('space-work')

    <h1>Tambah Menu</h1>

    @if ($errors->any())
        <div>
            <strong>Error:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Nama -->
    <div class="form-group">
        <label for="name">Nama Menu</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Foto -->
    <div class="form-group">
        <label for="photo">Foto</label>
        <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photo" name="photo">
        @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Harga -->
    <div class="form-group">
        <label for="price">Harga</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Stok -->
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') }}" required>
        @error('stok')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kategori -->
    <div class="form-group">
        <label for="category">Kategori</label>
        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}" required>
        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>


@endsection
