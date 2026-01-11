<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
ob_start();
$usu = $_SESSION["usuario"];
$estado = '';
$tipo = '';
//$idsucursal=$_SESSION["sucursal"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Incluye Bootstrap CSS en el encabezado -->
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        .form-inline input {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
        <div class="main-content">
            <?php include('../central/cabecera.php'); ?>
            <hr />
            <br />
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                NOTA DE CREDITO
                            </div>
                        </div>
                        <div class="panel-body">
                            <form role="form" name="miformulario" action="capturar.php" method="post">
                                <div class="col-md-6 form-group">
                                    <label><strong>TIPO DE COMPROBANTE:(*)</strong></label>
                                    <input type="text" class="form-control" name="tico" id="tico" required
                                        value="NOTA DE CREDITO" disabled />
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><strong>MOTIVO:(*)</strong></label>
                                    <input type="text" class="form-control" name="motivo" id="motivo" required
                                        value="ANULACION DE LA OPERACION" disabled />
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><strong>FECHA DE EMISION:(*)</strong></label>
                                    <input type="date" class="form-control" name="fecha" id="fecha" required />
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><strong>SERIE Y CORRELATIVO REFERENCIA:(*)</strong></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control mr-2" name="serie_v" id="serie_v"
                                            placeholder="Serie" required />
                                        <input type="text" class="form-control mr-2" name="correlativo_v"
                                            id="correlativo_v" placeholder="Correlativo" required />
                                        <button id="enviar" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><strong>SERIE:(*)</strong></label>
                                    <select name="serie_n" id="serie_n" class="form-control" required>
                                        <option value="">SELECCIONE</option>
                                        <option value="BN01">BN01</option>
                                        <option value="FN01">FN01</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><strong>CORRELATIVO:(*)</strong></label>
                                <input type="text" class="form-control" required readonly="true" name="correlativo_n" id="correlativo_n"/>
                                </div>
                        </div>

                        <div class="panel-footer">
                            <div align="right">
                                <div align="left">
                                    (*) campos obligatorios
                                </div>
                                <button type="submit" name="funcion" value="registrar"
                                    class="btn btn-info btn-icon icon-left"><i
                                        class="entypo-check"></i>Registrar</button>
                                <a class="btn btn-green btn-icon icon-left" href="index.php"><i
                                        class="entypo-cancel"></i>Cancelar</a>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>

                <!-- fin colmd-12 -->
                <div class="col-md-12">
                    <div class="panel panel-info" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                COMPROBAR COMPROBANTE
                            </div>
                        </div>
                    </div>

                    <div id="reporte_resultado">
                        <!-- Aquí se mostrará el reporte generado -->
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Incluye Bootstrap JS y jQuery en el pie del documento -->
</body>

</html>
<?php include("../central/pieproducto.php"); ?>
<script>
    $('#serie_n').change(function () {
        var serie_n = $('#serie_n').val();
        var correlativo_n = $('#correlativo_n').val();
        $.ajax({
            url: "obtener_notacredito.php",
            method: "POST",
            data: { serie_n: serie_n, correlativo_n: correlativo_n },
            success: function (data) {
                if (serie_n == 'BN01') {
                    $('#correlativo_n').val(data);
                   // console.log(data);
                } else if (serie_n == 'FN01') {
                    $('#correlativo_n').val(data);
                } else if (serie_n == '') {
                    $('#correlativo_n').val('');
                }
            }
        });
    });
</script>
<script>
    document.getElementById('enviar').addEventListener('click', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe de manera tradicional

        var serie = document.getElementById('serie_v').value;
        var correlativo = document.getElementById('correlativo_v').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'buscar_reporte.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Actualiza el contenedor con el resultado
                document.getElementById('reporte_resultado').innerHTML = xhr.responseText;
            } else {
                console.error('Error en la solicitud');
            }
        };
        xhr.send('serie_v=' + encodeURIComponent(serie) + '&correlativo_v=' + encodeURIComponent(correlativo));
    });
</script>