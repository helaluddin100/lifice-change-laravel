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
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control" name="name" type="text"
                                    value="{{ old('name', $template->name) }}">
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" name="status" id="termsCheck"
                                        {{ $template->status ? 'checked' : '' }}>
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
