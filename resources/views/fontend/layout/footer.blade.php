<style>
     @media (max-width: 767px) {
      /* For screens smaller than 768px (i.e., mobile devices) */
      .footers {
        margin-left: 20px;
      }
    }
    ul li a:hover{
        color: lightgray;
    }
</style>
<footer class="pt-1 pb-5" style="background-color:#1B5B53;">
    <div class="container">
        <div class="outer-footer-wrapper u-s-p-y-80 text-white">
            <h2 class="text-white">
                For special offers and other discount information
            </h2>
            <h1 class="text-white">
                Subscribe to our Newsletter
            </h1>

            <br>
            <form class="newsletter-form" action="{{ url('newslettersubscriber') }}" method="POST">
                @csrf
                 <label class="sr-only" for="newsletter-field">Enter your Email</label>
                <input type="text" id="newsletter-field" name="email" class="border text-dark" placeholder="Your Email Address">
                <button type="submit" class="button border">SUBMIT</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-3 col-lg-3 footers">
                <div class="row">
                <a href="#" class="logo ">
                    <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['footer_image']) }}" style="height:50px; " class="" alt="">
                </a>
                </div>
                <br>
                <div class="row">
                   <span class="text-uppercase  text-white"><b>Download Our App</b></span>
                </div>
                <div class="row pt-2">
                    <a href="" class="btn btn-outline-light d-flex align-items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
                        <linearGradient id="OpwYZ9nhL01h2sErtedzua_4PbFeZOKAc61_gr1" x1="24" x2="24" y1="4.617" y2="40.096" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#33bef0"></stop><stop offset="1" stop-color="#0a85d9"></stop></linearGradient><path fill="url(#OpwYZ9nhL01h2sErtedzua_4PbFeZOKAc61_gr1)" d="M33.9,6H14.1C9.626,6,6,9.626,6,14.1v19.8c0,4.473,3.626,8.1,8.1,8.1h19.8	c4.474,0,8.1-3.627,8.1-8.1V14.1C42,9.626,38.374,6,33.9,6z"></path><path d="M12.3,30.977c-1.378,0-2.5-1.114-2.5-2.484c0-1.37,1.122-2.484,2.5-2.484h3.798l4.869-8.309	l-1.423-2.429c-0.338-0.578-0.431-1.251-0.262-1.897c0.169-0.646,0.58-1.188,1.156-1.524c0.384-0.224,0.82-0.342,1.262-0.342	c0.885,0,1.712,0.474,2.158,1.237l0.007,0.012l0.006-0.011c0.445-0.763,1.272-1.237,2.158-1.237c0.443,0,0.879,0.119,1.263,0.343	c1.19,0.698,1.59,2.233,0.892,3.422l-6.291,10.736h3.328l0.293,0.295c0.222,0.223,0.425,0.476,0.623,0.774l0.197,0.33	c0.489,0.911,0.598,1.918,0.319,2.854l-0.211,0.714H12.3z" opacity=".05"></path><path d="M12.3,30.477c-1.103,0-2-0.89-2-1.984c0-1.094,0.897-1.984,2-1.984h4.084l5.162-8.809l-1.572-2.682	c-0.27-0.461-0.345-1-0.209-1.518c0.135-0.517,0.463-0.95,0.924-1.219c0.307-0.179,0.656-0.274,1.01-0.274	c0.708,0,1.37,0.379,1.727,0.989l0.438,0.749l0.438-0.748c0.356-0.61,1.018-0.989,1.726-0.989c0.354,0,0.703,0.095,1.01,0.274	c0.952,0.559,1.271,1.787,0.713,2.738L21.02,26.509h3.992l0.146,0.147c0.198,0.199,0.381,0.427,0.56,0.698l0.185,0.31	c0.418,0.781,0.511,1.646,0.27,2.456l-0.106,0.357H12.3z" opacity=".07"></path><path fill="#fff" d="M25.302,27.63c-0.148-0.224-0.312-0.434-0.498-0.621h-4.656l7.173-12.242	c0.419-0.715,0.179-1.634-0.535-2.053c-0.716-0.419-1.635-0.179-2.052,0.536l-0.87,1.484l-0.87-1.485	c-0.418-0.715-1.337-0.954-2.052-0.536c-0.715,0.418-0.955,1.337-0.536,2.052l1.72,2.935l-5.455,9.309H12.3	c-0.829,0-1.5,0.665-1.5,1.484c0,0.819,0.671,1.484,1.5,1.484h13.394c0.194-0.653,0.141-1.382-0.221-2.058L25.302,27.63z"></path><path d="M14.5,36.179c-0.443,0-0.879-0.119-1.263-0.344c-0.576-0.338-0.986-0.88-1.155-1.526	c-0.168-0.646-0.075-1.32,0.263-1.896l0.713-1.218l0.44-0.088C13.859,31.036,14.196,31,14.528,31l0.118,0.001	c1.081,0.032,2.06,0.494,2.766,1.3l0.476,0.542l-1.229,2.1C16.211,35.706,15.385,36.179,14.5,36.179z" opacity=".05"></path><path d="M14.5,35.679c-0.354,0-0.704-0.095-1.01-0.275c-0.46-0.27-0.789-0.704-0.924-1.221	s-0.061-1.056,0.21-1.517l0.6-1.024l0.22-0.044c0.329-0.066,0.634-0.098,0.932-0.098l0.112,0.001	c0.933,0.028,1.783,0.429,2.396,1.129l0.238,0.271l-1.047,1.789C15.87,35.3,15.208,35.679,14.5,35.679z" opacity=".07"></path><path fill="#fff" d="M14.626,32.002c-0.317-0.009-0.628,0.026-0.932,0.087l-0.487,0.831	c-0.419,0.715-0.179,1.634,0.536,2.053c0.238,0.14,0.5,0.206,0.757,0.206c0.515,0,1.017-0.266,1.295-0.741l0.865-1.477	c-0.487-0.556-1.19-0.934-2.03-0.959H14.626z"></path><path d="M33.229,36.179c-0.885,0-1.712-0.474-2.158-1.236l-6.027-10.285l-0.017-0.052	c-0.417-1.289-0.335-2.618,0.214-3.793l1.669-2.858l4.72,8.055h4.07c1.378,0,2.5,1.114,2.5,2.484c0,1.37-1.122,2.484-2.5,2.484	h-1.159l0.842,1.437c0.338,0.576,0.431,1.249,0.263,1.896s-0.579,1.188-1.155,1.526C34.109,36.06,33.673,36.179,33.229,36.179z" opacity=".05"></path><path d="M33.229,35.679c-0.708,0-1.37-0.378-1.727-0.988l-6-10.238l-0.017-0.052	c-0.361-1.118-0.288-2.317,0.208-3.376l1.216-2.081l4.433,7.565H35.7c1.103,0,2,0.89,2,1.984c0,1.094-0.897,1.984-2,1.984h-2.031	l1.283,2.19c0.271,0.461,0.345,1,0.21,1.517s-0.463,0.951-0.924,1.221C33.933,35.584,33.584,35.679,33.229,35.679z" opacity=".07"></path><path fill="#fff" d="M35.7,27.009h-4.643l-4.147-7.076l-0.763,1.303c-0.444,0.95-0.504,2.024-0.185,3.011l5.972,10.191	c0.279,0.476,0.78,0.741,1.295,0.741c0.257,0,0.519-0.066,0.757-0.206c0.715-0.419,0.954-1.338,0.535-2.053l-1.725-2.943H35.7	c0.829,0,1.5-0.665,1.5-1.484C37.2,27.674,36.529,27.009,35.7,27.009z"></path>
                        </svg>
                        <span class="ml-2">Google Play</span>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="" class="btn btn-outline-light d-flex align-items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
                        <linearGradient id="jFdG-76_seIEvf-hbjSsaa_rZwnRdJyYqRi_gr1" x1="1688.489" x2="1685.469" y1="-883.003" y2="-881.443" gradientTransform="matrix(11.64 0 0 22.55 -19615.32 19904.924)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#047ed6"></stop><stop offset="1" stop-color="#50e6ff"></stop></linearGradient><path fill="url(#jFdG-76_seIEvf-hbjSsaa_rZwnRdJyYqRi_gr1)" fill-rule="evenodd" d="M7.809,4.608c-0.45,0.483-0.708,1.227-0.708,2.194	v34.384c0,0.967,0.258,1.711,0.725,2.177l0.122,0.103L27.214,24.2v-0.433L7.931,4.505L7.809,4.608z" clip-rule="evenodd"></path><linearGradient id="jFdG-76_seIEvf-hbjSsab_rZwnRdJyYqRi_gr2" x1="1645.286" x2="1642.929" y1="-897.055" y2="-897.055" gradientTransform="matrix(9.145 0 0 7.7 -15001.938 6931.316)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffda1c"></stop><stop offset="1" stop-color="#feb705"></stop></linearGradient><path fill="url(#jFdG-76_seIEvf-hbjSsab_rZwnRdJyYqRi_gr2)" fill-rule="evenodd" d="M33.623,30.647l-6.426-6.428v-0.45l6.428-6.428	l0.139,0.086l7.603,4.321c2.177,1.227,2.177,3.249,0,4.493l-7.603,4.321C33.762,30.561,33.623,30.647,33.623,30.647z" clip-rule="evenodd"></path><linearGradient id="jFdG-76_seIEvf-hbjSsac_rZwnRdJyYqRi_gr3" x1="1722.978" x2="1720.622" y1="-889.412" y2="-886.355" gradientTransform="matrix(15.02 0 0 11.5775 -25848.943 10324.73)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#d9414f"></stop><stop offset="1" stop-color="#8c193f"></stop></linearGradient><path fill="url(#jFdG-76_seIEvf-hbjSsac_rZwnRdJyYqRi_gr3)" fill-rule="evenodd" d="M33.762,30.561l-6.565-6.567L7.809,43.382	c0.708,0.761,1.9,0.847,3.232,0.103L33.762,30.561" clip-rule="evenodd"></path><linearGradient id="jFdG-76_seIEvf-hbjSsad_rZwnRdJyYqRi_gr4" x1="1721.163" x2="1722.215" y1="-891.39" y2="-890.024" gradientTransform="matrix(15.02 0 0 11.5715 -25848.943 10307.886)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#33c481"></stop><stop offset="1" stop-color="#61e3a7"></stop></linearGradient><path fill="url(#jFdG-76_seIEvf-hbjSsad_rZwnRdJyYqRi_gr4)" fill-rule="evenodd" d="M33.762,17.429L11.041,4.522	c-1.33-0.761-2.524-0.658-3.232,0.103l19.386,19.369L33.762,17.429z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">Google Play</span>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-lg-2">
                {{-- <div class="row"> --}}
                        <h2 class="footer-heading"><a href="#" class="logo">
                        </a></h2>
                        <p class="text-white">{{ $appsettings[0]['footer_text'] }}</p>
                {{-- </div> --}}
            </div>
            <div class="col-lg-3 col-md-2">
                      <div class="outer-footer__content u-s-m-b-40">
                    <span class="outer-footer__content-title  pb-3 text-white"><b>Address</b></span>
                    <div class="outer-footer__text-wrap pb-1 text-white"><i class="fas fa-home"></i>
                        <span>{{ $appsettings[0]['address'] }}</span>
                    </div>
                    <div class="outer-footer__text-wrap  pb-1 text-white"><i class="fas fa-phone-volume"></i>
                        <span>{{ $appsettings[0]['phone_no'] }}</span>
                    </div>
                    <div class="outer-footer__text-wrap  pb-1 text-white"><i class="far fa-envelope"></i>
                        <span>{{ $appsettings[0]['email_address'] }}</span>
                    </div>
                    <div class="outer-footer__social">
                        @php
                            $facebookUrl = $appsettings[0]['facebook'];
                            $twitter = $appsettings[0]['twitter'];
                            $youtube = $appsettings[0]['youtube'];
                            $whatsapp = $appsettings[0]['whatsapp'];


                            // Check if the URL has a scheme, if not, prepend 'http://'
                            if (!Str::startsWith($facebookUrl, ['http://', 'https://'])) {
                                $facebookUrl = 'http://' . $facebookUrl;
                            }
                            if (!Str::startsWith($twitter, ['http://', 'https://'])) {
                                $twitter = 'http://' . $twitter;
                            } if (!Str::startsWith($youtube, ['http://', 'https://'])) {
                                $youtube = 'http://' . $youtube;
                            } if (!Str::startsWith($whatsapp, ['http://', 'https://'])) {
                                $whatsapp = 'http://' . $whatsapp;
                            }

                        @endphp
                                                <ul class="list-inline text-white">
                            <li class="list-inline-item text-white">
                                <a class="s-fb--color-hover" href="{{$facebookUrl }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="list-inline-item text-white">
                                <a class="s-tw--color-hover" href="{{ $twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item text-white">
                                <a class="s-youtube--color-hover" href="{{ $youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                            </li>
                            <li class="list-inline-item text-white">
                                <a class="s-insta--color-hover" href="{{ $whatsapp }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="outer-footer__content u-s-m-b-40">
                    <span class="outer-footer__content-title text-white"><b> Customer Service</b></span>
                    <div class="outer-footer__list-wrap">
                        <ul class="list-unstyled text-white">
                            @foreach ($cms_pages as $page)
                            <li class="pb-1"><a href="{{ url('page/'.$page['url']) }}">{{ $page['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="outer-footer__content u-s-m-b-40">
                    <span class="outer-footer__content-title text-white"><b>Our Company</b></span>
                    <div class="outer-footer__list-wrap">
                        <ul class="list-unstyled text-white ">
                            <li class="pb-1"><a href="{{ url('/') }}" class="hovers">Home</a></li>
                            <li class="pb-1"><a href="{{ url('faq') }}" >FAQ</a></li>
                            <li class="pb-1"><a href="{{ url('contact') }}" >Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="lower-footer " style="background-color: #1A6C64; padding:10px;">
        <div class="container ">
            <div class="row pl-3 pr-3">
                <div class="col-lg-12">
                    <div class="lower-footer__content d-flex justify-between">
                        <div class="lower-footer__copyright text-white">
                            <span>{{ $appsettings[0]['panel_footer_text'] }}</span>
                        </div>
                        <div class="lower-footer__payment">
                            <ul class="list-inline text-white">
                                <li class="list-inline-item text-white">
                                    <i class="fab fa-cc-stripe"></i>
                                </li>
                                <li class="list-inline-item text-white ">
                                    <i class="fab fa-cc-paypal"></i>
                                </li>
                                <li class="list-inline-item text-white">
                                    <i class="fab fa-cc-mastercard"></i>
                                </li>
                                <li class="list-inline-item text-white">
                                    <i class="fab fa-cc-visa"></i>
                                </li>
                                <li class="list-inline-item text-white">
                                    <i class="fab fa-cc-discover"></i>
                                </li>
                                <li class="list-inline-item text-white">
                                    <i class="fab fa-cc-amex"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Start of Tawk.to Script-->
<!--Start of Tawk.to Script-->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/65619746da19b36217909def/1hg2jdt1m';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    <!--End of Tawk.to Script-->
    <!--End of Tawk.to Script-->


<!--End of Tawk.to Script-->
</footer>
