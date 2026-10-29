<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4">Editar Usuario: {{ $usuario->name }}</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre completo:</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $usuario->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre de usuario (Username):</label>
                        <input type="text" name="username" class="form-control"
                            value="{{ old('username', $usuario->username) }}" style="text-transform: uppercase;"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico:</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $usuario->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña nueva <span class="text-muted"
                                style="font-size: 0.85rem;">(Dejar en blanco si no deseas cambiarla)</span>:</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Grupo:</label>
                        <select name="grupo" class="form-select">
                            <option value="">Seleccione un grupo...</option>
                            <option value="CALLCENTER GT°"
                                {{ old('grupo', $usuario->grupo) == 'CALLCENTER GT°' ? 'selected' : '' }}>CALLCENTER GT°
                            </option>
                            <option value="REDES SOCIALES"
                                {{ old('grupo', $usuario->grupo) == 'REDES SOCIALES' ? 'selected' : '' }}>REDES SOCIALES
                            </option>
                            <option value="TELEMARKETING"
                                {{ old('grupo', $usuario->grupo) == 'TELEMARKETING' ? 'selected' : '' }}>TELEMARKETING
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perfil de Usuario:</label>
                        <select name="role" class="form-select" required>
                            <option value="agent" {{ $usuario->role === 'agent' ? 'selected' : '' }}>Agente</option>
                            <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Administrador
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
