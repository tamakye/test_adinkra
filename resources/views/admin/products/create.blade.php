@extends('dashboard.layouts.app')
@section('title', 'Import Products | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('upload_product_active','active')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Upload Products</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload products</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">  
                        <div class="row">
                            <div class="col-md-3">
                                Bulk uploads
                                <ul>
                                    <li>Download <a href="{{ asset(get_product_template()) }}" target="_blank">Product template</a></li>
                                    <li>Ensure all data are filled in correctly</li>
                                    <li>Do not remove the header in the csv file</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.products.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">
                                            Upload (CSV) file *
                                        </label>
                                        <input type="file" name="csv_file"  class="form-control @error('csv_file') is-invalid @enderror" required="" accept=".csv">
                                        @error('csv_file')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                        @enderror

                                        <small class="mt-5 text-muted">Maximum 10MB file size. CSV file type only.</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{route('products')}}" class="btn btn-secondary">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>                 
                    </div>

                    <div class="card-footer">
                       <div class="card-body">
                        <h4 class="card-title text-muted">Product CSV template file</h4>
                        <p class="card-text"><a href="{{asset(get_product_template())}}" target="_blank">Download and view the product CSV template</a>. You can use this as a template for creating your CSV file.</p>

                        <h4 class="card-title text-muted">File format</h4>
                        <p class="card-text">The first line of your product CSV must include all of the headers listed below, which are included in the <a href="{{asset(get_product_template())}}" target="_blank">product CSV template.</a></p>

                        <hr>

                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Product name</strong>
                            <span class="col-md-8">The name of the product. It is a required field.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Product description</strong>
                            <span class="col-md-8">Description of the product. It is a required field.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">SKU</strong>
                            <span class="col-md-8">The product sku. This is an optional field. sku will be auto generated with left blank.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Quantity in stock</strong>
                            <span class="col-md-8">The quantity of product available. It is a required field</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Price.</strong>
                            <span class="col-md-8">The selling price of the product. It is a required field</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Retail Price</strong>
                            <span class="col-md-8">The retail price of the product. This should be greater or equal to the price. It is a required field</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Product Thumbnail</strong>
                            <span class="col-md-8">This is product image that shows up in product previews. Enter only the name of the image. It is a required field</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Product images</strong>
                            <span class="col-md-8">This is product images that shows up in product details. A maximum of 5 images is allowed. Enter only the names of the images seperated by a comma. For example <em>image1.png, image2.png, image3.png</em>. It is a required field.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Category</strong>
                            <span class="col-md-8">These are the categories to which the product are arranged. The unique slug of the category should be added here seperated by commas. For example <em>audi, bmw, tesla</em>. It is a required field. You can find the slugs <a href="{{ route('categories') }}" target="_blank">here</a>.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Status</strong>
                            <span class="col-md-8">Thes product status determines the visibility of the product. Only products with status published can be viewed by distributors. The status requireds one of the following ['published, draft, pending']. It is a required field.</span>
                        </div>

                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Make ID</strong>
                            <span class="col-md-8">This is the make to which the product belongs to. The unique slug of the make should be added here. For example <em>audi</em>. It is a required field. You can find the slugs <a href="{{ route('cars.filters.make') }}" target="_blank">here</a>.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Model ID</strong>
                            <span class="col-md-8">This is the model to which the product belongs to. The unique slug of the model should be added here. For example <em>tesla-model-3</em>. It can be an optional field. You can find the slugs <a href="{{ route('cars.filters.models') }}" target="_blank">here</a>.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Model type ID</strong>
                            <span class="col-md-8">This is the model type to which the product belongs to. The unique slug of the model type should be added here. For example <em>a3-cabriolet</em>. It is a required field. You can find the slugs <a href="{{ route('cars.filters.model-type') }}" target="_blank">here</a>.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Meta title</strong>
                            <span class="col-md-8">This is used for SEO purposes, The title that appears in search engine results when the product is search. It is optional but recommended to add to improve product search result. Maximum of 120 characters.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Meta keywords</strong>
                            <span class="col-md-8">A series of keywords you deem relevant to the page in question. They describe the content of a website shortly and concisely, and are therefore important indicators of a website's content to search engines. It is optional but recommended to add to improve product search result. Maximum of 150 characters.</span>
                        </div>
                        <div class="row mb-3">
                            <strong class="font-weight-bolder col-md-4">Meta keywords</strong>
                            <span class="col-md-8">This describes and summarizes the contents of your page for the benefit of users and search engines. It is optional but recommended to add to improve product search result. Maximum of 150 characters.</span>
                        </div>



                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
</div>
@endsection
