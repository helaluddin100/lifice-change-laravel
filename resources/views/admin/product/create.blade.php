@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Product</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Product</h4>

                        <form action="{{ route('admin.color.store') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" class="form-control" placeholder="Name" name="name"
                                            type="text">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="js-example-basic-single form-select" id="country" name="country"
                                            data-width="100%">
                                            <option value="one">One</option>
                                            <option value="one">One</option>
                                            <option value="one">One</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Initial Sold Count</label>
                                        <input type="number" class="form-control" name="sold_count"
                                            placeholder="Initial Sold Count">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Sell/Current Price *</label>
                                        <input type="number" class="form-control" name="current_price"
                                            placeholder="Sell/Current Price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Regular/Old Price</label>
                                        <input type="number" class="form-control" name="old_price"
                                            placeholder="Regular/Old Price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Buying Price (Optional)</label>
                                        <input type="number" class="form-control" name="buy_price"
                                            placeholder="Buying Price (Optional)">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity (Stock) *</label>
                                        <input type="number" class="form-control" name="quantity"
                                            placeholder="Quantity (Stock)">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity (Stock) *</label>
                                        <input type="number" class="form-control" name="quantity"
                                            placeholder="Quantity (Stock)">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Warranty</label>
                                        <input type="number" class="form-control" name="warranty" placeholder="Warranty">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Color and Price</label>
                                        <div id="color-price-container">
                                            <div class="row color-price-group">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Color</label>
                                                        <select class="js-example-basic-single form-select" name="color[]"
                                                            data-width="100%">
                                                            <option value="red">Red</option>
                                                            <option value="green">Green</option>
                                                            <option value="yellow">Yellow</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" class="form-control" name="price[]"
                                                            placeholder="Price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 d-flex align-items-end">
                                                    <div class="mb-3">
                                                        <button type="button"
                                                            class="btn btn-danger remove-color">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-2" id="add-color-btn">Add
                                            Color</button>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Size and Price</label>
                                        <div id="size-price-container">
                                            <div class="row size-price-group">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Size</label>
                                                        <select class="js-example-basic-single form-select" name="size[]"
                                                            data-width="100%">
                                                            <option value="small">Small</option>
                                                            <option value="medium">Medium</option>
                                                            <option value="large">Large</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" class="form-control" name="price[]"
                                                            placeholder="Price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 d-flex align-items-end">
                                                    <div class="mb-3">
                                                        <button type="button"
                                                            class="btn btn-danger remove-size">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-2" id="add-size-btn">Add
                                            Size</button>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="easyMdeExample" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-1">Product Details</h4>
                                        <p>You can add multiple product details for a single product here, like Brand,
                                            Model, Serial Number, Fabric Type, and EMI options, etc.</p>
                                        <h5 class="my-3">Is this detail required?</h5>
                                        <div id="product-detail-container">
                                            <div class="row product-detail-group">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Detail Type</label>
                                                        <input type="text" class="form-control" name="detail_type[]"
                                                            placeholder="e.g., Brand, Model">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Detail Description</label>
                                                        <input type="text" class="form-control"
                                                            name="detail_description[]"
                                                            placeholder="e.g., Samsung, Cotton">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 d-flex align-items-end">
                                                    <div class="mb-3">
                                                        <button type="button"
                                                            class="btn btn-danger remove-detail">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-2" id="add-detail-btn">Add a new
                                            Detail</button>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-1">Product Variant</h4>
                                        <p>You can add multiple variants for a single product here, like Size, Color, and
                                            Weight, etc.</p>

                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Variant Name</label>
                                            <input type="text" class="form-control" name="variant_name"
                                                placeholder="Enter the name of the variant (e.g., Color, Size, Material)">
                                        </div>

                                        <div id="product-variant-container">
                                            <div class="row product-variant-group">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Variant Option</label>
                                                        <input type="text" class="form-control"
                                                            name="variant_option[]" placeholder="e.g., Red, Large">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Additional Cost</label>
                                                        <input type="text" class="form-control" name="variant_cost[]"
                                                            placeholder="e.g., 10, 15">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 d-flex align-items-end">
                                                    <div class="mb-3">
                                                        <button type="button"
                                                            class="btn btn-danger remove-variant">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-primary mt-2" id="add-variant-btn">Add More
                                            Option +</button>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Product Images</label>
                                        <input id="images" class="form-control" name="images[]" type="file"
                                            multiple>
                                    </div>
                                    <div id="image-preview" class="row mt-3"></div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product_video" class="form-label">Product Video (YouTube Link)</label>
                                        <input id="product_video" class="form-control" name="product_video"
                                            type="text">
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
    <script>
        $(document).ready(function() {
            $('#add-color-btn').on('click', function() {
                const html = `
                <div class="row color-price-group">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <select class="js-example-basic-single form-select" name="color[]" data-width="100%">
                                <option value="red">Red</option>
                                <option value="green">Green</option>
                                <option value="yellow">Yellow</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price[]" placeholder="Price">
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger remove-color">×</button>
                        </div>
                    </div>
                </div>
            `;
                $('#color-price-container').append(html);
                $('.js-example-basic-single').select2(); // reinitialize select2 if you're using it
            });

            // Remove color-price group
            $(document).on('click', '.remove-color', function() {
                $(this).closest('.color-price-group').remove();
            });
        });

        $(document).ready(function() {
            $('#add-size-btn').on('click', function() {
                const html = `
                <div class="row size-price-group">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Size</label>
                            <select class="js-example-basic-single form-select" name="size[]" data-width="100%">
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price[]" placeholder="Price">
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <div class="mb-3">
                            <button type="button"
                                class="btn btn-danger remove-size">×</button>
                             </div>
                    </div>
                </div>
            `;
                $('#size-price-container').append(html);
                $('.js-example-basic-single').select2(); // Reinitialize if you're using select2
            });

            $(document).on('click', '.remove-size', function() {
                $(this).closest('.size-price-group').remove();
            });
        });

        $(document).ready(function() {
            $('#add-detail-btn').on('click', function() {
                const html = `
                <div class="row product-detail-group">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Detail Type</label>
                            <input type="text" class="form-control" name="detail_type[]" placeholder="e.g., Brand, Model">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label class="form-label">Detail Description</label>
                            <input type="text" class="form-control" name="detail_description[]" placeholder="e.g., Samsung, Cotton">
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                      <div class="mb-3">
                        <button type="button" class="btn btn-danger remove-detail">×</button>
                      </div>
                    </div>
                </div>
            `;
                $('#product-detail-container').append(html);
            });

            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.product-detail-group').remove();
            });
        });
        $(document).ready(function() {
            $('#add-variant-btn').on('click', function() {
                const variantHtml = `
                <div class="row product-variant-group">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Variant Option</label>
                            <input type="text" class="form-control" name="variant_option[]" placeholder="e.g., Red, Large">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label class="form-label">Additional Cost</label>
                            <input type="text" class="form-control" name="variant_cost[]" placeholder="e.g., 10, 15">
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger remove-variant">×</button>
                        </div>
                    </div>
                </div>
            `;
                $('#product-variant-container').append(variantHtml);
            });

            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.product-variant-group').remove();
            });
        });

        let selectedFiles = [];

        $('#images').on('change', function() {
            selectedFiles = Array.from(this.files); // Reset selected files
            displayImages();
        });

        function displayImages() {
            $('#image-preview').empty();
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageHtml = `
                <div class="col-md-3 mb-2 preview-image" data-index="${index}">
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" alt="Image Preview">
                        <button type="button" class="btn btn-sm btn-danger remove-image-btn" style="position:absolute;top:5px;right:5px;">×</button>
                    </div>
                </div>
            `;
                    $('#image-preview').append(imageHtml);
                };
                reader.readAsDataURL(file);
            });
        }

        $(document).on('click', '.remove-image-btn', function() {
            const index = $(this).closest('.preview-image').data('index');
            selectedFiles.splice(index, 1);
            displayImages();
        });
    </script>
@endsection
