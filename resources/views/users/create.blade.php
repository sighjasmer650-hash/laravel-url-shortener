@extends('layouts.app')

@section('title', 'Create User')

@section('page-title', 'Create User')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Create User
            </h2>

            <p class="text-muted mb-0">
                Create a new user and assign a company and role.
            </p>

        </div>

        <a href="{{ route('users.index') }}"
           class="btn btn-outline-secondary">

            ← Back to Users

        </a>

    </div>


    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-1">
                User Information
            </h5>

            <small class="text-muted">
                Enter the user details and select the appropriate company and role.
            </small>

        </div>


        <div class="card-body">

            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="alert alert-danger">

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

                </div>

            @endif


            <form action="{{ route('users.store') }}"
                  method="POST">

                @csrf


                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="name"
                                   class="form-label fw-semibold">

                                Full Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter user's full name"
                                   autofocus>


                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="email"
                                   class="form-label fw-semibold">

                                Email Address

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter user's email address">


                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Password --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="password"
                                   class="form-label fw-semibold">

                                Password

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter password">


                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="form-text">
                                Password must be at least 8 characters.
                            </div>

                        </div>

                    </div>


                    {{-- Confirm Password --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="password_confirmation"
                                   class="form-label fw-semibold">

                                Confirm Password

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm password">

                        </div>

                    </div>


                    {{-- Company --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="company_id"
                                   class="form-label fw-semibold">

                                Company

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <select name="company_id"
                                    id="company_id"
                                    class="form-select @error('company_id') is-invalid @enderror">

                                <option value="">
                                    Select Company
                                </option>


                                @foreach($companies as $company)

                                    <option value="{{ $company->id }}"
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

                        </div>

                    </div>


                    {{-- Role --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="role"
                                   class="form-label fw-semibold">

                                User Role

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <select name="role"
                                    id="role"
                                    class="form-select @error('role') is-invalid @enderror">

                                <option value="">
                                    Select Role
                                </option>


                                @foreach($roles as $role)

                                    <option value="{{ $role->name }}"
                                        {{ old('role') === $role->name ? 'selected' : '' }}>

                                        {{ $role->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('role')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="form-text">
                                Role is managed dynamically using Spatie Permission.
                            </div>

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- User Information --}}
                <div class="alert alert-info">

                    <div class="d-flex">

                        <div class="me-3 fs-4">
                            ℹ️
                        </div>

                        <div>

                            <strong>
                                User Information
                            </strong>

                            <p class="mb-0 mt-1">

                                The user will be created with the selected company
                                and assigned role.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Create User

                    </button>


                    <a href="{{ route('users.index') }}"
                       class="btn btn-light border">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

