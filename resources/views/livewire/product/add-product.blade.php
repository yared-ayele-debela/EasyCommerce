<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Add Product</li>
            </ol>
        </nav>
    </div>
    <section class="section ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="">Add Product</a>
                </div>
                <div class="card-body pt-1">
                    <form class="row g-3" wire:submit.prevent='store_product' enctype="multipart/form-data">
                        <div class="col-md-3 pt-2">
                            <label for="category" class="form-label">Category:</label>
                             <select wire:model="category" id="category" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $section)
                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                @foreach ($section['categories'] as $category)
                                <option value="{{ $category['id'] }}">&nbsp;&nbsp;->&nbsp;{{ $category['name'] }}</option>
                                @foreach ($category['subcategories'] as $subcategory)
                                <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;--->&nbsp;{{ $subcategory['name'] }}</option>
                                @endforeach
                                @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 pt-2">
                            <label for="brand_id" class="form-label">Select Brand</label>
                            <select wire:model="brand_id" class="form-control">
                                <option value="">--Select--</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <div class="col-md-3 pt-2">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" wire:model="product_name" required>
                            @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3 pt-2">
                            <label for="product_code" class="form-label">Product Code</label>
                            <input type="text" class="form-control" wire:model="product_code" required>
                            @error('product_code')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <div class="form-group">
                                <label for="price_type" class="pb-2">Price Type</label>
                                <select wire:model="priceType" class="form-control" id="price_type">
                                    <option value="regular">Regular Price</option>
                                    {{-- <option value="offer">Offer Price</option> --}}
                                </select>
                                @error('priceType')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 pt-2"  id="price_part" style="display: none;">
                            <label for="product_price" class="form-label">Product Price</label>
                            <input type="number" min="0" class="form-control" wire:model="product_price" >
                            @error('product_price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <label for="quantity" class="form-label">Product Quantity</label>
                            <input type="number" min="0" class="form-control" wire:model="quantity" >
                            @error('quantity')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3 pt-2">
                            <label for="product_discount" class="form-label">Product Discount (%)</label>
                            <input type="number"  min="0" step="0.01" class="form-control" wire:model="product_discount">
                            @error('product_discount')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <div class="form-group">
                              <label for="product_tax">Product Tax</label>
                              <select class="form-control" wire:model="product_tax" id="product_tax">
                                @foreach ($taxs as $tax)
                                <option value="{{ $tax->percentage }}">{{ $tax->taxname }} ({{ $tax->percentage }}%)</option>
                                @endforeach
                              </select>
                            </div>
                            @error('product_tax')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <label for="product_weight" class="form-label">Product Weight (mg)</label>
                            <input type="number"  min="0" class="form-control" wire:model="product_weight">
                            @error('product_weight')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <label for="product_color" class="form-label">Product Color</label>
                            <select class="form-control" wire:model="product_color" required>
                                <option value="" selected disabled>Select color</option>
                                @foreach ($color as $color)
                                <option value="{{ $color->name }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                            @error('product_color')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-2">
                            <label for="available_for_delivery" class="form-label">Available for Delivery</label>
                            <select wire:model="available_for_delivery" id="available_for_delivery" wire:model='available_for_delivery' class="form-control" required>
                                <option value="">-- Select Option --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('available_for_delivery') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-3 pt-2">
                            <label for="is_returnable" class="form-label">Is Returnable</label>
                            <select wire:model="is_returnable" id="is_returnable" wire:model='is_returnable' class="form-control" required>
                                <option value="">-- Select Option --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_returnable') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-3 pt-2" id="returnable_time_part" style="display: none;">
                            <label for="returnable_time" class="form-label">Returnable Time (days)</label>
                            <input type="number" min="0" wire:model='returnable_time' class="form-control" wire:model="returnable_time">
                            @error('returnable_time')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 pt-2">
                            <span class="text-danger">(Recommend Size : 500px x 500px)</span>
                            <div class="file-uploader" id="image-uploader">
                                <div class="file-drop-area" id="image-drop-area">
                                    <p>Attach your images<br>or<br><button id="browseImagesButton" class="btn btn-sm btn-secondary shadow-none">Browse image</button></p>
                                    <input type="file" id="imageInput"  wire:model="product_image"  accept="image/*" >
                                </div>
                                @error('product_image')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-4 pt-2">
                            <div class="file-uploader" id="video-uploader">
                                <div class="file-drop-area" id="video-drop-area">
                                    <p>Attach your videos here<br>or<br><button id="browseVideosButton" class="btn btn-sm btn-secondary shadow-none">Browse video</button></p>
                                    <input type="file" id="videoInput" wire:model="product_video" accept="video/*">
                                </div>
                                @error('product_video')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-12 pt-2">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea class="form-control" wire:model="description" id="summernote" rows="8" required></textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="displayfilters row">
                            @include('admin.filters.category_filters')
                        </div> --}}
                        <div class="form-group col-12 pt-2 text-right">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isReturnableSelect = document.getElementById('is_returnable');
            const returnableTimePart = document.getElementById('returnable_time_part');
            isReturnableSelect.addEventListener('change', function () {
                if (this.value == '1') {
                    returnableTimePart.style.display = 'block';
                }else {
                    returnableTimePart.style.display = 'none';
                }
            });

            $("#category").on('change',function(){
          var category_id=$(this).val();
          // alert(category_id);
          $.ajax({

            type:'post',
            url:'<?php echo url('/admin/category-filters') ?>',
            data:{category_id:category_id ,_token: '{{csrf_token()}}'},
            success:function(resp){
              $(".displayfilters").html(resp.view);
            }
          })
        });

        });
    </script>
</div>

