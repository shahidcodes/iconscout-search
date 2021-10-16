@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <form action="{{ route('icon.update', $icon->id) }}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <div class="card mt-2">
          <div class="card-body">
            <div class="form-group">
              <label for="iconName--edit">Name</label>
              <input type="text" class="form-control" name="name" id="iconName--edit" placeholder="Enter Name" value="{{$icon->name}}">
            </div>
            <div class="form-group">
              <label for="tags--edit">Tags</label>
              <input type="text" class="form-control" id="tags--edit" name="tags" placeholder="Icon tags" value="{{$icon->tags->pluck('name')->implode(', ')}}">
            </div>
            <div class="form-group">
              <label for="tags--edit">Categories</label>
              <input type="text" class="form-control" id="tags--edit" name="categories" placeholder="Icon categories" value="{{$icon->categories->pluck('name')->implode(', ')}}">
            </div>
            @csrf
            <div class="form-group">
              <label for="price--edit">Price</label>
              <input type="text" class="form-control" id="price--edit" name="price" placeholder="Icon price" value="{{$icon->price}}">
            </div>
            <div class="form-group">
              <label for="style--edit">Style</label>
              <input type="text" class="form-control" id="style--edit" name="style" placeholder="Icon style" value="{{$icon->style}}">
            </div>
            <div class="form-group">
              <label for="contributor--edit">Contributor</label>
              <input type="text" class="form-control" id="contributor--edit" placeholder="Icon contributor" value="{{$icon->contributor->name}}">
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