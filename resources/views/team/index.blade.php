@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Teams</h3>
          <a href="{{ route('team.create') }}" class="btn btn-primary" style="float:right;">Add</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">ID</th>
                <th>Name</th>
                <th>Members</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teams as $team)
              <tr>
                <td>{{$team->id}}</td>

                <td>{{$team->name}}</td>
                <td>
                  {{$team->members_count}}
                </td>
                <td>
                  <form method="POST" action="{{ route('team.destroy', $team->id) }}" style="display:inline;">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-sm btn-danger">
                      <span class="fas fa-trash"></span>
                    </button>
                  </form>
                  <a href="{{route('team.edit', $team->id)}}" class="btn btn-sm btn-success">
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
          {{$teams->links()}}
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
@endsection