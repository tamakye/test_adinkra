
<div class="card">
    <div class="card-body">
        <h5 class="font-weight-bolder mb-5">Order actions</h5>
        <div class="form-row">
          <div class="col-md-12">
            <div class="form-group">
                <select class="form-control select2 @error('order_actions') is-invalid @enderror" name="order_actions" id="order_actions" style="width: 100%">
                    <option selected hidden disabled value="">Choose action</option>
                    <option value="resend_order">Resend order detials</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary float-right @if(empty($order)) create_order @endif">Update</button>
            </div>
        </div>
    </div>
</div>
</div>
<hr>

{{-- <div class="card">
    <div class="card-body">
        <h5 class="font-weight-bolder mb-5">Vat</h5>
    </div>
</div> 
<hr> --}}

<div class="card">
    <div class="card-body">
        <h5 class="font-weight-bolder mb-5">Order notes</h5>
        <div class="form-group">
            <textarea name="order_notes" id="order_notes" cols="30" rows="5" class="form-control"
            placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
        </div>
    </div>
</div>