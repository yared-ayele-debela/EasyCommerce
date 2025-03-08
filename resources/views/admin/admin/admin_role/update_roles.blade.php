@extends('admindashboard.maindashboard')
@section('dashboard')
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="avascript:void(0);">Admins</a></li>
                <li class="breadcrumb-item">Update  Admins_and_Subadmins Roles</li>
            </ol>
        </nav>
    </div>
    <section class="section col-md-8" >
        <div class="card" >
            <div class="card-body pt-3">
                <form  action="{{ url('admin/update-role/'.$adminDetails['id']) }}" method="POST" >
                    @csrf
                    @if(!empty($adminRoles))
                        @foreach($adminRoles as $role)
                            @if($role['module']=="categories")
                              @if($role['view_access']==1)
                                  @php $viewCategories="checked"; @endphp
                              @else
                                  @php $viewCategories=""; @endphp
                              @endif
                              @if($role['edit_access']==1)
                                  @php $editCategories="checked"; @endphp
                              @else
                                  @php $editCategories=""; @endphp
                              @endif
                              @if($role['full_access']==1)
                                  @php $fullCategories="checked"; @endphp
                              @else
                                  @php $fullCategories=""; @endphp
                              @endif
                            @endif
                        @endforeach
                    @endif
                    <div class="col-md-12 pt-3">
                        <label for="categories" class="form-label">Categories</label>
                       <div class="col-md-12 d-flex">
                           <input class="form-checkbox" type="checkbox" name="categories[view]" value="1" @if(isset($viewCategories)) {{ $viewCategories }} @endif>&nbsp;View Access&nbsp;&nbsp;
                           <input class="form-checkbox" type="checkbox" name="categories[edit]" value="1" @if(isset($editCategories)) {{ $editCategories }} @endif>&nbsp;View/Edit Access&nbsp;&nbsp;
                           <input class="form-checkbox" type="checkbox" name="categories[full]" value="1" @if(isset($fullCategories)) {{ $fullCategories }} @endif>&nbsp;Full Access&nbsp;&nbsp;
                       </div>
                    </div>
                    @if(!empty($adminRoles))
                        @foreach($adminRoles as $role)
                            @if($role['module']=="products")
                                @if($role['view_access']==1)
                                    @php $viewProducts="checked"; @endphp
                                @else
                                    @php $viewProducts=""; @endphp
                                @endif
                                @if($role['edit_access']==1)
                                    @php $editProducts="checked"; @endphp
                                @else
                                    @php $editProducts=""; @endphp
                                @endif
                                @if($role['full_access']==1)
                                    @php $fullProducts="checked"; @endphp
                                @else
                                    @php $fullProducts=""; @endphp
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <div class="col-md-12 pt-3">
                        <label for="products" class="form-label">Products</label>
                        <div class="col-md-12 d-flex">
                            <input class="form-checkbox" type="checkbox" name="products[view]" value="1" @if(isset($viewProducts)) {{ $viewProducts }} @endif>&nbsp;View Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="products[edit]" value="1" @if(isset($editProducts)) {{ $editProducts  }} @endif>&nbsp;View/Edit Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="products[full]" value="1" @if(isset($fullProducts)) {{ $fullProducts  }} @endif >&nbsp;Full Access&nbsp;&nbsp;
                        </div>
                    </div>

                    @if(!empty($adminRoles))
                        @foreach($adminRoles as $role)
                            @if($role['module']=="coupons")
                                @if($role['view_access']==1)
                                    @php $viewCoupons="checked"; @endphp
                                @else
                                    @php $viewCoupons=""; @endphp
                                @endif
                                @if($role['edit_access']==1)
                                    @php $editCoupons="checked"; @endphp
                                @else
                                    @php $editCoupons=""; @endphp
                                @endif
                                @if($role['full_access']==1)
                                    @php $fullCoupons="checked"; @endphp
                                @else
                                    @php $fullCoupons=""; @endphp
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <div class="col-md-12 pt-3">
                        <label for="coupon" class="form-label">Coupon</label>
                        <div class="col-md-12 d-flex">
                            <input class="form-checkbox" type="checkbox" name="coupons[view]" value="1"  @if(isset($viewCoupons)) {{ $viewCoupons }} @endif>&nbsp;View Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="coupons[edit]" value="1"  @if(isset($editCoupons)) {{ $editCoupons }} @endif >&nbsp;View/Edit Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="coupons[full]" value="1"  @if(isset($fullCoupons)) {{ $fullCoupons }} @endif >&nbsp;Full Access&nbsp;&nbsp;
                        </div>
                    </div>
                    @if(!empty($adminRoles))
                        @foreach($adminRoles as $role)
                            @if($role['module']=="orders")
                                @if($role['view_access']==1)
                                    @php $viewOrders="checked"; @endphp
                                @else
                                    @php $viewOrders=""; @endphp
                                @endif
                                @if($role['edit_access']==1)
                                    @php $editOrders="checked"; @endphp
                                @else
                                    @php $editOrders=""; @endphp
                                @endif
                                @if($role['full_access']==1)
                                    @php $fullOrders="checked"; @endphp
                                @else
                                    @php $fullOrders=""; @endphp
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <div class="col-md-12 pt-3">
                        <label for="order" class="form-label">Orders</label>
                        <div class="col-md-12 d-flex">
                            <input class="form-checkbox" type="checkbox" name="orders[view]" value="1" @if(isset($viewOrders)) {{ $viewOrders }} @endif >&nbsp;View Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="orders[edit]" value="1" @if(isset($editOrders)) {{ $editOrders }} @endif >&nbsp;View/Edit Access&nbsp;&nbsp;
                            <input class="form-checkbox" type="checkbox" name="orders[full]" value="1" @if(isset($fullOrders)) {{ $fullOrders }} @endif >&nbsp;Full Access&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="form-group pt-3   ">
                        <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
