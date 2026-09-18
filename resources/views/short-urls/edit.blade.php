@extends('layouts.app')

@section('title', 'Edit Short URL')

@section('page-title', 'Edit Short URL')

@section('content')

<div class="container-fluid">


{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Edit Short URL
        </h2>

        <p class="text-muted mb-0">
            Update the original URL.
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

        <div class="d-flex align-items-center">

            <div class="bg-primary text-white rounded-circle
                        d-flex align-items-center justify-content-center me-3"
                 style="width:45px;height:45px;">

                <i class="bi bi-link-45deg"></i>

            </div>

            <div>

                <h5 class="fw-bold mb-1">
                    Short URL Information
                </h5>

                <small class="text-muted">
                    Update the original destination URL.
                </small>

            </div>

        </div>

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


        <form action="{{ route('short-urls.update', $shortUrl) }}"
              method="POST">

            @csrf

            @method('PUT')


            {{-- Short Code --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Short Code
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        #
                    </span>

                    <input type="text"
                           class="form-control"
                           value="{{ $shortUrl->short_code }}"
                           readonly>

                </div>

                <div class="form-text">
                    Short code cannot be changed.
                </div>

            </div>


            {{-- Company --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Company
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $shortUrl->company?->name ?? 'N/A' }}"
                       readonly>

            </div>


            {{-- Created By --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Created By
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $shortUrl->user?->name ?? 'N/A' }}"
                       readonly>

            </div>


            {{-- Original URL --}}
            <div class="mb-4">

                <label for="original_url"
                       class="form-label fw-semibold">

                    Original URL

                    <span class="text-danger">
                        *
                    </span>

                </label>

                <input type="url"
                       name="original_url"
                       id="original_url"
                       value="{{ old('original_url', $shortUrl->original_url) }}"
                       class="form-control @error('original_url') is-invalid @enderror"
                       placeholder="https://example.com/your-long-url"
                       required>

                @error('original_url')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Clicks --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Clicks
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $shortUrl->clicks }}"
                       readonly>

                <div class="form-text">
                    Click count is managed by the system.
                </div>

            </div>


            <hr class="my-4">


            {{-- Buttons --}}
            <div class="d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-check-circle me-1"></i>

                    Update Short URL

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
