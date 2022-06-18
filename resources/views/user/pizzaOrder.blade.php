@extends('user.layout.style')
@section('content')
    <div class="row mt-5 d-flex justify-content-center">
        <div class="col-4 ">
            <img src="{{ asset('uploads/'.$order->image) }}" class="img-thumbnail shadow" width="100%"><br>
            <a href="{{ route('user#index') }}">
                <button class="btn btn-danger mt-3">
                    <i class="fas fa-backspace"></i> Back
                </button>
            </a>
        </div>
        <div class="col-6">

            @if (Session::has('waitingTime'))
                <div class="alert bg-success alert-dismissible fade show" role="alert">
                    Pizza Order Success...Total Pirce <b>{{Session::get('totalPrice')}} Kyats and</b> Pls Wait <b>{{ Session::get('waitingTime') }} minutes</b>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <h4 class="fw-bold">Name</h4>
            <span class="fw-bold">{{ $order->pizza_name }}</span><hr>

            <h4 class="fw-bold">Price</h4>
            <span class="fw-bold">{{ $order->price - $order->discount_price }} Kyats</span><hr>

            <h4 class="fw-bold">Waiting Time</h4>
            <span class="fw-bold">{{ $order->waiting_time }} minutes</span><hr>

            <form action="" method="post">
                @csrf

                <h4 class="fw-bold">Pizza QTY</h4>
                <input type="number" name="pizzaQty" class="form-control" value="{{ old('pizzaQty') }}">
                @if ($errors->has('pizzaQty'))
                    <p class="text-danger">{{ $errors->first('pizzaQty') }}</p>
                @endif
                <hr>

                <h4 class="fw-bold">Payment Type</h4>
                <div class="mt-2">
                    <input class="form-input-check" type="radio" name="paymentType" value="1" {{ old('paymentType')=='1' ? 'checked':''}}>Credit Card
                    <input type="radio" name="paymentType" class="form-input-check" value="2" {{ old('paymentType')=='2' ? 'checked':''}}> Cash

                    @if ($errors->has('paymentType'))
                        <p class="text-danger">{{ $errors->first('paymentType') }}</p>
                    @endif
                </div><hr>

                <button class="btn btn-primary mt-2" type="submit"><i class="fas fa-shopping-cart"></i> Place Order</button>
            </form>

        </div>
    </div>
@endsection
