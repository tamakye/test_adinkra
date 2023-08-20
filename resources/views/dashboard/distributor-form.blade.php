@extends('layouts.app')
@section('title','Complete registration | MSSSHOP')
@section('accountStatus', 'active')
@section('accountActive','active')


@section('sidebar')
{{ sidebar(0) }}
@endsection

@section('content')
<div  id="dashbord">

    <section class="bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('distributors.partials.sidenav')
                </div>
                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5>Company details</h5>
                        </div>
                        <div class="card-body">
                            @if(empty($company))
                            <div class="alert alert-info">
                                <h5> <i class="fas fa-exclamation-circle"></i> Update your company details before proceeding.</h5>
                            </div>
                            @endif
                            <form action="{{ route('distributors.distributor-form') }}" method="post">
                                @csrf
                                <div class="form-row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="registration_number">Company Registration Number: *</label>
                                            <input type="text" class="form-control required @error('registration_number') is-invalid @enderror" name="registration_number" required="" value="{{ old('registration_number') ?? !empty($company) ? $company->registration_number : '' }}">
                                            @error('registration_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vat">Company VAT/TAX I.D. Number:*</label>
                                            <input type="text" class="form-control required @error('vat') is-invalid @enderror" name="vat" required="" value="{{ old('vat') ?? !empty($company) ? $company->vat : '' }}">
                                            @error('vat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trading_as">DBA/Trading As: *</label>
                                            <input type="text" class="form-control @error('trading_as') is-invalid @enderror" name="trading_as" value="{{ old('trading_as') ?? !empty($company) ? $company->trading_as : ''  }}" required>
                                            @error('trading_as')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Owner/President/Director Name:</label>
                                            <input type="text" class="form-control @error('director_name') is-invalid @enderror" name="director_name" required value="{{ old('director_name') ?? !empty($company) ? $company->director_name : ''  }}">
                                            @error('director_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Billing Address:</label>
                                            <input type="text" class="form-control required @error('billing_address') is-invalid @enderror" name="billing_address" value="{{ old('billing_address') ?? !empty($company) ? $company->billing_address : ''  }}" placeholder="" required="">
                                            @error('billing_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="shipping_address">Shipping Address:</label>
                                            <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required value="{{ old('shipping_address') ?? !empty($company) ? $company->shipping_address : '' }}" placeholder="">
                                            @error('shipping_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Contact Number (Primary):</label>
                                            <input type="tel" id="primay_contact" class="form-control required @error('primay_contact') is-invalid @enderror" name="primay_contact" value="{{ old('primay_contact') ?? $distributor->phone }}" required="">
                                            @error('primay_contact')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Contact Number (Secondary):</label>
                                            <input type="tel" id="secondary_contact" class="form-control required @error('secondary_contact') is-invalid @enderror" name="secondary_contact" value="{{ old('secondary_contact') ?? !empty($company) ? $company->secondary_contact : '' }}" >

                                            @error('secondary_contact')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="business_type">Business Type:</label>
                                            <input type="text" id="business_type" class="form-control mb-2 required @error('business_type') is-invalid @enderror" name="business_type" value="{{ old('business_type') ?? !empty($company) ? $company->business_type : '' }}" required="">
                                            <small style="font-size: 0.7rem;line-height;">(Sole Proprietor/Partnership/LTD Company/LLC/LLP/Corporation etc)</small>
                                            @error('business_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sales_outlet">No. of sales outlets:</label>
                                            <input type="number" min="0" class="form-control required @error('sales_outlet') is-invalid @enderror" name="sales_outlet" value="{{ old('sales_outlet') ?? !empty($company) ? $company->sales_outlet : '' }}" required="">
                                            @error('sales_outlet')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="years_in_business">Years in Business::</label>
                                            <input type="number" min="0" class="form-control required @error('years_in_business') is-invalid @enderror" name="years_in_business" value="{{ old('years_in_business') ?? !empty($company) ? $company->years_in_business : '' }}" required="">
                                            @error('years_in_business')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <label for="" class=" text-dark">Annual Turnover: </label>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="annual_turnover">2017: </label>
                                            <input type="number" min="0" id="annual_turnover" class="form-control required @error('annual_turnover') is-invalid @enderror" name="annual_turnover[]" value="{{ old('annual_turnover') ? old('annual_turnover')[0] : (!empty($company) ? $company->annual_turnover[0] : '') }}" >
                                            @error('annual_turnover')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="annual_turnover">2018: </label>
                                            <input type="number" min="0" id="annual_turnover" class="form-control required @error('annual_turnover') is-invalid @enderror" name="annual_turnover[]" value="{{ old('annual_turnover') ? old('annual_turnover')[1] :  (!empty($company) ? $company->annual_turnover[1] : '') }}" >
                                            @error('annual_turnover')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="annual_turnover">2019:</label>
                                            <input type="number" min="0" class="form-control required @error('annual_turnover') is-invalid @enderror" name="annual_turnover[]" value="{{ old('annual_turnover') ? old('annual_turnover')[2] :  (!empty($company) ? $company->annual_turnover[2] : '') }}" >
                                            @error('annual_turnover')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="annual_turnover">2020:</label>
                                            <input type="number" min="0" class="form-control required @error('annual_turnover') is-invalid @enderror" name="annual_turnover[]" value="{{ old('annual_turnover') ? old('annual_turnover')[3] :  (!empty($company) ? $company->annual_turnover[3] : '') }}" >
                                            @error('annual_turnover')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
{{-- 
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Local Currency:</label>
                                            <input type="text" class="form-control required @error('local_currency') is-invalid @enderror" name="local_currency" value="{{ old('local_currency') }}" required="">
                                            @error('local_currency')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">VAT Number (optional)</label>
                                            <input type="text" class="form-control @error('billing_vat') is-invalid @enderror" name="billing_vat" value="{{ old('billing_vat') }}">
                                            @error('billing_vat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Please tell us  why you are interested in MSS:</label>
                                            <textarea  class="form-control required @error('why_interested') is-invalid @enderror" name="why_interested"required="">{{ old('why_interested') ?? !empty($company) ? $company->why_interested : '' }}</textarea>
                                            @error('why_interested')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="">Trading area requested:</label>
                                        <textarea  class="form-control required @error('comments') is-invalid @enderror" name="trading_area"required="">{{ old('trading_area') ?? !empty($company) ? $company->trading_area : '' }}</textarea>
                                        @error('trading_area')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" style="font-size: 0.7rem">Projected percentage of T/O planned for MSS products:</label>
                                        <input type="text"  class="form-control required @error('projected_percentage') is-invalid @enderror" name="projected_percentage" required=""value="{{ old('projected_percentage') ?? !empty($company) ? $company->projected_percentage : '' }}">
                                        @error('projected_percentage')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Local Currency:</label>
                                        <input type="text"  class="form-control required @error('local_currency') is-invalid @enderror" name="local_currency" required="" maxlength="3" value="{{ old('local_currency') ?? !empty($company) ? $company->local_currency : '' }}">
                                        @error('local_currency')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Trade:</label>
                                        <select class="form-control select2 @error('trade') is-invalid @enderror" name="trade[]" required="" multiple="">

                                         @foreach(trade() as $id => $tradetype)
                                         <option value="{{ $id }}" {{ is_array(old('trade')) && in_array($id, old('trade')) ? 'selected' : ( !empty($company) && in_array($id, $company->trade) ? 'selected' : '') }} >{{ $tradetype }}</option>
                                         @endforeach

                                            {{-- <option value="distributor">Distributor</option>
                                            <option value="wholesaler">Wholesaler</option>
                                            <option value="retailer">Retailer</option>
                                            <option value="workshop">Workshop</option>
                                            <option value="agent">Agent</option> --}}
                                        </select>
                                        @error('trade')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                    <label for="">Other brands you represent:</label>
                                    <textarea  class="form-control required @error('other_brands') is-invalid @enderror" name="other_brands" >{{ old('other_brands') ?? !empty($company) ? $company->other_brands : '' }}</textarea>
                                    @error('other_brands')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                <label for="">Any other comments?</label>
                                <textarea  class="form-control @error('comments') is-invalid @enderror" name="comments" >{{ old('comments') ?? !empty($company) ? $company->comments : '' }}</textarea>
                                @error('comments')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn btn-primary ml-auto text-dark">Save details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>

{{-- footer --}}
@include('includes.footer')
@endsection

@section('script')
<script type="text/javascript">
</script>
@endsection