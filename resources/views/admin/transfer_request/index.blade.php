@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">Transfer Requests</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card border-0 shadow-sm">
            <div class="card-body">
               <h5 class="card-title">Transfer Requests</h5>
               <table class="table datatable" class="table datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>From Warehouse</th>
                        <th>To Warehouse</th>
                        <th>Note</th>
                        <th>Transfer Date</th>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($transfer_request as $stock)

                     <tr>
                        <td>{{ $stock->id }}</td>

                        <td>
                            {{ $stock->product->product_name }}
                        </td>
                        <td>{{ $stock->quantity }}</td>
                        <td>
                            {{ $stock->fromWarehouse->name }}
                        </td>
                        <td>
                            {{ $stock->toWarehouse->name }}
                        </td>
                        <td>{{ $stock->notes }}</td>

                         <td>{{ $stock->transfer_date }}</td>

                        <td>
                            @if ($user && $user->hasPermissionByRole('edit transaction'))
                            <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Approve this transfer
                            </a>
                            @endif
                            @if ($user && $user->hasPermissionByRole('edit transaction'))
                            <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reject">
                                Reject this transfer
                            </a>
                            @endif
                         {{-- <a href="{{ url('admin/delete-transfer-request/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this transfer request ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a> --}}
                        </td>
                     </tr>
                     <div class="modal fade" id="reject" tabindex="-1" aria-labelledby="rejectLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                            <h5 class="modal-title" id="rejectLabel">Warning ⚠️</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body border-0">
                                <p>Can you reject this transfer request ?</p>
                            </div>
                            <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="{{ url('admin/delete-transfer-request/'.$stock->id) }}" class="btn btn-primary">Yes</a>
                            </div>
                        </div>
                        </div>
                    </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                <h5 class="modal-title d-flex" id="exampleModalLabel">
                                    <p>
                                        Confirmation
                                    </p>&nbsp;
                                    <svg id='App_Window_Password_Correct_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.83 0 0 0.83 12 12)" >
                                        <g style="" >
                                        <g transform="matrix(1 0 0 1 -0.74 -1.5)" >
                                        <path style="stroke: rgb(0,0,0); stroke-width: 1.5; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.26, -10.5)" d="M 21.76 9.754 L 21.76 2.2539999999999996 C 21.76 1.4255728752538093 21.088427124746193 0.7539999999999996 20.26 0.7539999999999996 L 2.2600000000000016 0.7539999999999996 C 1.4315728752538113 0.7539999999999996 0.7600000000000016 1.4255728752538093 0.7600000000000016 2.2539999999999996 L 0.7600000000000016 18.753999999999998 C 0.7600000000000016 19.58242712474619 1.4315728752538113 20.253999999999998 2.2600000000000016 20.253999999999998 L 8.260000000000002 20.253999999999998" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 -0.74 -6.75)" >
                                        <path style="stroke: rgb(0,0,0); stroke-width: 1.5; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.26, -5.25)" d="M 0.76 5.254 L 21.76 5.254" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 5.26 5.25)" >
                                        <path style="stroke: rgb(0,0,0); stroke-width: 1.5; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-17.26, -17.25)" d="M 11.26 17.254 C 11.26 20.567708498984764 13.946291501015239 23.254000000000005 17.26 23.254000000000005 C 20.573708498984765 23.254000000000005 23.260000000000005 20.567708498984764 23.260000000000005 17.254 C 23.26 13.94029150101524 20.57370849898476 11.254 17.26 11.254 C 13.946291501015239 11.254 11.259999999999998 13.940291501015238 11.259999999999998 17.254 Z" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 5.17 5.6)" >
                                        <path style="stroke: rgb(0,0,0); stroke-width: 1.5; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-17.17, -17.6)" d="M 19.934 15.509 L 17.029 19.383 C 16.89830255807627 19.556824012998618 16.698671046361802 19.66545584517065 16.481735229263922 19.680800553718687 C 16.264799412166038 19.696145262266725 16.051864188686896 19.61669586936568 15.898 19.462999999999997 L 14.398 17.962999999999997" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 -4.49 0.38)" >
                                        <path style="stroke: rgb(0,0,0); stroke-width: 1.5; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-7.51, -12.38)" d="M 10.51 10.504 L 4.51 10.504 L 4.51 14.254 L 8.26 14.254" stroke-linecap="round" />
                                        </g>
                                        </g>
                                        </g>
                                        </svg>
                                     </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body border-0">
                                    <p>Can you aprove this transfer request ?</p>
                                </div>
                                <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ url('admin/approve-transfer-request/'.$stock->id) }}" class="btn btn-primary">Yes</a>
                                </div>
                            </div>
                            </div>
                        </div>

                     @endforeach

                  </tbody>
               </table>

            </div>
         </div>
      </div>
   </div>
 </section>
 <!-- Button trigger modal -->

@endsection
