<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FARM SJB | Acceso denegado</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
  {{-- Laravel muestra esta vista sola cuando ocurre abort(403) --}}
  <div class="card bg-white border-0 shadow-sm border-5 border-top border-primary text-center p-5" style="max-width:460px">
    <div class="rounded-circle bg-danger-subtle d-inline-flex align-items-center justify-content-center mx-auto mb-3"
         style="width:62px;height:62px">
      <i class="bi bi-shield-lock text-danger fs-3"></i>
    </div>
    <h1 class="h4 fw-bold">Acceso denegado</h1>
    <p class="text-secondary small">Tu rol no tiene permiso para abrir esta página.
      Si crees que es un error, habla con el administrador del sistema.</p>
    <a href="{{ route('dashboard.index') }}" class="btn btn-primary text-white">Volver al inicio</a>
  </div>
  <script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>
