
@extends("dashbord.layout.main")

@section('content')

<div class="card-body">
    <h4 class="card-title">Default form</h4>
    <p class="card-description"> Basic form layout </p>
    <form class="forms-sample" method="POST" action="{{ route("user.update",$user->id) }}">
      @csrf
      @method("PUT")
      <div class="form-group">
        @error('name') <p style="color: red" >{{ $message }}</p> @enderror
        <label for="exampleInputUsername1">Username</label>
        <input type="text" value="{{ $user->name }}"  name="name" class="form-control" id="exampleInputUsername1" placeholder="Username">
      </div>
      <div class="form-group">
        @error('phone') <p style="color: red" >{{ $message }}</p> @enderror
        <label for="exampleInputEmail1">Phone </label>
        <input type="email" value="{{ $user->phone }}" name="email" class="form-control" id="exampleInputEmail1" placeholder="Phone">
      </div>


      <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
      <button class="btn btn-light">Cancel</button>
    </form>
  </div>

@endsection
