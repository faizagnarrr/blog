<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .btn { padding: 8px 16px; background: #333; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .alert { background: #d4edda; padding: 10px; border-radius: 6px; margin-bottom: 20px; }
        .card { border: 1px solid #eee; border-radius: 8px; padding: 20px; margin-bottom: 16px; }
        .card h2 { margin: 0 0 8px; font-size: 20px; }
        .card h2 a { text-decoration: none; color: #111; }
        .card h2 a:hover { text-decoration: underline; }
        .meta { font-size: 13px; color: gray; margin-bottom: 10px; }
        .badge { background: #eee; padding: 2px 10px; border-radius: 99px; font-size: 12px; }
        .excerpt { color: #444; line-height: 1.6; }
        .filter { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
        .filter a { padding: 4px 12px; border-radius: 99px; border: 1px solid #ccc; text-decoration: none; font-size: 13px; color: #333; }
        .filter a.active { background: #333; color: white; border-color: #333; }
        .actions { display: flex; gap: 8px; margin-top: 12px; }
        .btn-sm { padding: 4px 10px; font-size: 13px; text-decoration: none; border-radius: 4px; }
        .btn-edit { background: #f0f0f0; color: #333; }
        .btn-del { background: none; border: 1px solid #e55; color: #e55; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>

<nav>
    <strong style="font-size: 20px">Blog</strong>
    <div style="display:flex; gap:10px; align-items:center">
        @auth
            <span style="font-size:14px; color:gray">Halo, {{ auth()->user()->name }}</span>
            <a href="/posts/create" class="btn">+ Tulis Artikel</a>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; cursor:pointer; color:gray; font-size:14px">Logout</button>
            </form>
        @else
            <a href="/login" class="btn">Login</a>
            <a href="/register" style="font-size:14px; color:#333">Register</a>
        @endauth
    </div>
</nav>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

{{-- Filter kategori --}}
<div class="filter">
    <a href="{{ url('/') }}" class="{{ !request('category') ? 'active' : '' }}">Semua</a>
    @foreach($categories as $cat)
        <a href="{{ url('/') }}?category={{ $cat->id }}"
           class="{{ request('category') == $cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
    @endforeach
</div>

{{-- Daftar artikel --}}
@forelse($posts as $post)
    <div class="card">
        <h2><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h2>
        <div class="meta">
            Oleh <strong>{{ $post->user->name }}</strong> ·
            {{ $post->created_at->diffForHumans() }}
            @if($post->category)
                · <span class="badge">{{ $post->category->name }}</span>
            @endif
        </div>
        <div class="excerpt">{{ Str::limit($post->body, 150) }}</div>

        @auth
            @if(auth()->id() === $post->user_id)
                <div class="actions">
                    <a href="/posts/{{ $post->id }}/edit" class="btn-sm btn-edit">Edit</a>
                    <form action="/posts/{{ $post->id }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn-sm btn-del" onclick="return confirm('Hapus artikel ini?')">Hapus</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
@empty
    <p style="color:gray">Belum ada artikel.</p>
@endforelse

{{-- Pagination --}}
<div style="margin-top: 24px">
    {{ $posts->links() }}
</div>

</body>
</html>