@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Members</h3>
          <a href="{{ route('member.create') }}" class="btn btn-primary" style="float:right;">Add</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">ID</th>
                <th>Name</th>
                <th>Team</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
              <tr>
                <td>{{$member->id}}</td>

                <td>{{$member->name}}</td>
                <td>
                  {{$member->team->name}}
                </td>
                <td>
                  <form method="POST" action="{{ route('member.destroy', $member->id) }}" style="display:inline;">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-sm btn-danger">
                      <span class="fas fa-trash"></span>
                    </button>
                  </form>
                  <a href="{{route('member.edit', $member->id)}}" class="btn btn-sm btn-success">
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
          {{$members->links()}}
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
@endsection