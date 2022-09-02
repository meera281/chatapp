@extends('layouts.app')
@section('content')
<div class="content-wrapper" style="background-color:#eee;">

  
@if(isset($success))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{$success}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if ($errors->any())                   <!-- Displaying The Validation Errors -->
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul>
      @foreach ($errors->all() as $error)
        <li><strong>{{ $error }}</strong></li>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      @endforeach
    </ul>
  </div>
@endif


<div class="container-fluid col-lg-12" >

<div class="row">
   <div class="contaier col-lg-12" style = "height:50px;">

   </div>
</div>

<div class="row">
 
   <div class="container col-lg-12">
      <h3 class="text-center fw-bold mt-3">Add Agent</h3>
   </div>
   <div class="contaier col-lg-12" style = "height:521px;">
      <div class="container col-lg-4 bg-light" style="margin-top:36px; height:366px;width:594px;">
         <main class="form-signin text-center" style="padding-top:80px;padding-right:55px;padding-left:55px;">
            <form method="POST" action="addagent">
              
               @csrf
               <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                    <label for="floatingInput">Email Address</label>
                </div>
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="floatingname" name="name" placeholder="Enter name">
                    <label for="floatingPassword">Name</label>
                </div>

                <button class="w-100 btn btn-primary mt-3" type="submit">Add Agent</button>
            </form>
         </main>
      </div>
   </div>
</div>

<div class="row">
   <div class="contaier col-lg-12" style = "height:0px;"></div>
</div>
</div>




    <!-- <form class="container col-md-4" method="POST" action="/addagent">
      @csrf
      <h2>Add Agent</h2>
      <div class="mt-3 mb-3">
        <label for="exampleInputPassword1" class="form-label">Agent Name</label>
        <input type="text" name="name" class="form-control" placeholder="peter" id="exampleInputPassword1">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Agent Email</label>
        <input type="email" name="email" class="form-control" placeholder="peter@test.com" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-3">Add Agent</button>
    </form> -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</div>
@endsection