@extends('user.layout.style')
@section('content')
    <div class="row mt-5 d-flex justify-content-center">

        <div class="col-4 ">
            <img src="{{ asset('uploads/'.$pizzaDetails->image) }}" class="img-thumbnail shadow" width="100%"><br>
            <a href="{{ route('user#order') }}">
                <button class="btn btn-dark float-end mt-2 col-12">
                    <i class="fas fa-shopping-cart"></i> Order
                </button>
            </a>
            <a href="{{ route('user#index') }}">
                <button class="btn btn-danger mt-2 col-12">
                    <i class="fas fa-backspace"></i> Back
                </button>
            </a>
        </div>
        <div class="col-6">
            <h4 class="fw-bold">Name</h4>
            <span class="fw-bold">{{ $pizzaDetails->pizza_name }}</span><hr>

            <h4 class="fw-bold">Pizza Category</h4>
            <span class="fw-bold">{{ $pizzaDetails->category_name }}</span><hr>

            <h4 class="fw-bold">Price</h4>
            <span class="fw-bold">{{ $pizzaDetails->price }} Kyats</span><hr>

            <h4 class="fw-bold">Discount</h4>
            <span class="fw-bold">{{ $pizzaDetails->discount_price }} Kyats</span><hr>

            <h4 class="fw-bold">Buy 1 Get 1</h4>
            <span class="fw-bold">
                @if ($pizzaDetails->buy_one_get_one_status == 1)
                    Have
                @else
                    Not Have
                @endif
            </span><hr>

            <h4 class="fw-bold">Waiting Time</h4>
            <span class="fw-bold">{{ $pizzaDetails->waiting_time }} minutes</span><hr>

            <div class="row">
                <div class="col-md-6 mt-1">
                    <h4 class="fw-bold">Description</h4>
                    <span class="fw-bold">{{ $pizzaDetails->description }}</span><hr>
                </div>

                <div class="col-md-6">
                    <h4 class="fw-bold text-danger">Total Price</h4>
                    <h4 class="fw-bold">{{ $pizzaDetails->price - $pizzaDetails->discount_price }} Kyats</h4><hr>
                </div>
            </div>

        </div>
    </div>
@endsection
