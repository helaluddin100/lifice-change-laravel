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
                            <h6 class="card-title">Colors</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.color.create') }}" class="btn btn-primary btn-icon">
                                    <i class="feather icon-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Color</th>
                                        <th>Business Type</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $key => $color)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $color->color }}</td>
                                            <td>{{ $color->businessType->name }}</td>
                                            <td>
                                                @if ($color->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.color.edit', $color->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $color->id }}"
                                                        action="{{ route('admin.color.destroy', $color->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $color->id }})">
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
