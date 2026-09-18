<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'URL Shortener')
    </title>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">

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

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="#">
                    Companies
                </a>

                <a href="#">
                    Users
                </a>

                <a href="#">
                    Invitations
                </a>

                <a href="#">
                    Short URLs
                </a>

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

