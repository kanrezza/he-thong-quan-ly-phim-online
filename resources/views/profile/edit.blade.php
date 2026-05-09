<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hồ sơ cá nhân - Lumière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050505; --panel: #0c0f14;
            --line: rgba(255,255,255,0.09);
            --text: #f1f5f9; --muted: #64748b; --green: #00d760;
        }
        * { box-sizing:border-box; }
        body {
            min-height:100vh; margin:0;
            background: radial-gradient(ellipse at 80% 0%, rgba(0,215,96,0.07), transparent 50%), var(--bg);
            color:var(--text);
            font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }
        a { text-decoration:none; color:inherit; }

        /* Nav */
        .topnav {
            display:flex; align-items:center; justify-content:space-between;
            padding:16px clamp(20px,5vw,64px);
            border-bottom:1px solid var(--line);
        }
        .brand { color:white; font-size:22px; font-weight:900; letter-spacing:-0.08em; }
        .brand span { color:var(--green); }
        .back-link { color:var(--muted); font-size:14px; font-weight:600; transition:color 0.14s; }
        .back-link:hover { color:var(--green); }

        /* Page */
        .page { max-width:980px; margin:0 auto; padding:40px clamp(20px,5vw,40px) 80px; }

        .layout { display:grid; grid-template-columns:240px 1fr; gap:24px; align-items:start; }

        /* Avatar card */
        .avatar-card {
            border:1px solid var(--line); border-radius:24px;
            padding:28px 20px 24px; background:var(--panel);
            text-align:center; position:sticky; top:24px;
        }

        .avatar-wrap { position:relative; display:inline-block; cursor:pointer; }

        .avatar-img {
            width:96px; height:96px; border-radius:50%;
            object-fit:cover; display:block;
            border:2px solid rgba(0,215,96,0.35);
        }

        .avatar-placeholder {
            width:96px; height:96px; border-radius:50%;
            background:linear-gradient(135deg, #0f2318, #0a1a0f);
            border:2px solid rgba(0,215,96,0.35);
            display:grid; place-items:center;
            font-size:36px; font-weight:800; color:var(--green);
            letter-spacing:-0.02em;
        }

        .avatar-overlay {
            position:absolute; inset:0; border-radius:50%;
            background:rgba(0,0,0,0.6);
            display:grid; place-items:center;
            opacity:0; transition:opacity 0.16s;
            color:white; font-size:12px; font-weight:700; letter-spacing:0.02em;
        }
        .avatar-wrap:hover .avatar-overlay { opacity:1; }
        #avatarInput { display:none; }

        .avatar-hint { color:var(--muted); font-size:11px; margin:8px 0 0; font-weight:500; }

        .user-name { font-size:17px; font-weight:800; letter-spacing:-0.03em; margin:16px 0 5px; }

        .role-tag {
            display:inline-block; border-radius:5px; padding:3px 10px;
            font-size:11px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase;
        }
        .role-admin { background:rgba(239,68,68,0.12); color:#f87171; border:1px solid rgba(239,68,68,0.22); }
        .role-user  { background:rgba(0,215,96,0.1); color:var(--green); border:1px solid rgba(0,215,96,0.22); }

        .divider { height:1px; background:var(--line); margin:18px 0; }

        .stat-row { display:flex; justify-content:space-around; }
        .stat-item { text-align:center; }
        .stat-num { font-size:24px; font-weight:900; letter-spacing:-0.05em; color:var(--green); line-height:1; }
        .stat-label { font-size:11px; color:var(--muted); margin-top:4px; font-weight:500; }

        /* Form */
        .form-sections { display:flex; flex-direction:column; gap:16px; }

        .section-card {
            border:1px solid var(--line); border-radius:20px;
            padding:22px 24px; background:var(--panel);
        }

        .section-head {
            margin:0 0 18px; padding-bottom:14px;
            border-bottom:1px solid var(--line);
            font-size:14px; font-weight:700; color:#94a3b8; letter-spacing:0.01em;
        }

        label { display:block; margin-bottom:6px; color:var(--muted); font-size:13px; font-weight:500; }

        input[type=text], input[type=email], textarea {
            width:100%; border:1px solid rgba(255,255,255,0.08); border-radius:10px;
            padding:11px 13px; background:#060b0e; color:var(--text);
            font:inherit; font-size:14px; transition:border-color 0.14s;
        }
        input:focus, textarea:focus { outline:none; border-color:rgba(0,215,96,0.42); }
        textarea { min-height:88px; resize:vertical; }

        .field { margin-bottom:14px; }
        .field:last-child { margin-bottom:0; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .field-error { color:#f87171; font-size:12px; margin-top:4px; }
        .char-count { text-align:right; font-size:11px; color:#374151; margin-top:4px; }

        /* Genre chips */
        .chip-grid { display:flex; flex-wrap:wrap; gap:8px; }
        .chip-label { cursor:pointer; }
        .chip-label input[type=checkbox] { display:none; }
        .chip {
            border:1px solid rgba(255,255,255,0.09); border-radius:999px;
            padding:7px 14px; font-size:13px; font-weight:600;
            color:#64748b; background:rgba(255,255,255,0.04);
            transition:all 0.14s; display:block;
        }
        .chip-label input:checked + .chip { border-color:rgba(0,215,96,0.45); background:rgba(0,215,96,0.1); color:var(--green); }
        .chip-label:hover .chip { color:#94a3b8; border-color:rgba(255,255,255,0.18); }

        /* Alerts */
        .alert-success { border:1px solid rgba(0,215,96,0.3); border-radius:12px; padding:12px 16px; background:rgba(0,215,96,0.07); color:#bbf7d0; font-size:14px; margin-bottom:18px; }
        .alert-error   { border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:12px 16px; background:rgba(239,68,68,0.07); color:#fca5a5; font-size:14px; margin-bottom:18px; }

        /* Buttons */
        .save-bar { display:flex; justify-content:flex-end; gap:10px; padding-top:4px; }
        .btn-save { border:0; border-radius:999px; padding:12px 26px; background:var(--green); color:#03130a; font:inherit; font-size:14px; font-weight:800; cursor:pointer; transition:background 0.14s; }
        .btn-save:hover { background:#00bf55; }
        .btn-cancel { border:1px solid var(--line); border-radius:999px; padding:12px 20px; background:transparent; color:#94a3b8; font:inherit; font-size:14px; font-weight:600; display:inline-flex; align-items:center; }
        .btn-cancel:hover { color:white; border-color:rgba(255,255,255,0.2); }

        /* Mode switcher */
        .mode-switcher {
            position:fixed; bottom:24px; right:24px; z-index:999;
            display:flex; border-radius:999px;
            border:1px solid rgba(255,255,255,0.1);
            background:rgba(5,5,5,0.9); backdrop-filter:blur(16px);
            padding:4px; gap:2px;
            box-shadow:0 4px 28px rgba(0,0,0,0.5);
        }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:700; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.active { background:var(--green); color:#03130a; }
        .mode-btn:hover:not(.active) { color:#d1d5db; }

        @media(max-width:760px) {
            .layout { grid-template-columns:1fr; }
            .avatar-card { position:static; }
            .field-row { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

    <nav class="topnav">
        <a class="brand" href="{{ route('movies.index') }}">LUMIERE<span>.</span></a>
        <a class="back-link" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('movies.index') }}">
            Quay lại
        </a>
    </nav>

    <div class="page">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" id="avatarInput" name="avatar" accept="image/*">

            <div class="layout">

                {{-- Avatar card --}}
                <div class="avatar-card">
                    <div class="avatar-wrap" onclick="document.getElementById('avatarInput').click()" title="Nhấn để đổi ảnh">
                        @if($user->avatar)
                            <img id="avatarPreview" class="avatar-img" src="{{ $user->avatarUrl() }}" alt="">
                        @else
                            <div id="avatarPreview" class="avatar-placeholder">
                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="avatar-overlay">Đổi ảnh</div>
                    </div>
                    <p class="avatar-hint">JPG · PNG · Tối đa 2MB</p>

                    <p class="user-name">{{ $user->name }}</p>
                    <span class="role-tag {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                        {{ $user->role === 'admin' ? 'Admin' : 'Thành viên' }}
                    </span>

                    <div class="divider"></div>

                    <div class="stat-row">
                        <div class="stat-item">
                            <div class="stat-num">{{ $user->comments()->count() }}</div>
                            <div class="stat-label">Bình luận</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num">{{ $user->ratings()->count() }}</div>
                            <div class="stat-label">Đánh giá</div>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="form-sections">

                    <div class="section-card">
                        <p class="section-head">Thông tin tài khoản</p>
                        <div class="field-row">
                            <div class="field">
                                <label>Họ và tên</label>
                                <input name="name" type="text" value="{{ old('name', $user->name) }}" required>
                                @error('name')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="field">
                                <label>Số điện thoại</label>
                                <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="Chưa cập nhật">
                            </div>
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <input name="email" type="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="section-card">
                        <p class="section-head">Giới thiệu bản thân</p>
                        <div class="field">
                            <label>Bio ngắn (tối đa 500 ký tự)</label>
                            <textarea name="bio" maxlength="500"
                                      placeholder="Ví dụ: Fan phim Hàn, thích thể loại kinh dị và cổ trang..."
                                      oninput="updateCount(this,'bioCount')">{{ old('bio', $user->bio) }}</textarea>
                            <p class="char-count"><span id="bioCount">{{ mb_strlen(old('bio', $user->bio ?? '')) }}</span> / 500</p>
                        </div>
                    </div>


                    <div class="save-bar">
                        <a class="btn-cancel" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('movies.index') }}">Huỷ</a>
                        <button class="btn-save" type="submit">Lưu thay đổi</button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="mode-switcher">
        <a href="{{ route('movies.index') }}" class="mode-btn {{ !request()->is('admin*') ? 'active' : '' }}">Website</a>
        <a href="{{ route('admin.dashboard') }}" class="mode-btn {{ request()->is('admin*') ? 'active' : '' }}">Admin</a>
    </div>
    @endif

    <script>
        function updateCount(el, id) {
            document.getElementById(id).textContent = el.value.length;
        }
        document.getElementById('avatarInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('avatarPreview');
                const img = document.createElement('img');
                img.id = 'avatarPreview';
                img.className = 'avatar-img';
                img.src = e.target.result;
                prev.replaceWith(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
