<html lang="en"><head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $appsettings[0]['application_title'] }}</title>
    <!-- Standard Favicon -->
    <link href="{{ asset('/storage/appsettings/'.$appsettings[0]['favicon']) }}" rel="shortcut icon">
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
      <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <link href="{{asset('dashboard/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/bootstrap-icons.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/boxicons.min.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/quill.snow.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/quill.bubble.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/remixicon.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/simple-datatables.css')}}" rel="stylesheet">
      <link href="{{asset('dashboard/css/style.css')}}" rel="stylesheet">
 </head>
 <body>
    <div class="container">
        @include('sweetalert::alert')
          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
             <div class="container">
                <div class="row justify-content-center">
                   <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                      <div class="card mb-3" style="border-radius:1rem; box-shadow:1px 1px 11px 1px rgb(169, 229, 253);">
                         <div class="card-body">
                            <div class="pt-4 pb-2">
                                <div class="d-flex justify-content-center py-4">
                                    <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['logo']) }}" style="width: 200px; height:200px;"  class="app-brand-logo">
                                </div>
                            </div>
                            <form class="row g-3 needs-validation" method="POST" action="{{ url('admin/login') }}" >
                                @csrf
                               <div class="col-12">
                                  <label for="email" class="form-label">Email</label> <input type="email" name="email" class="form-control" pattern="[A-Za-Z]" title="Only alphabet characters are allowed."  id="email" required="">
                                  <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                               </div>
                               <div class="col-12">
                                  <label for="password" class="form-label">Password</label> <input type="password" name="password" pattern=".{8,}" title="Only eight or more characters" class="form-control" id="yourPassword" required="">
                                  <div class="invalid-feedback">Please enter your password!</div>
                               </div>
                               <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Login with your Account</button></div>
                                 <div class="col-12"><p class="text-center"></p><a href="{{ url('admin/forget-password') }}">Forget your password</a> </div>
                            </form>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </section>
       </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{asset('dashboard/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dashboard/js/chart.min.js')}}"></script>
    <script src="{{asset('dashboard/js/echarts.min.js')}}"></script>
    <script src="{{asset('dashboard/js/quill.min.js')}}"></script>
    <script src="{{asset('dashboard/js/simple-datatables.js')}}"></script>
    <script src="{{asset('dashboard/js/tinymce.min.js')}}"></script>
    <script src="{{asset('dashboard/js/validate.js')}}"></script>
    <script src="{{asset('dashboard/js/main.js')}}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1002"></defs><polyline id="SvgjsPolyline1003" points="0,0"></polyline><path id="SvgjsPath1004" d="M0 0 "></path></svg></body></html>

 </body>
</html>
