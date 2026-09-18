@extends('layouts.app')

@section('title', 'Edit Invitation')
@section('page-title', 'Edit Invitation')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Edit Invitation
            </h2>

            <p class="text-muted mb-0">
                Update invitation information.
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

            <div class="d-flex align-items-center">

                <div class="bg-primary text-white rounded-circle
                            d-flex align-items-center justify-content-center me-3"
                     style="width:45px;height:45px;">

                    <i class="bi bi-envelope"></i>

                </div>

                <div>

                    <h5 class="fw-bold mb-1">
                        Invitation Information
                    </h5>

                    <small class="text-muted">
                        Update the invitation details below.
                    </small>

                </div>

            </div>

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


            <form action="{{ route('invitations.update', $invitation) }}"
                  method="POST">

                @csrf

                @method('PUT')


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
                                   value="{{ old('email', $invitation->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter user's email address">

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

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
                                            {{ old('company_id', $invitation->company_id) == $company->id ? 'selected' : '' }}>

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

                                <div class="form-text">
                                    You can only use your own company.
                                </div>

                            @endif


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

                                    <option value="{{ $role }}"
                                        {{ old('role', $invitation->role) === $role ? 'selected' : '' }}>

                                        {{ $role }}

                                    </option>

                                @endforeach

                            </select>


                            @error('role')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-8">

                        <div class="mb-3">

                            <label for="status"
                                   class="form-label fw-semibold">

                                Status

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <select name="status"
                                    id="status"
                                    class="form-select @error('status') is-invalid @enderror">

                                <option value="pending"
                                    {{ old('status', $invitation->status) === 'pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="accepted"
                                    {{ old('status', $invitation->status) === 'accepted' ? 'selected' : '' }}>

                                    Accepted

                                </option>

                                <option value="expired"
                                    {{ old('status', $invitation->status) === 'expired' ? 'selected' : '' }}>

                                    Expired

                                </option>

                            </select>


                            @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Update Invitation

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