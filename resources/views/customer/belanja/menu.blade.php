@extends('layout/layout')

@section('space-work')

    <div class="container">
        <h1>Menu for {{ $merchant->company_name }}</h1>

        <div class="alert alert-danger d-none" id="error-message"></div>
        <div class="alert alert-success d-none" id="success-message"></div>

        <div class="row">
            @foreach ($menus as $menu)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('image/'.$menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->name }}</h5>
                            <p class="card-text">{{ $menu->description }}</p>
                            <p class="card-text">Price: {{ $menu->price }}</p>
                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <div class="form-group">
                                    <label for="quantity-{{ $menu->id }}">Quantity</label>
                                    <input type="number" name="quantity" id="quantity-{{ $menu->id }}" value="1" class="form-control" min="1" max="{{ $menu->stok }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('cart.view') }}" class="btn btn-success mt-4">Go to Cart</a>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.add-to-cart-form');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const errorMessage = document.getElementById('error-message');
                    const successMessage = document.getElementById('success-message');
                    if (data.error) {
                        errorMessage.textContent = data.error;
                        errorMessage.classList.remove('d-none');
                        successMessage.classList.add('d-none');
                    } else if (data.success) {
                        successMessage.textContent = data.success;
                        successMessage.classList.remove('d-none');
                        errorMessage.classList.add('d-none');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

@endsection
