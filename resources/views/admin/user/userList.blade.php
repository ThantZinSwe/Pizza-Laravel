@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">

            @if (Session::has('deleteSuccess'))
                <div class="alert bg-danger opacity-75 alert-dismissible fade show" role="alert">
                    {{ Session::get('deleteSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title mt-1">
                  <a href="{{ route('admin#userList') }}"><button class="btn btn-sm btn-outline-dark">User List</button></a>
                  <a href="{{ route('admin#adminList') }}"><button class="btn btn-sm btn-outline-dark">Admin List</button></a>
                </h3>
                <div class="card-tools">
                    <form action="{{ route('admin#userListSearch') }}" type="get">
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
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user as $items)
                        <tr>
                            <td>{{ $items->id }}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->email }}</td>
                            <td>{{ $items->phone }}</td>
                            <td>{{ $items->address }}</td>
                            <td>
                              <a href="{{ route('admin#deleteUserAndAdmin',$items->id) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>

                {{-- @error('errorMessage')
                        <div class="alert bg-danger opacity-75 mt-3">{{ $message }}</div>
                @enderror --}}
                <div class="mt-2 offset-5">
                    {{ $user->links() }}
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
