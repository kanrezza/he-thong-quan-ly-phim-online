<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phim yêu thích - Lumière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#050505; --line:rgba(255,255,255,0.12); --text:#f5f5f5; --muted:#a3a3a3; --green:#00d760; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; background:var(--bg); color:var(--text); font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',system-ui,sans-serif; overflow-x:hidden; }
        a { color:inherit; text-decoration:none; }

        /* Sidebar */
        .sidebar { position:fixed; inset:0 auto 0 0; z-index:20; width:88px; border-right:1px solid var(--line); background:rgba(3,5,8,0.92); backdrop-filter:blur(18px); display:flex; flex-direction:column; align-items:center; padding:24px 8px; gap:22px; }
        .side-item { width:70px; min-height:62px; display:grid; place-items:center; gap:6px; color:#8a8f98; font-size:12px; text-align:center; }
        .side-icon { width:30px; height:30px; display:grid; place-items:center; border:1px solid rgba(255,255,255,0.12); border-radius:12px; color:#cbd5e1; font-size:17px; }
        .side-item.active { color:var(--green); font-weight:900; }
        .side-item.active .side-icon { border-color:rgba(0,215,96,0.65); box-shadow:0 0 24px rgba(0,215,96,0.28); color:var(--green); }

        /* Topbar */
        .topbar { position:fixed; inset:0 0 auto 88px; z-index:15; height:76px; display:flex; align-items:center; justify-content:space-between; gap:22px; padding:0 clamp(20px,4vw,52px); background:linear-gradient(180deg,rgba(3,5,8,0.92),rgba(3,5,8,0.35)); backdrop-filter:blur(18px); }
        .brand { color:white; font-size:30px; font-weight:900; letter-spacing:0.08em; }
        .brand span { color:var(--green); }
        .menu { display:flex; gap:4px; color:#d0d3da; font-size:14px; font-weight:800; white-space:nowrap; }
        .menu-item { position:relative; }
        .menu-item>a { display:flex; align-items:center; gap:5px; padding:8px 12px; border-radius:10px; color:#d0d3da; transition:background 0.15s,color 0.15s; }
        .menu-item>a:hover,.menu-item:hover>a { background:rgba(255,255,255,0.1); color:white; }
        .menu-arrow { font-size:10px; opacity:0.6; }
        .dropdown { display:none; position:absolute; top:100%; left:0; min-width:210px; padding-top:10px; z-index:100; }
        .menu-item:hover .dropdown { display:block; }
        .dropdown-body { background:rgba(10,12,18,0.98); border:1px solid var(--line); border-radius:16px; padding:8px; backdrop-filter:blur(20px); box-shadow:0 20px 60px rgba(0,0,0,0.65); }
        .dropdown a { display:block; padding:9px 12px; border-radius:10px; color:#c8ccd6; font-size:13px; font-weight:800; }
        .dropdown a:hover { background:rgba(255,255,255,0.1); color:white; }
        .dropdown-label { padding:6px 12px 4px; color:#555; font-size:11px; font-weight:900; letter-spacing:0.08em; text-transform:uppercase; }
        .top-actions { display:flex; align-items:center; gap:12px; }
        .search-form { flex:1; }
        .search-input { width:100%; border:1px solid var(--line); border-radius:16px; padding:12px 14px; background:rgba(255,255,255,0.08); color:white; font:inherit; font-size:14px; }
        .search-input::placeholder { color:#7b8190; }
        .profile-link { display:inline-flex; align-items:center; gap:7px; flex:0 0 auto; border:1px solid rgba(255,255,255,0.14); border-radius:999px; padding:0 14px; height:40px; background:rgba(255,255,255,0.07); color:#d1d5db; font:inherit; font-size:13px; font-weight:600; white-space:nowrap; }
        .profile-link:hover { border-color:rgba(0,215,96,0.5); color:#00d760; }
        .avatar-dot { width:24px; height:24px; border-radius:999px; background:rgba(0,215,96,0.2); border:1px solid rgba(0,215,96,0.4); display:grid; place-items:center; font-size:11px; font-weight:800; color:#00d760; flex-shrink:0; }
        .logout { border:0; border-radius:999px; padding:0 16px; height:40px; background:rgba(0,215,96,0.16); color:#bbf7d0; font:inherit; font-size:13px; font-weight:700; cursor:pointer; }
        .logout:hover { background:rgba(0,215,96,0.26); color:#fff; }

        /* Page */
        .app { padding-left:88px; }
        .content { padding:96px clamp(20px,5vw,64px) 64px; }

        .page-header { margin-bottom:28px; }
        h1 { margin:0; font-size:30px; letter-spacing:-0.04em; }
        .subtitle { color:var(--muted); font-size:14px; margin:8px 0 0; }

        .alert { border-radius:14px; padding:12px 16px; font-size:14px; margin-bottom:20px; }
        .alert-green { border:1px solid rgba(0,215,96,0.4); background:rgba(0,215,96,0.1); color:#bbf7d0; }

        .movie-row { display:grid; grid-template-columns:repeat(5,minmax(180px,1fr)); gap:16px; }

        .movie-card { display:flex; flex-direction:column; overflow:hidden; border:1px solid var(--line); border-radius:18px; background:#0d1117; box-shadow:0 8px 30px rgba(0,0,0,0.28); transition:transform 0.18s, box-shadow 0.18s; position:relative; }
        .movie-card:hover { transform:translateY(-3px); box-shadow:0 16px 44px rgba(0,0,0,0.42); }

        .card-poster { height:180px; background:#1a1a1a; overflow:hidden; }
        .card-poster img { width:100%; height:100%; object-fit:cover; display:block; }
        .card-poster-placeholder { width:100%; height:100%; display:grid; place-items:center; font-size:48px; color:#333; }

        .card-body { padding:12px 14px 14px; flex:1; display:flex; flex-direction:column; }
        .card-body small { color:#fca5a5; font-size:11px; font-weight:900; letter-spacing:0.1em; text-transform:uppercase; }
        .card-body h2 { margin:7px 0 5px; font-size:16px; letter-spacing:-0.04em; line-height:1.2; }
        .card-body p { margin:0 0 10px; color:var(--muted); font-size:12px; }

        .remove-btn { border:1px solid rgba(239,68,68,0.3); border-radius:8px; padding:6px 10px; background:rgba(239,68,68,0.1); color:#fca5a5; font:inherit; font-size:12px; font-weight:900; cursor:pointer; align-self:flex-start; }
        .remove-btn:hover { background:rgba(239,68,68,0.22); }

        .empty-state { text-align:center; padding:80px 20px; color:var(--muted); }
        .empty-state .icon { font-size:64px; display:block; margin-bottom:16px; }
        .empty-state p { font-size:16px; margin:0 0 20px; }
        .btn-browse { display:inline-flex; align-items:center; border-radius:999px; padding:13px 24px; background:var(--green); color:#03130a; font:inherit; font-weight:900; }

        .pagination { display:flex; justify-content:center; gap:8px; margin-top:32px; flex-wrap:wrap; }
        .pagination a, .pagination span { min-width:38px; height:38px; display:grid; place-items:center; border:1px solid var(--line); border-radius:10px; background:rgba(255,255,255,0.05); color:#d4d4d4; font-size:14px; font-weight:800; }
        .pagination a:hover { border-color:var(--green); color:var(--green); }
        .pagination .active span { border-color:var(--green); background:rgba(0,215,96,0.15); color:var(--green); }
        .pagination .disabled span { opacity:0.35; }

        @media(max-width:1180px) { .menu { display:none; } .movie-row { grid-template-columns:repeat(3,1fr); } }
        @media(max-width:600px) {
            .app { padding-left:0; }
            .sidebar { position:static; width:100%; height:auto; flex-direction:row; overflow-x:auto; }
            .topbar { position:static; inset:auto; height:auto; flex-direction:column; align-items:flex-start; padding:14px 16px; }
            .top-actions, .search-form { width:100%; min-width:0; }
            .movie-row { grid-template-columns:repeat(2,1fr); }
        }
        .mode-switcher { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; border-radius:999px; border:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); backdrop-filter:blur(16px); padding:4px; gap:2px; box-shadow:0 4px 28px rgba(0,0,0,0.5); }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:900; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.active { background:var(--green); color:#03130a; }
        .mode-btn:hover:not(.active) { color:#d1d5db; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="side-item" href="{{ route('movies.index') }}">
            <span class="side-icon">⌂</span><span>Trang chủ</span>
        </a>
        <a class="side-item" href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">
            <span class="side-icon">▣</span><span>Phim bộ</span>
        </a>
        <a class="side-item" href="{{ route('movies.index', ['cat' => 'phim-le']) }}">
            <span class="side-icon">▭</span><span>Phim lẻ</span>
        </a>
        <a class="side-item" href="{{ route('top-rated.index') }}">
            <span class="side-icon">★</span><span>Rating</span>
        </a>
        <a class="side-item" href="{{ route('history.index') }}">
            <span class="side-icon">↺</span><span>Lịch sử</span>
        </a>
        <a class="side-item active" href="{{ route('watchlist.index') }}">
            <span class="side-icon">♥</span><span>Yêu thích</span>
        </a>
    </aside>

    <main class="app">
        <header class="topbar">
            <a class="brand" href="{{ route('movies.index') }}">LUMIERE<span>.</span></a>
            <nav class="menu">
                <div class="menu-item">
                    <a href="{{ route('movies.index') }}">Thể loại <span class="menu-arrow">▾</span></a>
                    <div class="dropdown"><div class="dropdown-body">
                        <div class="dropdown-label">Tất cả thể loại</div>
                        @foreach($categories as $cat)
                            <a href="{{ route('movies.index', ['cat' => $cat->slug]) }}">{{ $cat->name }}</a>
                        @endforeach
                    </div></div>
                </div>
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">Phim Bộ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown"><div class="dropdown-body">
                        <a href="{{ route('movies.index', ['cat' => 'phim-bo']) }}">Tất cả phim bộ</a>
                    </div></div>
                </div>
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['cat' => 'phim-le']) }}">Phim Lẻ <span class="menu-arrow">▾</span></a>
                    <div class="dropdown"><div class="dropdown-body">
                        <a href="{{ route('movies.index', ['cat' => 'phim-le']) }}">Tất cả phim lẻ</a>
                    </div></div>
                </div>
                <div class="menu-item">
                    <a href="{{ route('movies.index', ['cat' => 'chieu-rap']) }}">Chiếu rạp <span class="menu-arrow">▾</span></a>
                    <div class="dropdown"><div class="dropdown-body">
                        <a href="{{ route('movies.index', ['cat' => 'chieu-rap']) }}">Tất cả phim chiếu rạp</a>
                    </div></div>
                </div>
                <a class="menu-item" href="{{ route('actors.index') }}" style="padding:8px 12px;border-radius:10px;">Diễn viên</a>
            </nav>
            <div class="top-actions">
                <form class="search-form" method="GET" action="{{ route('movies.index') }}">
                    <input class="search-input" type="search" name="q" placeholder="Tìm kiếm phim, thể loại...">
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

        <div class="content">
            <div class="page-header">
                <h1>Yêu thích</h1>
                <p class="subtitle">{{ $items->total() }} phim đã lưu</p>
            </div>

            @if(session('watchlist_msg'))
                <div class="alert alert-green">{{ session('watchlist_msg') }}</div>
            @endif

            @if($items->total() === 0)
                <div class="empty-state">
                    <span class="icon">♥</span>
                    <p>Chưa có phim yêu thích nào.</p>
                    <a class="btn-browse" href="{{ route('movies.index') }}">Khám phá phim ngay</a>
                </div>
            @else
                <div class="movie-row">
                    @foreach($items as $item)
                        @if($item->movie)
                        <div class="movie-card">
                            <a href="{{ route('movies.show', $item->movie) }}">
                                <div class="card-poster">
                                    @if($item->movie->poster)
                                        <img src="{{ $item->movie->posterUrl() }}" alt="{{ $item->movie->title }}">
                                    @else
                                        <div class="card-poster-placeholder"></div>
                                    @endif
                                </div>
                            </a>
                            <div class="card-body">
                                <small>{{ $item->movie->category->name ?? '' }}</small>
                                <h2>{{ $item->movie->title }}</h2>
                                <p>{{ $item->movie->year }} · {{ $item->movie->type }}</p>
                                <form method="POST" action="{{ route('watchlist.toggle', $item->movie) }}">
                                    @csrf
                                    <button class="remove-btn" type="submit">✕ Xóa khỏi yêu thích</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                @if($items->hasPages())
                    <div class="pagination">
                        @foreach($items->links()->elements as $el)
                            @if(is_string($el))<span class="disabled"><span>{{ $el }}</span></span>@endif
                            @if(is_array($el))
                                @foreach($el as $page => $url)
                                    @if($page == $items->currentPage())
                                        <span class="active"><span>{{ $page }}</span></span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @if($items->hasNextPage())<a href="{{ $items->nextPageUrl() }}">›</a>@endif
                    </div>
                @endif
            @endif
        </div>
    </main>

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="mode-switcher">
        <a href="{{ route('movies.index') }}" class="mode-btn active">Website</a>
        <a href="{{ route('admin.dashboard') }}" class="mode-btn">Admin</a>
    </div>
    @endif
</body>
</html>
