<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f7f8">
    <meta name="description" content="Lapor Tuntas — bukan sekadar lapor, tapi lacak sampai selesai.">
    <title>@yield('title', 'Lapor Tuntas — Kota Malang')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&family=Material+Symbols+Outlined:wght,FILL@400,500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="@yield('body-class')" data-map-url="{{ route('reports.map') }}" data-location-denied-url="{{ route('location.denied') }}">
    @hasSection('standalone')
        @yield('content')
    @else
        <header class="site-header">
            <div class="header-inner">
                <a href="{{ route('reports.map') }}" class="brand-lockup" aria-label="Lapor Tuntas, Kota Malang">
                    <span class="brand-mark"><span class="material-symbols-outlined" aria-hidden="true">location_on</span></span>
                    <span class="brand-copy"><strong>Lapor Tuntas</strong><small>Kota Malang</small></span>
                </a>
                <form class="header-search" method="GET" action="{{ route('tickets.track') }}" role="search">
                    <span class="material-symbols-outlined" aria-hidden="true">search</span>
                    <label class="sr-only" for="header-ticket-id">Cari ID tiket</label>
                    <input id="header-ticket-id" name="ticket_id" placeholder="Lacak tiket (cth. LT-8F3K-92QX)" value="{{ request('ticket_id') }}">
                </form>
                <nav class="main-nav" aria-label="Navigasi utama">
                    <a href="{{ route('reports.map') }}" @if(request()->routeIs('reports.map')) aria-current="page" @endif>Peta Laporan</a>
                    <a href="{{ route('tickets.track') }}" @if(request()->routeIs('tickets.*')) aria-current="page" @endif>Lacak tiket</a>
                    <a href="{{ route('staff.login') }}">Petugas</a>
                </nav>
                <a href="{{ route('reports.create') }}" class="button button-brand header-cta"><span class="material-symbols-outlined" aria-hidden="true">add</span><span>Buat laporan</span></a>
            </div>
        </header>
        @yield('content')
        <footer class="app-footer">
            <div class="app-footer-inner">
                <div><strong>Sistem Informasi Pengaduan Warga Kota Malang</strong><br><span>Pemerintah Kota Malang · Transparansi dan penanganan cepat</span></div>
                <div>Data demo · Tidak mewakili layanan pemerintah resmi</div>
            </div>
        </footer>
    @endif
    @stack('scripts')
</body>
</html>
