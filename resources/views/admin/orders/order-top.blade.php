<div class="card">
    <div class="card-body">
        <h5 class="font-weight-bolder mb-5">Order #{{ !empty($order) ? $order->order_number : get_order_number() }} details</h5>
        <div class="row">
            <div class="col-md-4">
                <h6 class="font-weight-bolder">General</h6>
                <div class="form-group mt-5">
                    <label for="order_date" class="mt-2">Date created:</label>
                    <input type="text" name="order_date" id="order_date" class="form-control order_date required" required="" autocomplete="off" value="{{ !empty($order) ? $order->order_date->format('Y/m/d H:m') :  old('order_date') }}">
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select class="form-control select2 required @error('status') is-invalid @enderror" name="status" id="status" style="width: 100%" required="">
                        <option selected hidden disabled value="">Choose status </option>
                        <option value="pending" {{ !empty($order) && $order->status == "pending" ? "selected" : "selected" }}>Pending</option>
                        <option value="processing" {{ !empty($order) && $order->status == "processing" ? "selected" : "" }}>Processing</option>
                        <option value="completed" {{ !empty($order) && $order->status == "completed" ? "selected" : "" }}>Completed</option>
                        <option value="cancelled" {{ !empty($order) && $order->status == "cancelled" ? "selected" : "" }}>Cancelled</option>
                        <option value="on-hold" {{ !empty($order) && $order->status == "on-hold" ? "selected" : "" }}>On-hold</option>
                        <option value="refunded" {{ !empty($order) && $order->status == "refunded" ? "selected" : "" }}>Refunded</option>
                        <option value="failed" {{ !empty($order) && $order->status == "failed" ? "selected" : "" }}>Failed</option>
                        <option value="draft" {{ !empty($order) && $order->status == "draft" ? "selected" : "" }}>Draft</option>
                    </select>
                </div> 

                <div class="form-group">
                    <label>Customer:</label>
                    <select class="customer form-control required @error('customer') is-invalid @enderror" name="customer" required="" id="customer">
                        @if(empty($order))
                        <option value="guest" selected data-status="guest">Guest</option>
                        @elseif(!empty($order->user_id))
                        <option value="{{ $order->users->id }}" selected data-status="user"> {{ $order->users->full_name}} - {{  $order->users->email }}</option>
                        @else
                        <option value="{{ $order->order_number }}" selected data-status="address"> {{ $order->addresses->billing_first_name.' '. $order->addresses->billing_first_name. ' '. $order->addresses->billing_email}} - </option>
                        @endif

                    </select>
                </div>

            </div>

            <div class="col-md-4">
                <h6 class="font-weight-bolder">Billing <small class="float-right text-muted cusor"><i class="fas fa-edit edit_billing_address"></i></small></h6>

                <div class=" mt-4" id="billing_info">
                    @if(!empty($order))
                    <h6 class="text-muted font-weight-bolder">Address:</h6>
                    <address  class="d-flex flex-column">
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_email) }}</span>
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_phone) }}</span>
                        <span  class="text-muted">{{ ucfirst(orderCountry($order->addresses->billing_country)->name) }}</span>
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_address_one) }}</span>
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_address_two) }}</span>
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_city) }}</span>
                        <span  class="text-muted">{{ ucfirst(orderRegion($order->addresses->billing_region)->name) }}</span>
                        <span  class="text-muted">{{ ucfirst($order->addresses->billing_zip_code) }}</span>
                    </address>
                    <h6 class="text-muted font-weight-bolder">Email:</h6>
                    <span class="text-muted">{{ ucfirst($order->addresses->billing_email) }}</span>
                    <h6 class="text-muted font-weight-bolder">Phone:</h6>
                    <span class="text-muted">{{ ucfirst($order->addresses->billing_phone) }}</span>
                    @endif
                </div>

                <div class="" id="billing_address_group" @if(!empty($order)) style="display: none;" @endif>
                    <div class="d-flex justify-content-start">
                        <a href="javascript:void(0)" class="text-underline load_billing_address">Load billing address</a>
                    </div>

                    <div class="form-row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">First name *</label>
                                <input type="text" class="form-control required @error('billing_first_name') is-invalid @enderror" name="billing_first_name" required="" value="{{  !empty($order) ?  $order->addresses->billing_first_name : old('billing_first_name') }}">
                                @error('billing_first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Last name *</label>
                                <input type="text" class="form-control required @error('billing_last_name') is-invalid @enderror" name="billing_last_name" required="" value="{{  !empty($order) ?  $order->addresses->billing_last_name : old('billing_last_name') }}">
                                @error('billing_last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="billing_address_one">Address 1*</label>
                            <input type="text" class="form-control" name="billing_address_one" value="{{  !empty($order) ?  $order->addresses->billing_address_one : old('billing_address_one') }}" id="billing_address_one">
                            <p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
                            @error('billing_address_one')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="billing_address_two">Address 2 *</label>
                            <input type="text" class="form-control" name="billing_address_two" value="{{  !empty($order) ?  $order->addresses->billing_address_two :old('billing_address_two') }}" id="billing_address_two">
                            <p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
                            @error('billing_address_two')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Country / Region *</label>
                            <select name="billing_country" id="billing_country" class="form-control required select2 country_select" required="" data-type="billing" style="width: 100%">
                                <option selected hidden disabled value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{  !empty($order) && $order->addresses->billing_country == $country->id ? 'selected' : (old('billing_country') == $country->id ? 'selected' : '')}}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('billing_country')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="billing_region">STATE OR PROVINCE *</label>

                            <select class="form-control  billing_region_select select2 @error('billing_region') is-invalid @enderror" name="billing_region" id="billing_region" style="width: 100%">
                                <option selected hidden disabled value="">Choose region</option>
                                @if(!empty($order))
                                @foreach(getRegions($order->addresses->billing_country) as $region)
                                <option value="{{ $region->id }}" 
                                    {{ $order->addresses->billing_region == $region->id ? 'selected' : (old('billing_region') == $region->id  ? 'selected' : '' )}}>
                                    {{ $region->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>

                            <input type="text" class="form-control billing_region_input @error('billing_region') is-invalid @enderror" name="billing_region" value="{{ old('billing_region') }}" style="display: none;" disabled id="billing_region_input">

                            @error('billing_region')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">City *</label>
                                <input type="text" id="billing_city" class="form-control required @error('billing_city') is-invalid @enderror" name="billing_city" value="{{  !empty($order) ?  $order->addresses->billing_city : old('billing_city') }}" required="">
                                @error('billing_city')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="billing_zip_code">Postcode *</label>
                                <input type="text" id="billing_zip_code" class="form-control required @error('billing_zip_code') is-invalid @enderror" name="billing_zip_code" value="{{ !empty($order) ?  $order->addresses->billing_zip_code :  old('billing_zip_code') }}" required="">
                                @error('billing_zip_code')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Phone *</label>
                                <input type="tel" class="form-control required @error('billing_phone') is-invalid @enderror" name="billing_phone" value="{{ !empty($order) ?  $order->addresses->billing_phone :  old('billing_phone') }}" required="">
                                @error('billing_phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Email address *</label>
                                <input type="email" class="form-control required @error('billing_email') is-invalid @enderror" name="billing_email" value="{{ !empty($order) ?  $order->addresses->billing_email :  old('billing_email') }}" required="">
                                @error('billing_email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">VAT Number (optional)</label>
                                <input type="text" class="form-control @error('billing_vat') is-invalid @enderror" name="billing_vat" value="{{ !empty($order) ?  $order->addresses->billing_vat :  old('billing_vat') }}">
                                @error('billing_vat')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-row">
                      <div class="col-md-12 form-group">
                        <label>Payment Type:</label>
                        <select class="form-control required select2 @error('payment_type') is-invalid @enderror" name="payment_type" id="payment_type" style="width: 100%">
                            <option selected disabled>Choose payment type</option>
                            <option value="n/a" {{ !empty($order) &&  $order->payment_type == 'n/a' ? 'selected' : (empty($order) ? 'selected' : '') }}>N/A</option>
                            <option value="cash_on_delivery" {{ !empty($order) &&  $order->payment_type == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="bank" {{ !empty($order) &&  $order->payment_type == 'bank' ? 'selected' : '' }}>Bank</option>
                            <option value="paystack" {{ !empty($order) &&  $order->payment_type == 'paystack'  ? 'selected': '' }}>Paystack</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Payment method:</label>
                        <select class="form-control required select2 @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method" style="width: 100%">
                            <option selected disabled>Choose payment method</option>
                            <option value="n/a" {{ !empty($order) &&  $order->payment_method == 'n/a' ? 'selected' : (empty($order) ? 'selected' : '')}}>N/A</option>
                            <option value="Card" {{ !empty($order) &&  $order->payment_method == 'Card' ? 'selected' : '' }}>Credit card(Paystack)</option>
                            <option value="Bank transfer" {{ !empty($order) &&  $order->payment_method == 'Bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="Cheque" {{ !empty($order) &&  $order->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="Momo" {{ !empty($order) &&  $order->payment_method == 'Momo'  ? 'selected': '' }}>Momo</option>
                            <option value="Cash" {{ !empty($order) &&  $order->payment_method == 'Cash'  ? 'selected': '' }}>Cash</option>
                            <option value="Other" {{ !empty($order) &&  $order->payment_method == 'Other'  ? 'selected': '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Transaction id</label>
                        <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" name="transaction_id" value="{{ !empty($order) ? $order->transaction_id : old('transaction_id') }}">
                        @error('transaction_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h6 class="font-weight-bolder">Shipping <small class="float-right text-muted cusor"><i class="fas fa-edit edit_shipping_address @if(!empty($order)) get_shipping_address @endif"></i></small></h6>


            <div class=" mt-4" id="shipping_info">
                @if(empty($order))
                <h6 class="text-muted font-weight-bolder">Address:</h6>
                <p class="text-muted">No shipping adress set</p>
                @else
                <h6 class="text-muted font-weight-bolder">Address:</h6>
                <address  class="d-flex flex-column">
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_email) }}</span>
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_phone) }}</span>
                    <span  class="text-muted">{{ ucfirst(orderCountry($order->addresses->shipping_country)->name)  }}</span>
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_address_one) }}</span>
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_address_two) }}</span>
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_city) }}</span>
                    <span  class="text-muted">{{ ucfirst(orderRegion($order->addresses->shipping_region)->name) }}</span>
                    <span  class="text-muted">{{ ucfirst($order->addresses->shipping_zip_code) }}</span>

                </address>
                <h6 class="text-muted font-weight-bolder">Customer provided note:</h6>
                <span>{{ ucfirst($order->order_notes) }}</span>
                @endif
            </div>

            <div class="" id="shipping_address_group" style="display: none;">
              <div class="d-flex justify-content-between mt-4">
                <a href="javascript:void(0)" class="text-underline load_shipping_address">Load shipping address</a>
                <a href="javascript:void(0)" class="text-underline copy_billing_address">Copy billing address</a>
            </div>


            <div class="form-row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">First name *</label>
                        <input type="text" class="form-control shipping_required @error('shipping_first_name') is-invalid @enderror" name="shipping_first_name" value="{{ !empty($order) ? $order->addresses->shipping_first_name : old('shipping_first_name') }}">
                        @error('shipping_first_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Last name *</label>
                        <input type="text" class="form-control shipping_required  @error('shipping_last_name') is-invalid @enderror" name="shipping_last_name" value="{{  !empty($order) ? $order->addresses->shipping_last_name :  old('shipping_last_name') }}">
                        @error('shipping_last_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 form-group mb-3">
                    <label for="shipping_address_one">Address 1*</label>
                    <input type="text" class="form-control" name="shipping_address_one" value="{{  !empty($order) ?  $order->addresses->shipping_address_one : old('shipping_address_one') }}" id="shipping_address_one">
                    <p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
                    @error('shipping_address_one')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="shipping_address_two">Address 2 *</label>
                    <input type="text" class="form-control" name="shipping_address_two" value="{{  !empty($order) ?  $order->addresses->shipping_address_two :old('shipping_address_two') }}" id="shipping_address_two">
                    <p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
                    @error('shipping_address_two')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <label for="shipping_country">Country / Region *</label>
                    <select name="shipping_country" id="shipping_country" class="form-control required select2 country_select" required="" data-type="billing" style="width: 100%">
                        <option selected hidden disabled value="">Select country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{  !empty($order) && $order->addresses->shipping_country == $country->id ? 'selected' : (old('billing_country') == $country->id ? 'selected' : '')}}>{{ $country->name }}</option>
                        @endforeach
                    </select>

                    @error('shipping_country')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">STATE OR PROVINCE *</label>

                        <select class="form-control  shipping_region_select select2 @error('shipping_region') is-invalid @enderror" name="shipping_region" id="shipping_region" style="width: 100%">
                            <option selected hidden disabled value="">Choose region</option>
                            @if(!empty($order))
                            @foreach(getRegions($order->addresses->shipping_country) as $region)
                            <option value="{{ $region->id }}" 
                                {{ $order->addresses->shipping_region == $region->id ? 'selected' : (old('shipping_region') == $region->id  ? 'selected' : '' )}}>
                                {{ $region->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>

                        <input type="text" class="form-control region_input @error('shipping_region') is-invalid @enderror" name="shipping_region" value="{{ old('shipping_region') }}" style="display: none;" disabled>

                        @error('shipping_region')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label for="">Town / City *</label>
                    <input type="text" id="shipping_city" class="form-control shipping_required @error('shipping_city') is-invalid @enderror" name="shipping_city" value="{{ !empty($order) ? $order->addresses->shipping_city :  old('shipping_city') }}">
                    @error('shipping_city')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="shipping_zip_code">Postcode *</label>
                        <input type="text" id="shipping_zip_code" class="form-control shipping_required @error('shipping_zip_code') is-invalid @enderror" name="shipping_zip_code" value="{{ !empty($order) ? $order->addresses->shipping_zip_code :  old('shipping_zip_code') }}">
                        @error('shipping_zip_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Phone *</label>
                        <input type="tel" class="form-control  shipping_required @error('shipping_phone') is-invalid @enderror" name="shipping_phone" value="{{ !empty($order) ? $order->addresses->shipping_phone : old('shipping_phone') }}">
                        @error('shipping_phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Email address *</label>
                        <input type="email" class="form-control shipping_required  @error('shipping_email') is-invalid @enderror" name="shipping_email" value="{{ !empty($order) ? $order->addresses->shipping_email : old('shipping_email') }}">
                        @error('shipping_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">VAT Number (optional)</label>
                        <input type="text" class="form-control @error('shipping_vat') is-invalid @enderror" name="shipping_vat" value="{{ !empty($order) ? $order->addresses->shipping_vat : old('shipping_vat') }}">
                        @error('shipping_vat')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>