<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title","CDRRMO")</title>

    <link rel="icon" type="image/png" href="{{ asset('img/koronadal.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
        <div class="nav-header">
            <div class="title">
                <h1><a href="/dashboard"><img src="/img/CDRRMO_KOR.png" alt="koronadal" style="width: 180px; height:100px; margin-top:15;"></a></h1>
            </div>
            <div class="navdrop">
                <ul>
                    <li class="dropdown-parent">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="bi bi-person-circle" style="font-size:30px;"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout()">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    <div class="elements">
        <div class="nav-side">
            <nav>
                <a href="/dashboard" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> DASHBOARD
                </a>
                <a href="/users" class="{{ request()->is('users*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> USERS
                </a>
                <a href="/sensors" class="{{ request()->is('sensors*') ? 'active' : '' }}">
                    <i class="bi bi-broadcast"></i> SENSOR STATUS
                </a>
                <a href="/alerts" class="{{ request()->is('alerts*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle-fill"></i> ALERTS
                </a>
                <a href="/tasks" class="{{ request()->is('tasks*') ? 'active' : '' }}">
                    <i class="bi bi-card-list"></i> TASK MANAGER
                </a>
                <a href="#" class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i> FLOOD REPORTS
                </a>
                <a href="#" class="{{ request()->is('monitoring*') ? 'active' : '' }}">
                    <i class="bi bi-binoculars-fill"></i> MONITORING
                </a>
                <a href="#" class="{{ request()->is('history*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> REPORTS HISTORY
                </a>
                <a href="/evacuation" class="{{ request()->is('evacuation*') ? 'active' : '' }}">
                    <i class="bi bi-map-fill"></i> EVACUATION MAP
                </a>
            </nav>
        </div>
        <div class="main-content">
            @yield("content")
        </div>
    </div>
    <script src="/js/script.js"></script>
</body>
</html>