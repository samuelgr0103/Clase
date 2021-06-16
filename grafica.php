<?php
//Importar la conexion
require 'conexion.php';
$db = conectarDB();
//Escribir en el query
$date = date('Y/m/d');

$query = "SELECT *FROM inscripciones where fechaCursoVenta='${date}'";
$suma="SELECT  nombrecurso, count(1) as total,fechaCursoVenta from inscripciones where fechaCursoVenta='${date}' GROUP BY nombrecurso ;";
//consultar la BD
$resultadoConsulta = mysqli_query($db, $query);
$resultadoConsulta2=mysqli_query($db,$suma);
$resultadoConsulta3=mysqli_query($db,$suma);

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['fecha'];
    $query = "SELECT *FROM inscripciones where fechaCursoVenta='${date}'";
    $suma="SELECT  nombrecurso, count(1) as total,fechaCursoVenta from inscripciones where fechaCursoVenta='${date}' GROUP BY nombrecurso ;";
    //consultar la BD
$resultadoConsulta = mysqli_query($db, $query);
$resultadoConsulta2=mysqli_query($db,$suma);
$resultadoConsulta3=mysqli_query($db,$suma);

}
$resultado=$_GET['resultado']?? null;

?>
	<script type="text/javascript" src="/jquery-1.12.0.min.js"></script>
	<script type="text/javascript" src="/dist/Chart.bundle.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		
		var datos = {
			labels : [
                <?php while ($consulta = mysqli_fetch_assoc($resultadoConsulta2)) : ?>"<?php echo $consulta['nombrecurso']; ?>" ,<?php endwhile;?>],
			datasets : [{
				label : "Total de cursos Comprados",
				backgroundColor : "rgba(220,120,220,0.5)",
				data : [<?php while ($consulta2 = mysqli_fetch_assoc($resultadoConsulta3)) : ?> <?php echo filter_var($consulta2['total'],FILTER_VALIDATE_INT); ?>,<?php endwhile; ?>]
			}
			]
		};


		var canvas = document.getElementById('chart').getContext('2d');
		window.bar = new Chart(canvas, {
			type : "bar",
			data : datos,
			options : {
				elements : {
					rectangle : {
						borderWidth : 1,
						borderColor : "rgb(0,255,0)",
						borderSkipped : 'bottom'
					}
				},
				responsive : true,
				title : {
					display : true,
					text : "Prueba de grafico de barras"
				}
			}
		});


		


	});
	</script>


<main class="contenedor">
    <h1 class="centrar-texto">Ventas Recetas</h1>

           <?php if(intval($resultado)===1): ?>
              <p class="alerta exito">Producto creado Correctamente</p>
              <?php elseif(intval($resultado)===2): ?>
              <p class="alerta exito">Producto Actualizado Correctamente</p>
              <?php elseif(intval($resultado)===3): ?>
              <p class="alerta exito">Producto Eliminado Correctamente</p>
    
           <?php endif; ?>
           <div class="botones-titulos">
        <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>
        <form action="" method="POST">
            <input type="date" name="fecha" id="fecha" value="<?php echo $date ?>">
            <input type="submit" value="Mostrar" class="boton boton--cafe">
        </form>
    </div>

    <table class="cursos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Receta</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar Resultados-->
            <?php while ($cursos = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo $cursos['idinscripciones']; ?></td>
                    <td><?php echo $cursos['nombrecurso']; ?></td>
                    <td><?php echo $cursos['precio']; ?></td>
                    <td><?php echo $cursos['descripcion']; ?></td>
                    <td><?php echo $cursos['fechaCursoVenta']; ?></td>
                    <td><?php echo $cursos['estado']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<script>

</script>

    <div id="cancas" class="grafica">
    <canvas id="chart" width="500" height="350">

    </canvas>
    </div>
</main>
<?php

//Cerrar la conexion
mysqli_close($db);
?>