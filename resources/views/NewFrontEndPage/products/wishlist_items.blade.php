<?php use App\Models\Product; ?>

<h1>Wishlists <span class="totalWishlistItems">{{  App\Helper\Helper::totalWishlistItems() }}items</span></h1>
<div class="table-wrapper u-s-m-b-60">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Descriptinon</th>
                <th>View/Delete</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody  id="movecart">
            @php $total_price=0 @endphp
            @foreach($userWishlistItems as $item)
            <tr>
                <td>
                    <div class="cart-anchor-image">
                        <a href="{{ url('product/'.$item['product_id']) }}">
                            <img class="lazy" alt="" src="{{ asset('/storage/products/'.$item['product']['product_image']) }}" style="">
                        </a>
                    </div>
                </td>
                <td>
                    <div class="cart ">
                        <span class="cart__page pt-3">Product</span>
                        <a href="javascript:void(0);">{{ $item['product']['product_name'] }}</a>
                        <p class="small text-muted text-left">
                        Product Code: &nbsp;{{ $item['product']['product_code'] }}<br>
                        Product Color: &nbsp;{{ $item['product']['product_color'] }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="action-wrapper">
                        <a href="{{url('product/'.$item['product']['id'])}}" class="button button-outline-secondary fas fa-edit     btnEdit"></a>
                        <button  class="button button-outline-secondary fas fa-trash wishlistItemDelete" data-wishlistid="{{ $item['id'] }}"></button>
                    </div>
                </td>
                <td class="header_product-price">
                    <span class="old_price"  id="mrp_536">
                        @php $product_price=$item['product']['product_price'] @endphp
                        {{  App\Helper\Helper::currency_converter($product_price) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
