@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Icons</h3>
          <a href="{{ route('icon.create') }}" class="btn btn-primary" style="float:right;">Add</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">ID</th>
                <th>Icon</th>
                <th>Name</th>
                <th>Style</th>
                <th>Tags</th>
                <th>Contributor</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($icons as $icon)
              <tr>
                <td>{{$icon->id}}</td>
                <td>
                  <img src="{{$icon->image}}" class="rounded-circle" style="width:50px;height:50px;" />
                </td>
                <td>{{$icon->name}}</td>
                <td>
                  {{$icon->style}}
                </td>
                <td>
                  {{$icon->tags->pluck('name')->implode(', ')}}
                </td>
                <td><span class="badge bg-primary">{{$icon->contributor->name}}</span></td>
                <td>
                  <form method="POST" action="{{ route('icon.destroy', $icon->id) }}" style="display:inline;">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-sm btn-danger">
                      <span class="fas fa-trash"></span>
                    </button>
                  </form>
                  <a href="{{route('icon.edit', $icon->id)}}" class="btn btn-sm btn-success">
                    <span class="fas fa-edit"></span>
                  </a>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          {{$icons->links()}}
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>

@endsection