@extends('layouts.app')
@section('content')
<div class="content-wrapper">

<!-- @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('success')}}</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
  @endif -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  
<div class="container">
<h2 class="text-center">Agent List</h2>
  <form method="get" action='/agentlist'>
    @csrf
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
            <a href="/edit/{{$userdetail['id']}}" > <button type="button" class="btn btn-primary mb-3"> <i class="fas fa-edit"></i> </button> </a> 
            <a href="/deleteagent/{{$userdetail['id']}}" > <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger mb-3"> <i class="fas fa-trash"></i> </button> </a>  
            </td>
        </tr>
        @endforeach
    </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</div>
@endsection