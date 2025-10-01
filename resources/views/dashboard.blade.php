<!doctype html>
<html><head><meta charset="utf-8"><title>Dashboard</title></head>
<body style="font-family:system-ui">
  <h2>Halo, {{ auth()->user()->username }} 👋</h2>
  <form method="POST" action="/logout">@csrf <button type="submit">Logout</button></form>
</body></html>
