<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="bg-light">
    <div class="navbar">
        <h5 class="navbar-title"><strong>Warriors Prueba:</strong> Agustin Escobedo Vargas</h5>
        <img class="navbar-logo" src="{{ asset('images/logo-nav.png') }}" alt="Imagen de esquina">
    </div>
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 col-12 mb-12" style="margin-top:20px">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title headers-paneles">
                            <h3>Alumnos</h3>
                            <button class="btn-alumnos" data-toggle="modal" data-target="#modalEstudiante">
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-user-graduate"></i>
                            </button>
                        </div>
                        <div class="container-tablas">
                            <table id="estudiantesTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Edad</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Grupo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estudiantes as $estudiante)
                                        <tr>
                                            <td>{{ $estudiante->nombre }}</td>
                                            <td>{{ $estudiante->apellidos }}</td>
                                            <td>{{ $estudiante->edad }}</td>
                                            <td>{{ $estudiante->email }}</td>
                                            <td>{{ $estudiante->telefono }}</td>
                                            <td>
                                                @if($estudiante->grupo)
                                                    {{ $estudiante->grupo->semestre }} - {{ $estudiante->grupo->grupo }}
                                                    ({{ $estudiante->grupo->turno }})
                                                @else
                                                    Sin grupo asignado
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalEditarEstudiante"
                                                    onclick="obtenerDatosEstudiante({{ $estudiante->id }})">
                                                    Editar
                                                </button>
                                                <form action="{{ route('estudiantes.delete', $estudiante->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="confirmarEliminacion(event)">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12 mb-12" style="margin-top:20px; margin-bottom:20px">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title headers-paneles">
                            <h3>Grupos</h3>
                            <button class="btn-grupos" data-toggle="modal" data-target="#modalGrupo">
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-users"></i>
                            </button>
                        </div>
                        <div class="container-tablas">
                            <table id="gruposTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Semestre</th>
                                        <th>Grupo</th>
                                        <th>Turno</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grupos as $grupo)
                                        <tr>
                                            <td>{{ $grupo->semestre }}</td>
                                            <td>{{ $grupo->grupo }}</td>
                                            <td>{{ $grupo->turno }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalEditarGrupo"
                                                    onclick="obtenerDatosGrupo({{ $grupo->id }})">
                                                    Editar
                                                </button>
                                                <form action="{{ route('grupos.delete', $grupo->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="confirmarEliminacion(event)">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEstudiante" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('estudiantes.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Edad</label>
                            <input type="number" name="edad" class="form-control" value="{{ old('edad') }}" min="0"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="tel" name="telefono" class="form-control" value="{{ old('telefono') }}"
                                pattern="[0-9]{10}" title="El teléfono debe tener 10 dígitos." required>
                        </div>
                        <div class="form-group">
                            <label>Grupo</label>
                            <select name="id_grupo" class="form-control" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('id_grupo') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->semestre }} - {{ $grupo->grupo }} ({{ $grupo->turno }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarGrupo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="formEditarGrupo" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Semestre</label>
                            <input type="number" name="semestre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Grupo</label>
                            <input type="text" name="grupo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Turno</label>
                            <select name="turno" class="form-control">
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                                <option value="Nocturno">Nocturno</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grupos.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Semestre</label>
                            <input type="number" name="semestre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Grupo</label>
                            <input type="text" name="grupo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Turno</label>
                            <select name="turno" class="form-control">
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                                <option value="Nocturno">Nocturno</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarEstudiante" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="formEditarEstudiante" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Edad</label>
                            <input type="number" name="edad" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="tel" name="telefono" class="form-control" pattern="[0-9]{10}"
                                title="El teléfono debe tener 10 dígitos." required>
                        </div>
                        <div class="form-group">
                            <label>Grupo</label>
                            <select name="id_grupo" class="form-control" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->semestre }} - {{ $grupo->grupo }}
                                        ({{ $grupo->turno }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#estudiantesTable').DataTable();

            $('#gruposTable').DataTable();

            @if ($errors->any())
                $('#modalEstudiante').modal('show');
            @endif

            setTimeout(function () {
                document.getElementById('success-message')?.remove();
            }, 5000);

        });
        function obtenerDatosGrupo(id) {
            fetch(`/grupos/${id}/editar`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#formEditarGrupo input[name="semestre"]').value = data.semestre;
                    document.querySelector('#formEditarGrupo input[name="grupo"]').value = data.grupo;
                    document.querySelector('#formEditarGrupo select[name="turno"]').value = data.turno;
                    document.querySelector('#formEditarGrupo').action = `/grupos/${data.id}`;
                })
                .catch(error => console.error('Error:', error));
        }

        function obtenerDatosEstudiante(id) {
            fetch(`/estudiantes/${id}/editar`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#formEditarEstudiante input[name="nombre"]').value = data.nombre;
                    document.querySelector('#formEditarEstudiante input[name="apellidos"]').value = data.apellidos;
                    document.querySelector('#formEditarEstudiante input[name="edad"]').value = data.edad;
                    document.querySelector('#formEditarEstudiante input[name="email"]').value = data.email;
                    document.querySelector('#formEditarEstudiante input[name="telefono"]').value = data.telefono;
                    document.querySelector('#formEditarEstudiante select[name="id_grupo"]').value = data.id_grupo;
                    document.querySelector('#formEditarEstudiante').action = `/estudiantes/${data.id}`;
                })
                .catch(error => console.error('Error:', error));
        }
        function confirmarEliminacion(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>