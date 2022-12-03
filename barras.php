<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $db = 'NODEMCU';

    $link = mysqli_connect($host, $user, $password, $db);

    $sql = "SELECT humedad, fecha from datos order by fecha";
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

<div id = "graficaBarras"></div>

<script type = "text/javascript">
    function crearCadenaBarras(json){
        var parsed = JSON.parse(json);
        var arr = [];
        for(var x in parsed){
            arr.push(parsed[x]);
        }
        return arr;
    }
</script>

<script type = "text/javascript">

    datosX = crearCadenaBarras('<?php echo $datosX ?>');
    datosY = crearCadenaBarras('<?php echo $datosY ?>');
    
    var data = [
        {
            x: datosX,
            y: datosY,
            type: 'bar',
            marker: {
                color: '#009879'
            }
        }
    ];

    var layout = {
        title: 'Gráfica de Barras de Humedad',
        font:{
            family: 'Raleway, sans-serif'
        },
        xaxis: {
            title: 'Fechas',
            tickangle: -45
        },
        yaxis: {
            title: 'Humedad'
        },
        bargap :0.05
    };

    Plotly.newPlot('graficaBarras', data, layout);
</script>