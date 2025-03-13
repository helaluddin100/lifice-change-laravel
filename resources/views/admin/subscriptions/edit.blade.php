@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Business Type</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Business Type</h4>

                        <form action="{{ route('admin.subscription.update', $subscription->id) }}" method="Post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" class="form-control" name="name"
                                            value="{{ $subscription->user->name }}" type="text">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input id="phone" class="form-control" name="phone"
                                            value="{{ $subscription->user->phone }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" class="form-control" name="email"
                                            value="{{ $subscription->user->email }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input id="address" class="form-control" name="address"
                                            value="{{ $subscription->user->address }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input id="country" class="form-control" name="country"
                                            value="{{ $subscription->user->country }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ip" class="form-label">IP</label>
                                        <input id="ip" class="form-control" name="ip"
                                            value="{{ $subscription->user->ip }}" type="text">
                                    </div>
                                </div>

                                <h4 class="mb-3">Subscription Infromation</h4>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="plan" class="form-label">Plan</label>
                                        <input id="plan" class="form-control" name="plan"
                                            value="{{ $subscription->plan }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <input id="payment_method" class="form-control" name="payment_method"
                                            value="{{ $subscription->payment_method }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">amount</label>
                                        <input id="amount" class="form-control" name="amount"
                                            value="{{ $subscription->amount }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ragular_amount" class="form-label">Ragular Amount</label>
                                        <input id="ragular_amount" class="form-control" name="ragular_amount"
                                            value="{{ $subscription->ragular_amount }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_amount" class="form-label">Discount Amount</label>
                                        <input id="discount_amount" class="form-control" name="discount_amount"
                                            value="{{ $subscription->discount_amount }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tax_amount" class="form-label">Tax Amount</label>
                                        <input id="tax_amount" class="form-control" name="tax_amount"
                                            value="{{ $subscription->tax_amount }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="total_amount" class="form-label">Total Amount</label>
                                        <input id="total_amount" class="form-control" name="total_amount"
                                            value="{{ $subscription->total_amount }}" type="text">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="transaction_id" class="form-label">Transaction ID</label>
                                        <input id="transaction_id" class="form-control" name="transaction_id"
                                            value="{{ $subscription->transaction_id }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input id="start_date" class="form-control" name="start_date"
                                            value="{{ $subscription->start_date }}" type="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input id="end_date" class="form-control" name="end_date"
                                            value="{{ $subscription->end_date }}" type="date">
                                    </div>
                                </div>

                            </div>
                            <h4 class="mb-3">Subscription Infromation</h4>

                            <div class="table-responsive">
                                <table id="dataTableExample" class="table">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Amount</th>
                                            <th>Regular Amount</th>
                                            <th>Discount</th>
                                            <th>Payment Method</th>
                                            <th>Transaction ID</th>
                                            <th>Payment ID</th>
                                            <th>Payment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscription->payments as $key => $payment)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->ragular_amount }}</td>
                                                <td>{{ $payment->discount_amount }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ $payment->transaction_id }}</td>
                                                <td>{{ $payment->payment_id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}
                                                <td>
                                                    @if ($payment->status == 'completed')
                                                        <span class="badge bg-success">Success</span>
                                                    @elseif($payment->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>




                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="subscription_status" class="form-label">Subscription Status</label>
                                    <select id="subscription_status" class="form-control" name="subscription_status">
                                        <option value="pending"
                                            {{ $subscription->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="rejected"
                                            {{ $subscription->status == 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>
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
