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
                            <h6 class="card-title">courier</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.client-review.create') }}" class="btn btn-primary btn-icon">
                                    <i class="feather icon-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Shop Name</th>
                                        <th>Image</th>
                                        <th>status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($clientReviews as $key => $clientReview)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $clientReview->name }}</td>
                                            <td>{{ $clientReview->shop_name }}</td>
                                            <td>
                                                <img src="{{ asset($clientReview->image) }}" alt=""
                                                    style="width: 50px; height: 50px;">
                                            </td>
                                            <td>
                                                @if ($clientReview->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.client-review.edit', $clientReview->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>



                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $clientReview->id }}"
                                                        action="{{ route('admin.client-review.destroy', $clientReview->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $clientReview->id }})">
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
