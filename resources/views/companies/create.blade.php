@extends('layouts.app')

@section('title', 'Create Company')
@section('page-title', 'Create Company')

@section('content')

<div class="container-fluid">


    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Create Company</h2>
            <p class="text-muted mb-0">
                Add a new company to the system.
            </p>
        </div>

        <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">
            ← Back to Companies
        </a>
    </div>

    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-1">Company Information</h5>
            <small class="text-muted">
                Enter the company details below.
            </small>
        </div>

        <div class="card-body">

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('companies.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Company Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter company name"
                                autofocus>

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Create Company
                    </button>

                    <a href="{{ route('companies.index') }}"
                        class="btn btn-light border">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>


</div>

@endsection