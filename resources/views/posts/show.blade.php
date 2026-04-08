<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .meta { color: gray; font-size: 14px; margin-bottom: 24px; }
        .body { line-height: 1.8; color: #333; }
        a { color: #333; }
    </style>
</head>
<body>
    <p><a href="/">← Kembali</a></p>
    <h1>{{ $post->title }}</h1>
    <div class="meta">
        Oleh <strong>{{ $post->user->name }}</strong> ·
        {{ $post->created_at->format('d M Y') }}
        @if($post->category) · {{ $post->category->name }} @endif
    </div>
    <div class="body">{{ $post->body }}</div>
</body>
</html>