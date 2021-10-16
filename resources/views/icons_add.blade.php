@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">

    <div class="col-md-12">
      <form action="{{ route('icon.store') }}" method="POST">
        <div class="card mt-2">
          @if(count($errors) > 0 )
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
              @foreach($errors->all() as $error)
              <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <div class="card-body">
            <div class="form-group">
              <label for="iconName--edit">Name</label>
              <input type="text" class="form-control" name="name" id="iconName--edit" placeholder="Enter Name">
            </div>

            @csrf
            <div class="form-group">
              <label for="price--edit">Price</label>
              <input type="text" class="form-control" id="price--edit" name="price" placeholder="Icon price">
            </div>
            <div class="form-group">
              <label for="style--edit">Style</label>
              <input type="text" class="form-control" id="style--edit" name="style" placeholder="Icon style">
            </div>
            <div class="form-group">
              <label for="url--edit">Url</label>
              <input type="text" class="form-control" id="url--edit" name="image" placeholder="Icon url">
            </div>
            <div class="form-group">
              <label for="tags--edit">Tags</label>
              <input type="text" class="form-control" id="tags--edit" name="tags" placeholder="Icon tags (comma separated)">
            </div>
            <div class="form-group">
              <label for="tags--edit">Categories</label>
              <input type="text" class="form-control" id="tags--edit" name="categories" placeholder="Icon categories (comma separated)">
            </div>
            <div class="form-group">
              <label for="contributor--edit">Contributor Name</label>
              <input type="text" class="form-control" name="contributor" id="contributor--edit" placeholder="Icon contributor">
              <small class="text-muted">Contributor will be created if does not exits</small>
            </div>


          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection