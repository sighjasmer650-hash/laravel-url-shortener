@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Users
            </h2>

            <p class="text-muted mb-0">
                Manage users in your system.
            </p>
        </div>

        <a href="{{ route('users.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>
            Create User

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show"
        role="alert">

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">

        {{ session('error') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">

        <strong>
            Please fix the following error:
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


    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">

                            <span class="fs-3">
                                👤
                            </span>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Users
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $users->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- User Table --}}
    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}
        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1 fw-bold">
                        User List
                    </h5>

                    <small class="text-muted">
                        All registered users
                    </small>

                </div>

                <span class="badge bg-light text-dark">

                    {{ $users->count() }}
                    Users

                </span>

            </div>

        </div>


        {{-- Table --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                #
                            </th>

                            <th>
                                User
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Company
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Created Date
                            </th>

                            <th class="text-end px-4">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                        <tr>

                            {{-- Serial Number --}}
                            <td class="px-4 fw-semibold">

                                {{ $loop->iteration }}

                            </td>


                            {{-- User --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary text-white rounded-circle
                                                    d-flex align-items-center justify-content-center
                                                    me-3"
                                        style="width:42px;height:42px;">

                                        <i class="bi bi-person"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold">

                                            {{ $user->name }}

                                        </div>


                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <i class="bi bi-envelope me-2 text-muted"></i>

                                    {{ $user->email }}

                                </div>

                            </td>


                            {{-- Company --}}
                            <td>

                                @if($user->company)

                                <span class="fw-semibold">

                                    {{ $user->company->name }}

                                </span>

                                @else

                                <span class="text-muted">
                                    No Company
                                </span>

                                @endif

                            </td>


                            {{-- Role --}}
                            <td>

                                @forelse($user->getRoleNames() as $role)

                                @php
                                $roleClass = match($role) {
                                'SuperAdmin' => 'bg-danger',
                                'Admin' => 'bg-primary',
                                'Manager' => 'bg-warning text-dark',
                                'Sales' => 'bg-success',
                                'Member' => 'bg-secondary',
                                default => 'bg-dark',
                                };
                                @endphp

                                <span class="badge {{ $roleClass }}">

                                    {{ $role }}

                                </span>

                                @empty

                                <span class="badge bg-light text-dark">
                                    No Role
                                </span>

                                @endforelse

                            </td>


                            {{-- Created Date --}}
                            <td>

                                <div>

                                    <strong>
                                        {{ $user->created_at?->format('d M Y') }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $user->created_at?->format('h:i A') }}

                                    </small>

                                </div>

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-4">

                                <a href="{{ route('users.edit', $user) }}"
                                    class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-pencil"></i>
                                    Edit

                                </a>


                                @if(!$user->hasRole('SuperAdmin'))

                                <button type="button"
                                    class="btn btn-sm btn-outline-danger delete-user-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}">

                                    <i class="bi bi-trash"></i>
                                    Delete

                                </button>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <div class="fs-1 mb-2">
                                    👤
                                </div>

                                <h5 class="fw-bold">
                                    No Users Found
                                </h5>

                                <p class="text-muted mb-3">
                                    Create your first user to get started.
                                </p>

                                <a href="{{ route('users.create') }}"
                                    class="btn btn-primary">

                                    <i class="bi bi-plus-lg"></i>
                                    Create User

                                </a>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- DELETE USER MODAL --}}
{{-- ================================================= --}}

<div class="modal fade"
    id="deleteUserModal"
    tabindex="-1"
    aria-labelledby="deleteUserModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            {{-- Modal Header --}}
            <div class="modal-header">

                <h5 class="modal-title fw-bold"
                    id="deleteUserModalLabel">

                    Delete User

                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            {{-- Modal Body --}}
            <div class="modal-body text-center py-4">

                <div class="fs-1 mb-3">
                    ⚠️
                </div>

                <h5 class="fw-bold">
                    Are you sure?
                </h5>

                <p class="text-muted mb-2">

                    You are about to delete:

                </p>

                <p class="fw-bold fs-5 mb-1"
                    id="deleteUserName">
                </p>

                <p class="text-muted"
                    id="deleteUserEmail">
                </p>

                <div class="alert alert-warning text-start mb-0">

                    <small>
                        This user will be permanently deleted.
                    </small>

                </div>

            </div>


            {{-- Modal Footer --}}
            <div class="modal-footer">

                <button type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">

                    Cancel

                </button>


                <form id="deleteUserForm"
                    method="POST">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                        class="btn btn-danger">

                        Yes, Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- DELETE USER JAVASCRIPT --}}
{{-- ================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const deleteButtons =
            document.querySelectorAll('.delete-user-btn');

        const deleteUserName =
            document.getElementById('deleteUserName');

        const deleteUserEmail =
            document.getElementById('deleteUserEmail');

        const deleteUserForm =
            document.getElementById('deleteUserForm');


        deleteButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const userId =
                    this.getAttribute('data-id');

                const userName =
                    this.getAttribute('data-name');

                const userEmail =
                    this.getAttribute('data-email');


                deleteUserName.textContent =
                    userName;

                deleteUserEmail.textContent =
                    userEmail;


                deleteUserForm.action =
                    "{{ url('users') }}/" + userId;

            });

        });

    });
</script>

@endsection