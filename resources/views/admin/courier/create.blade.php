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

                        <form action="{{ route('admin.courier.store') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control" name="name" type="text">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input id="image" class="form-control" name="image" type="file">
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input" checked name="status" id="termsCheck">
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
