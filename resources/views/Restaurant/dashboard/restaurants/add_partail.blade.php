 <div class="col-md-3 mb-2">
     <div class="form-group">
         <label for="delivery_zoon">Delivery Zoon</label>
         <select class="form-control select-delivery-zone" name="zone">
             <option required selected disabled>select delivery_zoon</option>
             @foreach ($zones as $zoon)
             <option value="{{ $zoon->name }}">{{ $zoon->name }}</option>
             @endforeach
         </select>
         @error('delivery_zoon')
         <small class=" text-danger">{{ $message }}</small>
         @enderror
     </div>
 </div>

