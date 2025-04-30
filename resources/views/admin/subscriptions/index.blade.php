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
                            <h6 class="card-title">Subscription Type</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.subscription.create') }}" class="btn btn-primary btn-icon">
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
                                        <th>Plan</th>
                                        <th>Pay Amount</th>
                                        <th>Regular Amount</th>
                                        <th>Discount</th>
                                        <th>Payment Method</th>
                                        <th>Transaction ID</th>
                                        <th>Payment ID</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $key => $subscription)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $subscription->user->name }}</td>
                                            <td>{{ $subscription->plan }}</td>

                                            <!-- Pay Amount (Show latest payment) -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->amount : 'N/A' }}
                                            </td>

                                            <!-- Regular Amount -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->ragular_amount : 'N/A' }}
                                            </td>

                                            <!-- Discount -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->discount_amount : 'N/A' }}
                                            </td>

                                            <!-- Payment Method -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->payment_method : 'N/A' }}
                                            </td>

                                            <!-- Transaction ID -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->transaction_id : 'N/A' }}
                                            </td>

                                            <!-- Payment ID -->
                                            <td>{{ $subscription->payments->first() ? $subscription->payments->first()->payment_id : 'N/A' }}
                                            </td>

                                            <!-- Payment Date -->
                                            {{-- <td>{{ $subscription->payments->first() ? $subscription->payments->first()->payment_date->format('Y-m-d') : 'N/A' }}
                                            </td> --}}
                                            <td>{{ $subscription->payments->first() ? \Carbon\Carbon::parse($subscription->payments->first()->payment_date)->format('Y-m-d') : 'N/A' }}
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($subscription->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($subscription->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Expired</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <a href="{{ route('admin.subscription.edit', $subscription->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i class="feather icon-edit"></i>
                                                </a>



                                                {{--
                                                @if (Auth::user()->role_id == 1)
                                                    <form id="reject_form_{{ $subscription->id }}"
                                                        action="{{ route('admin.subscription.reject', $subscription->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('POST') <!-- Use POST method for rejection -->
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $subscription->id }})">
                                                            <i class="feather icon-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif --}}
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
