@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Package</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Package</h4>

                        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data"
                            id="packageForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="js-example-basic-single form-select" id="country" name="country"
                                            data-width="100%">
                                            @foreach ($countrys as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" class="form-control" name="name" type="text"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_limit" class="form-label">Product Limit</label>
                                        <input id="product_limit" class="form-control" name="product_limit" type="text"
                                            value="{{ old('product_limit') }}">
                                        @error('product_limit')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="page_limit" class="form-label">Landing Page Limit</label>
                                        <input id="page_limit" class="form-control" name="page_limit" type="text"
                                            value="{{ old('page_limit') }}">
                                        @error('page_limit')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email_marketing" class="form-label">Email Marketing</label>
                                        <input id="email_marketing" class="form-control" name="email_marketing"
                                            type="text" value="{{ old('email_marketing') }}">
                                        @error('email_marketing')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card" class="form-label">Card Limit</label>
                                        <input id="card" class="form-control" name="card" type="text"
                                            value="{{ old('card') }}">
                                        @error('card')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input id="price" class="form-control" name="price" type="text"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="offer_price" class="form-label">Offer Price</label>
                                        <input id="offer_price" class="form-control" name="offer_price" type="text"
                                            value="{{ old('offer_price') }}">
                                        @error('offer_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="features" class="form-label">Features</label>
                                        <div id="featuresWrapper">
                                            <input id="features" class="form-control" name="features[]" type="text"
                                                value="{{ old('features.0') }}">
                                        </div>
                                        @error('features')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <ul id="featuresList"></ul>
                                        <button class="btn btn-primary" type="button" id="addFeature">Add
                                            Feature</button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="easyMdeExample" rows="5">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" checked name="status"
                                        id="termsCheck">
                                </div>
                            </div>

                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            let featureIndex = 1;

            // Add feature input field
            $('#addFeature').on('click', function() {
                let newFeatureInput = `<div class="wrap-input" id="feature-${featureIndex}">
                                            <input type="text" class="form-control" name="features[]" value="" placeholder="Feature ${featureIndex + 1}">
                                            <button type="button" class="btn btn-danger btn-sm removeFeature" data-index="${featureIndex}">Remove</button>
                                        </div>`;
                $('#featuresWrapper').append(newFeatureInput);
                featureIndex++;
            });

            // Remove feature input field
            $(document).on('click', '.removeFeature', function() {
                let index = $(this).data('index');
                $('#feature-' + index).remove();
            });
        });
    </script>
@endsection
