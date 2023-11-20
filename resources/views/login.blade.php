<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('assets/')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/')}}/css/style.css">
<body>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Login...</b></h4></div>

                    </div>
                </div>
                <div class="input-group mb-3">

                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                      </form>

                </div>


            </div>
            <div class="col-md-4 summary">


            </div>


        </div>

    </div>

   <script src="{{asset('assets/')}}/js/jquery-3.6.0.min.js"></script>
   <script src="{{asset('assets/')}}/js/popper.min.js"></script>
   <script src="{{asset('assets/')}}/js/bootstrap.min.js"></script>

</body>
</html>
