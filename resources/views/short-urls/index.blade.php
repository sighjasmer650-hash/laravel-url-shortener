@extends('layouts.app')

@section('title', 'Short URLs')
@section('page-title', 'Short URLs')

@section('content')

<div class="container-fluid">

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Short URLs
            </h2>

            <p class="text-muted mb-0">
                Manage and track your shortened URLs.
            </p>
        </div>

        @hasanyrole('Sales|Manager')
        <a href="{{ route('short-urls.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Short URL
        </a>
        @endhasanyrole

    </div>


    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show"
        role="alert">

        <i class="bi bi-check-circle me-1"></i>

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- ================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ================================================= --}}

    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">

        <i class="bi bi-exclamation-circle me-1"></i>

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

        <ul class="mb-0">

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


    {{-- ================================================= --}}
    {{-- STATISTICS --}}
    {{-- ================================================= --}}

    <div class="row mb-4">

        {{-- Total URLs --}}

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">

                            <span class="fs-3">
                                🔗
                            </span>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Short URLs
                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $shortUrls->total() }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Total Clicks --}}

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">

                            <span class="fs-3">
                                👆
                            </span>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total Clicks
                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $shortUrls->sum('clicks') }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- SHORT URL TABLE --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1 fw-bold">
                        Short URL List
                    </h5>

                    <small class="text-muted">
                        All shortened URLs
                    </small>

                </div>

                <span class="badge bg-light text-dark">

                    {{ $shortUrls->total() }}

                    {{ $shortUrls->total() == 1 ? 'URL' : 'URLs' }}

                </span>

            </div>


            <form method="GET" action="{{ route('short-urls.index') }}" class="row g-3 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Date Filter</label>

                    <select name="date_filter" class="form-select">
                        <option value="">All Dates</option>

                        <option value="today"
                            {{ request('date_filter') == 'today' ? 'selected' : '' }}>
                            Today
                        </option>

                        <option value="yesterday"
                            {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>
                            Yesterday
                        </option>

                        <option value="last_week"
                            {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>
                            Last Week
                        </option>

                        <option value="this_week"
                            {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>
                            This Week
                        </option>

                        <option value="last_month"
                            {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>
                            Last Month
                        </option>

                        <option value="this_month"
                            {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>
                            This Month
                        </option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                        Filter
                    </button>

                    <a
                        href="{{ route('short-urls.index') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>

                    <button
                        type="button"
                        class="btn btn-success"
                        onclick="downloadCSV()">
                        <i class="bi bi-download"></i>
                        Download
                    </button>

                </div>

            </form>



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

                            @if(auth()->user()->hasRole('SuperAdmin'))

                            <th>
                                Company
                            </th>

                            @endif

                            <th>
                                Original URL
                            </th>

                            <th>
                                Short URL
                            </th>

                            <th>
                                Created By
                            </th>

                            <th>
                                Clicks
                            </th>

                            <th>
                                Created
                            </th>

                            <th class="text-end px-4">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($shortUrls as $shortUrl)

                        <tr>

                            {{-- Serial Number --}}

                            <td class="px-4 fw-semibold">

                                {{ $shortUrls->firstItem() + $loop->index }}

                            </td>


                            {{-- Company --}}

                            @if(auth()->user()->hasRole('SuperAdmin'))

                            <td>

                                @if($shortUrl->company)

                                <span class="fw-semibold">

                                    {{ $shortUrl->company->name }}

                                </span>

                                @else

                                <span class="text-muted">
                                    N/A
                                </span>

                                @endif

                            </td>

                            @endif


                            {{-- Original URL --}}

                            <td style="max-width: 300px;">

                                <div class="text-truncate"
                                    title="{{ $shortUrl->original_url }}">

                                    <a href="{{ $shortUrl->original_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-decoration-none">

                                        {{ $shortUrl->original_url }}

                                    </a>

                                </div>

                            </td>


                            {{-- Short URL --}}

                            <td>
                                <div class="d-flex align-items-center gap-2"> <code>{{ $shortUrl->short_code }}</code> <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyShortCode('{{ $shortUrl->short_code }}')">copy</button> </div>
                            </td>


                            {{-- Created By --}}

                            <td>

                                @if($shortUrl->user)

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary text-white rounded-circle
                                                        d-flex align-items-center justify-content-center
                                                        me-2"
                                        style="width:35px;height:35px;">

                                        {{ strtoupper(substr($shortUrl->user->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="fw-semibold">

                                            {{ $shortUrl->user->name }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $shortUrl->user->email }}

                                        </small>

                                    </div>

                                </div>

                                @else

                                <span class="text-muted">
                                    N/A
                                </span>

                                @endif

                            </td>


                            {{-- Clicks --}}

                            <td>

                                <span class="badge bg-success-subtle text-success">

                                    {{ number_format($shortUrl->clicks) }}

                                </span>

                            </td>


                            {{-- Created Date --}}

                            <td>

                                @if($shortUrl->created_at)

                                <div>

                                    <strong>

                                        {{ $shortUrl->created_at->format('d M Y') }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $shortUrl->created_at->format('h:i A') }}

                                    </small>

                                </div>

                                @else

                                <span class="text-muted">
                                    N/A
                                </span>

                                @endif

                            </td>


                            {{-- Actions --}}

                            <td class="text-end px-4">

                                <button type="button"
                                    class="btn btn-sm btn-outline-danger delete-short-url-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteShortUrlModal"
                                    data-id="{{ $shortUrl->id }}"
                                    data-url="{{ url('/s/' . $shortUrl->short_code) }}">

                                    <i class="bi bi-trash"></i>
                                    Delete

                                </button>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="{{ auth()->user()->hasRole('SuperAdmin') ? 8 : 7 }}"
                                class="text-center py-5">

                                <div class="fs-1 mb-2">
                                    🔗
                                </div>

                                <h5 class="fw-bold">
                                    No Short URLs Found
                                </h5>



                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PAGINATION --}}
        {{-- ================================================= --}}

        @if($shortUrls->hasPages())

        <div class="card-footer bg-white">

            <div class="d-flex justify-content-end">

                {{ $shortUrls->links('pagination::bootstrap-5') }}

            </div>

        </div>

        @endif

    </div>

</div>



{{-- ================================================= --}}
{{-- DELETE MODAL --}}
{{-- ================================================= --}}

<div class="modal fade"
    id="deleteShortUrlModal"
    tabindex="-1"
    aria-labelledby="deleteShortUrlModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            {{-- Header --}}

            <div class="modal-header">

                <h5 class="modal-title fw-bold"
                    id="deleteShortUrlModalLabel">

                    Delete Short URL

                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            {{-- Body --}}

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

                <p class="fw-bold fs-5"
                    id="deleteShortUrlText">

                </p>

                <div class="alert alert-warning text-start mb-0">

                    <small>

                        This short URL will be permanently deleted.

                    </small>

                </div>

            </div>


            {{-- Footer --}}

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">

                    Cancel

                </button>


                <form id="deleteShortUrlForm"
                    method="POST">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                        class="btn btn-danger">

                        <i class="bi bi-trash"></i>

                        Yes, Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>



{{-- ================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ================================================= --}}

<script>
    function copyShortCode(code) {
        const textarea = document.createElement('textarea');

        textarea.value = code;
        document.body.appendChild(textarea);

        textarea.select();
        document.execCommand('copy');

        document.body.removeChild(textarea);

        alert('Short code copied!');
    }

    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | Delete Short URL
        |--------------------------------------------------------------------------
        */

        const deleteButtons =
            document.querySelectorAll('.delete-short-url-btn');

        const deleteText =
            document.getElementById('deleteShortUrlText');

        const deleteForm =
            document.getElementById('deleteShortUrlForm');


        deleteButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const shortUrlId =
                    this.getAttribute('data-id');

                const shortUrl =
                    this.getAttribute('data-url');


                deleteText.textContent =
                    shortUrl;


                deleteForm.action =
                    "{{ url('/short-urls') }}/" + shortUrlId;

            });

        });

    });


    function downloadCSV() {
        let rows = [];

        rows.push([
            'ID',
            'Company',
            'Created By',
            'Original URL',
            'Short Code',
            'Clicks',
            'Created At'
        ]);

        document.querySelectorAll('#shortUrlsTable tbody tr').forEach(function(row) {
            let columns = row.querySelectorAll('td');

            if (columns.length === 0) {
                return;
            }

            rows.push([
                columns[0]?.innerText.trim() || '',
                columns[1]?.innerText.trim() || '',
                columns[2]?.innerText.trim() || '',
                columns[3]?.innerText.trim() || '',
                columns[4]?.innerText.trim() || '',
                columns[5]?.innerText.trim() || '',
                columns[6]?.innerText.trim() || ''
            ]);
        });

        let csvContent = rows.map(function(row) {
            return row.map(function(value) {
                value = value.replace(/"/g, '""');
                return '"' + value + '"';
            }).join(',');
        }).join('\n');

        let blob = new Blob(
            [csvContent], {
                type: 'text/csv;charset=utf-8;'
            }
        );

        let url = URL.createObjectURL(blob);

        let link = document.createElement('a');

        link.href = url;
        link.download =
            'short-urls-' +
            new Date().toISOString().slice(0, 10) +
            '.csv';

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);

        URL.revokeObjectURL(url);
    }
</script>

@endsection