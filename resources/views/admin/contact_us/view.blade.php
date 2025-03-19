@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contacts</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Contact</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Contact Details</h4>

                        <div class="mb-4">
                            <strong>Name:</strong> {{ $contact->name }}
                        </div>
                        <div class="mb-4">
                            <strong>Email:</strong> {{ $contact->email }}
                        </div>
                        <div class="mb-4">
                            <strong>Phone:</strong> {{ $contact->phone }}
                        </div>
                        <div class="mb-4">
                            <strong>Subject:</strong> {{ $contact->subject }}
                        </div>
                        <div class="mb-4">
                            <strong>Message:</strong> {{ $contact->message }}
                        </div>

                        <div class="mb-4">
                            <strong>Status:</strong>
                            @if ($contact->status == 1)
                                <span class="badge bg-success">Read</span>
                            @else
                                <span class="badge bg-primary">Unread</span>
                            @endif
                        </div>

                        <a href="{{ route('admin.contact.index') }}" class="btn btn-primary">Back to Contacts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
