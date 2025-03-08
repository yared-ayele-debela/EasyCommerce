<div wire:ignore.self class="modal fade" id="ProductModal" tabindex="-1" aria-labelledby="ProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProductModalLabel">Add New Product</h5>
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                <option value="offer">Offer Price</option>
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
                        <label for="product_discount" class="form-label">Product Discount (%)</label>
                        <input type="number" class="form-control" wire:model="product_discount">
                        @error('product_discount')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3 pt-2">
                        <label for="product_tax" class="form-label">Product Tax</label>
                        <input type="number" min="0" class="form-control" wire:model="product_tax">
                        @error('product_tax')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3 pt-2">
                        <label for="product_weight" class="form-label">Product Weight (mg)</label>
                        <input type="number" min="0" class="form-control" wire:model="product_weight">
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
                    <div class="col-md-4 pt-2">
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
                    <div class="form-group col-12 pt-2 text-right">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div wire:ignore.self id="deleteProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg rounded">
            <form wire:submit.prevent="destroyProduct">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Are you sure you want to delete this product?</h5>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes! Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
