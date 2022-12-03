<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $db = 'NODEMCU';

    $link = mysqli_connect($host, $user, $password, $db);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>IOT</title>
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	  <script src="librerias/jquery-3.3.1.min.js"></script>
	  <script src="librerias/plotly-latest.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="estilos.css"/>
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
    <script
      src="https://kit.fontawesome.com/eb496ab1a0.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body onload="table()">
  <script>
    const table = () => {
      const xhttp = new XMLHttpRequest();
      xhttp.onload = () => {
          document.getElementById('table').innerHTML = xhttp.response;
      }
      xhttp.open("GET", "datos.php");
      xhttp.send()
    }
    setInterval(() => {
        table();
    }, 5000);
  </script>
    <header>
      <!-- !:::::La línea de búsqueda::::: -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.html">
            <img src="./images/logo.png" alt="LOGO" width="" height="70" />
          </a>
          <div
            class="collapse navbar-collapse d-flex justify-content-end"
            id="navbarNavDropdown"
          >
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="./index.html">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./acercade.html">Acerca de</a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link active"
                  aria-current="page"
                  href="./datos.html"
                  >Datos</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./equipo.html"
                  >Conoce a nuestro equipo</a
                >
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- !:::::El texto en la imagen::::: -->
      <div
        class="cover d-flex justify-content-end align-items-start flex-column p-5"
      >
        <h1>Aquar-IoT</h1>
        <p>Bringing the future to your aquarium</p>
      </div>
    </header>
    <section>
      <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
          <?php
                $data = file_get_contents("http://192.168.137.133/");
                $decode = json_decode($data, true);
                $query1 = 'INSERT INTO datos (temperatura, humedad, fecha) VALUES ('.$decode["temperatura"].','.$decode["humedad"].',"'.date("Y-m-d").'");';
                $query3 = 'INSERT INTO datos_int (temperatura_int, fecha_int) VALUES ('.$decode["temperatura_int"].',"'.date("Y-m-d").'");';
                $resultado1 = mysqli_query($link,$query1);
                $resultado3 = mysqli_query($link,$query3);
            ?>

            <!-- Sensor de Temperatura y Humedad en el Ambiente -->

          <table class="content-table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Temperatura</th>
                <th>Humedad</th>
                <th>Fecha</th>
              </tr>
            </thead>


            <?php             
                  $query2 = 'SELECT * FROM datos'; 
                  $resultado2 = mysqli_query($link,$query2); 

                  while($fila = mysqli_fetch_array($resultado2)){

                        $id = $fila['id'];
                        $temperatura = $fila['temperatura'];
                        $humedad = $fila['humedad'];
                        $fecha = $fila['fecha'];

                        echo  '<tr>
                        <td>'.$id.'</td>
                        <td>'.$temperatura.'</td>
                        <td>'.$humedad.'</td>
                        <td>'.$fecha.'</td>
                        </tr>';
                    }
            ?>
          </table>

          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-primary">
                  <div class="panel panel-heading">
                    Gráficas Temperatura y Humedad Ambiental
                  </div>
                  <div class="panel panel-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div id="cargaLineal"></div>
                      </div>
                      <div class="col-sm-6">
                        <div id="cargaBarras"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sensor Temperatura Interna  -->

          <table class="content-table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Temperatura Interna</th>
                <th>Fecha</th>
              </tr>
            </thead>

            <?php

                    $query4 = 'SELECT * FROM datos_int';
                    $resultado4 = mysqli_query($link, $query4);

                    while($fila = mysqli_fetch_array($resultado4)){
                        $id_int = $fila['id_int'];
                        $temperatura_int = $fila['temperatura_int'];
                        $fecha_int = $fila['fecha:int'];

                        echo  '<tr>
                        <td>'.$id_int.'</td>
                        <td>'.$temperatura_int.'</td>
                        <td>'.$fecha_int.'</td>
                        </tr>';
                    }
                        mysqli_close($link);
            ?>
          </table>

          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-primary">
                  <div class="panel panel-heading">
                    Gráfica Temperatura Interna
                  </div>
                  <div class="panel panel-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div id="cargaLineal2"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <section>
      <footer class="foot">
        <div class="group-1">
          <div class="box">
            <figure>
              <a href="./index.html">
                <img
                  src="images/escudo.png"
                  alt="Logo de Aquar-IoT"
                />
              </a>
            </figure>
          </div>
          <div class="box">
            <h2>Sustentabilidad</h2>
            <p class="justify-text">
              Nuestra propuesta también toma en cuenta los principios de
              sustentabilidad, ya que en la búsqueda de mantener las condiciones
              optimas en acuarios se suelen usar productos que generan grandes
              cantidades de desperdicios plásticos, tales como tiras de ph, por
              lo que nuestro producto busca eliminar la producción de estos
              desperdicios.
              <br /><br />Hemos determinado que nuestra propuesta aporta a los
              siguientes Objetivos de Desarrollo Sustentable: <br />-Industria,
              innovación e infraestructura <br />-Vida submarina <br />-Alianzas
              para lograr objetivos
            </p>
          </div>
          <div class="box">
            <h2>Síguenos</h2>
            <div class="social-media">
              <a
                href="/"
                class="fa fa-facebook"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
              <a
                href="/"
                class="fa fa-instagram"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
              <a
                href="/"
                class="fa fa-youtube"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
              <a
                href="/"
                class="fa fa-twitter"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
              <a
                href="/"
                class="fa fa-linkedin"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
              <a
                href="/"
                class="fa fa-youtube"
                target="_blank"
                rel="noopener noreferrer"
              ></a>
            </div>
          </div>
        </div>
        <div class="group-2">
          <small
            >&copy; 2022 <b>Aquar-IoT</b> - Todos los Derechos
            Reservados.</small
          >
        </div>
      </footer>
    </section>
  </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaLineal').load('lineal.php');
		$('#cargaBarras').load('barras.php');
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaLineal2').load('lineal2.php');
	});
</script>