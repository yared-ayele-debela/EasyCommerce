<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Dashboard</title>
      <meta name="robots" content="noindex, nofollow">
      <meta content="" name="description">
      <meta content="" name="keywords">
      <link href="{{asset('dashboard/img/Logo.png')}}" rel="icon">
      <link href="{{asset('dashboard/img/Logo.png')}}" rel="apple-touch-icon">
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

      @notifyCss
      <style>
        .bg-custom-primary{
            background-color:#17BE18 !important;
        }
        .bg-c-blue {
            background: linear-gradient(45deg,#4099ff,#73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg,#2ed8b6,#59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg,#FFB64D,#ffcb80);
        }

        .bg-c-pink {
            background: linear-gradient(45deg,#FF5370,#ff869a);
        }
        </style>
   </head>
   <body>

    @include('delivery_man.admin_dashboard.header')
    @include('delivery_man.admin_dashboard.left_side_bar')
    <main id="main" class="main" style="background-color:rgb(242, 244, 245)">
    @yield('delivery_man_dashboard')
    </main>
    @include('delivery_man.admin_dashboard.footer')
         <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
         <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
         <script src="{{ asset('dashboard/js/apexcharts.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/chart.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/echarts.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/quill.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/simple-datatables.js')}}"></script>
         <script src="{{ asset('dashboard/js/tinymce.min.js')}}"></script>
         <script src="{{ asset('dashboard/js/validate.js')}}"></script>
         <script src="{{ asset('dashboard/js/main.js')}}"></script>
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
         <script>
    const deliverymanId = {{ Auth::guard('deliverymen')->user()->id }}; // or use a variable passed to Blade

    function updateLocation(position) {
        fetch('/api/deliveryman/update-location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // if using web.php
            },
            body: JSON.stringify({
                id: deliverymanId,
                lat: position.coords.latitude,
                lng: position.coords.longitude
            })
        }).then(response => response.json())
          .then(data => console.log(data.message))
          .catch(err => console.error('Update failed', err));
    }

    function trackLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(updateLocation);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }
    setInterval(trackLocation, 5000);
</script>

            <script>
                $(document).ready(function() {
                $('#example').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],

                } );
            } );

        </script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
         <script type="text/javascript">

            $('.confirm-button').click(function(event) {
                var form =  $(this).closest("form");
                  var name = $(this).data("name");
                  event.preventDefault();
                  swal({
                      title: `Are you sure you want to delete this record?`,
                      text: "If you delete this, it will be gone forever.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
            });
        </script>
            @yield('jquery')
            @notifyJs
            //add this into main layouts
           @yield('script')

   </body>
</html>
