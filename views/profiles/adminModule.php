<!-- Campos de gestión -->
<div class="container my-4">
    <div class="data-section">
        <h3 class="mb-4">Campos de gestión</h3>

        <!-- Formulario de edición -->
        <div class="mb-5">
            <h4>Vista con los datos para modificar</h4>
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" value="Administrador">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="admin@example.com">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="Nueva contraseña">
                    </div>
                    <div class="col-md-6">
                        <label for="confirmPassword" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmar nueva contraseña">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>

        <!-- Data Table -->
        <h4 class="mb-3">Tabla de datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Admin Principal</td>
                        <td>admin@example.com</td>
                        <td><span class="badge bg-primary">Super Admin</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Moderador</td>
                        <td>mod@example.com</td>
                        <td><span class="badge bg-secondary">Moderador</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Editor</td>
                        <td>editor@example.com</td>
                        <td><span class="badge bg-info">Editor</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>