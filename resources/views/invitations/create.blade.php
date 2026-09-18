@extends('layouts.app')

@section('title', 'Create Invitation')
@section('page-title', 'Create Invitation')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Create Invitation
            </h2>

            <p class="text-muted mb-0">
                Invite a new user to your company.
            </p>
        </div>

        <a href="{{ route('invitations.index') }}"
           class="btn btn-outline-secondary">

            ← Back to Invitations

        </a>

    </div>


    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-1">
                Invitation Information
            </h5>

            <small class="text-muted">
                Enter the user details and select the appropriate role.
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


            <form action="{{ route('invitations.store') }}"
                  method="POST">

                @csrf


                <div class="row">


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
                                   placeholder="Enter user's email address"
                                   autofocus>


                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="form-text">
                                Invitation will be associated with this email address.
                            </div>

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


                            @if(auth()->user()->role === 'SuperAdmin')

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


                            @else

                                @php
                                    $adminCompany = $companies->first();
                                @endphp

                                <input type="hidden"
                                       name="company_id"
                                       value="{{ $adminCompany?->id }}">


                                <input type="text"
                                       class="form-control"
                                       value="{{ $adminCompany?->name }}"
                                       readonly>

                            @endif


                            @error('company_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            @if(auth()->user()->role === 'Admin')

                                <div class="form-text">
                                    You can only invite users to your own company.
                                </div>

                            @endif

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

                                    <option value="{{ $role }}"
                                        {{ old('role') === $role ? 'selected' : '' }}>

                                        {{ $role }}

                                    </option>

                                @endforeach

                            </select>


                            @error('role')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="form-text">

                                @if(auth()->user()->role === 'SuperAdmin')

                                    SuperAdmin can invite Admin, Member, Sales or Manager.

                                @elseif(auth()->user()->role === 'Admin')

                                    Admin can invite Sales or Manager only.

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- Invitation Information --}}
                <div class="alert alert-info">

                    <div class="d-flex">

                        <div class="me-3 fs-4">
                            ℹ️
                        </div>

                        <div>

                            <strong>
                                Invitation Information
                            </strong>

                            <p class="mb-0 mt-1">

                                The invitation will remain pending until the
                                invited user accepts it.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Send Invitation

                    </button>


                    <a href="{{ route('invitations.index') }}"
                       class="btn btn-light border">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection