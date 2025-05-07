@if(count($product_ids) > 0)
<table class="table table-bordered aiz-table">
  <thead>
  	<tr>
  		<td width="50%">
          <span>Product</span>
  		</td>
      <td data-breakpoints="lg" width="20%">
          <span>Base Price</span>
  		</td>
  		<td data-breakpoints="lg" width="20%">
          <span>Discount</span>
  		</td>
  	</tr>
  </thead>
  <tbody>
      @foreach ($product_ids as $key => $id)
      	@php
      		$product = \App\Models\Product::findOrFail($id);
      	@endphp
          <tr>
            <td>
              <div class="from-group row">
                <div class="col-auto">
                  <img class="size-60px img-fit" height="30px;" width="30px;" src="{{ $product->product_image}}">
                </div>
                <div class="col">
                  <span>{{  $product->product_name  }}</span>
                </div>
              </div>
            </td>
            <td>
                <span>{{ $product->product_price }}</span>
            </td>
            <td>
                <input type="text" lang="en" name="discount_{{ $id }}" value="{{ $product->product_discount }}" min="0" step="1" class="form-control" required>
            </td>

          </tr>
      @endforeach
  </tbody>
</table>
@endif
