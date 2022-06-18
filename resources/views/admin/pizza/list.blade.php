@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">

            @if (Session::has('insertSuccess'))
                <div class="alert bg-success opacity-75 alert-dismissible fade show" role="alert">
                    {{ Session::get('insertSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('deleteSuccess1'))
                <div class="alert bg-success opacity-75 alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('deleteSuccess1') }}</strong>{{ Session::get('deleteSuccess2') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('updateSuccess'))
                <div class="alert bg-success opacity-75 alert-dismissible fade show" role="alert">
                    {{ Session::get('updateSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title mt-1">
                    <a href="{{ route('admin#createPizza') }}">
                        <button class="btn btn-sm btn-outline-dark">
                            <i class="fas fa-plus"></i>
                        </button>
                    </a>
                    <span class="border rounded-pill border-success p-2 fw-bold ms-3 text-success" style="font-size:15px">Total - {{ $pizza->total() }}</span>
                </h3>

                <div class="card-tools d-flex">
                    <div class="me-2 mt-1">
                        <a href="{{ route('admin#downloadPizza') }}"><button class="btn btn-success btn-sm">Download CSV</button></a>
                    </div>
                  <form action="{{ route('admin#searchPizza') }}" type="get">
                      @csrf
                    <div class="input-group input-group-sm mt-1" style="width: 150px;" >
                        <input type="text" name="tableSearch" value="{{ request('tableSearch') }}" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append ">
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
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Publish Status</th>
                      <th>Buy 1 Get 1 Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                   @if ($status == 0)
                       <tr>
                           <td colspan="7">
                                <p class="text-muted">There is no data...</p>
                           </td>
                       </tr>
                   @else
                   @foreach ($pizza as $items)
                   <tr>
                       <td>{{ $items->pizza_id }}</td>
                       <td>{{ $items->pizza_name }}</td>
                       <td>
                         <img src='{{ asset('uploads/'.$items->image) }}' class="img-thumbnail" width="100px">
                       </td>
                       <td>{{ $items->price }}kyats</td>
                       <td>
                           @if ($items->publish_status == 1)
                           Publish
                           @elseif ($items->publish_status == 0)
                           Unpublish
                           @endif
                       </td>
                       <td>
                           @if ($items->buy_one_get_one_status == 1)
                           Yes
                           @elseif ($items->buy_one_get_one_status == 0)
                           No
                           @endif
                       </td>
                       <td>
                         <a href="{{ route('admin#editPizza',$items->pizza_id) }}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                         <a href="{{ route('admin#deletePizza',$items->pizza_id) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                         <a href="{{ route('admin#infoPizza',$items->pizza_id) }}"><button class="btn btn-sm bg-primary text-white"><i class="fas fa-eye"></i></button></a>
                       </td>
                   </tr>
                   @endforeach
                   @endif
                  </tbody>
                </table>
                <div class="mt-2 offset-5">
                    {{ $pizza->links() }}
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
