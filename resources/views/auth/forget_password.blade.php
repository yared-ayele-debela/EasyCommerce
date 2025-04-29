@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="offer-card p-4 rounded shadow-sm ">
                <h2 class="account-h2 mb-3 text-dark text-center">Forgot Password?</h2>
                <h6 class="account-h6 mb-4 text-dark text-center">Enter your email or username below and we will send you a link to reset your password.</h6>
                <p id="forget-error" class="text-danger"></p>
                <p id="forget-success" class="text-success"></p>
                <form class="needs-validation" method="POST" action="javascript:;" id="forgetForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-left">Username or Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" class="form-control" placeholder="Email" name="email" required>
                        <p id="forget-email" class="text-danger"></p>
                    </div>
                    <div class="mb-3">
                        <button  type="submit" class="btn text-white bg-primary w-100">Get Reset Link</button>
                    </div>
                </form>
                <div class="page-anchor mt-3">
                    <a href="{{ url('auth/login') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-arrow-left me-2"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
  <script>
    //Forgot password
 $("#forgetForm").submit(function(){
        var formdata=$(this).serialize();
        $.ajax({
         url:"/auth/forgot-password",
         type:"POST",
         data:formdata,
         success:function(resp){
            // alert(resp.type);
             if(resp.type=="error"){
              $.each(resp.errors,function(i,error){
                 $("#forget-"+i).attr('style','color:red');
                 $("#forget-"+i).html(error);
                 setTimeout(function(){
                   $("#forget-"+i).css({
                     'display':'none'
                   });
                 },3000);
              });
             }
             else if(resp.type=="success")
             {
            //    alert(resp.message);
               $("#forget-success").attr('style','color:green');
               $("#forget-success").html(resp.message);
             }
         },error:function(){
            alert("Error");
         }
        })

      });

  </script>
@endsection
