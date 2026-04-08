<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tulis Artikel</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
        label { display: block; font-size: 14px; margin-bottom: 4px; font-weight: 500; }
        input, select, textarea { width: 100%; padding: 10px; font-size: 15px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; margin-bottom: 16px; }
        textarea { height: 200px; resize: vertical; }
        button { padding: 10px 24px; background: #333; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; }
        .error { color: red; font-size: 13px; margin-top: -12px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <p><a href="/">← Kembali</a></p>
    <h1>Tulis Artikel Baru</h1>

    <form action="/posts" method="POST">
        @csrf

        <label>Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" placeholder="Judul artikel...">
        @error('title') <p class="error">{{ $message }}</p> @enderror

        <label>Kategori</label>
        <select name="category_id">
            <option value="">-- Tanpa Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <label>Isi Artikel</label>
        <textarea name="body" placeholder="Tulis artikel kamu di sini...">{{ old('body') }}</textarea>
        @error('body') <p class="error">{{ $message }}</p> @enderror

        <button type="submit">Publikasikan</button>
    </form>
</body>
</html>