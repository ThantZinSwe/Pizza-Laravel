@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title mt-1">
                    <span class="border rounded-pill border-success p-2 fw-bold ms-3 text-success" style="font-size:15px">Total -{{ $order->total() }}</span>
                </h3>
                <div class="card-tools">
                    <form action="{{ route('admin#searchOrder') }}" type="get">
                        @csrf
                        <div class="input-group input-group-sm mt-1" style="width: 150px;">
                            <input type="text" name="searchData" value="{{ request('searchData') }}" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Custmoer Name</th>
                      <th>Pizza Name</th>
                      <th>Pizza Count</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($order as $items)
                        <tr>
                            <td>{{ $items->order_id }}</td>
                            <td>{{ $items->customer_name }}</td>
                            <td>{{ $items->pizza_name }}</td>
                            <td>{{ $items->count }}</td>
                            <td>{{ $items->order_time }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-2 offset-5">
                    {{ $order->links() }}
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
