@extends('layouts.app')
@section('title','New ticket | MSSSHOP')
@section('hide-scrollbar','hide-scrollbar')
@section('accountStatus','active')
@section('tickets-active','active')

@section('content')
<div id="dashbord">
    <section class="bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('user.partials.sidenav')
                </div>
                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h5>New ticket</h5>
                            <a href="{{ route('tickets') }}" class="btn btn-outline-primary ml-auto text-dark">Back</a>
                        </div>
                        <div class="card-body">
                         @if($errors->any())
                         <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{  $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form class="tickets-form" action="{{ route('new-tickets') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category">Please select a category</label>
                                <select name="category" id="category" class="form-control select2">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea type="text" class="form-control" name="message"required="" rows="5" style="resize: none;">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="attachment" style="width: auto;">
                                    <button type="button" class="btn add-attachment" style="font-size: 0.5rem;
                                    padding: 0;
                                    color: #000; border: none;"><i class="fas fa-paperclip"></i> upload a file</button>
                                    <div class="badge badge-dark show-box p-1">
                                        <span class="close-file"><i class="fas fa-times"></i></span>
                                        <span class="show-filename mt-2"></span>
                                    </div>
                                    <br>
                                    <small>File import is limited to 5MB. Accepted formats are: jpg, png, doc, pdf, rar, zip.</small>
                                </label>
                                <input type="file" class="form-control" name="attachment" accept=".jpg, .png, .jpeg, .docx, .doc, .pdf, .zip" style="display: none;" id="attachment">
                                @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="text-right">
                                <button class="btn btn-outline-primary px-5 save-ticket" style="font-size: 0.6rem;
                                padding: 0;
                                color: #000;"> <i class="fas fa-ticket"></i> Open this ticket</button>
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

@endsection