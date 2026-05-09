<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa phim - Admin</title>
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
        a:hover { color:#00bf55; }

        h1 { max-width:900px; margin:36px 0 28px; font-size:clamp(36px,5vw,72px); line-height:0.92; letter-spacing:-0.06em; text-transform:uppercase; font-weight:900; }

        .form-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:20px; max-width:1040px; }
        .full { grid-column:1 / -1; }

        .card { border:1px solid rgba(255,255,255,0.08); border-radius:20px; padding:24px 26px; background:#0d1117; }
        .card-title { font-size:13px; font-weight:700; color:#6b7280; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 18px; }

        label { display:block; margin-bottom:7px; color:#9ca3af; font-size:13px; font-weight:600; }
        .req { color:#00d760; }

        input[type=text], input[type=number], input[type=file], select, textarea {
            width:100%; box-sizing:border-box;
            border:1px solid rgba(255,255,255,0.1); border-radius:11px;
            padding:11px 13px; background:#050a07; color:white;
            font:inherit; font-size:14px; transition:border-color 0.14s;
        }
        input:focus, select:focus, textarea:focus { outline:none; border-color:rgba(0,215,96,0.48); }
        input.err, select.err { border-color:rgba(239,68,68,0.55); }
        .field-err { color:#ef4444; font-size:12px; margin-top:5px; font-weight:500; }
        textarea { min-height:110px; resize:vertical; }

        .cat-grid { display:flex; flex-wrap:wrap; gap:8px; }
        .cat-label {
            display:flex; align-items:center; gap:7px;
            border:1px solid rgba(255,255,255,0.1); border-radius:9px;
            padding:7px 12px; cursor:pointer; font-size:13px; font-weight:600; color:#d1d5db;
            transition:all 0.13s; user-select:none;
        }
        .cat-label:hover { border-color:rgba(0,215,96,0.4); color:#bbf7d0; }
        .cat-label input[type=checkbox] { width:15px; height:15px; accent-color:#00d760; margin:0; flex-shrink:0; vertical-align:middle; }
        .cat-label:has(input:checked) { border-color:rgba(0,215,96,0.6); background:rgba(0,215,96,0.1); color:#bbf7d0; }

        .btn-save {
            border:0; border-radius:999px; padding:13px 28px;
            background:#00d760; color:#03130a; font:inherit; font-size:14px; font-weight:800; cursor:pointer;
        }
        .btn-save:hover { background:#00bf55; }

        .alert-success {
            border:1px solid rgba(0,215,96,0.38); border-radius:14px;
            padding:12px 16px; background:rgba(0,215,96,0.08); color:#bbf7d0; font-size:14px; margin-bottom:20px;
        }

        .ep-section { display:none; }
        .ep-section.show { display:block; }

        .ep-table { width:100%; border-collapse:collapse; }
        .ep-table th {
            text-align:left; padding:8px 10px; font-size:11px; font-weight:700;
            color:#6b7280; letter-spacing:0.07em; text-transform:uppercase;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }
        .ep-table td { padding:8px 6px; vertical-align:top; }
        .ep-table input { padding:9px 11px; font-size:13px; border-radius:9px; }

        .btn-add-ep {
            display:inline-flex; align-items:center; gap:7px;
            border:1px solid rgba(0,215,96,0.35); border-radius:999px; padding:9px 16px;
            background:rgba(0,215,96,0.08); color:#bbf7d0; font:inherit; font-size:13px; font-weight:700;
            cursor:pointer; margin-top:12px;
        }
        .btn-add-ep:hover { background:rgba(0,215,96,0.16); }

        .btn-del-ep { border:0; background:none; color:rgba(239,68,68,0.6); font-size:18px; cursor:pointer; padding:6px 4px; }
        .btn-del-ep:hover { color:#ef4444; }

        .poster-preview { border-radius:10px; max-width:100px; border:1px solid rgba(255,255,255,0.1); display:block; margin-bottom:10px; }

        @media(max-width:760px) { .form-grid { grid-template-columns:1fr; } }
        .mode-switcher { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; border-radius:999px; border:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); backdrop-filter:blur(16px); padding:4px; gap:2px; box-shadow:0 4px 28px rgba(0,0,0,0.5); }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:700; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.active { background:#00d760; color:#03130a; }
        .mode-btn:hover:not(.active) { color:#d1d5db; }
    </style>
</head>
<body>
<main class="page">
    <a href="{{ route('admin.movies.index') }}">← Quay lại danh sách</a>
    <h1>Sửa phim</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="border:1px solid rgba(239,68,68,0.4); border-radius:14px; padding:12px 16px; background:rgba(239,68,68,0.08); color:#fca5a5; font-size:14px; margin-bottom:20px">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-grid">

            <div class="card full">
                <p class="card-title">Thông tin cơ bản</p>
                <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px">
                    <div style="grid-column:1/-1">
                        <label>Tên phim <span class="req">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $movie->title) }}"
                               class="{{ $errors->has('title') ? 'err' : '' }}" required>
                        @error('title')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label>Loại phim <span class="req">*</span></label>
                        <select name="type" id="typeSelect" required onchange="toggleEpisodes(this.value)">
                            <option value="Phim lẻ"   {{ old('type',$movie->type)==='Phim lẻ'  ?'selected':'' }}>Phim lẻ</option>
                            <option value="Phim bộ"   {{ old('type',$movie->type)==='Phim bộ'  ?'selected':'' }}>Phim bộ</option>
                            <option value="Chiếu rạp" {{ old('type',$movie->type)==='Chiếu rạp'?'selected':'' }}>Chiếu rạp</option>
                        </select>
                    </div>
                    <div>
                        <label>Trạng thái</label>
                        <select name="status">
                            <option value="active"   {{ old('status',$movie->status)==='active'?'selected':'' }}>Hiện (active)</option>
                            <option value="inactive" {{ old('status',$movie->status)==='inactive'?'selected':'' }}>Ẩn (inactive)</option>
                        </select>
                    </div>
                    <div>
                        <label>Năm phát hành</label>
                        <input type="number" name="year" value="{{ old('year', $movie->year) }}" min="1900" max="2100">
                    </div>
                    <div>
                        <label>Quốc gia</label>
                        <select name="country">
                            <option value="">-- Chọn quốc gia --</option>
                            @foreach(['Việt Nam','Hàn Quốc','Trung Quốc','Nhật Bản','Mỹ','Thái Lan','Anh','Pháp','Đài Loan','Hồng Kông','Ấn Độ','Ý','Tây Ban Nha','Đức','Úc','Canada','Philippines','Indonesia','Nga','Khác'] as $c)
                                <option value="{{ $c }}" {{ old('country', $movie->country)===$c?'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="grid-column:1/-1">
                        <label>Mô tả phim</label>
                        <textarea name="description">{{ old('description', $movie->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <p class="card-title">Thể loại <span class="req">*</span></p>
                @php $selectedCats = old('categories', $movie->categories->pluck('id')->toArray()); @endphp
                <div class="cat-grid">
                    @foreach($categories as $cat)
                        <label class="cat-label">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}>
                            {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
                @error('categories')<p class="field-err" style="margin-top:10px">{{ $message }}</p>@enderror
            </div>

            <div class="card">
                <p class="card-title">Media</p>
                <div style="display:flex; flex-direction:column; gap:14px">
                    <div>
                        <label>Poster {{ $movie->poster ? '(để trống giữ nguyên)' : '(JPG/PNG, tối đa 4MB)' }}</label>
                        @if($movie->poster)
                            <img class="poster-preview" src="{{ $movie->posterUrl() }}" alt="Poster hiện tại" id="posterPreview">
                        @else
                            <img id="posterPreview" src="" alt="" style="display:none; margin-bottom:10px; max-width:100px; border-radius:8px; border:1px solid rgba(255,255,255,0.1)">
                        @endif
                        <input type="file" name="poster" accept="image/*" onchange="previewPoster(this)">
                        @error('poster')<p class="field-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label>Link video / YouTube URL</label>
                        <input type="text" name="video_url" value="{{ old('video_url', $movie->video_url) }}"
                               placeholder="https://youtube.com/watch?v=...">
                    </div>
                </div>
            </div>

            <div class="card full">
                <p class="card-title">Diễn viên</p>
                <textarea name="actors" placeholder="VD: Ngô Kinh, Trương Dịch Hưng..." style="min-height:80px">{{ old('actors', $movie->actors) }}</textarea>
                <p style="color:#4b5563; font-size:12px; margin:6px 0 0">Nhập tên các diễn viên, cách nhau bởi dấu phẩy.</p>
            </div>

            <div class="card full ep-section" id="episodesSection">
                <p class="card-title">Danh sách tập</p>
                <table class="ep-table">
                    <thead>
                        <tr>
                            <th style="width:70px">Tập</th>
                            <th>Tên tập</th>
                            <th>Link video</th>
                            <th style="width:100px">Thời lượng (phút)</th>
                            <th style="width:40px"></th>
                        </tr>
                    </thead>
                    <tbody id="epBody"></tbody>
                </table>
                <button type="button" class="btn-add-ep" onclick="addEpisode()">＋ Thêm tập</button>
            </div>

            <div class="full" style="padding-top:4px">
                <button class="btn-save" type="submit">Cập nhật phim</button>
            </div>

        </div>
    </form>
</main>

<script>
let epCount = 0;
let lastEpNum = 0;

function toggleEpisodes(type) {
    const sec = document.getElementById('episodesSection');
    if (type === 'Phim bộ') {
        sec.classList.add('show');
    } else {
        sec.classList.remove('show');
    }
}

function addEpisode(num, title, url, dur) {
    epCount++;
    const n = epCount;
    const epNum = (num != null && num !== '') ? num : lastEpNum + 1;
    if (epNum > lastEpNum) lastEpNum = epNum;

    const tbody = document.getElementById('epBody');
    const tr = document.createElement('tr');
    tr.className = 'ep-row';
    tr.id = 'ep-' + n;
    tr.innerHTML = `
        <td><input type="number" name="episodes[${n}][episode_number]" value="${epNum}" min="1" style="width:64px"
            oninput="updateLastEpNum()"></td>
        <td><input type="text" name="episodes[${n}][title]" value="${title != null ? title : ''}" placeholder="Tên tập" style="width:100%"></td>
        <td><input type="text" name="episodes[${n}][video_url]" value="${url != null ? url : ''}" placeholder="Link video" style="width:100%"></td>
        <td><input type="number" name="episodes[${n}][duration]" value="${dur != null ? dur : ''}" placeholder="Phút" min="1" style="width:90px"></td>
        <td><button type="button" class="btn-del-ep" onclick="removeEp(${n})">×</button></td>
    `;
    tbody.appendChild(tr);
}

function updateLastEpNum() {
    let max = 0;
    document.querySelectorAll('#epBody input[type=number]').forEach(inp => {
        if (inp.name && inp.name.includes('episode_number')) {
            const v = parseInt(inp.value) || 0;
            if (v > max) max = v;
        }
    });
    lastEpNum = max;
}

function removeEp(n) {
    const el = document.getElementById('ep-' + n);
    if (el) { el.remove(); updateLastEpNum(); }
}

function previewPoster(input) {
    const img = document.getElementById('posterPreview');
    if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.style.display = 'block';
    }
}

// Init
toggleEpisodes(document.getElementById('typeSelect').value);

// Load existing episodes
@foreach($movie->episodes as $ep)
    addEpisode({{ $ep->episode_number }}, {{ json_encode($ep->title) }}, {{ json_encode($ep->video_url) }}, {{ $ep->duration ?? 'null' }});
@endforeach
</script>
    <div class="mode-switcher">
        <a href="/movies" class="mode-btn">Website</a>
        <a href="/admin/dashboard" class="mode-btn active">Admin</a>
    </div>
</body>
</html>
