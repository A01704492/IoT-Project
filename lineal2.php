<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $db = 'NODEMCU';

    $link = mysqli_connect($host, $user, $password, $db);

    $sql = "SELECT temperatura_int, fecha_int from datos_int order by fecha_int";
    $result = mysqli_query($link, $sql);
    $valoresX = array();
    $valoresY = array();

    while ($ver = mysqli_fetch_row($result)) {
        $valoresX[]= $ver[1];
        $valoresY[]= $ver[0];
    }

    $datosX = json_encode($valoresX);
    $datosY = json_encode($valoresY);
?>

<div id = "graficaLineal1"></div>

<script type = "text/javascript">
    function crearCadenaLineal1(json){
        var parsed = JSON.parse(json);
        var arr = [];
        for(var x in parsed){
            arr.push(parsed[x]);
        }
        return arr;
    }
</script>

<script type = "text/javascript">
    
    datosX = crearCadenaLineal1('<?php echo $datosX ?>');
    datosY = crearCadenaLineal1('<?php echo $datosY ?>');

    var trace1 = {
        x: datosX,
        y: datosY,
        type: 'scatter',
        line: {
        color: '#009879',
        width: 1
        }
    };

    var layout = {
        title: 'Gráfica Lineal de Temperatura Interna',
        xaxis: {
            title: 'Fechas',
            tickangle: -45
        },
        yaxis: {
            title: 'Temperatura Interna'
        },
        font:{
            family: 'Raleway, sans-serif'
        }
    };

    var data = [trace1];

    Plotly.newPlot('graficaLineal1', data, layout);
</script>
