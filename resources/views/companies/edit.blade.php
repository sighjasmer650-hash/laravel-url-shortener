@extends('layouts.app')

@section('title', 'Edit Company')
@section('page-title', 'Edit Company')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Edit Company</h2>
            <p class="text-muted mb-0">
                Update company information.
            </p>
        </div>

        <a href="{{ route('companies.index') }}"
            class="btn btn-outline-secondary">
            ← Back to Companies
        </a>

    </div>

    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex align-items-center">

                <div class="bg-primary text-white rounded-circle
                        d-flex align-items-center justify-content-center me-3"
                    style="width:45px;height:45px;">

                    {{ strtoupper(substr($company->name, 0, 1)) }}

                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        {{ $company->name }}
                    </h5>

                    <small class="text-muted">
                        Company ID: #{{ $company->id }}
                    </small>
                </div>

            </div>

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

            <form action="{{ route('companies.update', $company) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="name"
                                class="form-label fw-semibold">
                                Company Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $company->name) }}"
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
                        Update Company
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