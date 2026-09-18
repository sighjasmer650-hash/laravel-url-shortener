@extends('layouts.app')

@section('title', 'Invitations')
@section('page-title', 'Invitations')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Invitations
            </h2>

            <p class="text-muted mb-0">
                Manage user invitations in your system.
            </p>
        </div>

        <a href="{{ route('invitations.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>
            Create Invitation

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
                                ✉️
                            </span>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Invitations
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $invitations->total() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Invitation Table --}}
    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}
        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1 fw-bold">
                        Invitation List
                    </h5>

                    <small class="text-muted">
                        All user invitations
                    </small>

                </div>

                <span class="badge bg-light text-dark">

                    {{ $invitations->total() }}
                    Invitations

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
                                Company
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Expires
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

                        @forelse($invitations as $invitation)

                            <tr>

                                {{-- Serial Number --}}
                                <td class="px-4 fw-semibold">

                                    {{ $invitations->firstItem() + $loop->index }}

                                </td>


                                {{-- Company --}}
                                <td>

                                    <span class="fw-semibold">
                                        {{ $invitation->company->name }}
                                    </span>

                                </td>


                                {{-- Email --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="bg-primary text-white rounded-circle
                                                    d-flex align-items-center justify-content-center
                                                    me-3"
                                             style="width:42px;height:42px;">

                                            <i class="bi bi-envelope"></i>

                                        </div>

                                        <div>

                                            <div class="fw-semibold">

                                                {{ $invitation->email }}

                                            </div>

                                            <small class="text-muted">

                                                Invitation email

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Role --}}
                                <td>

                                    <span class="badge {{ $invitation->getRoleBadgeClass() }}">

                                        {{ $invitation->role }}

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="badge {{ $invitation->getStatusBadgeClass() }}">

                                        ● {{ ucfirst($invitation->status) }}

                                    </span>

                                </td>


                                {{-- Expiry --}}
                                <td>

                                    @if($invitation->expires_at)

                                        <div>

                                            <strong>
                                                {{ $invitation->expires_at->format('d M Y') }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                {{ $invitation->expires_at->format('h:i A') }}

                                            </small>

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            No expiry
                                        </span>

                                    @endif

                                </td>


                                {{-- Created Date --}}
                                <td>

                                    <div>

                                        <strong>
                                            {{ $invitation->created_at?->format('d M Y') }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $invitation->created_at?->format('h:i A') }}

                                        </small>

                                    </div>

                                </td>


                                {{-- Actions --}}
                                <td class="text-end px-4">

                                    <a href="{{ route('invitations.edit', $invitation) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        Edit

                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger delete-invitation-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteInvitationModal"
                                            data-id="{{ $invitation->id }}"
                                            data-email="{{ $invitation->email }}">

                                        Delete

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="fs-1 mb-2">
                                        ✉️
                                    </div>

                                    <h5 class="fw-bold">
                                        No Invitations Found
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Create your first invitation to get started.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($invitations->hasPages())

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-end">

                    {{ $invitations->links('pagination::bootstrap-5') }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- ================================================= --}}
{{-- DELETE INVITATION MODAL --}}
{{-- ================================================= --}}

<div class="modal fade"
     id="deleteInvitationModal"
     tabindex="-1"
     aria-labelledby="deleteInvitationModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            {{-- Modal Header --}}
            <div class="modal-header">

                <h5 class="modal-title fw-bold"
                    id="deleteInvitationModalLabel">

                    Delete Invitation

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

                    You are about to delete invitation for:

                </p>

                <p class="fw-bold fs-5 mb-3"
                   id="deleteInvitationEmail">
                </p>

                <div class="alert alert-warning text-start mb-0">

                    <small>

                        This invitation will be permanently deleted.

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


                <form id="deleteInvitationForm"
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
{{-- DELETE INVITATION JAVASCRIPT --}}
{{-- ================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const deleteButtons =
        document.querySelectorAll('.delete-invitation-btn');

    const deleteInvitationEmail =
        document.getElementById('deleteInvitationEmail');

    const deleteInvitationForm =
        document.getElementById('deleteInvitationForm');


    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const invitationId =
                this.getAttribute('data-id');

            const invitationEmail =
                this.getAttribute('data-email');


            deleteInvitationEmail.textContent =
                invitationEmail;


            deleteInvitationForm.action =
                "{{ url('invitations') }}/" + invitationId;

        });

    });

});

</script>

@endsection