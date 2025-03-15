@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">Transactions</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card border-0 shadow-sm">
            <div class="card-body">
               <h5 class="card-title">Transactions</h5>
               <table class="table datatable" class="table datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <td>Order ID</td>
                        <td>Customer</td>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($transactions as $transaction)
                     <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>
                            {{ $transaction->order_id }}
                        </td>
                        <td>
                            {{ $transaction->user->name }}
                        </td>
                        <td>
                            {{ $transaction->payer_email }}
                        </td>
                        <td>
                            @if($transaction->amount=="")
                            {{ $transaction->amount }} 0&nbsp;Birr
                            @else
                            {{ $transaction->amount }} &nbsp;Birr

                            @endif
                        </td>
                        <td>
                            @if($transaction['payment_status'])
                           <a class=" text-white btn-primary  btn-sm ">
                              {{$transaction['payment_status']}}
                            </a>
                           @endif
                        </td>

                         <td>
                            @if ($user && $user->hasPermissionByRole('view detail transaction'))

                            <a href="{{ url('admin/transaction/'.$transaction->id) }}" style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm" ><i class=" ri-eye-fill"></i></a>
                            @endif
                            @if ($user && $user->hasPermissionByRole('delete transaction'))
                            <a href="{{ url('admin/transaction/delete/'.$transaction->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this transactions? ') " class="btn btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                            @endif
                        </td>

                     </tr>
                     @endforeach
                  </tbody>
               </table>
               {{-- <div class=" pagination-sm">
                  {{ $transaction->links() }}
               </div> --}}

            </div>
         </div>
      </div>
   </div>
 </section>
@endsection
