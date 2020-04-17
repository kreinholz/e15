<!doctype html>
<html lang='en'>

<head>
    <title>@yield('title', 'WisDOT SSO Program RTA Safety Inspections')</title>
    <meta charset='utf-8'>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='/css/rta_inspection.css' rel='stylesheet'>
    <link rel="shortcut icon" href="/favicon_dot.ico" type="image/vnd.microsoft.icon" id="favicon" />

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css2?family=Raleway&display=swap' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css2?family=Open+Sans&family=Raleway&display=swap' rel='stylesheet'>
    @yield('head')
</head>

<body>

    @if(session('flash-alert'))
    <div class='flash-alert'>
        {{ session('flash-alert') }}
    </div>
    @endif

    <header>
        <a href='/'><img src='/images/dot_logo_shadow.png' id='logo' alt='WisDOT Logo'></a>
        <span id='header'>Wisconsin Department of Transportation</span>
        <h3 class='alert alert-warning'>This is a mock-up for academic purposes, and not to be mistaken for an official
            government website. To visit the <strong>real</strong> WisDOT Rail Transit Safety
            Oversight website, click <a href='https://wisconsindot.gov/Pages/doing-bus/local-gov/astnce-pgms/transit/compliance/safety-rail.aspx'>here</a>.
        </h3>
        <nav>
            <ul>
                <li><a href='/'>Home</a></li>
                @if(Auth::id() == 1)
                    <li><a href='/checklists'>View Inspection Checklists</a></li>
                    <li><a href='/checklists/create'>Create a New Checklists</a></li>
                @endif
                @if(Auth::user())
                    <li><a href='/inspections/create'>Start a New Inspection</a></li>
                    <li><a href='/inspections'>List In-Progress/Completed Inspections</a></li>
                @endif
                <li><a href='/rta_safety_plan_checklist.pdf'>Inspection Checklist PDF</a></li>
<!-- login/logout code from https://hesweb.dev/e15/notes/laravel/auth-setup -->
                <li>
                    @if(!Auth::user())
                        <a href='/login'>Login</a>
                    @else
                        <form method='POST' id='logout' action='/logout'>
                            {{ csrf_field() }}
                            <a href='#' onClick='document.getElementById("logout").submit();'>Logout</a>
                        </form>
                    @endif
                </li>
            </ul>
        </nav>
    </header>

    <section id='main'>
        @yield('content')
    </section>

    <footer>
        <div id='footer'>
            <a href='/'><img src='/images/wi_logo_footer.png' id='logo' alt='Wisconsin Logo'></a>
        </div>
    </footer>

</body>

</html>