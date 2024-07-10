@extends('layout/layout')

@section('space-work')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>
<body>
    <h1>Edit Menu</h1>

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

    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $menu->description) }}</textarea>
        </div>

        <!-- Foto -->
        <div class="form-group">
            <label for="photo">Foto</label>
            @if ($menu->photo)
                <br>
                <img src="{{ asset('image/'.$menu->photo) }}" alt="{{ $menu->name }}" style="max-width: 200px;">
                <br><br>
            @endif
            <input type="file" class="form-control-file" id="photo" name="photo">
            <small class="form-text text-muted">Upload file gambar jika ingin mengganti foto.</small>
        </div>

        <!-- Harga -->
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $menu->price) }}" required>
        </div>

        <!-- Stok -->
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $menu->stok) }}" required>
        </div>

        <!-- Kategori -->
        <div class="form-group">
            <label for="category">Kategori</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $menu->category) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</body>
</html>
@endsection
