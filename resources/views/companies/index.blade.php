@extends('layouts.app')

@section('title', 'Companies')
@section('page-title', 'Companies')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Companies</h2>
            <p class="text-muted mb-0">
                Manage all companies in your system.
            </p>
        </div>

        <a href="{{ route('companies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Add Company
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <span class="fs-3">🏢</span>
                        </div>

                        <div>
                            <small class="text-muted">
                                Total Companies
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $companies->total() }}
                            </h3>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- Company Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-1 fw-bold">Company List</h5>

                    <small class="text-muted">
                        All registered companies
                    </small>
                </div>

                <span class="badge bg-light text-dark">
                    {{ $companies->total() }} Companies
                </span>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="px-4">#</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($companies as $company)

                        <tr>

                            {{-- Serial Number --}}
                            <td class="px-4 fw-semibold">
                                {{ $companies->firstItem() + $loop->index }}
                            </td>

                            {{-- Company --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary text-white rounded-circle
                                                d-flex align-items-center justify-content-center
                                                me-3"
                                        style="width:42px;height:42px;">

                                        {{ strtoupper(substr($company->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $company->name }}
                                        </div>

                                        <small class="text-muted">
                                            Registered company
                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- Status --}}
                            <td>

                                <span class="badge bg-success-subtle text-success">
                                    ● Active
                                </span>

                            </td>

                            {{-- Created Date --}}
                            <td>

                                <div>

                                    <strong>
                                        {{ $company->created_at?->format('d M Y') }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        {{ $company->created_at?->format('h:i A') }}
                                    </small>

                                </div>

                            </td>

                            {{-- Actions --}}
                            <td class="text-end px-4">

                                <a href="{{ route('companies.edit', $company) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <button type="button"
                                    class="btn btn-sm btn-outline-danger delete-company-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCompanyModal"
                                    data-id="{{ $company->id }}"
                                    data-name="{{ $company->name }}">
                                    Delete
                                </button>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <div class="fs-1 mb-2">
                                    🏢
                                </div>

                                <h5 class="fw-bold">
                                    No Companies Found
                                </h5>

                                <p class="text-muted mb-0">
                                    No companies have been created yet.
                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Pagination --}}
        @if($companies->hasPages())

        <div class="card-footer bg-white">

            <div class="d-flex justify-content-end">

                {{ $companies->links('pagination::bootstrap-5') }}

            </div>

        </div>

        @endif

    </div>


</div>



<div class="modal fade"
    id="deleteCompanyModal"
    tabindex="-1"
    aria-labelledby="deleteCompanyModalLabel"
    aria-hidden="true">

    
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            {{-- Modal Header --}}
            <div class="modal-header">

                <h5 class="modal-title fw-bold"
                    id="deleteCompanyModalLabel">

                    Delete Company

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

                <p class="fw-bold fs-5 mb-3"
                    id="deleteCompanyName">
                </p>

                <div class="alert alert-warning text-start mb-0">

                    <small>
                        This company will be soft deleted.
                        The company record will remain in the database.
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

                <form id="deleteCompanyForm"
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
{{-- DELETE MODAL JAVASCRIPT --}}
{{-- ================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const deleteButtons = document.querySelectorAll('.delete-company-btn');

        const deleteCompanyName =
            document.getElementById('deleteCompanyName');

        const deleteCompanyForm =
            document.getElementById('deleteCompanyForm');


        deleteButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const companyId = this.getAttribute('data-id');

                const companyName = this.getAttribute('data-name');


                // Set company name inside modal
                deleteCompanyName.textContent = companyName;


                // Set delete form action
                deleteCompanyForm.action =
                    "{{ url('companies') }}/" + companyId;

            });

        });

    });
</script>

@endsection