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
                            <h6 class="card-title">Upazila</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.upazila.create') }}" class="btn btn-primary btn-icon">
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
                                        <th>Country</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($upazilas as $key => $upazila)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $upazila->name }}</td>
                                            <td>
                                                @if ($upazila->country)
                                                    {{ $upazila->country->name }}
                                                @else
                                                    No Country Assigned
                                                @endif
                                            </td>
                                            <td>
                                                @if ($upazila->division)
                                                    {{ $upazila->division->name }}
                                                @else
                                                    No Country Assigned
                                                @endif
                                            </td>
                                            <td>
                                                @if ($upazila->district)
                                                    {{ $upazila->district->name }}
                                                @else
                                                    No Country Assigned
                                                @endif
                                            </td>
                                            <td>
                                                @if ($upazila->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.upazila.edit', $upazila->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $upazila->id }}"
                                                        action="{{ route('admin.upazila.destroy', $upazila->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $upazila->id }})">
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
