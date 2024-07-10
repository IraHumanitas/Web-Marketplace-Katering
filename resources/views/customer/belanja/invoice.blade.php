@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Invoice Details</h1>
        <p>Invoice Number: {{ $invoice->invoice_number }}</p>
        <p>Total Amount: ${{ $invoice->total_amount }}</p>
        <p>Status: {{ $invoice->status }}</p>
        <p>Due Date: {{ $invoice->due_date }}</p>

        <a href="{{ route('cart.view') }}" class="btn btn-primary">Back to Cart</a>
        <a href="{{ route('invoice.pay', ['id' => $invoice->id]) }}" class="btn btn-success">Pay Invoice</a>
        <a href="{{ route('invoice.download', ['id' => $invoice->id]) }}" class="btn btn-info">Download Invoice</a>
    </div>
@endsection
