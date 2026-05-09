<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang phim - Lumière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050505;
            --panel: rgba(9, 12, 16, 0.78);
            --panel-strong: #0d1117;
            --line: rgba(255, 255, 255, 0.12);
            --text: #f5f5f5;
            --muted: #a3a3a3;
            --green: #00d760;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        a { color: inherit; text-decoration: none; }

        .app { min-height: 100vh; padding-left: 88px; }

        /* Sidebar */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 20;
            width: 88px;
            border-right: 1px solid var(--line);
            background: rgba(3, 5, 8, 0.92);
            backdrop-filter: blur(18px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 8px;
            gap: 22px;
        }

        .side-item {
            width: 70px;
            min-height: 62px;
            display: grid;
            place-items: center;
            gap: 6px;
            color: #8a8f98;
            font-size: 12px;
            text-align: center;
        }

        .side-icon {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #cbd5e1;
            font-size: 17px;
        }

        .side-item.active { color: var(--green); font-weight: 900; }
        .side-item.active .side-icon {
            border-color: rgba(0, 215, 96, 0.65);
            box-shadow: 0 0 24px rgba(0, 215, 96, 0.28);
            color: var(--green);
        }

        /* Topbar */
        .topbar {
            position: fixed;
            inset: 0 0 auto 88px;
            z-index: 15;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            padding: 0 clamp(20px, 4vw, 52px);
            background: linear-gradient(180deg, rgba(3, 5, 8, 0.92), rgba(3, 5, 8, 0.35));
            backdrop-filter: blur(18px);
        }

        .brand { color: white; font-size: 30px; font-weight: 900; letter-spacing: 0.08em; }
        .brand span { color: var(--green); }

        .menu {
            display: flex;
            gap: 4px;
            color: #d0d3da;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
        }

        .menu-item {
            position: relative;
        }

        .menu-item > a {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            border-radius: 10px;
            color: #d0d3da;
            transition: background 0.15s, color 0.15s;
        }

        .menu-item > a:hover,
        .menu-item:hover > a {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .menu-arrow { font-size: 10px; opacity: 0.6; }

        /* dropdown outer: transparent padding bridges the hover gap */
        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 210px;
            padding-top: 10px;
            z-index: 100;
        }

        .menu-item:hover .dropdown { display: block; }

        /* dropdown inner: the visible card */
        .dropdown-body {
            background: rgba(10, 12, 18, 0.98);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 8px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.65);
        }

        .dropdown a {
            display: block;
            padding: 9px 12px;
            border-radius: 10px;
            color: #c8ccd6;
            font-size: 13px;
            font-weight: 800;
        }

        .dropdown a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .dropdown-sep {
            height: 1px;
            background: var(--line);
            margin: 6px 0;
        }

        .dropdown-label {
            padding: 6px 12px 4px;
            color: #555;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-form {
            flex: 1;
        }

        .search-input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font: inherit;
        }

        .search-input::placeholder { color: #7b8190; }

        .profile-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            flex: 0 0 auto;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 999px;
            padding: 0 14px;
            height: 40px;
            background: rgba(255,255,255,0.07);
            color: #d1d5db;
            font: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }
        .profile-link:hover { border-color: rgba(0,215,96,0.5); color: #00d760; }
        .profile-link .avatar-dot {
            width: 24px; height: 24px; border-radius: 999px;
            background: rgba(0,215,96,0.2); border: 1px solid rgba(0,215,96,0.4);
            display: grid; place-items: center;
            font-size: 11px; font-weight: 800; color: #00d760; flex-shrink: 0;
        }
        .logout {
            border: 0; border-radius: 999px; padding: 0 16px; height: 40px;
            background: rgba(0,215,96,0.16); color: #bbf7d0;
            font: inherit; font-size: 13px; font-weight: 700; cursor: pointer;
        }
        .logout:hover { background: rgba(0,215,96,0.26); color: #fff; }

        /* Hero */
        .hero {
            position: relative;
            min-height: 680px;
            padding: 138px clamp(24px, 5vw, 72px) 54px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center 20%;
            filter: brightness(0.45) saturate(1.2);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(5,5,5,0.97) 0%, rgba(5,5,5,0.72) 40%, rgba(5,5,5,0.25) 72%, rgba(5,5,5,0.88) 100%),
                linear-gradient(0deg, #050505 0%, rgba(5,5,5,0.05) 40%);
        }

        .hero-art {
            position: absolute;
            inset: 88px 0 0 44%;
            opacity: 0.86;
            background:
                radial-gradient(circle at 54% 36%, rgba(255,255,255,0.8), transparent 8%),
                radial-gradient(circle at 68% 42%, rgba(244,114,182,0.35), transparent 12%),
                radial-gradient(circle at 36% 35%, rgba(234,179,8,0.35), transparent 18%),
                linear-gradient(115deg, transparent 0 20%, rgba(255,255,255,0.16) 20% 21%, transparent 21% 31%, rgba(255,255,255,0.1) 31% 32%, transparent 32%);
            filter: saturate(1.2);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 560px;
        }

        .back-dot {
            width: 48px; height: 48px;
            display: grid; place-items: center;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            color: white; font-size: 26px;
            margin-bottom: 32px;
        }

        h1 {
            margin: 0;
            font-size: clamp(46px, 7vw, 96px);
            line-height: 0.95;
            letter-spacing: -0.09em;
            text-transform: uppercase;
        }

        .meta {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 10px; margin-top: 22px;
            color: #e5e7eb; font-weight: 800;
        }

        .rank {
            border-radius: 6px; padding: 5px 9px;
            background: var(--green); color: #03130a;
            font-size: 12px; font-weight: 900;
        }

        .tags { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 22px; }

        .tag {
            border-radius: 999px; padding: 8px 14px;
            background: rgba(255,255,255,0.12);
            color: #e5e7eb; font-size: 13px; font-weight: 800;
        }

        .desc {
            max-width: 520px; margin-top: 24px;
            color: #d1d5db; line-height: 1.75;
            text-shadow: 0 2px 24px rgba(0,0,0,0.6);
        }

        .watch-btn {
            display: inline-flex; align-items: center; gap: 10px;
            margin-top: 28px; border-radius: 999px; padding: 15px 24px;
            background: var(--green); color: #03130a; font-weight: 900;
            box-shadow: 0 16px 36px rgba(0,215,96,0.24);
        }

        /* Content section */
        .content {
            position: relative; z-index: 3;
            padding: 96px clamp(24px, 5vw, 72px) 32px;
        }

        .section-title { margin: 0 0 18px; font-size: 30px; letter-spacing: -0.04em; }

        .chips { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; }

        .chip {
            border: 1px solid var(--line); border-radius: 999px;
            padding: 9px 13px; color: #d4d4d4;
            background: rgba(255,255,255,0.06);
            font-size: 13px; font-weight: 800;
        }

        .chip.active {
            border-color: var(--green); color: var(--green);
            background: rgba(0,215,96,0.1);
        }

        .movie-row {
            display: grid;
            grid-template-columns: repeat(5, minmax(180px, 1fr));
            gap: 16px;
        }

        .movie-card {
            min-height: 260px;
            display: flex; flex-direction: column; justify-content: flex-end;
            overflow: hidden;
            border: 1px solid var(--line); border-radius: 18px; padding: 15px;
            background: linear-gradient(135deg, rgba(0,215,96,0.18), rgba(255,255,255,0.08));
            box-shadow: 0 18px 50px rgba(0,0,0,0.32);
            position: relative;
            transition: transform 0.18s, box-shadow 0.18s;
        }

        .movie-card:hover { transform: translateY(-4px); box-shadow: 0 28px 60px rgba(0,0,0,0.46); }

        .movie-card:nth-child(2n) { background: linear-gradient(135deg, rgba(37,99,235,0.28), rgba(255,255,255,0.08)); }
        .movie-card:nth-child(3n) { background: linear-gradient(135deg, rgba(234,179,8,0.28), rgba(255,255,255,0.08)); }
        .movie-card:nth-child(4n) { background: linear-gradient(135deg, rgba(239,68,68,0.22), rgba(255,255,255,0.08)); }

        .card-poster {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
        }

        .card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 35%, rgba(0,0,0,0.9) 100%);
        }

        .card-body { position: relative; z-index: 2; }

        .movie-card small {
            color: #bbf7d0; font-size: 11px; font-weight: 900;
            letter-spacing: 0.12em; text-transform: uppercase;
        }

        .movie-card h2 { margin: 9px 0 6px; font-size: 20px; letter-spacing: -0.05em; }
        .movie-card p { margin: 0; color: #d1d5db; font-size: 13px; line-height: 1.5; }

        .star-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 12px; color: #fbbf24; font-weight: 900;
        }

        .empty {
            grid-column: 1 / -1; border: 1px solid var(--line);
            border-radius: 20px; padding: 24px;
            background: rgba(255,255,255,0.06); color: #d4d4d4;
        }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 32px; flex-wrap: wrap; }
        .pagination a, .pagination span {
            min-width: 40px; height: 40px;
            display: grid; place-items: center;
            border: 1px solid var(--line); border-radius: 10px;
            background: rgba(255,255,255,0.06);
            color: #d4d4d4; font-size: 14px; font-weight: 800;
        }
        .pagination a:hover { border-color: var(--green); color: var(--green); }
        .pagination .active span {
            border-color: var(--green); background: rgba(0,215,96,0.18); color: var(--green);
        }
        .pagination .disabled span { opacity: 0.4; cursor: not-allowed; }

        @media (max-width: 1180px) {
            .menu { display: none; }
            .movie-row { grid-template-columns: repeat(3, minmax(160px, 1fr)); }
        }

        @media (max-width: 760px) {
            .app { padding-left: 0; }
            .sidebar { position: static; width: 100%; height: auto; flex-direction: row; justify-content: flex-start; overflow-x: auto; }
            .topbar { position: static; inset: auto; height: auto; flex-direction: column; align-items: flex-start; padding: 18px 20px; }
            .top-actions, .search-form { width: 100%; min-width: 0; }
            .hero { min-height: 520px; padding: 54px 20px 42px; }
            .hero-art { inset: 120px 0 0 20%; opacity: 0.38; }
            .content { padding: 20px 20px 48px; }
            .movie-row { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    @php
        $catSlugNow = request('cat', '');
        $queryNow   = request('q', '');
        $sideActive = 'home';
        if ($catSlugNow === 'phim-bo') $sideActive = 'series';
        elseif ($catSlugNow === 'phim-le') $sideActive = 'single';
    @endphp

    <aside class="sidebar">
        <a class="side-item {{ $sideActive === 'home' ? 'active' : '' }}" href="{{ route('movies.index') }}">
            <span class="side-icon">⌂</span>
            <span>Trang chủ</span>
        </a>
        <a class="side-item {{ $sideActive === 'series' ? 'active' : '' }}" href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">
            <span class="side-icon">▣</span>
            <span>Phim bộ</span>
        </a>
        <a class="side-item {{ $sideActive === 'single' ? 'active' : '' }}" href="{{ route('movies.index', ['cat' => 'phim-le']) }}">
            <span class="side-icon">▭</span>
            <span>Phim lẻ</span>
        </a>
        <a class="side-item" href="{{ route('top-rated.index') }}">
            <span class="side-icon">★</span>
            <span>Rating</span>
        </a>
        <a class="side-item" href="{{ route('history.index') }}">
            <span class="side-icon">↺</span>
            <span>Lịch sử</span>
        </a>
        <a class="side-item" href="{{ route('watchlist.index') }}">
            <span class="side-icon">♥</span>
            <span>Yêu thích</span>
        </a>
    </aside>

    <main class="app">
        <header class="topbar">
            <a class="brand" href="{{ route('movies.index') }}">LUMIERE<span>.</span></a>
            <nav class="menu">
                {{-- Thể loại --}}
                <div class="menu-item">
                    <a href="#categories">Thể loại <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <div class="dropdown-label">Tất cả thể loại</div>
                            @foreach($categories as $cat)
                                <a href="{{ route('movies.index', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Phim Bộ --}}
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">Phim Bộ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">Tất cả phim bộ</a>
                            <div class="dropdown-sep"></div>
                            <div class="dropdown-label">Theo thể loại</div>
                            @foreach($categories->whereNotIn('slug', ['phim-bo']) as $cat)
                                <a href="{{ route('movies.index', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Phim Lẻ --}}
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['q' => 'Phim lẻ']) }}">Phim Lẻ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('movies.index', ['q' => 'Phim lẻ']) }}">Tất cả phim lẻ</a>
                            <div class="dropdown-sep"></div>
                            <div class="dropdown-label">Theo thể loại</div>
                            @foreach($categories as $cat)
                                <a href="{{ route('movies.index', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Phim chiếu rạp --}}
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['cat' => 'chieu-rap']) }}">Chiếu rạp <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('movies.index', ['cat' => 'chieu-rap']) }}">Tất cả phim chiếu rạp</a>
                        </div>
                    </div>
                </div>

                {{-- Diễn viên --}}
                <a class="menu-item" href="{{ route('actors.index') }}" style="padding:8px 12px; border-radius:10px">Diễn viên</a>

                {{-- Quốc gia --}}
                <div class="menu-item">
                    <a href="#">Quốc gia <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('movies.index', ['q' => 'Hàn Quốc']) }}">Hàn Quốc</a>
                            <a href="{{ route('movies.index', ['q' => 'Trung Quốc']) }}">Trung Quốc</a>
                            <a href="{{ route('movies.index', ['q' => 'Nhật Bản']) }}">Nhật Bản</a>
                            <a href="{{ route('movies.index', ['q' => 'Việt Nam']) }}">Việt Nam</a>
                            <a href="{{ route('movies.index', ['q' => 'Thái Lan']) }}">Thái Lan</a>
                            <a href="{{ route('movies.index', ['q' => 'Ấn Độ']) }}">Ấn Độ</a>
                            <a href="{{ route('movies.index', ['q' => 'Hồng Kông']) }}">Hồng Kông</a>
                            <a href="{{ route('movies.index', ['q' => 'Đài Loan']) }}">Đài Loan</a>
                            <a href="{{ route('movies.index', ['q' => 'Indonesia']) }}">Indonesia</a>
                            <a href="{{ route('movies.index', ['q' => 'Philippines']) }}">Philippines</a>
                            <a href="{{ route('movies.index', ['q' => 'Mỹ']) }}">Mỹ</a>
                            <a href="{{ route('movies.index', ['q' => 'Anh']) }}">Anh</a>
                            <a href="{{ route('movies.index', ['q' => 'Pháp']) }}">Pháp</a>
                            <a href="{{ route('movies.index', ['q' => 'Đức']) }}">Đức</a>
                            <a href="{{ route('movies.index', ['q' => 'Tây Ban Nha']) }}">Tây Ban Nha</a>
                            <a href="{{ route('movies.index', ['q' => 'Ý']) }}">Ý</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="top-actions">
                <form class="search-form" method="GET" action="{{ route('movies.index') }}">
                    <input class="search-input" type="search" name="q" value="{{ $query }}" placeholder="Tìm kiếm phim, thể loại...">
                </form>
                <a class="profile-link" href="{{ route('profile.edit') }}">
                    <span class="avatar-dot">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    Chào, {{ explode(' ', auth()->user()->name)[0] }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Đăng xuất</button>
                </form>
            </div>
        </header>

        <section class="content">
            <h2 class="section-title">
                @if($query)
                    Kết quả cho "{{ $query }}"
                @elseif($catSlug === 'phim-bo')
                    Kết quả cho Phim Bộ
                @elseif($catSlug === 'phim-le')
                    Kết quả cho Phim Lẻ
                @elseif($catSlug === 'chieu-rap')
                    Kết quả cho Phim Chiếu Rạp
                @elseif($catSlug !== '')
                    @php $activeCat = $categories->firstWhere('slug', $catSlug); @endphp
                    Kết quả cho Phim {{ $activeCat->name ?? $catSlug }}
                @else
                    Phim Đang Chiếu
                @endif
            </h2>

            <div id="categories" class="chips">
                <a class="chip {{ $catSlug === '' && $query === '' ? 'active' : '' }}" href="{{ route('movies.index') }}">Tất cả</a>
                @foreach ($categories as $cat)
                    <a class="chip {{ $catSlug === $cat->slug ? 'active' : '' }}"
                       href="{{ route('movies.index', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            <div class="movie-row">
                @forelse ($movies as $movie)
                    <a class="movie-card" href="{{ route('movies.show', $movie) }}">
                        @if($movie->poster)
                            <div class="card-poster" style="background-image: url('{{ $movie->posterUrl() }}')"></div>
                            <div class="card-overlay"></div>
                        @endif
                        <div class="card-body">
                            <small>{{ $movie->category->name ?? '' }} · {{ $movie->type }}</small>
                            <h2>{{ $movie->title }}</h2>
                            <p>
                                {{ $movie->year }}
                                @if($movie->rating > 0)
                                    · <span class="star-badge">★ {{ $movie->rating }}</span>
                                @endif
                            </p>
                        </div>
                    </a>
                @empty
                    @if($query)
                        <div class="empty">Không tìm thấy phim phù hợp với "{{ $query }}".</div>
                    @endif
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($movies->hasPages())
                <div class="pagination">
                    @foreach ($movies->links()->elements as $element)
                        @if (is_string($element))
                            <span class="disabled"><span>{{ $element }}</span></span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $movies->currentPage())
                                    <span class="active"><span>{{ $page }}</span></span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if($movies->hasNextPage())
                        <a href="{{ $movies->nextPageUrl() }}">›</a>
                    @endif
                </div>
            @endif
        </section>

    </main>
    @if(auth()->check() && auth()->user()->role === 'admin')
    <style>
        .mode-switcher { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; border-radius:999px; border:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); backdrop-filter:blur(16px); padding:4px; gap:2px; box-shadow:0 4px 28px rgba(0,0,0,0.5); }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:900; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.active { background:var(--green); color:#03130a; }
        .mode-btn:hover:not(.active) { color:#d1d5db; }
    </style>
    <div class="mode-switcher">
        <a href="{{ route('movies.index') }}" class="mode-btn active">Website</a>
        <a href="{{ route('admin.dashboard') }}" class="mode-btn">Admin</a>
    </div>
    @endif
</body>
</html>
