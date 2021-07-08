<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  //iniciamos las variables de session
  session_start();

  if(!isset($_SESSION["nombre"]))
  {
    header("Location: login.html");
  }

  else  //Agrega toda la vista
  {
    require 'header.php';

    if($_SESSION['escritorio'] == 1)
    {
        require_once '../modelos/Consultas.php';
        
        $consulta = new Consultas();
        
        $rsptac = $consulta->totalCompraHoy();
        $regc = $rsptac->fetch_object();
        $totalc = $regc->total_compra;

        $rsptav = $consulta->totalVentaHoy();
        $regv = $rsptav->fetch_object();
        $totalv = $regv->total_venta;

        //Mostrar graficos 
        $compras10 = $consulta->comprasUlt10dias();
        $fechasc = '';
        $totalesc = '';

        while($regfechac = $compras10->fetch_object())
        {
            $fechasc =  $fechasc.'"'.$regfechac->fecha.'",';
            $totalesc = $totalesc.$regfechac->total.',';
        }

        //Quitamos la ultima coma
        $fechasc = substr($fechasc,0,-1);
        $totalesc = substr($totalesc,0,-1);

        //Graficos Venta
        $compras12 = $consulta->ventas12meses();
        $fechasv = '';
        $totalesv = '';

        while($regfechav = $compras12->fetch_object())
        {
            $fechasv =  $fechasv.'"'.$regfechav->fecha.'",';
            $totalesv = $totalesv.$regfechav->total.',';
        }

        //Quitamos la ultima coma
        $fechasv = substr($fechasv,0,-1);
        $totalesv = substr($totalesv,0,-1);


        //Grafico pastel
        $articulosCat = $consulta->articulosPorCategoria();
        $data = array(); // Array donde vamos a guardar los datos
        while($r = $articulosCat->fetch_object())
        {
            $data[]=$r; // Guardar los resultados en la variable $data
            //$fechasc =  $fechasc.'"'.$regfechac->fecha.'",';
            //$totalesc = $totalesc.$regfechac->total.',';
        }

?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">    
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>S/. <?php echo $totalc; ?></strong>
                                        <p>Compras</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="ingreso.php" class="small-box-footer">
                                    Compras 
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>S/. <?php echo $totalv; ?></strong>
                                        <p>Ventas</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="venta.php" class="small-box-footer">
                                    Ventas 
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Compras realizadas (día y mes)
                                </div>
                                <div class="box body">
                                    <canvas id="compras" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Ventas realizadas por mes
                                </div>
                                <div class="box body">
                                    <canvas id="ventas" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Artículos disponibles por categoría
                                </div>
                                <div class="box body">
                                    <canvas id="articulosCompra" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php
  
  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>

<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>

<script>
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Compras en S/. realizadas',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Ventas en S/. realizadas',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx3 = document.getElementById("articulosCompra").getContext('2d');
var data = {
    labels: [<?php foreach($data as $d):?>
                "<?php
                    if($d->cat=="Muebles de oficina"){
                        echo "M.Ofi";
                    } if($d->cat=="Audio y video"){
                        echo "A y V";
                    } if($d->cat=="Software"){
                        echo "Soft.";
                    } if($d->cat=="Dispositivos Electronicos"){
                        echo "D.Elect";
                    } if($d->cat=="Impresoras y Fax"){
                        echo "I y F";
                    } if($d->cat=="Gamer"){
                        echo "Gm";
                    } if($d->cat=="Videojuegos"){
                        echo "Vi";
                    }
                    //echo $d->cat
                ?>", 
                <?php endforeach; ?>],
        datasets: [{
            label: 'Cantidad de artículos',
            data: [<?php foreach($data as $d):?>
                    <?php echo $d->total;?>,
                    <?php endforeach; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
};

var options = {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true
            }
        }]
    }
};
var chart3 = new Chart(ctx3, {
    type: 'bar', /* valores: line, bar, pie*/
    data: data,
    options: options
});


/*
var compras2 = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            label: 'Compras en $ de los ultimos 10 dias',
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
*/
</script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>