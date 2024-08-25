@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Business Type</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Business Type</h4>

                        <form action="{{ route('admin.business.update', $business_type->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control" name="name" type="text"
                                    value="{{ $business_type->name }}">
                            </div>

                            <div class="mb-3">

                                <label for="description" class="form-label">Description</label>

                                <textarea class="form-control" name="description" id="easyMdeExample" rows="5">{!! $business_type->description !!}</textarea>

                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="hidden" name="status" value="0">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" name="status" id="termsCheck"
                                        value="1" {{ $business_type->status == 1 ? 'checked' : '' }}>
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
