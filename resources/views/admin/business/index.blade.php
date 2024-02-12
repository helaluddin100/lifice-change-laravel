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
                            <h6 class="card-title">Business Type</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.business.create') }}" class="btn btn-primary btn-icon">
                                    <i data-feather="check-square"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>description</th>
                                        <th>Creator </th>
                                        <th>status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($business_types as $key => $business_type)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $business_type->name }}</td>
                                            <td>{!! $business_type->description !!}</td>
                                            <td>{{ $business_type->user->name }}</td>
                                            <td>
                                                @if ($business_type->status === '1')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-icon">
                                                    <i data-feather="check-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon">
                                                    <i data-feather="box"></i>
                                                </button>
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
