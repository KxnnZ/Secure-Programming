<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar</title>
  <style>
    body{font-family:system-ui;background:#f6f7f9;margin:0}
    .card{max-width:420px;margin:8vh auto;background:#fff;padding:24px;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.06)}
    label{display:block;margin:10px 0 6px}
    input{width:100%;padding:10px;border:1px solid #dcdfe4;border-radius:8px}
    .row{display:flex;justify-content:space-between;align-items:center;margin-top:12px}
    button{padding:10px 14px;border:0;border-radius:8px;background:#222;color:#fff;cursor:pointer}
    .error{background:#ffe8e8;color:#a40000;padding:10px;border-radius:8px;margin-bottom:12px}
    .link{font-size:13px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Daftar Akun</h2>

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/register">
      @csrf
      <label>Username (Max 20 Letters)</label>
      <input type="text" name="username" value="{{ old('username') }}" required
            pattern="[A-Za-z]{3,20}" title="3-20 huruf A-Z">

      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>

      <label>Password (min 8)</label>
      <input type="password" name="password" required>

      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" required>

      <div class="row">
        <span class="link">Sudah punya akun? <a href="/login">Login</a></span>
        <button type="submit">Daftar</button>
      </div>
    </form>
  </div>
</body>
</html>
