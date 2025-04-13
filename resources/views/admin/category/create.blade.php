@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Category</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Category</h4>
                        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                    name="name" type="text" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Business Type Field -->
                            <div class="mb-3">
                                <label for="business_type_id" class="form-label">Business Type</label>
                                <select class="form-control @error('business_type_id') is-invalid @enderror"
                                    name="business_type_id" required>
                                    @foreach (App\Models\BusinessType::all() as $business)
                                        <option value="{{ $business->id }}"
                                            {{ old('business_type_id') == $business->id ? 'selected' : '' }}>
                                            {{ $business->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('business_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Field -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input id="image" class="form-control @error('image') is-invalid @enderror"
                                    name="image" type="file">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Checkbox -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status" id="termsCheck"
                                        {{ old('status', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="termsCheck">Active</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
