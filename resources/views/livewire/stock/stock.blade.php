<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-white shadow-sm">
       <nav>
          <ol class="breadcrumb p-3">
             <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
             <li class="breadcrumb-item active">All stocks</li>
          </ol>
       </nav>
     </div>
     <section class="section">
       <div class="row">
          <div class="col-lg-12">
             <div class="card border-0 shadow-sm">
                <div class="card-body mt-2">
                   <a class="btn btn-primary mt-2 mb-2">Lists of Produt in Stoks</a>
                   <table id="example" class="table ml-4 mr-4 mt-2">
                    <thead>
                         <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Sku</th>
                            <th>Warehouse</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <td>Status</td>
                            <td>Action</td>
                         </tr>
                      </thead>
                      <tbody>
                        @foreach ($all_stock as $k => $stock)

                         <tr>
                            <td>{{ $stock->id }}</td>
                            <td>
                                @if(empty($stock->product->product_name))

                                @else
                                {{ $stock->product->product_name }}
                                @endif
                            </td>
                            <td>{{ $stock->sku }}</td>
                            <td>
                                @if(empty($stock->warehouse->name))

                                @else
                                {{ $stock->warehouse->name }}
                                @endif
                            </td>
                            <td>{{ $stock->size }}</td>
                            <td>{{ $stock->price }}</td>
                            <td>{{ $stock->stock }}</td>

                            <td>
                                @if ($user && $user->hasPermissionByRole('edit stock'))
                            {{-- @if ($user && $user->hasPermissionByRole('edit_subscription')) --}}
                            <button wire:click="update_status({{ $stock['id'] }})" class="btn btn-sm {{ $stock['status'] ? 'btn-success' : 'btn-danger' }}">
                                {{ $stock['status']=="1" ? 'In' : 'Out' }}
                            </button>
                            {{-- @endif --}}
                                @endif
                            <td>

                            @if ($user && $user->hasPermissionByRole('delete stock'))
                             <a href="{{ url('admin/products/delete_attribute/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this stock product ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                            @endif
                            </td>
                         </tr>
                         @endforeach

                      </tbody>
                   </table>
                   <div class=" pagination-sm">
                    {{-- {{ $all_stock->links() }} --}}

                   </div>

                </div>
             </div>
          </div>
       </div>
     </section>

</div>
