@extends('admin.layouts.app')
@section('title', 'Edit '.$product->name)
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('add_product_active','active')


@section('styles')
<link rel="stylesheet" href="{{ asset('/plugins/jquery-upload/image-uploader.min.css') }}">
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{route('products')}}">
                            <h1 class="text-dark m-0">Products</h1>
                        </a></li>
                        <li class="breadcrumb-item">{{ $product->name }}</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header">
        <div class="container-fluid">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{  $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('edit-product', $product->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="card p-4 mb-2">
                            <div class="form-group row">
                                <label for="product_name">Product name*</label>
                                <input type="text" name="product_name" id="product_name" required class="form-control s_required @error('product_name') is-invalid @enderror" value="{{  old('product_name') ?? $product->name}}" placeholder="Product name">
                                <small class="ml-auto product_name_count">{{ 120 - strlen($product->name)}} </small>

                                @error('product_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group row flex-column">
                                <label for="product_description">Description*</label>
                                <textarea type="text" name="product_description" id="product_description" class="form-control editor @error('product_description') is-invalid @enderror" placeholder="Product name" rows="10" >{{  old('product_description') ?? $product->description }}</textarea>
                                {{-- <small class="ml-auto " id="description_count">500</small> --}}

                                @error('product_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card p-4  mb-2">
                            <h6 class="descriptions">Overview</h6>
                            <hr>
                            <div class="row mb-0 pb-0">
                                <div class="form-group col-md-4 mb-0 pb-0">
                                    <label for="">Sku</label>
                                    <input type="text" id="sku" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{  old('sku') ?? $product->sku }}" maxlength="30">
                                    <small class="ml-auto sku_count">{{ 30 - strlen($product->sku) }}</small>
                                    @error('sku')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 mb-2 pb-0">
                                    <label for="">Price*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0 form-height">{{ config('adinkra.currency_code') }}</span>
                                        </div>
                                        <input type="text" name="price" id="price" min="0" class="form-control border-left-0  numeric check-difference pl-0 @error('price') is-invalid @enderror"  required=""  value="{{  old('price') ?? $product->price }}">
                                    </div>
                                    @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                                    <small id="price-feedback" class="m-0 text-danger"></small>
                                </div>
                                <div class="form-group col-md-4 mb-0 pb-0">
                                    <label for="retail_price">
                                        Retail price* 
                                    </label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 form-height">{{ config('adinkra.currency_code') }}</span>
                                            </div>
                                            <input type="text" name="retail_price" id="retail_price" min="0" class="form-control numeric border-left-0 pl-0 check-difference @error('retail_price') is-invalid @enderror" value="{{  old('retail_price') ?? $product->retail_price }}" required>
                                        </div>
                                        @error('retail_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small id="retail-feedback" class="m-0 text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 mb-0 pb-0">
                                    <label for="quantity_in_stock">Quantity in stock</label>
                                    <input type="number" id="quantity_in_stock" class="form-control @error('quantity_in_stock') is-invalid @enderror" name="quantity_in_stock" value="{{  old('quantity_in_stock') ?? $product->quantity_in_stock }}" required="" min="1">
                                    @error('quantity_in_stock')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card p-4  mb-2 ">
                            <h6 class="descriptions d-flex"> Filters </h6>
                            <hr>
                            <div class="attributes" id="attributes">
                                <input type="hidden" class="attribute_total" value="10">
                                {{-- <input type="hidden" class="attribute_total" value="{{ count($attributes->attributevalues) }}"> --}}
                                @foreach($product->attributes as $pro_attribute)
                                <div class="row mb-3 attributes-row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="product_attributes">Attribute</label>
                                        <select name="product_attributes[]" class="form-control select2 product_attributes" required>
                                            <option value="" selected disabled></option>
                                            @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}" data-slug="{{ $attribute->slug }}" {{ $pro_attribute->id == $attribute->id ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                    $attributevalue =  get_atttibutevalue($pro_attribute->pivot->attributevalue_id);
                                    @endphp
                                    <div class="form-group col-md-4 mb-2" >
                                        <label for="attributevalues">Value</label>
                                        <select name="attributevalues[]" class="form-control select2 attributevalues attr" required>
                                            <option value="" selected disabled></option>
                                            <option value="{{ $attributevalue->id }}" selected>{{ $attributevalue->title }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 mb-2" >
                                        <label for="attribute_price">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 form-height">{{ config('adinkra.currency_code') }}</span>
                                            </div>
                                            <input type="number" name="attribute_price[]" class="form-control" value="{{ old('attribute_price') ?? $pro_attribute->pivot->attribute_price }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="form-group  col-md-1 mb-2 d-flex" style="padding-top: 25px;">
                                        <button type="button" class="btn btn-danger btn-sm m-auto mt-1 remove_fields">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div> 
                                @endforeach
                            </div>

                            <div class="form-group add_fields_wrapper">

                                <button  type="button" class="btn btn-primary btn-sm w-25  mb-2 mt-1 add_fields"   @if(count($product->attributes) >= 10) style="display: none;" @endif>
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card p-4  mb-2">
                            <h6 class="descriptions">Extras</h6>
                            <hr>
                            <small class="descriptions">Upload images* <span class="text-muted text-danger">max of 5 images</span>
                            </small>
                            <div class=" form-group row mb-0">
                                <div class="col-md-12 form-group">
                                    <div class="input-field required">
                                        <div class="input-images-2"></div>
                                    </div>
                                    @error('product_images')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card p-4  mb-2">
                            <h6 class="descriptions d-flex">
                                Search Engine Optimize
                                <a href="javascript:void(0)" class="ml-auto" id="edit-seo" >Edit seo</a>
                            </h6>
                            <hr>
                            <div class="seo">
                                <div class="seo-title">{{ ucfirst($product->meta_title )}}</div>
                                <div class="seo-link">
                                    <a href="{{ route('products.single', $product->slug) }}" target="_blank">{{ route('products.single', $product->slug) }}</a>
                                </div>
                                <div class="seo-description">
                                    <span class=""><span class="text-muted">{{ $product->created_at->format('M d, Y') }}</span> - <span class="seo-description-text">{{ $product->meta_description }}</span></span>
                                </div>
                            </div>
                            <div   id="seo mb-5" style="display: none;">
                                <div class="row mb-0 mt-4">
                                    <div class="form-group col-md-6">
                                        <label for="">Meta title</label>
                                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') ?? $product->meta_title }}" maxlength="120" id="meta_title">
                                        @error('meta_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class=" float-right meta_title_count">
                                            {{ 120 - strlen($product->meta_title) }}
                                        </small>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keywords">Keywords</label>
                                        <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords') ?? $product->meta_keywords }}" maxlength="150" id="meta_keywords">
                                        @error('meta_keywords')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class=" float-right meta_keywords_count">
                                            {{ 150 - strlen($product->meta_keywords) }}
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="form-group col-md-12">
                                        <label for="">Meta description</label>
                                        <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" maxlength="150" id="meta_description">{{ old('meta_description') ?? $product->meta_description }}</textarea>
                                        @error('meta_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class=" float-right descriptions_count">
                                            {{ 150 - strlen($product->meta_description) }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-0">
                                    <div class="form-group col-md-12">
                                        <label for="">Poetry In Jewelry</label>
                                        <textarea name="poetry_in_jewelry" class="form-control @error('poetry_in_jewelry') is-invalid @enderror" maxlength="150" id="poetry_in_jewelry">{{ old('poetry_in_jewelry') ?? $product->poetry_in_jewelry }}</textarea>
                                        @error('poetry_in_jewelry')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class=" float-right descriptions_count">
                                            {{ 150 - strlen($product->poetry_in_jewelry) }}
                                        </small>
                                    </div>
                            </div>

                            <hr>
                            <div class="row mb-0">
                                    <div class="form-group col-md-12">
                                        <label for="">Details</label>
                                        <textarea name="details" class="form-control @error('details') is-invalid @enderror" maxlength="150" id="details">{{ old('details') ?? $product->details }}</textarea>
                                        @error('details')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class=" float-right descriptions_count">
                                            {{ 150 - strlen($product->details) }}
                                        </small>
                                    </div>
                            </div>


                        </div>
                    </div>

                    {{-- saide right --}}
                    <div class="col-md-3">
                        <div class="card mb-2">
                            <div class="card-header descriptions">
                                Publish
                            </div>
                            <div class="row  m-2">
                                <button type="submit" class="btn btn-primary btn-block" style="font-size: 12px;"> <i class="fas fa-check-circle"></i> Save changes</button>
                                {{-- <button type="submit" class="btn btn-primary ml-auto"  style="font-size: 12px;"> <i class="fas fa-edit"></i>  Save & Edit</button> --}}
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-header descriptions">
                                Status*
                            </div>
                            <div class="form-group p-2">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="published" {{ old('status') == 'published'? 'selected' : ($product->status == 'published' ? 'selected' : '') }}>Published</option>
                                    <option value="draft" {{ old('status') == 'draft'? 'selected' : ($product->status == 'draft' ? 'selected' : '') }}>Draft</option>
                                    <option value="pending" {{ old('status') == 'pending'? 'selected' : ($product->status == 'pending' ? 'selected' : '')}}>Pending</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header descriptions">
                                Product collection*
                            </div>
                            <div class="form-group p-2">
                                <select name="product_collection" id="product_collection" required="" class="form-control select2">
                                    <option value="" selected disabled></option>
                                    @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" {{ old('product_collection') == $collection->id ? 'selected' : ($collection->id == $product->collection_id ? 'selected' : '' ) }}>{{$collection->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_collection')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="card mb-2">
                            <div class="card-header descriptions">
                                Product conditions*
                            </div>
                            <div class="form-group p-2">
                                <select name="product_conditions[]" id="product_conditions" required="" class="form-control select2" multiple="">
                                    {{-- <option value="" >---select---</option> --}}
                                    @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}" 
                                        @foreach($product->conditions as $product_condition)
                                        @if(old('product_conditions') == $condition->id )
                                        selected 
                                        @elseif($condition->id == $product_condition->id)
                                        selected
                                        @else
                                        @endif
                                        @endforeach>
                                        {{$condition->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_conditions')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="card mb-2">`
                            <div class="card-header descriptions">
                                Category*
                            </div>
                            <div class="form-group p-2">
                                <select name="product_category[]" id="product_category" required="" class="form-control select2" multiple="">
                                    {{-- <option value="" selected hidden disabled>---select---</option> --}}
                                    @foreach(get_categories($product->collection_id) as $category)
                                    <option value="{{ $category->id }}" 

                                        @if(old('product_category') && in_array($product_cat, old('product_category')))
                                        selected 
                                        @else

                                        @foreach($product->categories as $product_cat)
                                        @if($category->id == $product_cat->id)
                                        selected
                                        @endif
                                        @endforeach

                                        @endif>

                                        {{$category->name}}

                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_category')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="card mb-2">
                            <div class="card-header descriptions">
                                Material*
                            </div>
                            <div class="form-group p-2">
                                <select name="product_material" id="product_material" required="" class="form-control select2">
                                    <option value="" selected disabled></option>
                                    @foreach($materials as $material)
                                    <option value="{{ $material->id }}" {{ old('product_material') == $material->id ? 'selected' : ($material->id == $product->material_id ? 'selected' : '' ) }}>{{$material->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_material')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-flex flex-column mb-5">
                            <label for="">Thumbnail</label>
                            <img class="img-thumbnail m-auto" src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" alt="Thumbnail image" id="image_preview" width="300" style="border-radius: 15px;">
                            <div class="custom-file mt-1" >
                                <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail">
                                <label class="custom-file-label" for="thumbnail">Choose file</label>
                            </div>
                            @error('thumbnail') 
                            <span class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <hr>
                        <div class="form-group d-flex flex-column">
                            <label for="">Product Inspiration Image</label>
                            <img class="img-thumbnail m-auto" src="{{ asset(get_product_inspiration($product->inspiration)) }}" alt="Inspiration image" id="imageinspiration_preview" width="300" style="border-radius: 15px;">
                            <div class="custom-file mt-1" >
                                <input type="file" name="inspiration" class="custom-file-input" id="inspiration">
                                <label class="custom-file-label" for="inspiration">Choose file</label>
                            </div>
                            @error('inspiration') 
                            <span class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="{{ asset('/plugins/jquery-upload/image-uploader.min.js') }}"></script>
    <script src="{{asset('dashboard/js/products.js')}}"></script>

    <script type="text/javascript">
        $(function(){
            @if(!empty($product->product_image))

            let preloaded = [

                @foreach(json_decode($product->product_image) as $image)
                {id: '{{$image}}', src: '{{ asset(get_product_images($image)) }}'},
                @endforeach

                ];

            $('.input-images-2').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old_images',
                maxFiles: 2
            });
            @else
            $('.input-images-2').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'old_images',
                maxFiles: 2
            });
            @endif

            $('.upload-text').html('<i class="fas fa-upload"></i> <span>Drag &amp; Drop files here or click to browse</span>').addClass('text-muted');



        })
    </script>
    @endsection