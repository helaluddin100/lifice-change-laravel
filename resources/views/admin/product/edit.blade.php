@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Product</h4>

                        <form action="{{ route('admin.product.update', $product->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- To specify that it's an update request -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Business Type</label>
                                        <select class="js-example-basic-single form-select" id="business_type"
                                            name="business_type" data-width="100%">
                                            @foreach ($businessTypes as $businessType)
                                                <option value="{{ $businessType->id }}"
                                                    {{ $businessType->id == old('business_type', $product->business_types) ? 'selected' : '' }}>
                                                    {{ $businessType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" class="form-control" value="{{ old('name', $product->name) }}"
                                            placeholder="Name" name="name" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="js-example-basic-single form-select category-select" id="category"
                                            name="category_id" data-width="100%">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Sell/Current Price *</label>
                                        <input type="number" class="form-control" name="current_price"
                                            value="{{ old('current_price', $product->current_price) }}"
                                            placeholder="Sell/Current Price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Regular/Old Price</label>
                                        <input type="number" class="form-control" name="old_price"
                                            value="{{ old('old_price', $product->old_price) }}"
                                            placeholder="Regular/Old Price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity (Stock) *</label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ old('quantity', $product->quantity) }}"
                                            placeholder="Quantity (Stock)">
                                    </div>
                                </div>

                                <!-- Color Loop -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Color and Price</label>
                                        <div id="color-price-container">
                                            @foreach ($product->product_colors as $index => $color)
                                                <div class="row color-price-group">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Color</label>
                                                            <select class="js-example-basic-single form-select color-select"
                                                                name="product_colors[{{ $index }}][color]"
                                                                data-width="100%">
                                                                <option value="{{ $color['color'] }}">
                                                                    {{ \App\Models\DemoColor::find($color['color'])->color }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Price</label>
                                                            <input type="number" class="form-control"
                                                                name="product_colors[{{ $index }}][price]"
                                                                value="{{ $color['price'] }}" placeholder="Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Quantity</label>
                                                            <input type="number" class="form-control"
                                                                name="product_colors[{{ $index }}][quantity]"
                                                                value="{{ $color['quantity'] }}" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button"
                                                            class="btn btn-danger remove-color">×</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-color-btn" class="btn btn-primary">Add Color</button>
                                    </div>
                                </div>

                                <!-- Size Loop -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Size and Price</label>
                                        <div id="size-price-container">
                                            @foreach ($product->product_sizes as $index => $size)
                                                <div class="row size-price-group">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Size</label>
                                                            <select class="js-example-basic-single form-select size-select"
                                                                name="product_sizes[{{ $index }}][size]"
                                                                data-width="100%">
                                                                <option value="{{ $size['size'] }}">
                                                                    {{ \App\Models\DemoSize::find($size['size'])->size }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Price</label>
                                                            <input type="number" class="form-control"
                                                                name="product_sizes[{{ $index }}][price]"
                                                                value="{{ $size['price'] }}" placeholder="Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Quantity</label>
                                                            <input type="number" class="form-control"
                                                                name="product_sizes[{{ $index }}][quantity]"
                                                                value="{{ $size['quantity'] }}" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 d-flex align-items-end">
                                                        <div class="mb-3">
                                                            <button type="button"
                                                                class="btn btn-danger remove-size">×</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-size-btn" class="btn btn-primary">Add
                                            Size</button>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="easyMdeExample" rows="5">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-1">Product Details</h4>
                                        <p>You can add multiple product details for a single product here, like Brand,
                                            Model, Serial Number, Fabric Type, and EMI options, etc.</p>
                                        <h5 class="my-3">Is this detail required?</h5>
                                        <div id="product-detail-container">
                                            @foreach ($product->product_details as $index => $detail)
                                                <div class="row product-detail-group">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Detail Type</label>
                                                            <input type="text" class="form-control"
                                                                name="product_details[{{ $index }}][detail_type]"
                                                                value="{{ $detail['detail_type'] }}"
                                                                placeholder="e.g., Brand, Model">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="mb-3">
                                                            <label class="form-label">Detail Description</label>
                                                            <input type="text" class="form-control"
                                                                name="product_details[{{ $index }}][detail_description]"
                                                                value="{{ $detail['detail_description'] }}"
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
                                            @endforeach
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
                                                value="{{ old('variant_name', $product->variant_name) }}"
                                                placeholder="Enter the name of the variant (e.g., Color, Size, Material)">
                                        </div>

                                        <div id="product-variant-container">
                                            @foreach ($product->product_variant as $index => $variant)
                                                <div class="row product-variant-group">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Variant Option</label>
                                                            <input type="text" class="form-control"
                                                                name="product_variant[{{ $index }}][option]"
                                                                value="{{ $variant['option'] }}"
                                                                placeholder="e.g., Red, Large">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="mb-3">
                                                            <label class="form-label">Additional Cost</label>
                                                            <input type="text" class="form-control"
                                                                name="product_variant[{{ $index }}][cost]"
                                                                value="{{ $variant['cost'] }}"
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
                                            @endforeach
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
                                    <div id="image-preview" class="row mt-3">
                                        @foreach ($productImages as $image)
                                            <div class="col-md-3 mt-2">
                                                <img src="{{ asset($image->image_path) }}" alt="Product Image"
                                                    style="max-width: 100%; height: auto;">
                                            </div>
                                        @endforeach

                                    </div>
                                </div>





                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product_video" class="form-label">Product Video (YouTube Link)</label>
                                        <input id="product_video" class="form-control" name="video"
                                            value="{{ old('video', $product->video) }}" type="text">
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
                            <input class="btn btn-primary" type="submit" value="Update Product">
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
            function populateSelectOptions(selectElement, options, valueKey, labelKey) {
                selectElement.empty().append('<option value="">Select Option</option>');
                $.each(options, (key, option) => selectElement.append(
                    `<option value="${option[valueKey]}">${option[labelKey]}</option>`));
                selectElement.select2();
            }

            function fetchOptions(businessTypeId, callback) {
                if (!businessTypeId) return;
                $.ajax({
                    url: '{{ route('admin.product.getOptions', ':business_type_id') }}'.replace(
                        ':business_type_id', businessTypeId),
                    method: 'GET',
                    success: callback,
                    error: () => alert('Error fetching options.')
                });
            }

            $('#business_type').on('change', function() {
                const businessTypeId = $(this).val();
                fetchOptions(businessTypeId, (response) => {
                    populateSelectOptions($('.category-select'), response.categories, 'id', 'name');
                    populateSelectOptions($('.color-select').first(), response.colors, 'id',
                        'color');
                    populateSelectOptions($('.size-select').first(), response.sizes, 'id', 'size');
                });
            });

            function addFieldGroup(container, template, index, fetchCallback) {
                const html = template(index);
                container.append(html);
                const newSelect = container.find(`[name*="[${index}]"]`).filter('.form-select');
                fetchCallback(newSelect);
            }

            function removeFieldGroup(button, groupClass) {
                $(document).on('click', button, function() {
                    $(this).closest(groupClass).remove();
                });
            }

            $('#add-color-btn').on('click', function() {
                const businessTypeId = $('#business_type').val();
                if (!businessTypeId) return alert('Please select a Business Type first.');
                const index = $('#color-price-container .color-price-group').length;
                addFieldGroup($('#color-price-container'), (i) => `
                    <div class="row color-price-group">
                        <div class="col-lg-4"><select class="js-example-basic-single form-select color-select" name="product_colors[${i}][color]" data-width="100%"></select></div>
                        <div class="col-lg-4"><input type="number" class="form-control" name="product_colors[${i}][price]" placeholder="Price"></div>
                        <div class="col-lg-3"><input type="number" class="form-control" name="product_colors[${i}][quantity]" placeholder="Quantity"></div>
                        <div class="col-lg-1"><button type="button" class="btn btn-danger remove-color">×</button></div>
                    </div>`, index, (select) => fetchOptions(businessTypeId, (response) => populateSelectOptions(
                    select, response.colors, 'id', 'color')));
            });

            $('#add-size-btn').on('click', function() {
                const businessTypeId = $('#business_type').val();
                if (!businessTypeId) return alert('Please select a Business Type first.');
                const index = $('#size-price-container .size-price-group').length;
                addFieldGroup($('#size-price-container'), (i) => `
                    <div class="row size-price-group">
                        <div class="col-lg-4"><select class="js-example-basic-single form-select size-select" name="product_sizes[${i}][size]" data-width="100%"></select></div>
                        <div class="col-lg-4"><input type="number" class="form-control" name="product_sizes[${i}][price]" placeholder="Price"></div>
                        <div class="col-lg-3"><input type="number" class="form-control" name="product_sizes[${i}][quantity]" placeholder="Quantity"></div>
                        <div class="col-lg-1"><button type="button" class="btn btn-danger remove-size">×</button></div>
                    </div>`, index, (select) => fetchOptions(businessTypeId, (response) => populateSelectOptions(
                    select, response.sizes, 'id', 'size')));
            });

            $('#add-detail-btn').on('click', function() {
                const index = $('#product-detail-container .product-detail-group').length;
                addFieldGroup($('#product-detail-container'), (i) => `
                    <div class="row product-detail-group">
                        <div class="col-lg-6"><input type="text" class="form-control" name="product_details[${i}][detail_type]" placeholder="e.g., Brand, Model"></div>
                        <div class="col-lg-5"><input type="text" class="form-control" name="product_details[${i}][detail_description]" placeholder="e.g., Samsung, Cotton"></div>
                        <div class="col-lg-1"><button type="button" class="btn btn-danger remove-detail">×</button></div>
                    </div>`, index, () => {});
            });

            $('#add-variant-btn').on('click', function() {
                const index = $('#product-variant-container .product-variant-group').length;
                addFieldGroup($('#product-variant-container'), (i) => `
                    <div class="row product-variant-group">
                        <div class="col-lg-6"><input type="text" class="form-control" name="product_variant[${i}][option]" placeholder="e.g., Red, Large"></div>
                        <div class="col-lg-5"><input type="text" class="form-control" name="product_variant[${i}][cost]" placeholder="e.g., 10, 15"></div>
                        <div class="col-lg-1"><button type="button" class="btn btn-danger remove-variant">×</button></div>
                    </div>`, index, () => {});
            });

            removeFieldGroup('.remove-color', '.color-price-group');
            removeFieldGroup('.remove-size', '.size-price-group');
            removeFieldGroup('.remove-detail', '.product-detail-group');
            removeFieldGroup('.remove-variant', '.product-variant-group');

            $('#images').on('change', function() {
                $('#image-preview').empty();
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => $('#image-preview').append(
                        `<div class="col-md-3 mt-2"><img src="${e.target.result}" alt="Product Image" style="max-width: 100%; height: auto;"></div>`
                    );
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection
