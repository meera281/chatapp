@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    

 @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  
  <!-- <div class="container">
    <form method="post" action='/getagentfromadmin'>
      @csrf
      <div class="form-floating text-right">
        <button type="submit" class="btn-primary mt-3"> Go to Agent Dashboard </button>
      </div>
    </form>
  </div> -->

  <div class="container">
    <h2 class="text-center" style="padding-top:14px;">Agent List</h2>
    <form method="get" action='/admin'>
      <!-- @csrf -->
      <div class="form-floating text-right">
        <input type="text" name='search'>
        <button type='submit'> <i class="fas fa-search fa-fw"></i> </button>
      </div>
    </form>
  </div>

  <div class="container col-lg-11">
    <table class="table table-bordered table-hover text-center">
      <tr class="table-success">
        <td>ID</td>
        <td>Agent Name</td>
        <td>Agent Email</td>
        <td>Operations</td>
      </tr>
     @foreach($userdetails as $userdetail)    
        <tr>
          <td> {{$userdetail['id']}} </td>
          <td> {{$userdetail['name']}} </td>
          <td> {{$userdetail['email']}} </td>
          <td> 
            <a href="/edit/{{$userdetail['id']}}/{{$userdetail['name']}}" > <button type="button" class="btn btn-primary mb-3"> <i class="fas fa-edit"></i> </button> </a> 
            <a href="/deleteagent/{{$userdetail['id']}}" > <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger mb-3"> <i class="fas fa-trash"></i> </button> </a>  
          </td>
        </tr>
      @endforeach
    </table>
  </div>

    
</div>
<!-- /.content-wrapper -->
@endsection