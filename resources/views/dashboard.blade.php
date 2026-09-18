@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <!-- Welcome -->
    <div class="welcome-section">

        <div class="welcome-content">

            <div>
                <h1>
                    Welcome back, {{ auth()->user()->name }} 👋
                </h1>

                <p>
                    Here's what's happening with your URL Shortener today.
                </p>
            </div>

        </div>

    </div>


    <!-- Dashboard Cards -->
    <div class="dashboard-cards">

        <!-- Role -->
        <div class="dashboard-card">

            <div class="card-top">

                <div class="card-icon role-icon">
                    R
                </div>

                <span class="card-label">
                    Your Role
                </span>

            </div>

            <div class="card-value">
                {{ auth()->user()->role }}
            </div>

            <div class="card-description">
                Current account role
            </div>

        </div>


        <!-- Email -->
        <div class="dashboard-card">

            <div class="card-top">

                <div class="card-icon email-icon">
                    @
                </div>

                <span class="card-label">
                    Email
                </span>

            </div>

            <div class="card-value email">
                {{ auth()->user()->email }}
            </div>

            <div class="card-description">
                Registered email address
            </div>

        </div>


        <!-- Company -->
        <div class="dashboard-card">

            <div class="card-top">

                <div class="card-icon company-icon">
                    C
                </div>

                <span class="card-label">
                    Company
                </span>

            </div>

            <div class="card-value">
                {{ auth()->user()->company?->name ?? 'N/A' }}
            </div>

            <div class="card-description">
                Associated company
            </div>

        </div>


        <!-- Status -->
        <div class="dashboard-card">

            <div class="card-top">

                <div class="card-icon status-icon">
                    ✓
                </div>

                <span class="card-label">
                    Account Status
                </span>

            </div>

            <div class="card-value status">
                Active
            </div>

            <div class="card-description">
                Your account is active
            </div>

        </div>

    </div>


    <!-- Quick Actions -->
    <div class="dashboard-section">

        <div class="section-header">

            <div>
                <h2>Quick Actions</h2>

                <p>
                    Manage your URL Shortener system
                </p>
            </div>

        </div>


        <div class="quick-actions">

            <a href="#" class="quick-action">
                <span class="action-icon">👥</span>

                <div>
                    <strong>Users</strong>

                    <small>
                        Manage users
                    </small>
                </div>
            </a>


            <a href="#" class="quick-action">
                <span class="action-icon">🏢</span>

                <div>
                    <strong>Companies</strong>

                    <small>
                        Manage companies
                    </small>
                </div>
            </a>


            <a href="#" class="quick-action">
                <span class="action-icon">✉</span>

                <div>
                    <strong>Invitations</strong>

                    <small>
                        Manage invitations
                    </small>
                </div>
            </a>


            <a href="#" class="quick-action">
                <span class="action-icon">🔗</span>

                <div>
                    <strong>Short URLs</strong>

                    <small>
                        View short URLs
                    </small>
                </div>
            </a>

        </div>

    </div>

@endsection