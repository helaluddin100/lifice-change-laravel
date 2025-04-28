@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit brand</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Brand</h4>
                        <form action="{{ route('admin.brand.update', $brand->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="brand" class="form-label">Name</label>
                                <input id="brand" class="form-control" name="brand" type="text"
                                    value="{{ old('name', $brand->brand) }}">
                            </div>
                            <div class="mb-3">
                                <label for="business_type_id" class="form-label">Business Type</label>
                                <select class="form-control @error('business_type_id') is-invalid @enderror"
                                    name="business_type_id" required>
                                    @foreach (App\Models\BusinessType::all() as $business)
                                        <option value="{{ $business->id }}"
                                            {{ old('business_type_id', $brand->business_type_id) == $business->id ? 'selected' : '' }}>
                                            {{ $business->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('business_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" name="status" value="1"
                                        id="termsCheck" {{ old('status', $brand->status) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
