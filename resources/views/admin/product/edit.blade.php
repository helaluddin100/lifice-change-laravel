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

                        <form action="{{ route('admin.product.store') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Business Type</label>
                                        <select class="js-example-basic-single form-select" id="business_type"
                                            name="business_type" data-width="100%">
                                            @foreach ($businessTypes as $businessType)
                                                <option value="{{ $businessType->id }}">{{ $businessType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                                        <select class="js-example-basic-single form-select category-select" id="category"
                                            name="category_id" data-width="100%">
                                            <option value="">Select Category</option>
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
                                        <label class="form-label">Warranty</label>
                                        <input type="text" class="form-control" name="warranty" placeholder="Warranty">
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
                                                        <select class="js-example-basic-single form-select color-select"
                                                            name="product_colors[0][color]" data-width="100%">
                                                            <option value="">Select Color</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" class="form-control"
                                                            name="product_colors[0][price]" placeholder="Price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" class="form-control"
                                                            name="product_colors[0][quantity]" placeholder="Quantity">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <button type="button" class="btn btn-danger remove-color">×</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="add-color-btn" class="btn btn-primary">Add
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
                                                        <select class="js-example-basic-single form-select size-select"
                                                            name="product_sizes[0][size]" data-width="100%">
                                                            <option value="">Select Size</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" class="form-control"
                                                            name="product_sizes[0][price]" placeholder="Price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" class="form-control"
                                                            name="product_sizes[0][quantity]" placeholder="Quantity">
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
                                                        <input type="text" class="form-control"
                                                            name="product_details[0][detail_type]"
                                                            placeholder="e.g., Brand, Model">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Detail Description</label>
                                                        <input type="text" class="form-control"
                                                            name="product_details[0][detail_description]"
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
                                                            name="product_variant[0][option]"
                                                            placeholder="e.g., Red, Large">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Additional Cost</label>
                                                        <input type="text" class="form-control"
                                                            name="product_variant[0][cost]" placeholder="e.g., 10, 15">
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
                                        <input id="product_video" class="form-control" name="video" type="text">
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" checked name="status"
                                        id="termsCheck" value="1">
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
            // Function to populate select options and initialize Select2
            function populateSelectOptions(selectElement, options, valueKey, labelKey) {
                selectElement.empty().append('<option value="">Select Option</option>');
                $.each(options, function(key, option) {
                    selectElement.append('<option value="' + option[valueKey] + '">' + option[labelKey] +
                        '</option>');
                });
                selectElement.select2(); // Initialize select2 for this element
            }

            // Handle the business type change and make an AJAX request
            $('#business_type').on('change', function() {
                var businessTypeId = $(this).val();

                if (businessTypeId) {
                    $.ajax({
                        url: '{{ route('admin.product.getOptions', ':business_type_id') }}'.replace(
                            ':business_type_id', businessTypeId),
                        method: 'GET',
                        success: function(response) {
                            // Clear existing options in the initial select elements
                            $('.category-select').empty().append(
                                '<option value="">Select Category</option>');
                            $('.color-select').first()
                                .empty(); // Clear only the first color select initially
                            $('.size-select').first()
                                .empty(); // Clear only the first size select initially

                            // Populate categories
                            $.each(response.categories, function(key, category) {
                                $('.category-select').append('<option value="' +
                                    category.id + '">' + category.name + '</option>'
                                );
                            });

                            // Populate colors for the initial color select
                            populateSelectOptions($('.color-select').first(), response.colors,
                                'id', 'color');

                            // Populate sizes for the initial size select
                            populateSelectOptions($('.size-select').first(), response.sizes,
                                'id', 'size');

                            // Reinitialize select2 for the initial selects
                            $('.js-example-basic-single').select2();
                        },
                        error: function() {
                            alert('Error fetching options.');
                        }
                    });
                }
            });

            // Add Color Button - Adding new color field group
            $('#add-color-btn').on('click', function() {
                const businessTypeId = $('#business_type').val();
                if (!businessTypeId) {
                    alert('Please select a Business Type first.');
                    return;
                }
                const index = $('#color-price-container .color-price-group').length;
                const html = `
                    <div class="row color-price-group">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Color</label>
                                <select class="js-example-basic-single form-select color-select" name="product_colors[${index}][color]" data-width="100%">
                                    <option value="">Select Color</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="product_colors[${index}][price]" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="product_colors[${index}][quantity]" placeholder="Quantity">
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
                const newColorSelect = $(`[name="product_colors[${index}][color]"]`);
                $.ajax({
                    url: '{{ route('admin.product.getOptions', ':business_type_id') }}'.replace(
                        ':business_type_id', businessTypeId),
                    method: 'GET',
                    success: function(response) {
                        populateSelectOptions(newColorSelect, response.colors, 'id', 'color');
                        newColorSelect.select2();
                    },
                    error: function() {
                        alert('Error fetching colors.');
                    }
                });
            });

            // Remove Color Button - Remove color field group
            $(document).on('click', '.remove-color', function() {
                $(this).closest('.color-price-group').remove();
            });

            // Add Size Button - Adding new size field group
            $('#add-size-btn').on('click', function() {
                const businessTypeId = $('#business_type').val();
                if (!businessTypeId) {
                    alert('Please select a Business Type first.');
                    return;
                }
                const index = $('#size-price-container .size-price-group').length;
                const html = `
                    <div class="row size-price-group">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Size</label>
                                <select class="js-example-basic-single form-select size-select" name="product_sizes[${index}][size]" data-width="100%">
                                    <option value="">Select Size</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="product_sizes[${index}][price]"
                                    placeholder="Price">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="product_sizes[${index}][quantity]"
                                    placeholder="Quantity">
                            </div>
                        </div>
                        <div class="col-lg-1 d-flex align-items-end">
                            <div class="mb-3">
                                <button type="button" class="btn btn-danger remove-size">×</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#size-price-container').append(html);

                const newSizeSelect = $(`[name="product_sizes[${index}][size]"]`);
                $.ajax({
                    url: '{{ route('admin.product.getOptions', ':business_type_id') }}'.replace(
                        ':business_type_id', businessTypeId),
                    method: 'GET',
                    success: function(response) {
                        populateSelectOptions(newSizeSelect, response.sizes, 'id', 'size');
                        newSizeSelect.select2();
                    },
                    error: function() {
                        alert('Error fetching sizes.');
                    }
                });
            });

            // Remove Size Button
            $(document).on('click', '.remove-size', function() {
                $(this).closest('.size-price-group').remove();
            });

            // Add Detail Button
            $('#add-detail-btn').on('click', function() {
                const index = $('#product-detail-container .product-detail-group').length;
                const html = `
                    <div class="row product-detail-group">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Detail Type</label>
                                <input type="text" class="form-control" name="product_details[${index}][detail_type]"
                                    placeholder="e.g., Brand, Model">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Detail Description</label>
                                <input type="text" class="form-control"
                                    name="product_details[${index}][detail_description]"
                                    placeholder="e.g., Samsung, Cotton">
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

            // Remove Detail Button
            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.product-detail-group').remove();
            });

            // Add Variant Button
            $('#add-variant-btn').on('click', function() {
                const index = $('#product-variant-container .product-variant-group').length;
                const html = `
                    <div class="row product-variant-group">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Variant Option</label>
                                <input type="text" class="form-control"
                                    name="product_variant[${index}][option]" placeholder="e.g., Red, Large">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Additional Cost</label>
                                <input type="text" class="form-control"
                                    name="product_variant[${index}][cost]" placeholder="e.g., 10, 15">
                            </div>
                        </div>
                        <div class="col-lg-1 d-flex align-items-end">
                            <div class="mb-3">
                                 <button type="button" class="btn btn-danger remove-variant">×</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#product-variant-container').append(html);
            });

            // Remove Variant Button
            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.product-variant-group').remove();
            });

            // Image Preview
            $('#images').on('change', function() {
                $('#image-preview').empty(); // Clear previous previews
                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image-preview').append(
                                `<div class="col-md-3 mt-2"><img src="${e.target.result}" alt="Product Image" style="max-width: 100%; height: auto;"></div>`
                            );
                        }
                        reader.readAsDataURL(this.files[i]);
                    }
                }
            });
        });
    </script>
@endsection
