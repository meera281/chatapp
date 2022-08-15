@extends('layouts.app')
@section('content')
<div class="content-wrapper" style="overflow-y:hidden; background-color:#eee;">
  
  @if(isset($success))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{$success}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif




    <div class="container-fluid col-lg-12" >

<div class="row">
   <div class="contaier col-lg-12" style = "height:68px;">

   </div>
</div>

<div class="row">
 
   <div class="container col-lg-12">
      <h3 class="text-center fw-bold mt-3">Edit Agent</h3>
   </div>
   <div class="contaier col-lg-12" style = "height:531px;">
      <div class="container col-lg-4 bg-light" style="margin-top:36px; height:300px;width:594px;">
         <main class="form-signin text-center" style="padding-top:80px;padding-right:55px;padding-left:55px;">
            <form method="POST" action="/editagent">
              
               @csrf
               <div class="form-floating">
                            <input type="text" value="{{$name}}" class="form-control" id="floatingInput"  name="name" placeholder="name@example.com" required>
                            <label for="floatingInput">Agent Name</label>
                </div>
                <input type="hidden" name ="id" value="{{$id}}">       
                <button class="w-100 btn btn-primary mt-3" type="submit">Update Agent</button>
            </form>
         </main>
      </div>
   </div>
</div>

<div class="row">
   <div class="contaier col-lg-12" style = "height:0px;"></div>
</div>
</div>




    <!-- <form class="container col-md-4" method="POST" action="/editagent">
          @csrf
            <h2>Edit Agent</h2>
            <div class="mt-3 mb-3">
                <label for="exampleInputPassword1" class="form-label">Agent Name</label>
                <input type="text" name="name" class="form-control" placeholder="peter" id="exampleInputPassword1">
            </div>
            
            <div class="mt-3 mb-3">
                <label for="exampleInputPassword1" class="form-label"> </label>
                <input type="hidden" name="id" class="form-control" value="{{$id}}" id="exampleInputPassword1">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Update Agent</button>
      
    </form> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</div>
@endsection