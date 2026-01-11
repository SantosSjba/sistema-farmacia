<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj = new clsConexion;
$data = $obj->consultar("SELECT * FROM confi_backup WHERE idbackup='1'");
foreach ((array) $data as $row) {
  $host = $row["host"];
  $db_name = $row["db_name"];
  $user = $row["user"];
  $pass = $row["pass"];
}
?>
<style media="screen">
  a {
    color: #ffffff;
  }
</style>
<div class="page-container">
  <div class="main-content">
    <?php include('../central/cabecera.php'); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <blockquote class="blockquote-default" align="center">
            <p>
              <strong>CREAR COPIA DE RESPALDO DE LA BASE DE DATOS</strong>
            </p>
            <p>
            <div class="row">
              <div class="col-sm-12">
                <div class="col-sm-12">
                  <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-database"></i></div>
                    <div class="num" data-start="0" data-end="vc" data-postfix="" data-duration="" data-delay="0">&nbsp;
                    </div>
                    <h3><a href="backup.php">DESCARGAR</a></h3>
                  </div>

                </div>
              </div>
            </div>
          </blockquote>
        </div>
      </div>
      <div class="col-md-6">
      </div>
    </div>
  </div>
</div>
<?php include("../central/pieproducto.php"); ?>