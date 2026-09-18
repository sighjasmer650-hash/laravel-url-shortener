@extends('layouts.app')

@section('title', 'Create Short URL')

@section('page-title', 'Create Short URL')

@section('content')

<div class="container-fluid">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Create Short URL
            </h2>

            <p class="text-muted mb-0">
                Create a short URL for your company.
            </p>
        </div>

        <a href="{{ route('short-urls.index') }}"
            class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>

            Back to Short URLs

        </a>

    </div>


    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-1">
                Short URL Information
            </h5>

            <small class="text-muted">
                Enter the original URL. A short code will be generated automatically.
            </small>

        </div>


        <div class="card-body">

            {{-- Validation Errors --}}
            @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                    @endforeach

                </ul>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

            @endif


            {{-- Success --}}
            @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-1"></i>

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

            @endif


            <form action="{{ route('short-urls.store') }}"
                method="POST">

                @csrf


                {{-- Company --}}


                <div class="mb-3">
                    <label class="form-label">Company</label>

                    @hasanyrole('Sales|Manager')

                    {{-- Sales / Manager: Any company can be selected --}}
                    <select
                        name="company_id"
                        class="form-select @error('company_id') is-invalid @enderror"
                        required>
                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                        <option
                            value="{{ $company->id }}"
                            {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                        @endforeach
                    </select>

                    @error('company_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-text">
                        Sales / Manager can create a Short URL for any company.
                    </div>

                    @else

                    {{-- Other allowed role: Own company --}}
                    <input
                        type="text"
                        class="form-control"
                        value="{{ auth()->user()->company?->name ?? 'N/A' }}"
                        readonly>

                    <div class="form-text">
                        Short URL will be created under your company.
                    </div>

                    @endhasanyrole
                </div>



                <div class="mb-3">
                    <label for="original_url" class="form-label">
                        Original URL
                    </label>

                    <input
                        type="url"
                        name="original_url"
                        id="original_url"
                        class="form-control @error('original_url') is-invalid @enderror"
                        value="{{ old('original_url') }}"
                        placeholder="https://example.com/page"
                        required>

                    @error('original_url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>




                {{-- Information --}}
                <div class="alert alert-info">

                    <div class="d-flex">

                        <div class="me-3 fs-4">
                            🔗
                        </div>

                        <div>

                            <strong>
                                Automatic Short URL
                            </strong>

                            <p class="mb-0 mt-1">

                                The system will automatically generate
                                a unique short code after you submit this URL.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-link-45deg me-1"></i>

                        Generate Short URL

                    </button>

                    <a href="{{ route('short-urls.index') }}"
                        class="btn btn-light border">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>


</div>

@endsection