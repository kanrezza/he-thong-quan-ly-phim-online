<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lumière – Xem phim không giới hạn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050505;
            --line: rgba(255,255,255,0.12);
            --text: #f5f5f5;
            --muted: #a3a3a3;
            --green: #00d760;
            --red: #e50914;
        }

        * { box-sizing:border-box; }

        body {
            margin:0; min-height:100vh; overflow-x:hidden;
            background:var(--bg); color:var(--text);
            font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        a { color:inherit; text-decoration:none; }

        /* ── Sidebar ── */
        .sidebar {
            position:fixed; inset:0 auto 0 0; z-index:20; width:88px;
            border-right:1px solid var(--line);
            background:rgba(3,5,8,0.92); backdrop-filter:blur(18px);
            display:flex; flex-direction:column; align-items:center;
            padding:24px 8px; gap:22px;
        }
        .side-item {
            width:70px; min-height:62px; display:grid;
            place-items:center; gap:6px;
            color:#8a8f98; font-size:11px; text-align:center;
        }
        .side-icon {
            width:30px; height:30px; display:grid; place-items:center;
            border:1px solid rgba(255,255,255,0.12); border-radius:12px;
            color:#cbd5e1; font-size:17px;
        }
        .side-item.active { color:var(--green); font-weight:900; }
        .side-item.active .side-icon {
            border-color:rgba(0,215,96,0.65);
            box-shadow:0 0 24px rgba(0,215,96,0.28);
            color:var(--green);
        }
        .side-item.locked { opacity:0.45; cursor:pointer; }
        .side-item.locked:hover { opacity:0.75; }

        /* ── Topbar ── */
        .topbar {
            position:fixed; inset:0 0 auto 88px; z-index:15; height:76px;
            display:flex; align-items:center; justify-content:space-between;
            gap:22px; padding:0 clamp(20px,4vw,52px);
            background:linear-gradient(180deg,rgba(3,5,8,0.92),rgba(3,5,8,0.35));
            backdrop-filter:blur(18px);
        }
        .brand { color:white; font-size:30px; font-weight:900; letter-spacing:0.08em; }
        .brand span { color:var(--green); }

        /* Nav menu */
        .menu {
            display:flex; gap:4px; color:#d0d3da;
            font-size:14px; font-weight:800; white-space:nowrap;
        }
        .menu-item { position:relative; }
        .menu-item > a {
            display:flex; align-items:center; gap:5px;
            padding:8px 12px; border-radius:10px; color:#d0d3da;
            transition:background 0.15s, color 0.15s;
        }
        .menu-item > a:hover,
        .menu-item:hover > a { background:rgba(255,255,255,0.1); color:white; }
        .menu-plain { padding:8px 12px; border-radius:10px; color:#d0d3da; }
        .menu-plain:hover { background:rgba(255,255,255,0.1); color:white; }
        .menu-arrow { font-size:10px; opacity:0.6; }

        .dropdown { display:none; position:absolute; top:100%; left:0; min-width:210px; padding-top:10px; z-index:100; }
        .menu-item:hover .dropdown { display:block; }
        .dropdown-body {
            background:rgba(10,12,18,0.98); border:1px solid var(--line);
            border-radius:16px; padding:8px;
            backdrop-filter:blur(20px); box-shadow:0 20px 60px rgba(0,0,0,0.65);
        }
        .dropdown a { display:block; padding:9px 12px; border-radius:10px; color:#c8ccd6; font-size:13px; font-weight:800; }
        .dropdown a:hover { background:rgba(255,255,255,0.1); color:white; }
        .dropdown-sep { height:1px; background:var(--line); margin:6px 0; }
        .dropdown-label { padding:6px 12px 4px; color:#555; font-size:11px; font-weight:900; letter-spacing:0.08em; text-transform:uppercase; }

        /* Top-right actions */
        .top-actions { display:flex; align-items:center; gap:10px; }
        .search-form { flex:1; min-width:220px; }
        .search-input {
            width:100%; border:1px solid var(--line); border-radius:16px;
            padding:12px 14px; background:rgba(255,255,255,0.08);
            color:white; font:inherit;
        }
        .search-input::placeholder { color:#7b8190; }
        .btn-login {
            border:1px solid rgba(0,215,96,0.35); border-radius:999px;
            padding:11px 18px; background:transparent;
            color:#bbf7d0; font:inherit; font-size:14px; font-weight:900; cursor:pointer;
            white-space:nowrap;
        }
        .btn-login:hover { background:rgba(0,215,96,0.1); }
        .btn-register {
            border:0; border-radius:999px; padding:11px 20px;
            background:#00d760; color:#03130a;
            font:inherit; font-size:14px; font-weight:900; cursor:pointer;
            white-space:nowrap;
        }
        .btn-register:hover { background:#00bf55; }

        /* ── Hero ── */
        .hero {
            position:relative; min-height:680px;
            padding:138px clamp(24px,5vw,72px) 54px;
            overflow:hidden;
        }
        .hero-bg {
            position:absolute; inset:0;
            background-size:cover; background-position:center 20%;
            filter:brightness(0.4) saturate(1.1);
        }
        .hero-overlay {
            position:absolute; inset:0;
            background:
                linear-gradient(90deg,rgba(5,5,5,0.97) 0%,rgba(5,5,5,0.72) 40%,rgba(5,5,5,0.25) 72%,rgba(5,5,5,0.88) 100%),
                linear-gradient(0deg,#050505 0%,rgba(5,5,5,0.05) 40%);
        }
        .hero-no-poster {
            position:absolute; inset:0;
            background:
                radial-gradient(circle at 70% 30%,rgba(0,215,96,0.18),transparent 50%),
                linear-gradient(135deg,#051309,#070709 52%,#0c0f18);
        }
        .hero-content { position:relative; z-index:2; max-width:560px; }
        .back-dot {
            width:48px; height:48px; display:grid; place-items:center;
            border:1px solid var(--line); border-radius:999px;
            background:rgba(255,255,255,0.08); color:white; font-size:26px;
            margin-bottom:32px;
        }
        h1 {
            margin:0; font-size:clamp(46px,7vw,96px);
            line-height:0.95; letter-spacing:-0.09em; text-transform:uppercase;
        }
        .meta {
            display:flex; flex-wrap:wrap; align-items:center;
            gap:10px; margin-top:22px; color:#e5e7eb; font-weight:800;
        }
        .rank {
            border-radius:6px; padding:5px 9px;
            background:#00d760; color:#03130a; font-size:12px; font-weight:900;
        }
        .tags { display:flex; flex-wrap:wrap; gap:10px; margin-top:22px; }
        .tag {
            border-radius:999px; padding:8px 14px;
            background:rgba(255,255,255,0.12); color:#e5e7eb;
            font-size:13px; font-weight:800;
        }
        .desc { max-width:520px; margin-top:24px; color:#d1d5db; line-height:1.75; }
        .hero-actions { display:flex; flex-wrap:wrap; gap:12px; margin-top:28px; }
        .watch-btn {
            display:inline-flex; align-items:center; gap:10px;
            border-radius:999px; padding:15px 24px;
            background:#00d760; color:#03130a; font-weight:900;
            border:0; cursor:pointer; font:inherit; font-size:15px;
        }
        .watch-btn:hover { background:#00bf55; }
        .register-btn {
            display:inline-flex; align-items:center; gap:10px;
            border:1px solid rgba(0,215,96,0.35); border-radius:999px; padding:15px 24px;
            color:#bbf7d0; font-weight:900; font-size:15px;
            background:rgba(0,215,96,0.08);
        }
        .register-btn:hover { background:rgba(0,215,96,0.16); }

        /* ── Content ── */
        .content {
            position:relative; z-index:3;
            margin-top:-48px;
            padding:0 clamp(24px,5vw,72px) 60px;
        }
        .section-title { margin:0 0 18px; font-size:30px; letter-spacing:-0.04em; }
        .chips { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:22px; }
        .chip {
            border:1px solid var(--line); border-radius:999px;
            padding:9px 13px; color:#d4d4d4;
            background:rgba(255,255,255,0.06); font-size:13px; font-weight:800;
        }
        .chip.active { border-color:var(--green); color:var(--green); background:rgba(0,215,96,0.1); }

        /* Movie grid */
        .movie-row {
            display:grid; grid-template-columns:repeat(5,minmax(180px,1fr)); gap:16px;
        }
        .movie-card {
            min-height:260px; display:flex; flex-direction:column; justify-content:flex-end;
            overflow:hidden; border:1px solid var(--line); border-radius:18px; padding:15px;
            background:linear-gradient(135deg,rgba(0,215,96,0.12),rgba(255,255,255,0.05));
            box-shadow:0 18px 50px rgba(0,0,0,0.32); position:relative;
            transition:transform 0.18s, box-shadow 0.18s; cursor:pointer;
        }
        .movie-card:hover { transform:translateY(-4px); box-shadow:0 28px 60px rgba(0,0,0,0.46); }
        .movie-card:nth-child(2n) { background:linear-gradient(135deg,rgba(0,180,80,0.18),rgba(255,255,255,0.05)); }
        .movie-card:nth-child(3n) { background:linear-gradient(135deg,rgba(0,215,96,0.22),rgba(255,255,255,0.05)); }
        .card-poster { position:absolute; inset:0; background-size:cover; background-position:center; }
        .card-overlay { position:absolute; inset:0; background:linear-gradient(180deg,transparent 35%,rgba(0,0,0,0.9) 100%); }

        /* Lock overlay */
        .card-lock {
            position:absolute; inset:0; z-index:5;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            gap:8px; opacity:0; transition:opacity 0.18s;
            background:rgba(0,0,0,0.55); border-radius:18px;
        }
        .card-lock-icon { font-size:28px; }
        .card-lock-text { font-size:12px; font-weight:900; color:white; text-align:center; line-height:1.4; }
        .movie-card:hover .card-lock { opacity:1; }

        .card-body { position:relative; z-index:2; }
        .movie-card small { color:#fca5a5; font-size:11px; font-weight:900; letter-spacing:0.12em; text-transform:uppercase; }
        .movie-card h2 { margin:9px 0 6px; font-size:20px; letter-spacing:-0.05em; }
        .movie-card p { margin:0; color:#d1d5db; font-size:13px; line-height:1.5; }
        .star-badge { display:inline-flex; align-items:center; gap:4px; font-size:12px; color:#fbbf24; font-weight:900; }

        .empty { grid-column:1/-1; border:1px solid var(--line); border-radius:20px; padding:24px; background:rgba(255,255,255,0.06); color:#d4d4d4; }

        /* Login prompt banner */
        .login-prompt {
            display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;
            border:1px solid rgba(0,215,96,0.3); border-radius:20px; padding:18px 22px;
            background:rgba(0,215,96,0.07); margin-bottom:20px;
        }
        .login-prompt p { font-size:14px; color:#bbf7d0; font-weight:800; margin:0; }
        .login-prompt-btns { display:flex; gap:10px; }
        .lp-login { border:1px solid rgba(0,215,96,0.35); border-radius:999px; padding:9px 18px; color:#bbf7d0; font:inherit; font-size:13px; font-weight:900; }
        .lp-register { border:0; border-radius:999px; padding:9px 18px; background:#00d760; color:#03130a; font:inherit; font-size:13px; font-weight:900; cursor:pointer; }

        /* Pagination */
        .pagination { display:flex; justify-content:center; gap:8px; margin-top:32px; flex-wrap:wrap; }
        .pagination a, .pagination span {
            min-width:40px; height:40px; display:grid; place-items:center;
            border:1px solid var(--line); border-radius:10px;
            background:rgba(255,255,255,0.06); color:#d4d4d4; font-size:14px; font-weight:800;
        }
        .pagination a:hover { border-color:var(--green); color:var(--green); }
        .pagination .active span { border-color:var(--green); background:rgba(0,215,96,0.15); color:var(--green); }
        .pagination .disabled span { opacity:0.4; }

        /* App wrapper */
        .app { padding-left:88px; }

        @media(max-width:1180px) {
            .menu { display:none; }
            .movie-row { grid-template-columns:repeat(3,minmax(160px,1fr)); }
        }
        @media(max-width:760px) {
            .app { padding-left:0; }
            .sidebar { position:static; width:100%; height:auto; flex-direction:row; justify-content:flex-start; overflow-x:auto; }
            .topbar { position:static; inset:auto; height:auto; flex-direction:column; align-items:flex-start; padding:16px 20px; }
            .top-actions, .search-form { width:100%; min-width:0; }
            .hero { min-height:520px; padding:60px 20px 42px; }
            .content { margin-top:-20px; padding:0 20px 48px; }
            .movie-row { grid-template-columns:repeat(2,1fr); }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <a class="side-item active" href="{{ route('home') }}">
            <span class="side-icon">⌂</span><span>Trang chủ</span>
        </a>
        <a class="side-item locked" href="{{ route('login') }}" title="Đăng nhập để xem">
            <span class="side-icon">▣</span><span>Phim bộ</span>
        </a>
        <a class="side-item locked" href="{{ route('login') }}" title="Đăng nhập để xem">
            <span class="side-icon">▭</span><span>Phim lẻ</span>
        </a>
        <a class="side-item locked" href="{{ route('login') }}" title="Đăng nhập để xem">
            <span class="side-icon">★</span><span>Rating</span>
        </a>
        <a class="side-item locked" href="{{ route('login') }}" title="Đăng nhập để xem">
            <span class="side-icon">↺</span><span>Lịch sử</span>
        </a>
        <a class="side-item locked" href="{{ route('login') }}" title="Đăng nhập để xem">
            <span class="side-icon">♥</span><span>Yêu thích</span>
        </a>
    </aside>

    <main class="app">
        {{-- Topbar --}}
        <header class="topbar">
            <a class="brand" href="{{ route('home') }}">LUMIERE<span>.</span></a>

            <nav class="menu">
                {{-- Thể loại --}}
                <div class="menu-item">
                    <a href="#">Thể loại <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <div class="dropdown-label">Tất cả thể loại</div>
                            @foreach($categories as $cat)
                                <a href="{{ route('home', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- Phim Bộ --}}
                <div class="menu-item">
                    <a href="{{ route('home', ['cat' => 'phim-bo']) }}">Phim Bộ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('home', ['cat' => 'phim-bo']) }}">Tất cả phim bộ</a>
                        </div>
                    </div>
                </div>
                {{-- Phim Lẻ --}}
                <div class="menu-item">
                    <a href="{{ route('home', ['q' => 'Phim lẻ']) }}">Phim Lẻ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('home', ['q' => 'Phim lẻ']) }}">Tất cả phim lẻ</a>
                        </div>
                    </div>
                </div>
                {{-- Chiếu rạp --}}
                <div class="menu-item">
                    <a href="{{ route('home', ['cat' => 'chieu-rap']) }}">Chiếu rạp <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('home', ['cat' => 'chieu-rap']) }}">Tất cả phim chiếu rạp</a>
                        </div>
                    </div>
                </div>
                {{-- Diễn viên --}}
                <a class="menu-plain" href="{{ route('login') }}" title="Đăng nhập để xem">Diễn viên</a>
                {{-- Quốc gia --}}
                <div class="menu-item">
                    <a href="#">Quốc gia <span class="menu-arrow">▾</span></a>
                    <div class="dropdown">
                        <div class="dropdown-body">
                            <a href="{{ route('home', ['q' => 'Hàn Quốc']) }}">Hàn Quốc</a>
                            <a href="{{ route('home', ['q' => 'Trung Quốc']) }}">Trung Quốc</a>
                            <a href="{{ route('home', ['q' => 'Nhật Bản']) }}">Nhật Bản</a>
                            <a href="{{ route('home', ['q' => 'Việt Nam']) }}">Việt Nam</a>
                            <a href="{{ route('home', ['q' => 'Thái Lan']) }}">Thái Lan</a>
                            <a href="{{ route('home', ['q' => 'Mỹ']) }}">Mỹ</a>
                            <a href="{{ route('home', ['q' => 'Anh']) }}">Anh</a>
                            <a href="{{ route('home', ['q' => 'Pháp']) }}">Pháp</a>
                            <a href="{{ route('home', ['q' => 'Hồng Kông']) }}">Hồng Kông</a>
                            <a href="{{ route('home', ['q' => 'Đài Loan']) }}">Đài Loan</a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="top-actions">
                <form class="search-form" method="GET" action="{{ route('home') }}">
                    <input class="search-input" type="search" name="q" value="{{ $query }}" placeholder="Tìm kiếm phim, thể loại...">
                </form>
                <a class="btn-login" href="{{ route('login') }}">Đăng nhập</a>
                <a class="btn-register" href="{{ route('register') }}">Đăng ký</a>
            </div>
        </header>

        {{-- Hero --}}
        <section class="hero">
            @if($featured && $featured->poster)
                <div class="hero-bg" style="background-image:url('{{ $featured->posterUrl() }}')"></div>
                <div class="hero-overlay"></div>
            @else
                <div class="hero-no-poster"></div>
            @endif

            <div class="hero-content">
                <div class="back-dot">‹</div>
                @if($featured)
                    <h1>{{ $featured->title }}</h1>
                    <div class="meta">
                        @if($featured->rating > 0)<span class="rank">★ {{ $featured->rating }}/10</span>@endif
                        @if($featured->year)<span>{{ $featured->year }}</span>@endif
                        <span>{{ $featured->type }}</span>
                    </div>
                    <div class="tags">
                        <span class="tag">{{ $featured->category->name ?? '' }}</span>
                    </div>
                    @if($featured->description)
                        <p class="desc">{{ Str::limit($featured->description, 160) }}</p>
                    @endif
                @else
                    <h1>Kho phim khổng lồ</h1>
                    <div class="meta"><span class="rank">Hàng nghìn bộ phim</span></div>
                @endif
            </div>
        </section>

        {{-- Movie list --}}
        <section class="content">
            {{-- Categories filter --}}
            <div class="chips">
                <a class="chip {{ $catSlug === '' && $query === '' ? 'active' : '' }}" href="{{ route('home') }}">Tất cả</a>
                @foreach($categories as $cat)
                    <a class="chip {{ $catSlug === $cat->slug ? 'active' : '' }}"
                       href="{{ route('home', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            {{-- Movies grid --}}
            <div class="movie-row">
                @forelse($movies as $movie)
                    <a class="movie-card" href="{{ route('login') }}">
                        @if($movie->poster)
                            <div class="card-poster" style="background-image:url('{{ $movie->posterUrl() }}')"></div>
                            <div class="card-overlay"></div>
                        @endif
                        <div class="card-lock">
                            <span class="card-lock-icon">🔒</span>
                            <span class="card-lock-text">Đăng nhập<br>để xem</span>
                        </div>
                        <div class="card-body">
                            <h2>{{ $movie->title }}</h2>
                            <p>{{ $movie->year }}@if($movie->rating > 0) · <span class="star-badge">★ {{ $movie->rating }}</span>@endif</p>
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
                    @foreach($movies->links()->elements as $element)
                        @if(is_string($element))<span class="disabled"><span>{{ $element }}</span></span>@endif
                        @if(is_array($element))
                            @foreach($element as $page => $url)
                                @if($page == $movies->currentPage())
                                    <span class="active"><span>{{ $page }}</span></span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if($movies->hasNextPage())<a href="{{ $movies->nextPageUrl() }}">›</a>@endif
                </div>
            @endif
        </section>
    </main>

</body>
</html>
