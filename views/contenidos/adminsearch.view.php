<div class="container-fluid">
<div class="page-header">
    <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>ADMINISTRADORES</small></h1>
</div>
<p class="lead">Buscador de Administradores. Para buscar el respectivo Administrador ingresa su nombre o su número de cédula correspondiente.</p>
</div>

<div class="container-fluid">
<ul class="breadcrumb breadcrumb-tabs">
    <li>
        <a href="<?php echo SERVERURL; ?>admin/" class="btn btn-info">
            <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ADMINISTRADOR
        </a>
    </li>
    <li>
        <a href="<?php echo SERVERURL; ?>adminlist" class="btn btn-success">
            <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES
        </a>
    </li>
    <li>
        <a href="<?php echo SERVERURL; ?>adminsearch/" class="btn btn-primary">
            <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR
        </a>
    </li>
</ul>
</div>

<div class="container-fluid">
<form class="well">
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="form-group label-floating">
                <span class="control-label">¿A quién estas buscando?</span>
                <input class="form-control" type="text" name="search_admin_init" required="">
            </div>
        </div>
        <div class="col-xs-12">
            <p class="text-center">
                <button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
            </p>
        </div>
    </div>
</form>
</div>

<div class="container-fluid">
<form class="well">
    <p class="lead text-center">Su última búsqueda fue <strong>“Busqueda”</strong></p>
    <div class="row">
        <input class="form-control" type="hidden" name="search_admin_destroy">
        <div class="col-xs-12">
            <p class="text-center">
                <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
            </p>
        </div>
    </div>
</form>
</div>

<!-- Panel listado de busqueda de administradores -->
<div class="container-fluid">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">NOMBRES</th>
                        <th class="text-center">APELLIDOS</th>
                        <th class="text-center">TELÉFONO</th>
                        <th class="text-center">A. CUENTA</th>
                        <th class="text-center">A. DATOS</th>
                        <th class="text-center">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>7890987651</td>
                        <td>Nombres</td>
                        <td>Apellidos</td>
                        <td>Telefono</td>
                        <td>
                            <a href="#!" class="btn btn-success btn-raised btn-xs">
                                <i class="zmdi zmdi-refresh"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#!" class="btn btn-success btn-raised btn-xs">
                                <i class="zmdi zmdi-refresh"></i>
                            </a>
                        </td>
                        <td>
                            <form>
                                <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>7890987651</td>
                        <td>Nombres</td>
                        <td>Apellidos</td>
                        <td>Telefono</td>
                        <td>
                            <a href="#!" class="btn btn-success btn-raised btn-xs">
                                <i class="zmdi zmdi-refresh"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#!" class="btn btn-success btn-raised btn-xs">
                                <i class="zmdi zmdi-refresh"></i>
                            </a>
                        </td>
                        <td>
                            <form>
                                <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <nav class="text-center">
            <ul class="pagination pagination-sm">
                <li class="disabled"><a href="javascript:void(0)">«</a></li>
                <li class="active"><a href="javascript:void(0)">1</a></li>
                <li><a href="javascript:void(0)">2</a></li>
                <li><a href="javascript:void(0)">3</a></li>
                <li><a href="javascript:void(0)">4</a></li>
                <li><a href="javascript:void(0)">5</a></li>
                <li><a href="javascript:void(0)">»</a></li>
            </ul>
        </nav>
    </div>
</div>
</div>