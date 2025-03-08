<div>
    @php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">all admins</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header ">
                @if ($user && $user->hasPermissionByRole('create_admin'))
                    <a class="btn btn-primary" href="">All Admins</a>
                @endif
            </div>
            <div class="card-body mt-3">
               <table id="example"  class="table m-3">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($admins as $k => $all)
                     <tr>
                        <td>{{ $all['id'] }}</td>
                        <td>{{ $all['name']}}</td>
                        <td>
                            @if($all['type'])
                            <a href='' class="btn btn-primary btn-sm">{{ $all['type'] }}</a></a>
                            @endif
                        </td>
                        <td>{{ $all['mobile']}}</td>
                        <td>{{ $all['email']}}</td>
                        <td>
                           @if(!empty($all['image']))
                           <img src="{{ asset('storage/admin/image/'.$all['image']) }}" style=" box-shadow:1px 1px 3px gray; border-radius:2rem;width: 40px; height:40px;" class="" alt="">
                           @else
                           <img  src="{{ asset('/storage/products/noimagefile.png') }}" style="box-shadow:1px 1px 3px gray;  border-radius:2rem; width: 40px; height:40px;" class="" alt="">
                           @endif
                        </td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_admin'))
                            <button wire:click="toggleStatus({{ $all['id'] }})" class="btn btn-sm {{ $all['status'] ? 'btn-success' : 'btn-danger' }}">
                                {{ $all['status'] ? 'Active' : 'Inactive' }}
                            </button>
                            @endif
                        </td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('view_admin'))
                            <a href="{{ url('admin/edit_admin/'.$all['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                            @endif
                            <i class="cont">
                            @if ($user && $user->hasPermissionByRole('view_admin'))
                            <a id="popoverButton"  href="{{ url('admin/activity/'.$all['id']) }}" style="background-color:rgb(239, 239, 239)" class="btn btn-sm" >
                            <svg id='Activity_History_16' width='16' height='16' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                                <g transform="matrix(0.26 0 0 0.26 8 8)" >
                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-26, -24.5)" d="M 5.984375 3 C 5.715944908807362 3.0041616022218895 5.460458877148426 3.1160687120609554 5.2753906 3.3105469000000003 L 3.2753906 5.4160156 C 3.098532336306122 5.601986117530402 2.9999349698916893 5.8488292188781 3 6.1054688 L 3 38 C 2.9953026 39.996687 3.4701588 41.831964 4.4785156 43.265625 C 4.5362354 43.353817 4.5896725 43.446245 4.6503906 43.53125 C 5.6950455 44.993767 7.24098 46 9 46 C 9.1457065 46 9.2870689 45.982246 9.4296875 45.96875 C 9.6167499 45.982507 9.8030009 45.999368 9.9960938 46 C 9.997395865425197 46.00000254281455 9.998697934574803 46.00000254281455 10 46 L 43 46 C 43.05035386985833 45.99988525254492 43.10062716967078 45.99596777875658 43.150391 45.988281 C 44.846022 45.93196 46.335214 44.949591 47.349609 43.529297 C 48.394304 42.06658 49 40.124787 49 38 C 49 35.875213 48.394304 33.93342 47.349609 32.470703 C 46.33991 31.056983 44.859683 30.076386 43.173828 30.011719 C 43.172521 30.011669 43.171229 30.011768 43.169922 30.011719 C 43.11371763257942 30.002987802146635 43.05687086001283 29.99906725432053 43 30 L 39 30 L 39 4 C 38.99984125264519 3.595632208590733 38.756191934876114 3.2311488546901197 38.3826013606948 3.076412243596292 C 38.00901078651348 2.9216756325024646 37.57899982697983 3.0071372028187886 37.292969 3.292968800000001 L 34.005859 6.5859375 L 30.707031 3.2929688 C 30.31650119155472 2.902600737853089 29.68349880844528 2.9026007378530885 29.292969 3.2929688 L 26 6.5859375 L 22.707031 3.2929688 C 22.31650119155472 2.902600737853089 21.68349880844528 2.9026007378530885 21.292969 3.2929688 L 18 6.5859375 L 14.707031 3.2929688 C 14.316501191554721 2.902600737853089 13.683498808445279 2.9026007378530885 13.292969 3.2929688 L 10 6.5859375 L 6.7070312 3.2929688 C 6.515707894846558 3.101556981555518 6.254977873696566 2.995855596276754 5.984375 3 z M 14 5.4140625 L 17.292969 8.7070312 C 17.68349880844528 9.097399262146912 18.31650119155472 9.097399262146912 18.707031 8.7070312 L 22 5.4140625 L 25.292969 8.7070312 C 25.68349880844528 9.097399262146912 26.31650119155472 9.097399262146912 26.707031 8.7070312 L 30 5.4140625 L 33.300781 8.7070312 C 33.69131092298864 9.097399928537932 34.32431407701136 9.097399928537932 34.714844 8.7070312 L 37 6.4179688 L 37 30 L 9 30 C 7.4265671 30 6.026184 30.808777 5 32.025391 L 5 6.5039062 L 6.0175781 5.4316406 L 9.2929688 8.7070312 C 9.683498631353997 9.09739939542504 10.316501168646004 9.09739939542504 10.707031 8.7070312 L 14 5.4140625 z M 9 12 L 9 14 L 23 14 L 23 12 L 9 12 z M 26 12 L 26 14 L 33 14 L 33 12 L 26 12 z M 9 16 L 9 18 L 16 18 L 16 16 L 9 16 z M 19 16 L 19 18 L 33 18 L 33 16 L 19 16 z M 9 20 L 9 22 L 14 22 L 14 20 L 9 20 z M 17 20 L 17 22 L 24 22 L 24 20 L 17 20 z M 27 20 L 27 22 L 33 22 L 33 20 L 27 20 z M 9 24 L 9 26 L 20 26 L 20 24 L 9 24 z M 23 24 L 23 26 L 33 26 L 33 24 L 23 24 z M 9 32 C 10.002404 32 10.957667 32.559874 11.722656 33.630859 C 12.487645 34.701844 13 36.260018 13 38 C 13 39.739982 12.487645 41.298156 11.722656 42.369141 C 11.059441 43.297643 10.252459 43.840347 9.3964844 43.96875 C 7.9940773 43.836945 7.0101734 43.259608 6.2871094 42.359375 C 6.2570884 42.321998 6.2321962 42.278906 6.203125 42.240234 C 5.4838588 41.174802 5.0003789 39.678441 5 38.001953 C 5.000000635638088 38.00130200015516 5.000000635638088 38.000650999844844 5 38 C 5 36.260018 5.5123545 34.701844 6.2773438 33.630859 C 7.042333 32.559874 7.9975962 32 9 32 z M 12.980469 32 L 38 32 L 43 32 C 44.001135 32 44.955398 32.561279 45.720703 33.632812 C 46.486008 34.704346 47 36.261787 47 38 C 47 39.738213 46.486008 41.295654 45.720703 42.367188 C 44.955398 43.438721 44.001135 44 43 44 L 12.980469 44 C 13.109001 43.849048 13.233139 43.694308 13.349609 43.53125 C 14.394264 42.068733 15 40.126011 15 38 C 15 35.873989 14.394264 33.931267 13.349609 32.46875 C 13.233139 32.305692 13.109001 32.150952 12.980469 32 z M 9 35 C 7.8954305003384135 35 7 36.34314575050762 7 38 C 7 39.65685424949238 7.8954305003384135 41 9 41 C 10.104569499661586 41 11 39.65685424949238 11 38 C 11 36.34314575050762 10.104569499661586 35 9 35 z" stroke-linecap="round" />
                                </g>
                            </svg>
                            </a>
                            <div id="popover" class="popover">
                                <div class="popover-content">
                                    <p>view admin activities</p>
                                </div>
                            </div>
                            </i>
                            @endif
                            @if ($user && $user->hasPermissionByRole('delete_admin'))
                            <a href="{{ url('admin/admin-subadmin/'.$all['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Admin or SubAdmin ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                            @endif
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{-- {{ $categories->links() }} --}}
               </div>

            </div>
         </div>
      </div>
   </div>
 </section>
</div>
