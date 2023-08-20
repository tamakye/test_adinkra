 <div class="row mb-3 attributes-row">
    <div class="form-group col-md-4 mb-2">
        <label for="product_attributes">Attribute</label>
        <select name="product_attributes[]" class="form-control select2 product_attributes" required>
            <option value="" selected disabled></option>
            @foreach($attributes as $attribute)
            <option value="{{ $attribute->id }}" data-slug="{{ $attribute->slug }}">{{ $attribute->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4 mb-2" >
        <label for="attributevalues">Value</label>
        <select name="attributevalues[]" class="form-control select2 attributevalues attr" required>
            <option value="" selected disabled></option>
        </select>
    </div>
    <div class="form-group col-md-3 mb-2" >
        <label for="attribute_price">Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent border-right-0 form-height">{{ config('adinkra.currency_code') }}</span>
            </div>
            <input type="text" name="attribute_price[]" class="form-control numeric" value="{{ old('attribute_price') }}" min="0" required>
        </div>
        
    </div>
    <div class="form-group  col-md-1 mb-2 d-flex" style="padding-top: 25px;">
        <button type="button" class="btn btn-danger btn-sm m-auto mt-1 remove_fields">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</div> 