<html lang="en">
    <head>
   <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $appsettings[0]['application_title'] }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ $appsettings[0]['favicon'] }}" rel="shortcut icon">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style>

        .bg-custom-primary{
            background-color:#17BE18 !important;
        }
        .bg-custom-primary:hover{
            background-color:#0faf0f !important;
        }
        .bg-custom-primary:focus{
            background-color:#0a800a !important;
        }
</style>
 </head>
 <body>
    <main>
       <div class="container">
          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
             <div class="container">
                <div class="row justify-content-center">
                   <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                      <div class="card mb-3" style="border-radius:1rem; box-shadow:1px 1px 11px 1px rgb(238, 238, 238);">
                         <div class="card-body">
                            <div class="d-flex justify-content-center py-4">
                                <img src="{{ $appsettings[0]['logo'] }}" style="max-height: 100px;"  class="app-brand-logo">
                            </div>
                              <h4 class="font-weight-bold text-dark text-center">Dellivery Man Login</h4>
                                <p class="text-muted text-center">Enter your credentials to access your account</p>
                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if(session('info'))
                                    <div class="alert alert-info">{{ session('info') }}</div>
                                @endif
                            <form class="row g-3 needs-validation" method="POST" action="{{ url('delivery-boy/login') }}" >
                                @csrf
                               <div class="col-12">
                                  <label for="email" class="form-label">Email</label> <input type="email" name="email" class="form-control" pattern="[A-Za-Z]" title="Only alphabet characters are allowed."  id="email" required="">
                                  <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                               </div>
                               <div class="col-12">
                                  <label for="password" class="form-label">Password</label> <input type="password" name="password" pattern=".{8,}" title="Only eight or more characters" class="form-control" id="yourPassword" required="">
                                  <div class="invalid-feedback">Please enter your password!</div>
                               </div>
                               <div class="col-12"> <button class="btn bg-custom-primary text-white w-100" type="submit">Login</button></div>
                                 <div class="col-12"><p class="text-center"></p><a class="text-dark text-muted" href="{{ url('admin/forget-password') }}">Forget your password</a> </div>
                            </form>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </section>
       </div>
       @include('sweetalert::alert')
    </main>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{asset('backend/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('backend/js/chart.min.js')}}"></script>
    <script src="{{asset('backend/js/echarts.min.js')}}"></script>
    <script src="{{asset('backend/js/quill.min.js')}}"></script>
    <script src="{{asset('backend/js/simple-datatables.js')}}"></script>
    <script src="{{asset('backend/js/tinymce.min.js')}}"></script>
    <script src="{{asset('backend/js/validate.js')}}"></script>
    @notifyJs
    <script src="{{asset('backend/js/main.js')}}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1002"></defs><polyline id="SvgjsPolyline1003" points="0,0"></polyline><path id="SvgjsPath1004" d="M0 0 "></path></svg></body></html>
