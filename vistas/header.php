<?php
if (strlen(session_id()) < 1) //Si la variable de session no esta iniciada
{
  session_start();
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ventas | VENTAS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/favicon.ico">

  <!--DATATABLES-->
  <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
  <!--Botones-->
  <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">

  <!--Responsive-->
  <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">

  <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">

  <!-- Estilos personales -->
  <link rel="stylesheet" href="css/estilosFondo.css">


</head>

<body class="hold-transition skin-red-light sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">TT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>TopTech</b></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/usuarios/admin.png?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="../files/usuarios/admin.?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    Sistema de ventas TopTech
                  </p>
                </li>

                <!-- Menu Footer-->
                <div class="user-footer bg-orange">

                  <div class="text-center">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-primary btn-flat ">Cerrar Sesión</a>
                  </div>
                </div>
              </ul>
            </li>

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"></li>
          <?php
          if ($_SESSION['escritorio'] == 1) {
            echo
            '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Escritorio</span>
                  </a>
                </li>';
          }

          if ($_SESSION['almacen'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Almacén</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                      <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                    </ul>
                  </li>';
          }
          if ($_SESSION['compras'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i>
                      <span>Compras</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Compras</a></li>
                      <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                    </ul>
                  </li>';
          }
          if ($_SESSION['ventas'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Ventas</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                      <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                    </ul>
                  </li>';
          }
          if ($_SESSION['acceso'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-folder"></i> <span>Usuarios</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                    </ul>
                  </li>';
          }
          if ($_SESSION['consultac'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Compras</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a></li>                
                    </ul>
                  </li>';
          }

          if ($_SESSION['consultav'] == 1) {
            echo
            '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>                
                    </ul>
                  </li>';
          }
          ?>


        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>