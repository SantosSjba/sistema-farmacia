<?php
ob_start();
include("../seguridad.php");
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$usu=$_SESSION["usuario"];
$obj= new clsConexion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
<link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
<!-- <link rel="stylesheet" href="../assets/alert/jquery-ui.css"> -->
<link rel="stylesheet" href="../assets/ui/jquery-ui.css">
<style>
.columnas2{
    text-align:center
}
.left{
    float: left;
}
.right{
    float: right;
}
.center{
   display:inline-block
}
.FACTURA,.BOLETA,.TICKET{
	display:none;
}
</style>
</head>
<body class="page-body">
<div class="page-container">
<div class="main-content">
  	<?php include('../central/cabecera.php');?>
    <div class="panel-title">
      <b>Compra</b>
    </div>
     <form class="nuevo" action="guardarcompra.php" method="post">
	    <div class="row">
	        <div class="col-sm-9">
	        <div class="panel panel-info">
	            <div class="panel-body">
							<label><strong>Producto:</strong></label>
		          <div class="col-sm-12">
								<div class="input-group">
										<input type="hidden" class="form-control"   name="idproducto" id="idproducto">
										<input type="text" class="form-control"   placeholder="buscar por descripcion" name="des" id="des">
										<input type="hidden" class="form-control"   name="pres" id="pres">
										<input type="hidden" class="form-control"   name="precio" id="precio">
										<input type="hidden" class="form-control"   name="descuento" id="descuento">
										<div class="input-group-btn">
											<button type="button" class="btn btn-info" name="btn_add" id="btn_add"><span class="glyphicon glyphicon-shopping-cart"> agrega</span></button>
										</div>
									</div>
           	</div><br>
	         </div>
	          </div>
    												<div class="panel panel-info">
    													<div class="table-responsive">
    														 <div id="live_data"></div>
    												 </div>
    												</div>
														 <div class="panel panel-info">
															 <div class="panel-footer">
                                <div align="center">
																 <button type="button" class="btn btn-info" onClick="location.href='limpiar.php'" ><span class="glyphicon glyphicon-refresh"> Nuevo</span></button>
																<button type="submit"  class="btn btn-primary"><span class="glyphicon glyphicon glyphicon-floppy-saved"> Registrar</span></button>

															 </div>
                               </div>
														 </div>
	          </div>

	        <div class="col-sm-3">
	                <div class="row">
	                    <div class="col-sm-12">
												<div class="panel panel-info">
												<div class="panel-heading">
														 <div id="live_total"></div>
												</div>
													</div>
	                        </div>
	                    <div class="col-sm-12">
	                          <div class="panel panel-info">
	                            <div class="panel-body">
                          <label>TIPO DOCUMENTO:</label>
                          <select  class="form-control" name="docu" required>
                          <option value="FACTURA">FACTURA</option>
                          <option value="BOLETA">BOLETA</option>
                          </select><br>
                          <label>Nº DE ORDEN:</label>
													<input type="text"  class="form-control" required name="numdocu" id="numdocu"/><br>

													<label>PROVEEDOR:</label>
                          	<input type="hidden"  name="idlab_pro" required id="idlab_pro"/>
													<!-- <input type="text" class="form-control" required name="prov" id="prov"/> -->
                          	<textarea rows="2" name="prov"  id="prov" required class="form-control"></textarea>
                          <br>

													<label>FECHA DE EMISION:</label>
													<input type="text"id="fecha" name="fecha" value="<?php echo (date('Y-m-d'));?>" class="form-control"readonly /><br>

                    	<div class="table-responsive">
                    		 <div id="live_igv"></div>
                     </div>
	                            </div>
	                          </div>
	                    </div>
	                </div>
	        </div>
	    </div>
      </form>
	</div>
</div>
  <?php include("../central/pieproducto.php");?>
<script src="../assets/alert/alertify/alertify.js"></script>
<!-- <script src="../assets/alert/jquery-ui.js"></script> -->
<script src="../assets/ui/jquery-ui.min.js"></script>
<script type="text/javascript">
//busquedaproductos
$(function() {
            $("#des").autocomplete({
                source: "busquedaproductos.php",
                minLength: 2,
                select: function(event, ui) {
					event.preventDefault();
          $('#cod').val(ui.item.codigo);
					$('#des').val(ui.item.descripcion);
					$('#pres').val(ui.item.presentacion);
					$('#precio').val(ui.item.precio);
					$('#descuento').val(ui.item.descuento);
					$('#idproducto').val(ui.item.idproducto);
			     }
        });
		});

//busqueda de clientes
$(function() {
            $("#prov").autocomplete({
                source: "busquedaprovedor.php",
                minLength: 2,
                select: function(event, ui) {
					event.preventDefault();
            $('#prov').val(ui.item.nombres);
				   	$('#idlab_pro').val(ui.item.idcliente);
			     }
            });
		});
</script>
<script>
$(document).ready(function(){
      function fetch_data()
      {
           $.ajax({
                url:"consultacarrito.php",
                method:"POST",
                success:function(data){
                     $('#live_data').html(data);
                }
           });
      }
      fetch_data();
						//calculo del igv , subtotal, etc
						function fetch_igv()
						{
								 $.ajax({
											url:"consultaigv.php",
											method:"POST",
											success:function(data){
													 $('#live_igv').html(data);

											}
								 });
						}
						fetch_igv();

						function fetch_total()
						{
								 $.ajax({
											url:"consultatotal.php",
											method:"POST",
											success:function(data){
													 $('#live_total').html(data);

											}
								 });
						}
						fetch_total();

	// guardar por descripcion
	$(document).on('click', '#btn_add', function(){
			  var idproducto = $('#idproducto').val();
				var des = $('#des').val();
				var pres = $('#pres').val();
				var precio = $('#precio').val();
				var descuento = $('#descuento').val();
			 $.ajax({
						url:"guardarcarrito.php",
						method:"POST",
						data:{idproducto:idproducto,des:des,pres:pres,precio:precio,descuento:descuento},
						dataType:"text",
								 success:function(data){
									 console.log(data);
										//alertify.alert('Agregar',data);
										fetch_data();
										fetch_igv();
										fetch_total();
										limpiar();
								 }
			 })
	});

	$(document).on('click', '.btn_delete', function(){
			 var id=$(this).data("id3");
						$.ajax({
								 url:"eliminarcarrito.php",
								 method:"POST",
								 data:{id:id},
								 dataType:"text",
								 success:function(data){
									fetch_data();
									fetch_igv();
									fetch_total();
								 }
						});
	});

	  function limpiar()
      {
	       $('#cod').val('');
         $('#des').val('');
         $('#pres').val('');
         $('#precio').val('');
				 $('#idproducto').val('');
         $('#des').focus();
      }
      function edit_data(id, text, cantidad){
          $.ajax({
               url:"actualizarcarrito.php",
               method:"POST",
               data:{id:id,text:text,cantidad:cantidad},
               dataType:"text",

          }).success(function(data){
          alertify.alert('mensaje',data);
           //alert(data);
           fetch_data();
          fetch_igv();
          fetch_total();
          });
     }
     function edit_datap(id, text, precio){
         $.ajax({
              url:"actualizarcarritop.php",
              method:"POST",
              data:{id:id, text:text,precio:precio},
              dataType:"text",

         }).success(function(data){
      alertify.alert('mensaje',data);
          //alert(data);
          fetch_data();
           fetch_igv();
           fetch_total();
         });
    }
			$(document).on('blur', '.cantidad', function(event){
							event.preventDefault();
					 var id = $(this).attr("id2");
					 var cantidad = $(this).text();
					 edit_data(id,cantidad,"cantidad");
			});

			$(document).on('blur', '.precio', function(event){
							event.preventDefault();
					 var id = $(this).attr("id1");
					 var precio = $(this).text();
					 edit_datap(id,precio,"precio");
			});
 });
</script>
</body>
</html>
