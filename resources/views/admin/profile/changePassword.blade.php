@extends('admin.layout.app')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="mb-2">
                                <a href="{{ route('admin#profile') }}" class="text-dark"><i class="fas fa-chevron-circle-left">Back</i></a>
                            </div>
                            @if (Session::has('success'))
                                <div class="alert bg-success opacity-75 alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header p-2 bg-purple opacity-75">
                                    <legend class="text-center">Change Password</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form action="{{ route('admin#changePassword',Auth()->user()->id) }}" method="post" class="form-horizontal">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-4 col-form-label">Current Password</label>
                                                    <div class="col-sm-8">
                                                      <input type="password" class="form-control" id="inputName" name="currentPassword" value="{{ old('currentPassword') }}" style="border-color:purple">
                                                      @if ($errors->has('currentPassword'))
                                                          <p class="text-danger">{{ $errors->first('currentPassword') }}</p>
                                                      @endif
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="inputName" class="col-sm-4 col-form-label">New Password</label>
                                                    <div class="col-sm-8">
                                                      <input type="password" class="form-control" id="inputName" name="newPassword" value="{{ old('newPassword') }}" style="border-color:purple">
                                                      @if ($errors->has('newPassword'))
                                                          <p class="text-danger">{{ $errors->first('newPassword') }}</p>
                                                      @endif
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="inputName" class="col-sm-4 col-form-label">Confirm Password</label>
                                                    <div class="col-sm-8">
                                                      <input type="password" class="form-control" id="inputName" name="confirmPassword" value="{{ old('confirmPassword') }}" style="border-color:purple">
                                                      @if ($errors->has('confirmPassword'))
                                                          <p class="text-danger">{{ $errors->first('confirmPassword') }}</p>
                                                      @endif
                                                    </div>
                                                  </div>


                                                <div class="float-end">
                                                    <button type="submit" class="btn bg-purple opacity-75 text-white">Update</button>
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
        </section>
    </div>

@endsection
