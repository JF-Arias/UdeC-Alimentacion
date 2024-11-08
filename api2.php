<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
    <!-- Cargar Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Estudiantes</h2>

        <!-- Formulario para Insertar / Editar Estudiantes -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="formEstudiante">
                    <input type="hidden" id="id_estudiante" name="id_estudiante">

                    <div class="mb-3">
                        <label for="nombre_estudiante" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellidos_estudiante" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos_estudiante" name="apellidos_estudiante" required>
                    </div>

                    <div class="mb-3">
                        <label for="edad_estudiante" class="form-label">Edad</label>
                        <input type="number" class="form-control" id="edad_estudiante" name="edad_estudiante" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Tabla para mostrar Estudiantes -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de Estudiantes</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Edad</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEstudiantes">
                        <!-- Aquí se llenarán los estudiantes con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cargar Bootstrap 5 y Axios para realizar peticiones HTTP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>
        // Cargar los estudiantes cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarEstudiantes();
        });

        // Función para obtener y mostrar los estudiantes
        function cargarEstudiantes() {
            axios.get('api.php')
                .then(function(response) {
                    const estudiantes = response.data;
                    let contenido = '';
                    estudiantes.forEach(estudiante => {
                        contenido += `
                            <tr>
                                <td>${estudiante.id_estudiante}</td>
                                <td>${estudiante.nombre_estudiante}</td>
                                <td>${estudiante.apellidos_estudiante}</td>
                                <td>${estudiante.edad_estudiante}</td>
                                <td>${estudiante.fecha_creacion}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editarEstudiante(${estudiante.id_estudiante})">Editar</button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('tablaEstudiantes').innerHTML = contenido;
                })
                .catch(function(error) {
                    console.error('Error al cargar los estudiantes:', error);
                });
        }

        // Función para insertar o actualizar un estudiante
        document.getElementById('formEstudiante').addEventListener('submit', function(e) {
            e.preventDefault();

            const idEstudiante = document.getElementById('id_estudiante').value;
            const nombreEstudiante = document.getElementById('nombre_estudiante').value;
            const apellidosEstudiante = document.getElementById('apellidos_estudiante').value;
            const edadEstudiante = document.getElementById('edad_estudiante').value;

            const data = {
                nombre_estudiante: nombreEstudiante,
                apellidos_estudiante: apellidosEstudiante,
                edad_estudiante: edadEstudiante
            };

            if (idEstudiante) {
                // Si hay un id_estudiante, actualizar el registro
                data.id_estudiante = idEstudiante;
                axios.put('api.php', data)
                    .then(function(response) {
                        alert(response.data.mensaje);
                        cargarEstudiantes();
                        limpiarFormulario();
                    })
                    .catch(function(error) {
                        console.error('Error al actualizar el estudiante:', error);
                    });
            } else {
                // Si no hay id_estudiante, insertar un nuevo registro
                axios.post('api.php', data)
                    .then(function(response) {
                        alert(response.data.mensaje);
                        cargarEstudiantes();
                        limpiarFormulario();
                    })
                    .catch(function(error) {
                        console.error('Error al insertar el estudiante:', error);
                    });
            }
        });

        // Función para editar un estudiante (carga los datos en el formulario)
        function editarEstudiante(idEstudiante) {
            axios.get('api.php')
                .then(function(response) {
                    const estudiante = response.data.find(e => e.id_estudiante == idEstudiante);
                    document.getElementById('id_estudiante').value = estudiante.id_estudiante;
                    document.getElementById('nombre_estudiante').value = estudiante.nombre_estudiante;
                    document.getElementById('apellidos_estudiante').value = estudiante.apellidos_estudiante;
                    document.getElementById('edad_estudiante').value = estudiante.edad_estudiante;
                })
                .catch(function(error) {
                    console.error('Error al cargar el estudiante:', error);
                });
        }

        // Función para limpiar el formulario después de guardar
        function limpiarFormulario() {
            document.getElementById('id_estudiante').value = '';
            document.getElementById('nombre_estudiante').value = '';
            document.getElementById('apellidos_estudiante').value = '';
            document.getElementById('edad_estudiante').value = '';
        }
    </script>
</body>
</html>
