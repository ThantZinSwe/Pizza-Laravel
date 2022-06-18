@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
                <div class="mb-2">
                    <a href="{{ route('admin#category') }}" class="text-dark"><i class="fas fa-chevron-circle-left">Back</i></a>
                </div>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Update Category</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" action="{{ route('admin#updateCategory') }}" method="post">
                        @csrf
                        <div class="form-group row">

                          <input type="hidden" name="id" value="{{ $category->category_id }}">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>

                          <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Name" name='categoryName' value="{{ old('categoryName',$category->category_name) }}">

                            @if ($errors->has('categoryName'))
                                <p class="text-danger">{{ $errors->first('categoryName') }}</p>
                            @endif

                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Update</button>
                          </div>
                        </div>
                      </form>

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
