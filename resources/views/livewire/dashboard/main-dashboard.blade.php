<div>
    <div class="pagetitle shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold" style="font-weight: bold">Total Admins</p>
                                        <h4 class="my-1 text-success">{{ $alladmins }}</h4>
                                        <p class="mb-0 font-13">+5.4% from last week</p>
                                    </div>
                                    <div class="widgets-icons-2  rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Customers</p>
                                        <h4 class="my-1 text-success">{{ $allusers }}</h4>
                                        <p class="mb-0 font-13">
                                            {{ $lastMonthCustomer }}
                                            @if ($percentageCustomer >= 0)
                                           ( {{ number_format($percentageCustomer, 1) }}% ) from <br> last month
                                            @else
                                           ( {{ number_format(abs($percentageCustomer), 1) }}% ) down from <br> last month
                                            @endif
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2  rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Customer_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.64 0 0 0.64 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -11.6)" d="M 11.548828 2.2089844 C 11.433875 2.2156719 11.317281 2.2432188 11.207031 2.2929688 C 10.201031 2.7459687 8.5434219 3.7951562 8.1074219 5.9101562 C 7.6204219 8.2741563 9.1644531 10.722562 11.564453 10.976562 C 13.969453 11.230562 16 9.353 16 7 C 16 4.357 13.817 3.5019531 13 3.5019531 L 12.4375 2.65625 C 12.2365 2.354 11.893688 2.1889219 11.548828 2.2089844 z M 12 14 C 8.996 14 3 15.508 3 18.5 L 3 20 C 3 20.552 3.448 21 4 21 L 20 21 C 20.552 21 21 20.552 21 20 L 21 18.5 C 21 15.508 15.004 14 12 14 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Vendors</p>
                                        <h4 class="my-1 text-success">{{ $allvendors }}</h4>
                                        <p class="mb-0 font-13">
                                            {{ $lastMonthVendors }}
                                             @if ($percentageChange >= 0)
                                           ( {{ number_format($percentageChange, 1) }}% ) from <br> last month
                                            @else
                                           ( {{ number_format(abs($percentageChange), 1) }}% ) down from <br> last month
                                            @endif

                                        </p>
                                    </div>
                                    <div class="widgets-icons-2  rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Delivery Boy</p>
                                        <h4 class="my-1 text-success">{{ $alldeliveryboys }}</h4>
                                    </div>
                                    <div class="widgets-icons-2  rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivery_Man_Head_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.5 0 0 0.5 8 8)">
                                                <g style="">
                                                    <g transform="matrix(1 0 0 1 -2 -8.53)">
                                                        <path style="stroke: rgb(248, 248, 248); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-10, -3.47)" d="M 12.5 5.945 C 12.5 6.04418 12.4705 6.14111 12.4152 6.22347 C 12.36 6.30583 12.2815 6.3699 12.1897 6.40753 C 12.0979 6.44516 11.9971 6.45464 11.8999 6.43478 C 11.8027 6.41492 11.7137 6.36662 11.644 6.296 L 10 4.625 L 8.35602 6.3 C 8.28614 6.37086 8.1967 6.41926 8.09915 6.439 C 8.00161 6.45873 7.90039 6.44891 7.80846 6.41078 C 7.71653 6.37266 7.63807 6.30796 7.58312 6.22499 C 7.52817 6.14201 7.49923 6.04452 7.50002 5.945 L 7.50002 0.5 L 12.5 0.5 L 12.5 5.945 Z" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 -2.5 -3)">
                                                        <path style="stroke: rgb(255, 251, 251); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-9.5, -9)" d="M 7.5 17.5 L 1.5 17.5 C 1.23478 17.5 0.98043 17.3946 0.792893 17.2071 C 0.605357 17.0196 0.5 16.7652 0.5 16.5 L 0.5 1.5 C 0.5 1.23478 0.605357 0.98043 0.792893 0.792893 C 0.98043 0.605357 1.23478 0.5 1.5 0.5 L 17.5 0.5 C 17.7652 0.5 18.0196 0.605357 18.2071 0.792893 C 18.3946 0.98043 18.5 1.23478 18.5 1.5 L 18.5 7.167" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 4.5 0.44)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.5, -12.44)" d="M 16.5 11.438 C 16.3022 11.438 16.1089 11.4966 15.9444 11.6065 C 15.78 11.7164 15.6518 11.8726 15.5761 12.0553 C 15.5004 12.238 15.4806 12.4391 15.5192 12.6331 C 15.5578 12.8271 15.653 13.0052 15.7929 13.1451 C 15.9327 13.2849 16.1109 13.3802 16.3049 13.4188 C 16.4989 13.4574 16.7 13.4376 16.8827 13.3619 C 17.0654 13.2862 17.2216 13.158 17.3315 12.9936 C 17.4414 12.8291 17.5 12.6358 17.5 12.438 C 17.5 12.1728 17.3946 11.9184 17.2071 11.7309 C 17.0196 11.5433 16.7652 11.438 16.5 11.438 Z" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 4.5 8.25)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.5, -20.25)" d="M 18 20 C 17.5673 20.3246 17.0409 20.5 16.5 20.5 C 15.9591 20.5 15.4327 20.3246 15 20" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 4.5 4)">
                                                        <path style="stroke: rgb(241, 241, 241); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.5, -16)" d="M 9.5 16.5 C 14.0714 15.1667 18.9286 15.1667 23.5 16.5" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 4.5 4.52)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.5, -16.52)" d="M 22.5 16 L 21.62 11.59 C 21.5845 11.4121 21.5012 11.2472 21.3792 11.113 C 21.2571 10.9787 21.1008 10.8802 20.927 10.828 L 16.79 9.58604 C 16.6025 9.52975 16.4025 9.52975 16.215 9.58604 L 12.077 10.826 C 11.9032 10.8782 11.7469 10.9767 11.6248 11.111 C 11.5028 11.2452 11.4195 11.4101 11.384 11.588 L 10.5 16 L 10.5 17.5 C 10.5 19.0913 11.1321 20.6175 12.2574 21.7427 C 13.3826 22.8679 14.9087 23.5 16.5 23.5 C 18.0913 23.5 19.6174 22.8679 20.7426 21.7427 C 21.8679 20.6175 22.5 19.0913 22.5 17.5 L 22.5 16 Z" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 2.38 5.5)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-14.38, -17.5)" d="M 14.5 17.75 C 14.3619 17.75 14.25 17.6381 14.25 17.5 C 14.25 17.3619 14.3619 17.25 14.5 17.25" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 2.63 5.5)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-14.63, -17.5)" d="M 14.5 17.75 C 14.6381 17.75 14.75 17.6381 14.75 17.5 C 14.75 17.3619 14.6381 17.25 14.5 17.25" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 6.38 5.5)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-18.38, -17.5)" d="M 18.5 17.75 C 18.3619 17.75 18.25 17.6381 18.25 17.5 C 18.25 17.3619 18.3619 17.25 18.5 17.25" stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 6.63 5.5)">
                                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-18.63, -17.5)" d="M 18.5 17.75 C 18.6381 17.75 18.75 17.6381 18.75 17.5 C 18.75 17.3619 18.6381 17.25 18.5 17.25" stroke-linecap="round" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Sales Person</p>
                                        <h4 class="my-1 text-success">{{ $total_sales_person }}</h4>
                                    </div>
                                    <div class="widgets-icons-2  rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Personal_Growth_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.27 0 0 0.27 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(243, 243, 243); fill-rule: nonzero; opacity: 1;" transform=" translate(-25.99, -25)" d="M 38 3 C 34.698136 3 32 5.6981361 32 9 C 32 12.301864 34.698136 15 38 15 C 41.301864 15 44 12.301864 44 9 C 44 5.6981361 41.301864 3 38 3 z M 12 5 C 11.63936408342243 4.994899710454515 11.303918635428394 5.184375296169332 11.122112278513482 5.495872849714331 C 10.940305921598572 5.80737040325933 10.940305921598572 6.192629596740671 11.122112278513484 6.504127150285671 C 11.303918635428394 6.815624703830669 11.639364083422432 7.005100289545485 12 7 L 18.585938 7 L 4.2929688 21.292969 C 4.031730979736982 21.54378627693672 3.9264984571322734 21.91623528883332 4.0178557241231125 22.26667551899203 C 4.109212991113951 22.617115749150738 4.382884502828869 22.89078718345139 4.733324758830068 22.98214435131215 C 5.0837650148312665 23.07350151917291 5.456213996960412 22.96826889121244 5.7070312 22.707031 L 20 8.4140625 L 19.998047 15 C 19.992946710454515 15.36063591657757 20.18242229616933 15.696081364571606 20.49391984971433 15.877887721486518 C 20.80541740325933 16.059694078401428 21.19067659674067 16.059694078401428 21.50217415028567 15.877887721486516 C 21.813671703830668 15.696081364571606 22.003147289545485 15.360635916577568 21.998047 15 L 22 5 L 12 5 z M 38 5 C 40.220984 5 42 6.7790164 42 9 C 42 11.220984 40.220984 13 38 13 C 35.779016 13 34 11.220984 34 9 C 34 6.7790164 35.779016 5 38 5 z M 33.5 16 C 30.475695 16 28 18.476746 28 21.5 L 28 32 C 27.99924541128578 32.07283238866816 28.006449476821825 32.145529269882914 28.021484 32.216797 C 28.135989 33.760669 29.429122 35 31 35 C 31.351843 35 31.685108 34.92606 32 34.8125 L 32 43.5 C 32 45.421188 33.578812 47 35.5 47 C 36.476925 47 37.362705 46.58945 38 45.935547 C 38.637295 46.58945 39.523075 47 40.5 47 C 42.421188 47 44 45.421188 44 43.5 L 44 34.8125 C 44.314892 34.92606 44.648157 35 45 35 C 46.571539 35 47.864967 33.759624 47.978516 32.214844 C 47.99340958688333 32.14421449041259 48.00061288897951 32.07218012830349 48 32 L 48 21.5 C 48 18.476746 45.524305 16 42.5 16 L 41.599609 16 L 34.400391 16 L 33.5 16 z M 33.5 18 L 34.400391 18 L 41.599609 18 L 42.5 18 C 44.439695 18 46 19.561254 46 21.5 L 46 32 C 46 32.56503 45.56503 33 45 33 C 44.43497 33 44 32.56503 44 32 L 44 24 L 42 24 L 42 32 L 42 43.5 C 42 44.340812 41.340812 45 40.5 45 C 39.659188 45 39 44.340812 39 43.5 L 39 32 L 37 32 L 37 43.5 C 37 44.340812 36.340812 45 35.5 45 C 34.659188 45 34 44.340812 34 43.5 L 34 24 L 32 24 L 32 32 C 32 32.56503 31.56503 33 31 33 C 30.43497 33 30 32.56503 30 32 L 30 21.5 C 30 19.561254 31.560305 18 33.5 18 z M 20 21 L 20 22 L 20 47 L 26 47 L 26 21 L 20 21 z M 22 23 L 24 23 L 24 45 L 22 45 L 22 23 z M 12 28 L 12 29 L 12 47 L 18 47 L 18 28 L 12 28 z M 14 30 L 16 30 L 16 45 L 14 45 L 14 30 z M 4 34 L 4 35 L 4 47 L 10 47 L 10 34 L 4 34 z M 6 36 L 8 36 L 8 45 L 6 45 L 6 36 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Orders</p>
                                        <br>
                                        <h4 class="my-1 text-success">{{ $allorders }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Paid <br> Order</p>
                                        <h4 class="my-1 text-success">{{ $paidorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Paid_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='26' height='26' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.46 0 0 0.46 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-15, -13)" d="M 15 1 C 14.74425 1 14.488469 1.0974687 14.292969 1.2929688 L 7.5859375 8 L 10.414062 8 L 15 3.4140625 L 19.585938 8 L 22.414062 8 L 15.707031 1.2929688 C 15.511531 1.0974687 15.25575 1 15 1 z M 3 10 C 2.448 10 2 10.448 2 11 L 2 13 C 2 13.552 2.448 14 3 14 L 3.1660156 14 L 4.7207031 23.328125 C 4.8817031 24.292125 5.7163594 25 6.6933594 25 L 23.304688 25 C 24.282688 25 25.116344 24.292125 25.277344 23.328125 L 26.833984 14 L 27 14 C 27.552 14 28 13.552 28 13 L 28 11 C 28 10.448 27.552 10 27 10 L 3 10 z M 19 14 C 19.25575 14 19.511531 14.097469 19.707031 14.292969 C 20.098031 14.683969 20.098031 15.316031 19.707031 15.707031 L 14.707031 20.707031 C 14.512031 20.902031 14.256 21 14 21 C 13.744 21 13.487969 20.902031 13.292969 20.707031 L 11.292969 18.707031 C 10.901969 18.316031 10.901969 17.683969 11.292969 17.292969 C 11.683969 16.901969 12.316031 16.901969 12.707031 17.292969 L 14 18.585938 L 18.292969 14.292969 C 18.488469 14.097469 18.74425 14 19 14 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Pending Orders</p>
                                        <h4 class="my-1 text-success">{{ $pendingorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Data_Pending_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.55 0 0 0.55 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-15, -15)" d="M 6 4 C 4.9069372 4 4 4.9069372 4 6 L 4 8 L 4 24 C 4 25.105 4.895 26 6 26 L 24 26 C 25.105 26 26 25.105 26 24 L 26 8 L 26 6 C 26 4.9069372 25.093063 4 24 4 L 6 4 z M 6 6 L 24 6 L 24 8 L 17 8 C 17 9.105 16.105 10 15 10 C 13.895 10 13 9.105 13 8 L 6 8 L 6 6 z M 15 12 C 18.314 12 21 14.686 21 18 C 21 21.314 18.314 24 15 24 C 11.686 24 9 21.314 9 18 C 9 14.686 11.686 12 15 12 z M 14.984375 13.986328 C 14.43285880343316 13.99494907306296 13.992447279873389 14.448468138368236 14 15 L 14 17.585938 L 12.792969 18.792969 C 12.531728205207122 19.04378557313715 12.42649336499705 19.416235992218144 12.517850189015965 19.76667805152247 C 12.609207013034881 20.117120110826793 12.882879889173207 20.39079298696512 13.233321948477531 20.482149810984033 C 13.583764007781856 20.57350663500295 13.956214426862848 20.468271794792877 14.207031 20.207031 L 16 18.414062 L 16 15 C 16.0037014610102 14.729699667173675 15.89782332475401 14.469413346079792 15.706490332869745 14.278448278708167 C 15.51515734098548 14.087483211336544 15.254667707530459 13.982106271031087 14.984375 13.986328 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Delivered Order</p>
                                        <h4 class="my-1 text-success">{{ $deliveredorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total New <br> Order</p>
                                        <h4 class="my-1 text-success">{{ $neworder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Cancelled Order</p>
                                        <h4 class="my-1 text-success">{{ $cancelledorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Processing Order</p>
                                        <h4 class="my-1 text-success">{{ $processingorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Picked Order</p>
                                        <h4 class="my-1 text-success">{{ $pickedorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Completed Order</p>
                                        <h4 class="my-1 text-success">{{ $completedorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3  border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Paid <br> Order</p>
                                        <h4 class="my-1 text-success">{{ $paidorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Delivered_Box_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.57 0 0 0.57 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.5, -13.5)" d="M 5.75 3 C 5.395 3 5.0657188 3.1890937 4.8867188 3.4960938 L 3.1367188 6.4960938 C 3.0477188 6.6490937 3 6.823 3 7 L 3 19 C 3 20.103 3.897 21 5 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 15.134 15.134 12 19 12 C 19.34 12 19.673 12.033078 20 12.080078 L 20 12.074219 C 20.342 12.124219 20.676 12.198922 21 12.294922 L 21 7 C 21 6.823 20.952281 6.6490938 20.863281 6.4960938 L 19.113281 3.4960938 C 18.934281 3.1890937 18.605 3 18.25 3 L 5.75 3 z M 6.3242188 5 L 17.675781 5 L 18.841797 7 L 5.1582031 7 L 6.3242188 5 z M 9 9 L 15 9 L 15 11 L 9 11 L 9 9 z M 19 14 C 16.239 14 14 16.239 14 19 C 14 21.761 16.239 24 19 24 C 21.761 24 24 21.761 24 19 C 24 16.239 21.761 14 19 14 z M 21.050781 16.650391 L 22.449219 18.050781 L 18.5 22 L 15.550781 19.050781 L 16.949219 17.650391 L 18.5 19.199219 L 21.050781 16.650391 z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary my-3" style="font-weight: bold">Total Custom Orders</p>
                                        <h4 class="my-1 text-success">{{ $allcustomorder }}</h4>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <svg id='Purchase_Order_16' width='30' height='30' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='16' height='16' stroke='none' fill='#000000' opacity='0' />
                                            <g transform="matrix(0.46 0 0 0.46 8 8)">
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(251, 251, 251); fill-rule: nonzero; opacity: 1;" transform=" translate(-13.05, -13)" d="M 10.1875 0.0625 C 10.125 0.0664063 10.0625 0.078125 10 0.09375 C 9.652344 0.164063 9.367188 0.414063 9.25 0.75 L 4.4375 13.9375 C 4.289063 14.277344 4.34375 14.671875 4.578125 14.960938 C 4.808594 15.25 5.179688 15.386719 5.546875 15.316406 C 5.910156 15.246094 6.203125 14.980469 6.3125 14.625 L 10.84375 2.21875 L 23.625 4.78125 C 23.296875 5.8125 21.371094 11.972656 19.125 17.90625 C 18.175781 20.414063 17.402344 22.027344 16.625 22.875 C 16.109375 23.4375 15.59375 23.726563 14.875 23.84375 C 11.3125 24.34375 11.75 19.8125 11.75 19.8125 L 0.375 15.21875 C -0.808594 20.34375 3.125 21.5625 3.125 21.5625 L 11.46875 25.34375 C 11.46875 25.34375 12.269531 25.726563 13.1875 25.875 C 13.207031 25.875 13.230469 25.875 13.25 25.875 C 13.535156 25.917969 13.808594 25.964844 14.09375 25.9375 C 14.125 25.929688 14.15625 25.914063 14.1875 25.90625 C 15.765625 25.855469 17.089844 25.3125 18.09375 24.21875 C 19.242188 22.96875 20.03125 21.1875 21 18.625 C 23.460938 12.125 25.90625 4.3125 25.90625 4.3125 C 25.992188 4.042969 25.957031 3.75 25.816406 3.503906 C 25.671875 3.261719 25.433594 3.089844 25.15625 3.03125 L 10.375 0.09375 C 10.3125 0.078125 10.25 0.0664063 10.1875 0.0625 Z M 11.65625 5.59375 C 11.125 5.640625 10.722656 6.089844 10.738281 6.625 C 10.757813 7.15625 11.1875 7.582031 11.71875 7.59375 C 11.785156 7.609375 11.84375 7.617188 11.875 7.625 C 12.417969 7.738281 12.949219 7.386719 13.0625 6.84375 C 13.175781 6.300781 12.824219 5.769531 12.28125 5.65625 C 12.214844 5.640625 12.1875 5.632813 12.15625 5.625 C 12.054688 5.597656 11.949219 5.585938 11.84375 5.59375 C 11.78125 5.585938 11.71875 5.585938 11.65625 5.59375 Z M 14.90625 6.53125 C 14.417969 6.570313 14.027344 6.960938 13.988281 7.449219 C 13.949219 7.9375 14.273438 8.382813 14.75 8.5 L 19.125 9.71875 C 19.660156 9.867188 20.210938 9.550781 20.359375 9.015625 C 20.507813 8.480469 20.191406 7.929688 19.65625 7.78125 L 15.28125 6.59375 C 15.191406 6.558594 15.097656 6.539063 15 6.53125 C 14.96875 6.53125 14.9375 6.53125 14.90625 6.53125 Z M 10.1875 9.75 C 9.710938 9.828125 9.355469 10.238281 9.347656 10.722656 C 9.339844 11.207031 9.679688 11.625 10.15625 11.71875 C 10.222656 11.734375 10.28125 11.742188 10.3125 11.75 C 10.679688 11.882813 11.09375 11.792969 11.367188 11.511719 C 11.644531 11.234375 11.730469 10.820313 11.589844 10.453125 C 11.449219 10.089844 11.109375 9.835938 10.71875 9.8125 C 10.652344 9.796875 10.625 9.789063 10.59375 9.78125 C 10.460938 9.742188 10.324219 9.734375 10.1875 9.75 Z M 13.09375 10.65625 C 12.636719 10.730469 12.289063 11.105469 12.253906 11.5625 C 12.214844 12.023438 12.5 12.449219 12.9375 12.59375 L 17.3125 14.03125 C 17.839844 14.203125 18.40625 13.917969 18.578125 13.390625 C 18.75 12.863281 18.464844 12.296875 17.9375 12.125 L 13.5625 10.71875 C 13.414063 10.660156 13.253906 10.640625 13.09375 10.65625 Z M 8.59375 13.59375 C 8.117188 13.671875 7.761719 14.082031 7.753906 14.566406 C 7.746094 15.050781 8.085938 15.46875 8.5625 15.5625 C 8.628906 15.578125 8.6875 15.585938 8.71875 15.59375 C 9.082031 15.722656 9.488281 15.628906 9.761719 15.359375 C 10.03125 15.085938 10.125 14.679688 9.996094 14.316406 C 9.867188 13.953125 9.539063 13.695313 9.15625 13.65625 C 9.089844 13.640625 9.03125 13.632813 9 13.625 C 8.867188 13.585938 8.730469 13.578125 8.59375 13.59375 Z M 11.4375 14.6875 C 10.984375 14.769531 10.648438 15.148438 10.617188 15.605469 C 10.585938 16.066406 10.875 16.484375 11.3125 16.625 L 15.65625 18.0625 C 16.183594 18.234375 16.75 17.949219 16.921875 17.421875 C 17.09375 16.894531 16.808594 16.328125 16.28125 16.15625 L 11.9375 14.75 C 11.777344 14.6875 11.605469 14.664063 11.4375 14.6875 Z" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filter', 'today')">Today</a></li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filter', 'month')">This Month</a></li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filter', 'year')">This Year</a></li>
                        </ul>
                    </div>
                    <div class="activity_body">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activity <span>| Today</span></h5>
                            <div class="activity">
                                @foreach ($admin_activity as $activity)
                                @php
                                $hoursAgo = $activity->created_at->diffInHours(now());
                                $badgeColor = 'text-success'; // Default color

                                if ($hoursAgo >= 1 && $hoursAgo < 2) { $badgeColor='text-success' ; } elseif ($hoursAgo>= 2 && $hoursAgo < 3) { $badgeColor='text-primary' ; } elseif ($hoursAgo>=3 && $hoursAgo < 5) { $badgeColor='text-danger' ; } elseif ($hoursAgo>= 6 ) {
                                            $badgeColor = 'text-secondary';
                                            }
                                            @endphp

                                            <div class="activity-item d-flex">
                                                <div class="activite-label">{{ $activity->created_at->diffForHumans() }}</div>
                                                <i class='bi bi-circle-fill activity-badge {{ $badgeColor }} align-self-start'></i>
                                                <div class="activity-content">{{ $activity->activity }} <a href="#" class="fw-bold text-dark">{{ $activity->description }}</a></div>
                                            </div>
                                            @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-12 card mx-2">
                <p class="text-center">Order Reports</p>
                <canvas id="orderChart"></canvas>
            </div>
            <div class="col-lg-4 card">
                <p class="text-center">Users City Report</p>
                <canvas id="doughnutChart"></canvas>
            </div>

            <div class="col-lg-7 card mx-2">
                <p class="text-center">Stock Reports</p>
                <canvas id="productStockChart"></canvas>
            </div>
            <div class="col-lg-4 card">
                {{-- <div class="card"> --}}
                <p class="text-center">Order Status Reports</p>
                <canvas id="orderStatusChart"></canvas>
                {{-- </div> --}}
            </div>
            <div class="col-lg-7 card mx-2">
                <p class="text-center">Sales Reports</p>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="col-lg-4 card">
                <p class="text-center">Product in Warehouse Reports</p>
                <canvas id="productStockCharts"></canvas>
            </div>
            <div class="col-md-11 card mx-2">
                <p class="text-center">Customer Reports</p>
                <canvas id="customersChart"></canvas>
            </div>
            <div class="col-md-11 card mx-2">
                <p class="text-center">Top Selling Product Reports</p>
                <canvas id="topSellingProductsChart"></canvas>
            </div>
        </div>
    </section>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('topSellingProductsChart').getContext('2d');
        var topSellingProductsChart = new Chart(ctx, {
            type: 'bar'
            , data: {
                labels: @json($topSellingProductsData['labels'])
                , datasets: [{
                    label: 'Top-Selling Products'
                    , data: @json($topSellingProductsData['data'])
                    , backgroundColor: @json($topSellingProductsData['backgroundColor'])
                    , borderColor: @json($topSellingProductsData['borderColor'])
                    , borderWidth: 1
                }]
            }
            , options: {
                responsive: true
                , scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        Livewire.on('refreshChart', data => {
            topSellingProductsChart.data.labels = data.labels;
            topSellingProductsChart.data.datasets[0].data = data.data;
            topSellingProductsChart.update();
        });

        var customersCtx = document.getElementById('customersChart').getContext('2d');
        var customersChart = new Chart(customersCtx, {
            type: 'line'
            , data: {
                labels: @json($customerData['labels'])
                , datasets: [{
                    label: 'New Customers'
                    , data: @json($customerData['data'])
                    , backgroundColor: 'rgba(255, 159, 64, 0.2)'
                    , borderColor: 'rgba(255, 159, 64, 1)'
                    , borderWidth: 1
                    , fill: false
                }]
            }
            , options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var salesCtx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(salesCtx, {
            type: 'line'
            , data: {
                labels: @json($salesData['labels'])
                , datasets: [{
                    label: 'Sales'
                    , data: @json($salesData['data'])
                    , backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    , borderColor: 'rgba(75, 192, 192, 1)'
                    , borderWidth: 1
                    , fill: false
                }]
            }
            , options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var ctx = document.getElementById('orderStatusChart').getContext('2d');
        var orderStatusChart = new Chart(ctx, {
            type: 'doughnut'
            , data: {
                labels: @json($orderStatusData['labels'])
                , datasets: [{
                    label: 'Order Status'
                    , data: @json($orderStatusData['data'])
                    , backgroundColor: @json($orderStatusData['colors'])
                    , borderColor: '#ffffff', // Optionally add border color
                    borderWidth: 1
                }]
            }
            , options: {
                responsive: true
                , plugins: {
                    legend: {
                        position: 'top'
                    , }
                    , tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        var ctx = document.getElementById('productStockChart').getContext('2d');
        var productStockChart = new Chart(ctx, {
            type: 'bar'
            , data: {
                labels: @json($productsData['labels'])
                , datasets: [{
                    label: 'Stock'
                    , data: @json($productsData['data'])
                    , backgroundColor: 'rgba(54, 162, 235, 0.2)'
                    , borderColor: 'rgba(54, 162, 235, 1)'
                    , borderWidth: 1
                }]
            }
            , options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var ctx = document.getElementById('orderChart').getContext('2d');
        var orderChart = new Chart(ctx, {
            type: 'line', // Change from 'bar' to 'line'
            data: {
                labels: @json($ordersData['labels'])
                , datasets: [{
                    label: 'Orders'
                    , data: @json($ordersData['data'])
                    , backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    , borderColor: 'rgba(75, 192, 192, 1)'
                    , borderWidth: 1
                    , fill: false // Ensure the area under the line is not filled
                }]
            }
            , options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut'
            , data: {
                labels: @json($usersData['labels'])
                , datasets: [{
                    label: 'User Distribution by City'
                    , data: @json($usersData['data'])
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(75, 192, 192, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(75, 192, 192, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }]
            }
            , options: {
                responsive: true
            }
        });

        var ctx = document.getElementById('productStockCharts').getContext('2d');
        var productStockChart = new Chart(ctx, {
            type: 'doughnut'
            , data: {
                labels: @json($productStockData['labels'])
                , datasets: [{
                    label: 'Stock'
                    , data: @json($productStockData['data'])
                    , backgroundColor: @json($productStockData['colors'])
                    , borderColor: '#ffffff'
                    , borderWidth: 1
                }]
            }
            , options: {
                responsive: true
                , plugins: {
                    legend: {
                        position: 'top'
                    , }
                    , tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

    </script>
    @endpush
</div>

