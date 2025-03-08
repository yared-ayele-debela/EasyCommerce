<div class="col-md-6">
      <label for="parent_id" class="form-label"> Select Category Level</label> 
      <select name="parent_id" id="parent_id" class="form-select" style="color:#000;">
         <option  value="0" @if(isset($categories['parent_id']) && $categories['parent_id']==0)  selected=""         
         @endif>Main Category</option>
         @if(!empty($getcategory))
           @foreach ($getcategory as $category)
                 <option value="{{ $category['id'] }}"  @if(isset($category['parent_id']) && $category['parent_id']==$category['id'])  selected=""         
                 @endif >{{ $category['name'] }}</option>
                 @if(!empty($category['subcategories']))
                       @foreach ($category['subcategories'] as $subcategory)
                            <option value="{{ $subcategory['id'] }}" @if(isset($category['parent_id'])&&$category['parent_id']==$subcategory['id']) selected=""
                             
                            @endif>&nbsp;&nbsp;&raquo;{{ $subcategory['name'] }}</option>
                       @endforeach
                 @endif
           @endforeach
         @endif
      </select>
   </div>