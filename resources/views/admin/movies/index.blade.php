<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý phim - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            margin:0; min-height:100vh;
            background: radial-gradient(circle at 100% 0%, rgba(0,215,96,0.1), transparent 32%), #050505;
            color:#f5f5f5;
            font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }
        .page { padding:28px clamp(20px,5vw,72px) 64px; }
        a { color:#00d760; text-decoration:none; font-weight:700; }

        .nav { display:flex; justify-content:space-between; gap:16px; align-items:center; flex-wrap:wrap; }
        .brand { color:#00d760; font-size:28px; font-weight:900; letter-spacing:-0.05em; text-transform:uppercase; }

        h1 { margin:48px 0 6px; font-size:clamp(36px,6vw,68px); line-height:0.93; letter-spacing:-0.05em; text-transform:uppercase; font-weight:900; }

        .toolbar { display:flex; flex-wrap:wrap; gap:12px; margin:20px 0; align-items:center; }

        .btn {
            display:inline-flex; align-items:center; min-height:42px;
            border-radius:999px; padding:0 18px;
            font:inherit; font-weight:700; cursor:pointer; border:0; text-decoration:none;
            font-size:14px;
        }
        .btn-green { background:#00d760; color:#03130a; }
        .btn-green:hover { background:#00bf55; }
        .btn-outline { background:transparent; border:1px solid rgba(255,255,255,0.15); color:#d1d5db; }
        .btn-outline:hover { background:rgba(255,255,255,0.07); }
        .btn-sm { font-size:13px; min-height:34px; padding:0 12px; border-radius:8px; }

        .alert-success {
            border:1px solid rgba(0,215,96,0.38); border-radius:14px;
            padding:12px 16px; background:rgba(0,215,96,0.08);
            color:#bbf7d0; margin-bottom:20px; font-size:14px;
        }

        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:700px; }
        thead th {
            border-bottom:1px solid rgba(255,255,255,0.09);
            padding:10px 14px; text-align:left;
            color:#6b7280; font-size:11px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;
        }
        tbody tr { border-bottom:1px solid rgba(255,255,255,0.05); }
        tbody tr:hover { background:rgba(255,255,255,0.03); }
        tbody td { padding:13px 14px; font-size:14px; vertical-align:middle; }

        .poster-thumb {
            width:46px; height:66px; border-radius:8px;
            object-fit:cover; border:1px solid rgba(255,255,255,0.1);
            background:#111;
        }
        .poster-placeholder {
            width:46px; height:66px; border-radius:8px;
            background:#1a1a1a; border:1px solid rgba(255,255,255,0.1);
            display:grid; place-items:center; color:#4b5563; font-size:20px;
        }

        .badge { display:inline-block; border-radius:6px; padding:3px 10px; font-size:12px; font-weight:700; }
        .badge-green { background:rgba(0,215,96,0.16); color:#00d760; }
        .badge-gray  { background:rgba(255,255,255,0.08); color:#9ca3af; }

        .actions { display:flex; gap:8px; }
        .star { color:#fbbf24; font-weight:700; }

        .pagination { display:flex; justify-content:center; gap:8px; margin-top:32px; flex-wrap:wrap; }
        .pagination a, .pagination span {
            min-width:38px; height:38px; display:grid; place-items:center;
            border:1px solid rgba(255,255,255,0.1); border-radius:8px;
            background:rgba(255,255,255,0.04); color:#9ca3af; font-size:14px; font-weight:700;
        }
        .pagination a:hover { border-color:#00d760; color:#00d760; }
        .pagination .active span { border-color:#00d760; background:rgba(0,215,96,0.14); color:#00d760; }
        .pagination .disabled span { opacity:0.35; }
        .mode-switcher { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; border-radius:999px; border:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); backdrop-filter:blur(16px); padding:4px; gap:2px; box-shadow:0 4px 28px rgba(0,0,0,0.5); }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:700; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.active { background:#00d760; color:#03130a; }
        .mode-btn:hover:not(.active) { color:#d1d5db; }
    </style>
</head>
<body>
    <main class="page">
        <nav class="nav">
            <div class="brand">Admin · Lumière</div>
            <div style="display:flex; gap:10px; flex-wrap:wrap">
                <a class="btn btn-outline btn-sm" href="{{ route('admin.dashboard') }}">← Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline btn-sm" type="submit">Đăng xuất</button>
                </form>
            </div>
        </nav>

        <h1>Quản lý phim</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="toolbar">
            <a class="btn btn-green" href="{{ route('admin.movies.create') }}">+ Thêm phim mới</a>
            <span style="color:#6b7280; font-size:14px; font-weight:500">Tổng {{ $movies->total() }} phim</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px">Poster</th>
                        <th>Tên phim</th>
                        <th>Thể loại</th>
                        <th>Loại</th>
                        <th>Năm</th>
                        <th>Đánh giá</th>
                        <th>Trạng thái</th>
                        <th style="width:130px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movies as $movie)
                        <tr>
                            <td>
                                @if($movie->poster)
                                    <img class="poster-thumb" src="{{ $movie->posterUrl() }}" alt="{{ $movie->title }}">
                                @else
                                    <div class="poster-placeholder">🎬</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('movies.show', $movie) }}" style="color:#f3f4f6; font-weight:700">{{ $movie->title }}</a>
                            </td>
                            <td style="color:#9ca3af">{{ $movie->categories->pluck('name')->join(', ') ?: '—' }}</td>
                            <td style="color:#9ca3af">{{ $movie->type }}</td>
                            <td style="color:#9ca3af">{{ $movie->year ?? '—' }}</td>
                            <td>
                                @if($movie->rating > 0)
                                    <span class="star">★</span>
                                    <span style="font-weight:700"> {{ $movie->rating }}</span>
                                @else
                                    <span style="color:#374151">—</span>
                                @endif
                            </td>
                            <td>
                                @if($movie->status === 'active')
                                    <span class="badge badge-green">Hiện</span>
                                @else
                                    <span class="badge badge-gray">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-outline btn-sm" href="{{ route('admin.movies.edit', $movie) }}">Sửa</a>
                                    <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm"
                                                style="background:rgba(239,68,68,0.14); color:#ef4444; border:1px solid rgba(239,68,68,0.24)"
                                                type="submit"
                                                onclick="return confirm('Xóa phim {{ addslashes($movie->title) }}?')">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:#4b5563; padding:52px; font-size:15px">Chưa có phim nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
    </main>
    <div class="mode-switcher">
        <a href="/movies" class="mode-btn">Website</a>
        <a href="/admin/dashboard" class="mode-btn active">Admin</a>
    </div>
</body>
</html>
