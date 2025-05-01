@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Courier Type</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Courier Type</h4>

                        <form action="{{ route('admin.courier.update', $courier->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control" value="{{ $courier->name }}" name="name"
                                    type="text">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input id="image" class="form-control" name="image" type="file">

                                @if ($courier->image)
                                    <img src="{{ asset($courier->image) }}" width="100">
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" name="status" value="1"
                                        id="termsCheck" {{ old('status', $courier->status) ? 'checked' : '' }}>
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
