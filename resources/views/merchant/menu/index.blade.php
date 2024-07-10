@extends('layout/layout')

@section('space-work')

    <div class="container">
        <h1 class="mt-4">Daftar Menu</h1>

        <!-- Form pencarian -->
        <form action="{{ route('menus.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Menu...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        <a href="{{ route('menus.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>Aksi</th> <!-- Tambah kolom untuk aksi -->
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->description }}</td>
                    <td>{{ $menu->price }}</td>
                    <td>{{ $menu->stok }}</td>
                    <td>{{ $menu->category }}</td>
                    <td><img src="{{ asset('image/'.$menu->photo) }}" alt="{{ $menu->name }}" style="max-width: 100px;"></td>
                    <td>
                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Tambahkan script JavaScript Bootstrap (opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
