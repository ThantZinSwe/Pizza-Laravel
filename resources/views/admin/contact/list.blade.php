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
                <div class="card-tools">
                    <form action="{{ route('admin#contactSearch') }}" type="get">
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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if ($status == 0)
                       <tr>
                           <td colspan="4">
                               <p class="text-muted">There is no data...</p>
                           </td>
                       </tr>
                    @else

                    @foreach ($contact as $items)
                    <tr>
                        <td>{{ $items->contact_id }}</td>
                        <td>{{ $items->name }}</td>
                        <td>{{ $items->email }}</td>
                        <td>{{ $items->message }}</td>
                    </tr>
                    @endforeach

                    @endif

                  </tbody>
                </table>

                <div class="mt-2 offset-5">
                    {{ $contact->links() }}
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
