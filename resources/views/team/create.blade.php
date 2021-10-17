@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">

    <div class="col-md-12">
      <form action="{{ route('team.store') }}" method="POST">
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