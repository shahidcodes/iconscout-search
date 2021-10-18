@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <h2>{{$team->name}}</h2>
              <div class="row justify-content-between">
                <div class="col">
                  <h4>Members</h4>
                </div>
                <div class="col-1 row justify-content-end">
                  <a href="{{ route('member.create') }}" class="btn btn-primary">Add</a>
                </div>
              </div>
            </div>
            <table class="table table-bordered mt-2">
              <thead>
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($team->members as $member)
                <tr>
                  <td>{{$member->id}}</td>
                  <td>{{$member->name}}</td>
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
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection