<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'URL Shortener')
    </title>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    @yield('css')

</head>

<body>

    <div class="app-wrapper">

        <!-- Sidebar -->

        <aside class="sidebar">

            <div class="logo">
                URL Shortener
            </div>

            <nav class="sidebar-menu">

                {{-- Dashboard: All logged-in users --}}
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>


                {{-- Companies: SuperAdmin only --}}
                @if(auth()->user()->role === 'SuperAdmin')

                <a href="{{ route('companies.index') }}"
                    class="{{ request()->routeIs('companies.*') ? 'active' : '' }}">
                    Companies
                </a>

                @endif


                {{-- Users: SuperAdmin only --}}
                @if(auth()->user()->role === 'SuperAdmin')

                <a href="#"
                    class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    Users
                </a>

                @endif


                {{-- Invitations: SuperAdmin + Admin --}}
                @if(in_array(auth()->user()->role, ['SuperAdmin', 'Admin']))

                <a href="{{ route('invitations.index') }}"
                    class="{{ request()->routeIs('invitations.*') ? 'active' : '' }}">
                    Invitations
                </a>

                @endif


                {{-- Short URLs --}}
                @if(in_array(auth()->user()->role, ['Admin', 'Member']))

                <a href="#"
                    class="{{ request()->routeIs('short-urls.*') ? 'active' : '' }}">
                    Short URLs
                </a>

                @endif

            </nav>

        </aside>


        <!-- Main Area -->

        <div class="main-wrapper">

            <!-- Header -->

            <header class="top-header">

                <div>
                    <h3>@yield('page-title', 'Dashboard')</h3>
                </div>

                <div class="user-area">

                    <span>
                        {{ auth()->user()->name }}
                    </span>

                    <span class="role">
                        {{ auth()->user()->role }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit" class="logout-btn">
                            Logout
                        </button>

                    </form>

                </div>

            </header>


            <!-- Content -->

            <main class="content">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>