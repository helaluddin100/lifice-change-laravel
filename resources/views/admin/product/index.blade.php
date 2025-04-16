@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Table</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="card-title">Product</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-icon">
                                    <i class="feather icon-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Business Type</th>
                                        <th>Category</th>
                                        <th>Buy Price</th>
                                        <th>Sell Price</th>
                                        <th>Stock</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <!-- Show first product image if exists -->
                                            <td>
                                                <!-- Check if images relationship exists and has images -->
                                                @if ($product->demoimages && $product->demoimages->isNotEmpty())
                                                    <!-- Ensure image path is correct -->
                                                    <img src="{{ asset($product->demoimages->first()->image_path) }}"
                                                        alt="Product Image" style="max-width: 80px; height: auto;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>



                                            <!-- Product name -->
                                            <td>{{ $product->name }}</td>

                                            <!-- Business Type -->
                                            <td>
                                                {{ \App\Models\BusinessType::find($product->business_types)->name }}
                                            </td>

                                            <!-- Category -->
                                            <td>
                                                {{ \App\Models\DemoCategory::find($product->category_id)->name }}
                                            </td>

                                            <!-- Buy Price -->
                                            <td>{{ $product->buy_price }}</td>

                                            <!-- Sell Price -->
                                            <td>{{ $product->current_price }}</td>

                                            <!-- Stock Quantity -->
                                            <td>{{ $product->quantity }}</td>

                                            <!-- Color -->
                                            <td>
                                                @foreach ($product->product_colors as $color)
                                                    {{ \App\Models\DemoColor::find($color['color'])->color }}
                                                @endforeach
                                            </td>

                                            <!-- Size -->
                                            <td>
                                                @foreach ($product->product_sizes as $size)
                                                    {{ \App\Models\DemoSize::find($size['size'])->size }}
                                                @endforeach
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($product->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $product->id }}"
                                                        action="{{ route('admin.product.destroy', $product->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $product->id }})">
                                                            <i class="feather icon-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
