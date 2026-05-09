<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $movie->title }} - Lumière</title>
    <style>
        :root {
            --bg: #050505;
            --line: rgba(255,255,255,0.12);
            --text: #f5f5f5;
            --muted: #a3a3a3;
            --green: #00d760;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0; min-height: 100vh;
            background: var(--bg); color: var(--text);
            font-family: Verdana, sans-serif;
        }

        a { color: inherit; text-decoration: none; }

        /* Hero */
        .hero {
            position: relative; min-height: 520px;
            padding: 100px clamp(24px, 6vw, 80px) 48px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center 20%;
            filter: brightness(0.35) saturate(1.1);
        }

        .hero-overlay {
            position: absolute; inset: 0;
            background:
                linear-gradient(90deg, rgba(5,5,5,0.96) 0%, rgba(5,5,5,0.65) 50%, rgba(5,5,5,0.9) 100%),
                linear-gradient(0deg, #050505 0%, rgba(5,5,5,0.02) 40%);
        }

        .hero-no-poster {
            position: absolute; inset: 0;
            background: radial-gradient(circle at 70% 30%, rgba(0,215,96,0.18), transparent 50%),
                        linear-gradient(135deg, #0b1720, #040507 52%, #111827);
        }

        .nav-bar {
            position: absolute; top: 0; left: 0; right: 0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px clamp(24px, 6vw, 80px);
            z-index: 5;
        }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: #d1d5db; font-weight: 900; font-size: 14px;
        }

        .back-link:hover { color: var(--green); }

        .brand { color: white; font-size: 26px; font-weight: 900; letter-spacing: 0.08em; }
        .brand span { color: var(--green); }

        .hero-content {
            position: relative; z-index: 2; max-width: 700px;
        }

        .badges { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }

        .badge {
            border-radius: 6px; padding: 5px 10px;
            font-size: 12px; font-weight: 900;
        }

        .badge-green { background: var(--green); color: #03130a; }
        .badge-gray  { background: rgba(255,255,255,0.14); color: #e5e7eb; }
        .badge-red   { background: rgba(229,9,20,0.8); color: white; }

        h1 {
            margin: 0 0 16px;
            font-size: clamp(38px, 6vw, 80px);
            line-height: 0.95; letter-spacing: -0.08em;
            text-transform: uppercase;
        }

        .meta {
            display: flex; flex-wrap: wrap; gap: 12px;
            color: #d1d5db; font-size: 14px; font-weight: 800;
        }

        .meta-sep { color: #4b5563; }

        .desc { max-width: 600px; margin-top: 20px; color: #d1d5db; line-height: 1.75; }

        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 10px;
            border: 0; border-radius: 999px; padding: 14px 24px;
            background: var(--green); color: #03130a;
            font: inherit; font-weight: 900; cursor: pointer;
            text-decoration: none;
        }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 10px;
            border: 1px solid var(--line); border-radius: 999px; padding: 14px 24px;
            background: rgba(255,255,255,0.1); color: white;
            font: inherit; font-weight: 900; cursor: pointer;
            text-decoration: none;
        }

        /* Main layout */
        .main { padding: clamp(24px, 4vw, 60px) clamp(24px, 6vw, 80px) 80px; }

        .layout { display: grid; grid-template-columns: 1fr 300px; gap: 32px; }

        /* Video player */
        .player-wrap {
            border-radius: 20px; overflow: hidden;
            background: #000; aspect-ratio: 16/9;
            border: 1px solid var(--line);
        }

        .player-wrap iframe,
        .player-wrap video {
            width: 100%; height: 100%; border: 0; display: block;
        }

        .no-video {
            width: 100%; aspect-ratio: 16/9;
            display: grid; place-items: center;
            background: #0a0a0a; border: 1px solid var(--line);
            border-radius: 20px; color: var(--muted);
        }

        /* Episodes */
        .section { margin-top: 28px; }
        .section-title { font-size: 22px; letter-spacing: -0.04em; margin: 0 0 14px; }

        .ep-list { display: flex; flex-wrap: wrap; gap: 8px; }

        .ep-btn {
            min-width: 48px; height: 40px; padding: 0 14px;
            border: 1px solid var(--line); border-radius: 10px;
            background: rgba(255,255,255,0.07); color: #d4d4d4;
            font: inherit; font-size: 14px; font-weight: 900; cursor: pointer;
            text-decoration: none; display: grid; place-items: center;
        }

        .ep-btn.active,
        .ep-btn:hover { border-color: var(--green); color: var(--green); background: rgba(0,215,96,0.1); }

        /* Sidebar */
        .sidebar-panel {
            border: 1px solid var(--line); border-radius: 22px;
            padding: 20px; background: #0d1117;
        }

        .panel-title { font-size: 18px; letter-spacing: -0.04em; margin: 0 0 16px; }

        /* Rating inline */
        .rating-block {
            border: 1px solid var(--line); border-radius: 22px;
            padding: 22px 24px; background: #0d1117;
            margin-top: 28px;
        }

        .rating-block-top {
            display: flex; align-items: center; gap: 20px;
            flex-wrap: wrap; margin-bottom: 16px;
        }

        .avg-rating {
            font-size: 42px; font-weight: 900; letter-spacing: -0.05em;
            color: var(--green); line-height: 1;
        }

        .avg-rating small { font-size: 16px; color: var(--muted); font-weight: 400; }

        .rating-stars { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 14px; }

        .star {
            width: 40px; height: 40px; border-radius: 10px;
            border: 1px solid var(--line); background: rgba(255,255,255,0.07);
            color: #d4d4d4; font-size: 14px; font-weight: 900;
            cursor: pointer; display: grid; place-items: center;
            font-family: inherit; transition: all 0.12s;
        }

        .star:hover, .star.selected { border-color: #fbbf24; background: rgba(251,191,36,0.15); color: #fbbf24; }

        .submit-btn {
            padding: 11px 26px; border: 0; border-radius: 999px;
            background: var(--green); color: #03130a;
            font: inherit; font-weight: 900; cursor: pointer; font-size: 14px;
        }

        .submit-btn:hover { background: #00bf55; }

        .alert-success {
            border: 1px solid rgba(0,215,96,0.42); border-radius: 12px;
            padding: 11px 14px; background: rgba(0,215,96,0.1);
            color: #bbf7d0; font-size: 14px; margin-bottom: 12px;
        }

        /* Comments */
        .comment-form { margin-top: 28px; }

        .comment-input {
            width: 100%; border: 1px solid var(--line); border-radius: 16px;
            padding: 14px; background: #0a0a0a; color: white;
            font: inherit; font-size: 14px; resize: vertical; min-height: 90px;
        }

        .comment-list { margin-top: 20px; display: flex; flex-direction: column; gap: 14px; }

        .comment-item {
            border: 1px solid var(--line); border-radius: 16px;
            padding: 14px 16px; background: #0d1117;
        }

        .comment-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 8px;
        }

        .comment-author { font-weight: 900; font-size: 14px; }
        .comment-date { color: var(--muted); font-size: 12px; }

        .comment-content { color: #d1d5db; font-size: 14px; line-height: 1.6; }

        .delete-btn {
            border: 0; background: none; color: rgba(239,68,68,0.7);
            font: inherit; font-size: 13px; cursor: pointer; padding: 0;
        }

        .delete-btn:hover { color: #ef4444; }

        .empty-comments { color: var(--muted); font-size: 14px; }

        @media (max-width: 960px) {
            .layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .hero { min-height: 420px; padding: 80px 20px 36px; }
        }
    </style>
</head>
<body>

    <section class="hero">
        @if($movie->poster)
            <div class="hero-bg" style="background-image: url('{{ $movie->posterUrl() }}')"></div>
            <div class="hero-overlay"></div>
        @else
            <div class="hero-no-poster"></div>
        @endif

        <nav class="nav-bar">
            <a class="back-link" href="{{ route('movies.index') }}">← Quay lại</a>
            <a class="brand" href="{{ route('movies.index') }}">LUMIERE<span>.</span></a>
        </nav>

        <div class="hero-content">
            <div class="badges">
                @if($movie->rating > 0)
                    <span class="badge badge-green">★ {{ $movie->rating }}/10</span>
                @endif
                <span class="badge badge-gray">{{ $movie->type }}</span>
                @if($movie->year)
                    <span class="badge badge-gray">{{ $movie->year }}</span>
                @endif
                <span class="badge badge-gray">{{ $movie->category->name ?? '' }}</span>
            </div>

            <h1>{{ $movie->title }}</h1>

            <div class="meta">
                <span>{{ $movie->ratings->count() }} lượt đánh giá</span>
                <span class="meta-sep">·</span>
                <span>{{ $movie->comments->count() }} bình luận</span>
                @if($movie->type === 'Phim bộ')
                    <span class="meta-sep">·</span>
                    <span>{{ $movie->episodes->count() }} tập</span>
                @endif
            </div>

            @if($movie->description)
                <p class="desc">{{ $movie->description }}</p>
            @endif

            @auth
            <div class="hero-actions" style="margin-top:20px">
                <form method="POST" action="{{ route('watchlist.toggle', $movie) }}">
                    @csrf
                    <button type="submit" class="{{ $inWatchlist ? 'btn-secondary' : 'btn-primary' }}"
                            style="font-size:14px; padding:12px 20px">
                        {{ $inWatchlist ? '♥ Đã lưu yêu thích' : '♡ Thêm yêu thích' }}
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </section>

    <div class="main">
        <div class="layout">

            {{-- Left: video + episodes + comments --}}
            <div>
                @php
                    $ep = request()->query('ep');
                    $activeEp = $movie->episodes->firstWhere('episode_number', $ep) ?? $movie->episodes->first();
                    $videoUrl = ($movie->type === 'Phim bộ' && $activeEp) ? $activeEp->video_url : $movie->video_url;
                @endphp

                @if($videoUrl)
                    @php
                        $isYoutube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
                        if($isYoutube) {
                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $m);
                            $ytId = $m[1] ?? '';
                        }
                    @endphp
                    <div class="player-wrap">
                        @if($isYoutube && isset($ytId) && $ytId)
                            <iframe src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=0"
                                    allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        @else
                            <video controls src="{{ $videoUrl }}" preload="metadata">
                                Trình duyệt không hỗ trợ video.
                            </video>
                        @endif
                    </div>
                @else
                    <div class="no-video">
                        <span>Chưa có video cho phim này</span>
                    </div>
                @endif

                {{-- Episode list --}}
                @if($movie->type === 'Phim bộ' && $movie->episodes->count() > 0)
                    <div class="section">
                        <h3 class="section-title">Danh sách tập</h3>
                        <div class="ep-list">
                            @foreach($movie->episodes as $episode)
                                <a class="ep-btn {{ ($activeEp && $activeEp->id === $episode->id) ? 'active' : '' }}"
                                   href="{{ route('movies.show', [$movie, 'ep' => $episode->episode_number]) }}">
                                    Tập {{ $episode->episode_number }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Rating --}}
                <div class="rating-block">
                    <h3 class="section-title" style="margin:0 0 14px">Đánh giá phim</h3>
                    <div class="rating-block-top">
                        <div>
                            <div class="avg-rating">
                                {{ $movie->rating > 0 ? $movie->rating : '–' }}<small>/10</small>
                            </div>
                            <p style="color:var(--muted); font-size:13px; margin:4px 0 0">
                                {{ $movie->ratings->count() }} lượt đánh giá
                            </p>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('ratings.store', $movie) }}" id="ratingForm"
                                  style="flex:1; min-width:220px">
                                @csrf
                                <input type="hidden" name="score" id="scoreInput" value="{{ $userRating ?? '' }}">
                                <p style="font-size:13px; color:var(--muted); margin:0 0 10px">
                                    {{ $userRating ? "Bạn đã đánh giá: {$userRating}/10" : 'Chọn điểm của bạn:' }}
                                </p>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 10; $i++)
                                        <button type="button" class="star {{ $userRating == $i ? 'selected' : '' }}"
                                                onclick="selectRating({{ $i }})">{{ $i }}</button>
                                    @endfor
                                </div>
                                @if(session('rating_success'))
                                    <div class="alert-success" style="margin-bottom:12px">{{ session('rating_success') }}</div>
                                @endif
                                <button class="submit-btn" type="submit">Lưu đánh giá</button>
                            </form>
                        @else
                            <p style="color:var(--muted); font-size:14px; margin:0">
                                <a href="{{ route('login') }}" style="color:var(--green); font-weight:900">Đăng nhập</a> để đánh giá phim.
                            </p>
                        @endauth
                    </div>
                </div>

                {{-- Comments --}}
                <div class="section">
                    <h3 class="section-title">Bình luận ({{ $movie->comments->count() }})</h3>

                    @if(session('comment_success'))
                        <div class="alert-success">{{ session('comment_success') }}</div>
                    @endif

                    @auth
                        <form class="comment-form" method="POST" action="{{ route('comments.store', $movie) }}">
                            @csrf
                            <textarea class="comment-input" name="content" placeholder="Viết bình luận của bạn..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <p style="color:#ef4444; font-size:13px; margin:6px 0 0">{{ $message }}</p>
                            @enderror
                            <div style="margin-top:10px">
                                <button class="btn-primary" type="submit" style="font-size:14px; padding:11px 20px">Gửi bình luận</button>
                            </div>
                        </form>
                    @else
                        <p style="color:var(--muted); font-size:14px">
                            <a href="{{ route('login') }}" style="color:var(--green); font-weight:900">Đăng nhập</a> để bình luận.
                        </p>
                    @endauth

                    <div class="comment-list">
                        @forelse($movie->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->user->name ?? 'Ẩn danh' }}</span>
                                    <div style="display:flex; align-items:center; gap:10px">
                                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                        @auth
                                            @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="delete-btn" type="submit" onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <p class="comment-content">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="empty-comments">Chưa có bình luận. Hãy là người đầu tiên!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right: movie info --}}
            <div>
                <div class="sidebar-panel">
                    <p class="panel-title">Thông tin phim</p>
                    <table style="width:100%; border-collapse:collapse; font-size:14px">
                        <tr>
                            <td style="color:var(--muted); padding:6px 0; width:40%">Thể loại</td>
                            <td style="font-weight:800">{{ $movie->category->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td style="color:var(--muted); padding:6px 0">Loại</td>
                            <td style="font-weight:800">{{ $movie->type }}</td>
                        </tr>
                        @if($movie->year)
                        <tr>
                            <td style="color:var(--muted); padding:6px 0">Năm</td>
                            <td style="font-weight:800">{{ $movie->year }}</td>
                        </tr>
                        @endif
                        @if($movie->type === 'Phim bộ')
                        <tr>
                            <td style="color:var(--muted); padding:6px 0">Số tập</td>
                            <td style="font-weight:800">{{ $movie->episodes->count() }} tập</td>
                        </tr>
                        @endif
                        @if($movie->country)
                        <tr>
                            <td style="color:var(--muted); padding:6px 0">Quốc gia</td>
                            <td style="font-weight:800">{{ $movie->country }}</td>
                        </tr>
                        @endif
                        @if($movie->actors)
                        <tr>
                            <td style="color:var(--muted); padding:6px 0; vertical-align:top">Diễn viên</td>
                            <td style="font-weight:700; line-height:1.6">{{ $movie->actors }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        .mode-switcher { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; border-radius:999px; border:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); backdrop-filter:blur(16px); padding:4px; gap:2px; box-shadow:0 4px 28px rgba(0,0,0,0.5); }
        .mode-btn { border-radius:999px; padding:8px 16px; font-size:13px; font-weight:900; color:#4b5563; text-decoration:none; transition:all 0.15s; white-space:nowrap; }
        .mode-btn.act { background:var(--green); color:#03130a; }
        .mode-btn:hover:not(.act) { color:#d1d5db; }
    </style>
    <script>
        function selectRating(score) {
            document.getElementById('scoreInput').value = score;
            document.querySelectorAll('.star').forEach((btn, i) => {
                btn.classList.toggle('selected', i < score);
            });
        }
    </script>
    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="mode-switcher">
        <a href="{{ route('movies.index') }}" class="mode-btn act">Website</a>
        <a href="{{ route('admin.dashboard') }}" class="mode-btn">Admin</a>
    </div>
    @endif
</body>
</html>
