

<br>
<h4 class="section-h4 deliveryText deliveryText">Add New Delivery Address</h4>
<div class="u-s-m-b-24">
    <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
    <label class="label-text " for="ship-to-different-address">Add address?</label>
</div>
<div class="collapse" id="showdifferent">
    <!-- Form-Fields -->
    <h4 class="section-h4 newAddress">Add New Delivery Address</h4>
    <!-- Form-Fields -->
    <form action="{{ url('save-delivery-address') }}"  method="post">
        @csrf
    <input type="hidden" name="delivery_id">
    <div class="group-inline u-s-m-b-13">
        <div class="group-1 u-s-p-r-16">
            <label for="first-name">First Name
                <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_name" name="delivery_name" class="text-field" required>
            @error('delivery_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="group-2">
            <label for="delivery_address">Delivery address
                <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_address" name="delivery_address" class="text-field" required>
            @error('delivery_address')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="u-s-m-b-13">
        <label for="select-country">Country
            <span class="astk">*</span>
        </label>
        <div class="select-box-wrapper">
            <select class="select-box" id="delivery_country" name="delivery_country" required>
                @foreach ($countries as $country)
                <option value="{{ $country['country_name'] }}" @if($country['country_name']==Auth::user()->country) selected @endif>{{ $country['country_name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="u-s-m-b-13">
        <label for="delivery_city">City
            <span class="astk">*</span>
        </label>
        <div class="select-box-wrapper">
            <select class="select-box" id="delivery_city" name="delivery_city" required>
                @foreach ($city as $city)
                <option value="{{ $city->name }}" @if( $city->name==Auth::user()->city) selected @endif>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="u-s-m-b-13">
        <label for="delivery_state">State
            <span class="astk">*</span>
        </label>
        <div class="select-box-wrapper">
            <select class="select-box" id="delivery_state" name="delivery_state"  required>
                @foreach ($state as $state)
                <option value="{{ $state->name }}" @if( $state->name==Auth::user()->city) selected @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="u-s-m-b-13">
        <label for="delivery_pincode">Pincode
            <span class="astk">*</span>
        </label>
        <input type="text" id="delivery_pincode" name="delivery_pincode" placeholder="pincode"  class="text-field">
        @error('delivery_pincode')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="u-s-m-b-13">
        <label for="delivery_mobile">Mobile Number
            <span class="astk">*</span>
        </label>
        <input type="text" id="delivery_mobile" name="delivery_mobile" pattern="[0-9]{10}" placeholder="delivery_mobile" required class="text-field">
        @error('delivery_mobile')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="button button-primary ">Save</button>
    </form>
</div>
