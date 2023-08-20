@extends('admin.layouts.app')
@section('title', ' Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('site-pages-menu-open','menu-open')
@section('homepage_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <h1 class="text-dark m-0">Site pages</h1>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="top-slider">
                        <div class="card-header">
                            <h5 class="bold">Top slider</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Slider one</label>
                                <input type="text" name="top_slider_one" class="form-control" value="{{ !empty($page) ? $page->top_slider_one : 'WELCOME TO 3DINKRA, A POETIC GASP OF AFRICAN ART' }}">
                                @error('top_slider_one')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Slider one</label>
                                <input type="text" name="top_slider_two" class="form-control" value="{{ !empty($page) ? $page->top_slider_two : 'NEW COLLECTION COMING SOON' }}">
                                @error('top_slider_two')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Slider one</label>
                                <input type="text" name="top_slider_three" class="form-control" value="{{ !empty($page) ? $page->top_slider_three : 'SUBSCRIBE TO OUR NEWSLETTERS SO YOU DON’T MISS OUR NEW COLLECTIONS' }}">
                                @error('top_slider_three')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="adinkra">
                        <div class="card-header">
                            <h5 class="bold">ADINKRA COLLECTION</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Adinkra Title Test</label>
                                <input type="text" name="adinkra_text" class="form-control" value="{{ !empty($page) ? $page->adinkra_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.'}}">
                                @error('adinkra_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image heading</label>
                                <input type="text" name="adinkra_image_heading" class="form-control" value="{{ !empty($page) ? $page->adinkra_image_heading : 'STONE OF AGES'}}">
                                @error('adinkra_image_heading')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image text</label>
                                <input type="text" name="adinkra_image_text" class="form-control" value="{{ !empty($page) ? $page->adinkra_image_text : 'STONE OF AGES'}}">
                                @error('adinkra_image_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="legacy">
                        <div class="card-header">
                            <h5 class="bold">LEGACY JEWELRY COLLECTION</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Legacy Title Test</label>
                                <input type="text" name="legacy_text" class="form-control" value="{{ !empty($page) ? $page->legacy_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.'}}">
                                @error('legacy_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image heading</label>
                                <input type="text" name="legacy_image_heading" class="form-control" value="{{ !empty($page) ? $page->legacy_image_heading : 'STONE OF AGES'}}">
                                @error('legacy_image_heading')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image text</label>
                                <input type="text" name="legacy_image_text" class="form-control" value="{{ !empty($page) ? $page->legacy_image_text : 'STONE OF AGES'}}">
                                @error('legacy_image_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="art">
                        <div class="card-header">
                            <h5 class="bold">ART AND SCULPTURE COLLECTION</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Art Title Test</label>
                                <input type="text" name="art_text" class="form-control" value="{{ !empty($page) ? $page->art_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.'}}">
                                @error('art_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image heading</label>
                                <input type="text" name="art_image_heading" class="form-control" value="{{ !empty($page) ? $page->art_image_heading : 'STONE OF AGES'}}">
                                @error('art_image_heading')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image text</label>
                                <input type="text" name="art_image_text" class="form-control" value="{{ !empty($page) ? $page->art_image_text : 'STONE OF AGES'}}">
                                @error('art_image_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="custom">
                        <div class="card-header">
                            <h5 class="bold">CUSTOM JEWELRY</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Custom Title Test</label>
                                <input type="text" name="custom_text" class="form-control" value="{{ !empty($page) ? $page->custom_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.'}}">
                                @error('custom_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="">Image heading</label>
                                <input type="text" name="custom_image_heading" class="form-control" value="{{ !empty($page) ? $page->custom_image_heading : 'STONE OF AGES'}}">
                                @error('custom_image_heading')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image text</label>
                                <input type="text" name="custom_image_text" class="form-control" value="{{ !empty($page) ? $page->custom_image_text : 'STONE OF AGES'}}">
                                @error('custom_image_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('pages') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="digital">
                        <div class="card-header">
                            <h5 class="bold">DIGITAL COLLECTION</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Digital Title Test</label>
                                <input type="text" name="digital_text" class="form-control" value="{{ !empty($page) ? $page->digital_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.'}}">
                                @error('digital_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="">Image heading</label>
                                <input type="text" name="digital_image_heading" class="form-control" value="{{ !empty($page) ? $page->digital_image_heading : 'STONE OF AGES'}}">
                                @error('digital_image_heading')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Image text</label>
                                <input type="text" name="digital_image_text" class="form-control" value="{{ !empty($page) ? $page->digital_image_text : 'STONE OF AGES'}}">
                                @error('digital_image_text')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection