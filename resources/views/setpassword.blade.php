<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Set Password</title>

    <style>
          body {
            background-color: #F3EBF6;
            font-family: 'Ubuntu', sans-serif;
        }
        
        .main {
            background-color: #FFFFFF;
            width: 400px;
            height: 400px;
            margin: 7em auto;
            border-radius: 1.5em;
            box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
        }
        
        .sign {
            padding-top: 40px;
            color: #8C55AA;
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            font-size: 23px;
        }
        
        .un {
        width: 76%;
        color: rgb(38, 50, 56);
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        background: rgba(136, 126, 126, 0.04);
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        outline: none;
        box-sizing: border-box;
        border: 2px solid rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
        margin-left: 46px;
        text-align: center;
        margin-bottom: 27px;
        font-family: 'Ubuntu', sans-serif;
        }
        
        form.form1 {
            padding-top: 40px;
        }
        
        .pass {
                width: 76%;
        color: rgb(38, 50, 56);
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        background: rgba(136, 126, 126, 0.04);
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        outline: none;
        box-sizing: border-box;
        border: 2px solid rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
        margin-left: 46px;
        text-align: center;
        margin-bottom: 27px;
        font-family: 'Ubuntu', sans-serif;
        }
        
      
        .un:focus, .pass:focus {
            border: 2px solid rgba(0, 0, 0, 0.18) !important;
            
        }
        
        .submit {
          cursor: pointer;
            border-radius: 5em;
            color: #fff;
            background: linear-gradient(to right, #9C27B0, #E040FB);
            border: 0;
            padding-left: 40px;
            padding-right: 40px;
            padding-bottom: 10px;
            padding-top: 10px;
            font-family: 'Ubuntu', sans-serif;
            margin-left: 35%;
            font-size: 13px;
            box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
        }
        
        .forgot {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #E1BEE7;
            padding-top: 15px;
        }
        
        a {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #E1BEE7;
            text-decoration: none
        }
        
        @media (max-width: 600px) {
            .main {
                border-radius: 0px;
            }
          }
    </style>

  </head>

  <body>
    @if(isset($error))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{$error}}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    @endif
    
    <!-- <form class="container col-md-4 mt-3" method="POST" action="/setpassword">
      @csrf
        <h2>Set Password</h2>
  <div class="mb-3">
    <input type="hidden" name="email" class="form-control"  value="{{$_POST['email']}}" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
    <input type="password" name="confirmpassword" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
    </form> -->

    <div class="main">
      <p class="sign" align="center">Set Password</p>
      <form class="form1" method="POST" action="/setpassword">
        @csrf
        <input class="un " type="hidden" name="email" value="{{$_POST['email']}}" align="center" placeholder="Email">
        <input class="pass" type="password" name="password" align="center" placeholder="Password" required>
        <input class="pass" type="password" name="confirmpassword" align="center" placeholder="Confirm Password" required>
        <button type="submit" class="submit" align="center">Submit</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>