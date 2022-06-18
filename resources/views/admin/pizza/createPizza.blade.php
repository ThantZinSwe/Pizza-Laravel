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

              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Add Pizza</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" action="{{ route('admin#insertPizza') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-3 col-form-label ">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Name" name='name' value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            @endif
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Image</label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name='image' placeholder="Image">
                              @if ($errors->has('image'))
                                  <p class="text-danger">{{ $errors->first('image') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Price</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" placeholder="Price" name='price' value="{{ old('price') }}">
                              @if ($errors->has('price'))
                                  <p class="text-danger">{{ $errors->first('price') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Publish Status</label>
                            <div class="col-sm-9">
                              <select name="publishStatus" class="form-control">
                                  <option value="">Choose publish status...</option>
                                  <option value="1" {{ old('publishStatus')== '1' ? 'selected':'' }}>Publish</option>
                                  <option value="0" {{ old('publishStatus')== '0' ? 'selected':'' }}>Unpublish</option>
                              </select>
                              @if ($errors->has('publishStatus'))
                                  <p class="text-danger">{{ $errors->first('publishStatus') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Category</label>
                            <div class="col-sm-9">
                                <select name="categoryId" class="form-control">
                                    <option value="">Choose category...</option>
                                    @foreach ($category as $items)
                                        <option value="{{ $items->category_id }}" {{ old('categoryId')==$items->category_id ? 'selected':''}}>{{ $items->category_name }}</option>
                                    @endforeach
                                </select>
                              @if ($errors->has('categoryId'))
                                  <p class="text-danger">{{ $errors->first('categoryId') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Discount</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" placeholder="Discount" name='discount' value="{{ old('discount') }}">
                              @if ($errors->has('discount'))
                                  <p class="text-danger">{{ $errors->first('discount') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Buy 1 Get 1</label>
                            <div class="col-sm-9 mt-2">
                                <input type="radio" name="buyOneGetOne" class="form-input-check" value="1" {{ old('buyOneGetOne')=='1' ? 'checked':''}}> Yes
                                <input type="radio" name="buyOneGetOne" class="form-input-check" value="0" {{ old('buyOneGetOne')=='0' ? 'checked':''}}> No
                              @if ($errors->has('buyOneGetOne'))
                                  <p class="text-danger">{{ $errors->first('buyOneGetOne') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Waiting Time</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" placeholder="Waiting Time" name='waitingTime' value="{{ old('waitingTime') }}">
                              @if ($errors->has('waitingTime'))
                                  <p class="text-danger">{{ $errors->first('waitingTime') }}</p>
                              @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label ">Description</label>
                            <div class="col-sm-9">
                              <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                              @if ($errors->has('description'))
                                  <p class="text-danger">{{ $errors->first('description') }}</p>
                              @endif
                            </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-9 offset-3">
                            <button type="submit" class="btn bg-dark text-white">Add</button>
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
