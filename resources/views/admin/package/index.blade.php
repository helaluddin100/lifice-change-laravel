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
                            <h6 class="card-title">packages Type</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-icon">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Product Limit</th>
                                        <th>Landing Page </th>
                                        <th>Email markating </th>
                                        <th>Countrys </th>
                                        <th>Price </th>
                                        <th>Offer Price </th>
                                        <th>status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($packages as $key => $package)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $package->name }}</td>
                                            <td>{{ $package->product_limit }}</td>
                                            <td>{{ $package->page_limit }}</td>
                                            <td>{{ $package->email_marketing }}</td>
                                            <td>{{ $package->country->name }}</td>
                                            <td>{{ $package->price }}</td>
                                            <td>{{ $package->offer_price }}</td>
                                            <td>
                                                @if ($package->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.packages.edit', $package->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $package->id }}"
                                                        action="{{ route('admin.packages.destroy', $package->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $package->id }})">
                                                            <i data-feather="trash"></i>
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
