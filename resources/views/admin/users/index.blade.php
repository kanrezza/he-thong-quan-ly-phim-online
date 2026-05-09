<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý người dùng - Admin</title>
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

        .btn {
            display:inline-flex; align-items:center; min-height:40px;
            border-radius:999px; padding:0 16px;
            font:inherit; font-weight:700; cursor:pointer; border:0; text-decoration:none;
            font-size:13px;
        }
        .btn-outline { background:transparent; border:1px solid rgba(255,255,255,0.15); color:#d1d5db; }
        .btn-outline:hover { background:rgba(255,255,255,0.07); }
        .btn-sm { min-height:34px; padding:0 12px; border-radius:8px; }

        .alert-success {
            border:1px solid rgba(0,215,96,0.38); border-radius:14px;
            padding:12px 16px; background:rgba(0,215,96,0.08);
            color:#bbf7d0; margin-bottom:20px; font-size:14px;
        }

        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:600px; }
        thead th {
            border-bottom:1px solid rgba(255,255,255,0.09);
            padding:10px 14px; text-align:left;
            color:#6b7280; font-size:11px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;
        }
        tbody tr { border-bottom:1px solid rgba(255,255,255,0.05); }
        tbody tr:hover { background:rgba(255,255,255,0.03); }
        tbody td { padding:13px 14px; font-size:14px; vertical-align:middle; }

        .badge {
            display:inline-block; border-radius:6px; padding:3px 10px;
            font-size:12px; font-weight:700;
        }
        .badge-green { background:rgba(0,215,96,0.16);  color:#00d760; }
        .badge-red   { background:rgba(239,68,68,0.16);  color:#ef4444; }

        .actions { display:flex; gap:8px; }

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

        <h1>Người dùng</h1>
        <p style="color:#6b7280; font-size:14px; font-weight:500; margin:4px 0 28px">Tổng {{ $users->total() }} tài khoản</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Trạng thái</th>
                        <th>Tham gia</th>
                        <th style="width:160px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td style="color:#374151; font-size:13px">{{ $user->id }}</td>
                            <td style="font-weight:700; color:#f3f4f6">{{ $user->name }}</td>
                            <td style="color:#6b7280">{{ $user->email }}</td>
                            <td style="color:#6b7280">{{ $user->phone ?? '—' }}</td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge badge-green">Hoạt động</span>
                                @else
                                    <span class="badge badge-red">Bị khóa</span>
                                @endif
                            </td>
                            <td style="color:#6b7280; font-size:13px">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions">
                                    @if($user->status === 'active')
                                        <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                            @csrf
                                            <button class="btn btn-sm"
                                                    style="background:rgba(239,68,68,0.15); color:#ef4444; border:1px solid rgba(239,68,68,0.25)"
                                                    type="submit"
                                                    onclick="return confirm('Khóa tài khoản {{ addslashes($user->name) }}?')">
                                                Khóa
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                            @csrf
                                            <button class="btn btn-sm"
                                                    style="background:rgba(0,215,96,0.14); color:#00d760; border:1px solid rgba(0,215,96,0.28)"
                                                    type="submit">
                                                Mở khóa
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:#4b5563; padding:52px; font-size:15px">Chưa có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination">
                @foreach ($users->links()->elements as $element)
                    @if (is_string($element))
                        <span class="disabled"><span>{{ $element }}</span></span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="active"><span>{{ $page }}</span></span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if($users->hasNextPage())
                    <a href="{{ $users->nextPageUrl() }}">›</a>
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
