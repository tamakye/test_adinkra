@extends('admin.layouts.app')
@section('title', 'Edit '. $attribute->name)

@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('attributes_active','active')

{{-- main content --}}
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body d-flex mb-2">
                <small class="text-uppercase border-bottom title">Product attribute</small>

                <a href="{{ route('attributes') }}" class="btn btn-primary btn-sm ml-auto"><i data-feather="corner-down-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form id="attributesForm" action="{{ route('attributes.update', $attribute->slug) }}"  method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="button_type" id="save_status" value="save">

            <div class="row flex-column-reverse flex-md-row flex-lg-row">

                <div class="col-md-9">
                    <div class="card" id="add-new-attribute">
                        @if($errors->any())
                        <div class="alert alert-danger pt-3">
                            <ul class="">
                                <i class="fas fa-times-circle"></i> All fields are required. The name, titles, slugs, colours and thumbnail fields are required.
                        {{-- @foreach($errors->all()  as $error)
                        <li>{{ $error }}</li>
                        @endforeach --}}
                    </ul>
                </div>
                @else
                <div class="alert alert-info pt-3">
                    <ul class="">
                        <i class="fas fa-exclamation-triangle"></i> All fields are required. The name, titles, slugs, colours and thumbnail fields are required.
                    </ul>
                </div>
                @endif

                <div class="card-header">
                    <h5 class="font-weight-bolder">Edit "{{ $attribute->name }}" attribute</h5>
                </div>
                <div class="card-body">

                    <div class="form-group mb-2">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control seo_name @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $attribute->name }}" required="" id="name">
                        @error('name') 
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                       <label class="form-label" for="attribute_slug">Slug <small>Optional</small></label>
                       <input type="text" class="form-control slug  @error('attribute_slug') is-invalid @enderror" name="attribute_slug" value="{{ old('attribute_slug') ?? $attribute->slug }}" id="attribute_slug" readonly="">
                       @error('slug') 
                       <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                    <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens</small>
                </div>


                <div class="row flex-column mt-4">
                    <div class="table-responsive"> 
                        <table id="attributeTable" class="table table-bordered"> 
                            <thead class="bg-primary text-white"> 
                                <tr> 
                                    <th class="text-center">#</th> 
                                    <th class="text-center">Is default</th> 
                                    <th class="text-center">Title</th> 
                                    <th class="text-center">Slug</th> 
                                    <th class="text-center">Colour</th> 
                                    <th class="text-center">Image</th> 
                                    <th class="text-center">Remove </th> 
                                </tr> 
                            </thead> 
                            <tbody id="tbody"> 
                                <input type="hidden" class="count_values" value="{{ count($attribute->attributevalues) }}">

                                @foreach($attribute->attributevalues as $value)
                                <tr class="tableRow" id="{{$loop->index + 1}}">
                                    <input type="hidden" name="values[]" value="{{ $value->id }}">
                                    <td class="row-index"> <span>{{$loop->index + 1}}</span></td>
                                    <td class="text-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ck_{{ $value->id}}" name="default" class="custom-control-input default" 
                                            {{ $value->default == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="ck_{{ $value->id }}"></label>
                                        </div>
                                    </td>
                                    <td><input type="text" name="title[]" class="form-control title" value="{{ $value->title }}"></td>
                                    <td><input type="text" name="slug[]" class="form-control slug" id="{{$value->id  }}" value="{{ $value->slug  }}"></td>
                                    <td><input type="color" name="colour[]" class="form-control" value="{{ $value->colour  }}"></td>
                                    <td>
                                        <div class="preview m-auto"  style="width: 50px !important; height: 50px !important;     overflow: hidden;">
                                            @if(!empty($value->thumbnail))
                                            <img class="img-thumbnail cursor image_preview" src="{{ asset(get_attribute_thumbnail($value->thumbnail)) }}" alt="Thumbnail image" >
                                            @else
                                            <img class="img-thumbnail cursor image_preview" src="{{ asset(default_placeholder()) }}" alt="Thumbnail image" >
                                            @endif
                                        </div>

                                        <div class="custom-file  mt-4" style="display: none;">
                                            <input type="file" name="thumbnail[]" class="custom-file-input thumbnail" accept=".png, .jpg, .jpeg" value="{{ null }}" >
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="text-danger removeRow"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> 
                        </table> 
                    </div> 
                    <div>
                        <button type="button" class="btn btn-sm btn-primary float-left" id="addBtn" > 
                            Add new attribute 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-2 pb-2">
            <div class="card-header descriptions">
                Publish
            </div>
            <div class="d-flex justify-content-between  m-2">
                <button type="submit" class="btn btn-sm btn-primary save_btn" data-status="save"> <i data-feather="save"></i> Save</button>
                <button type="submit" class="btn btn-sm btn-success ml-auto save_btn" data-status="edit"> <i data-feather="edit"></i>  Save & Continue</button>
            </div>
        </div>

        <div class="card mb-2 pb-2">
            <div class="card-header descriptions">
                Status
            </div>

            <div class="m-2">
                <select class="form-control select2" name="status" id="status" required="">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : ($attribute->status == 'draft' ? 'selected' : '') }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : ($attribute->status == 'published' ? 'selected' : '') }}>Published</option>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : ($attribute->status == 'pending' ? 'selected' : '') }}>Pending</option>
                </select>
                @error('status') 
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('dashboard/js/products.js') }}" type="text/javascript"></script>
<script src="{{ asset('dashboard/js/attribute.js') }}" type="text/javascript"></script>
@endsection