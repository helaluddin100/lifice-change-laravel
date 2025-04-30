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
                                <a href="{{ route('admin.courier.create') }}" class="btn btn-primary btn-icon">
                                    <i class="feather icon-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>User Name</th>
                                        <th>Courier Name</th>
                                        <th>Store ID</th>
                                        <th>Client ID</th>
                                        <th>Client Secret</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($couriers as $key => $courier)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $courier->user->name }}</td>
                                            <td>{{ $courier->courier_name }}</td>
                                            <td>{{ $courier->store_id }}</td>
                                            <td>{{ $courier->client_id }}</td>
                                            <td>{{ $courier->client_secret }}</td>
                                            <td>{{ $courier->username }}</td>
                                            <td>{{ $courier->password }}</td>
                                            <td>{{ $courier->created_at->format('d-m-Y') }}</td>


                                            <td>
                                                <a href="{{ route('admin.courier.edit', $courier->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>



                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $courier->id }}"
                                                        action="{{ route('admin.courier.destroy', $courier->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $courier->id }})">
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
