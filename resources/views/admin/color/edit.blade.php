@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Color</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Color</h4>
                        <form action="{{ route('admin.color.update', $color->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="color" class="form-label">Name</label>
                                <input id="color" class="form-control" name="color" type="text"
                                    value="{{ old('color', $color->color) }}">
                            </div>
                            <div class="mb-3">
                                <label for="business_type_id" class="form-label">Business Type</label>
                                <select class="form-control @error('business_type_id') is-invalid @enderror"
                                    name="business_type_id" required>
                                    @foreach (App\Models\BusinessType::all() as $business)
                                        <option value="{{ $business->id }}"
                                            {{ old('business_type_id', $color->business_type_id) == $business->id ? 'selected' : '' }}>
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
                                        id="termsCheck" {{ old('status', $color->status) ? 'checked' : '' }}>
                                    {{-- <input type="checkbox" class="form-check-input" name="status" id="termsCheck"> --}}
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
