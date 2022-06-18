@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-3">
          <div class="col-8 offset-3 mt-4">
            <div class="col-md-9">

                <div class="mb-2">
                    <a href="{{ route('admin#pizzaList') }}" class="text-dark"><i class="fas fa-chevron-circle-left">Back</i></a>
                </div>

              <div class="card shadow">
                <div class="card-header p-2 bg-gradient-white">
                  <h4 class="text-center text-dark opacity-100" style="font-family: Comic Sans MS;font-size:28px">Pizza Infomation</h4>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row gx-3">
                            <div class='text-center mx-3 col-4 '>
                                <img src="{{ asset('uploads/'.$pizza->image) }}" alt="" style="width: 200px;height:200px" class="rounded-circle img-fluid shadow-md">
                            </div>
                            <div class="col">
                                <div class="mt-1" style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Name : </span><span class='text-red opacity-100'>{{ $pizza->pizza_name }}</span>
                                </div>
                                <div class="mt-1"style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Category : </span><span class='text-red opacity-100'>{{ $pizza->category_name }}</span>
                                </div>
                                <div class="mt-1"style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Price :  </span><span class='text-red opacity-100'>{{ $pizza->price }} kyats</span>
                                </div>
                                <div class="mt-1"style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Publish Status :
                                        <span class='text-red opacity-100'>
                                            @if ($pizza->publish_status == 1)
                                            Publish
                                            @else
                                            Unpublish
                                            @endif
                                        </span>
                                    </span>
                                </div>
                                <div class="mt-1" style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Discount : </span><span class='text-red opacity-100'> {{ $pizza->discount_price }} kyats</span>
                                </div>
                                <div class="mt-1"style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Buy 1 Get 1 :
                                        <span class='text-red opacity-100'>
                                            @if ($pizza->buy_one_get_one_status == 1)
                                            Yes
                                            @else
                                            No
                                            @endif
                                        </span>
                                    </span>
                                </div>
                                <div class="mt-1" style="font-family:Comic Sans MS, Comic Sans, cursive;font-style: normal;font-weight: 300;font-size:18px">
                                    <span>Description :  </span><span class='text-red opacity-100 '>{{ $pizza->description }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
