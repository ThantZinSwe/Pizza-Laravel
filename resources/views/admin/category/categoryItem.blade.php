@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-2 py-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title mt-1">
                    <h3 class="d-inline-flex">{{ $categoryItem[0]->category_name }}</h3>
                    <span class="border rounded-pill border-success p-2 fw-bold ms-3 text-success" style="font-size:15px">Total - {{ $categoryItem->total() }}</span>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Buy One Get One</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($categoryItem as $items)
                    <tr>
                        <td>{{ $items->pizza_id }}</td>
                        <td>{{ $items->pizza_name }}</td>
                        <td><img src="{{ asset('uploads/'.$items->image) }}" width="120px"></td>
                        <td>{{ $items->price }}</td>
                        <td>
                            @if ($items->buy_one_get_one_status == 1)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class=" d-inline-flex my-2 mx-2 float-start">
                    {{ $categoryItem->links() }}
                </div>
                <div class="my-2 mx-2 float-end">
                    <a href="{{ route('admin#category') }}"><button class="btn btn-dark">Back</button></a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
