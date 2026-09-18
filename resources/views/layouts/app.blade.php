<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'URL Shortener')
    </title>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

    @yield('css')

</head>

<body>

    <div class="app-wrapper">

        {{-- Sidebar --}}
        <aside class="sidebar">

            <div class="logo">
                URL Shortener
            </div>

            <nav class="sidebar-menu">

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>


                {{-- Companies --}}
                @role('SuperAdmin')
                <a
                    href="{{ route('companies.index') }}"
                    class="{{ request()->routeIs('companies.*') ? 'active' : '' }}">
                    Companies
                </a>
                @endrole


                {{-- Users --}}
                @role('SuperAdmin')
                <a
                    href="{{ route('users.index') }}"
                    class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    Users
                </a>
                @endrole


                {{-- Invitations --}}
                @hasanyrole('SuperAdmin|Admin')
                <a
                    href="{{ route('invitations.index') }}"
                    class="{{ request()->routeIs('invitations.*') ? 'active' : '' }}">
                    Invitations
                </a>
                @endhasanyrole


                {{-- Short URLs --}}
                @hasanyrole('Admin|Member|Sales|Manager')
                <a
                    href="{{ route('short-urls.index') }}"
                    class="{{ request()->routeIs('short-urls.*') ? 'active' : '' }}">
                    Short URLs
                </a>
                @endhasanyrole

            </nav>

        </aside>


        {{-- Main Wrapper --}}
        <div class="main-wrapper">

            {{-- Header --}}
            <header class="top-header">

                <div>
                    <h3>
                        @yield('page-title', 'Dashboard')
                    </h3>
                </div>


                {{-- User Area --}}
                <div class="user-area">

                    <span>
                        {{ auth()->user()->name }}
                    </span>


                    {{-- Current Role --}}
                    <span class="role">

                        {{ auth()->user()->getRoleNames()->implode(', ') }}

                    </span>


                    {{-- Logout --}}
                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="logout-btn">
                            Logout
                        </button>

                    </form>

                </div>

            </header>


            {{-- Content --}}
            <main class="content">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html