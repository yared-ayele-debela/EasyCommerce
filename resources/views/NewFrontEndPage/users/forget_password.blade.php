@extends('fontend.layout.layout')
@section('content')

<div class="page-lost-password u-s-p-t-80 ">
    <div class="container mb-4 ">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div class="page-lostpassword p-4 rounded-sm shadow-sm">
                    <h2 class="account-h2 u-s-m-b-20">Forgot Password ?</h2>
                    <h6 class="account-h6 u-s-m-b-30">Enter your email or username below and we will send you a link to reset your password.</h6>
                    <p id="forget-error"></p>
                    <p id="forget-success"></p>
                    <form  class="needs-validation" method="POST" action="javascript:;" id="forgetForm" >
                        @csrf
                        <div class="w-50">
                            <div class="u-s-m-b-13">
                                <label for="user-name-email">Username or Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="email" class="text-field" placeholder="Email" name="email">
                                <p id="forget-email"></p>
                            </div>
                            <div class="u-s-m-b-13">
                                <button class="button button-primary " type="submit">Get Reset Link</button>
                            </div>

                        </div>
                        <div class="page-anchor">
                            <a href="{{ url('user/login-register') }}">
                                <i class="fas fa-long-arrow-alt-left u-s-m-r-9"></i>Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 ">
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
         url:"/user/forgot-password",
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
