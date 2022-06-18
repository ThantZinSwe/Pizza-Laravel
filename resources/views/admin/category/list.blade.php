@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">

            @if (Session::has('add'))
                <div class="alert bg-success opacity-75 alert-dismissible fade show" role="alert">
                    {{ Session::get('add') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('deleteSuccess'))
                <div class="alert bg-danger opacity-75 alert-dismissible fade show" role="alert">
                    {{ Session::get('deleteSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('updateSuccess1'))
                <div class="alert bg-primary opacity-75 alert-dismissible fade show text-black" role="alert">
                    <strong>{{ Session::get('updateSuccess1') }}</strong>{{ Session::get('updateSuccess2') }} <strong>{{ Session::get('updateSuccess3') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title mt-1">
                    <a href="{{ route('admin#addCategory') }}"><button class="btn btn-sm btn-outline-dark fw-bold">Add Category</button></a>
                    <span class="border rounded-pill border-success p-2 fw-bold ms-3 text-success" style="font-size:15px">Total - {{ $category->total() }}</span>
                </h3>
                <div class="card-tools d-flex">
                    <div class="me-2 mt-1">
                        <a href="{{ route('admin#downloadCategory') }}"><button class="btn btn-success btn-sm">Download CSV</button></a>
                    </div>
                    <form action="{{ route('admin#searchData') }}" type="get">
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
                      <th>Category Name</th>
                      <th>Count</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($category as $items)
                    <tr>
                        <td>{{ $items->category_id }}</td>
                        <td>{{ $items->category_name }}</td>
                        <td>
                            @if ( $items->counts == 0)
                                <a href="#" class="text-decoration-none text-dark">{{ $items->counts }}</a>
                            @else
                                <a href="{{ route('admin#categoryItem',$items->category_id) }}" class="text-decoration-none text-dark">{{ $items->counts }}</a>
                            @endif
                        </td>
                        <td>
                          <a href="{{ route('admin#editCategory',$items->category_id) }}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                          <a href="{{ route('admin#deleteCategory',$items->category_id) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                @error('errorMessage')
                        <div class="alert bg-danger opacity-75 mt-3">{{ $message }}</div>
                @enderror
                <div class="mt-2 offset-5">
                    {{ $category->links() }}
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
