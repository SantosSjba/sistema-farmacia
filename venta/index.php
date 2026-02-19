<?php
ob_start();
include("../seguridad.php");
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$usu = $_SESSION["usuario"];
$obj = new clsConexion();
/////////////////////////////////////////////////////////
$data = $obj->consultar("SELECT MAX(idventa) as idventa FROM venta");
foreach ($data as $row) {
	if ($row['idventa'] == NULL) {
		$idventa = '1';
	} else {
		$idventa = $row['idventa'] + 1;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
	<link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
	<link rel="stylesheet" href="../assets/ui/jquery-ui.css">

	<!-- <link rel="stylesheet" href="../assets/alert/jquery-ui.css"> -->
</head>

<body class="page-body">
	<div class="page-container">
		<div class="main-content">
			<?php include('../central/cabecera.php'); ?>
			<div class="panel-title">
				<b>Venta</b>
			</div>
			<div class="row">
				<div class="col-sm-9">
					<div class="panel panel-info">
						<div class="panel-body">
							<label><strong>Producto:</strong></label>
							<div class="col-sm-12">
								<form name="barcode" id="barcode_form">
									<div class="input-group">
										<input type="hidden" name="" id="idventa" value="<?php echo "$idventa"; ?>">
										<input type="text" class="form-control"
											placeholder="ingrese el codigo de barras" name="cod" id="cod">
										<div class="input-group-btn">
											<button type="submit" class="btn btn-info"><span
													class="glyphicon glyphicon-barcode"></span></button>
										</div>
									</div>
								</form>
							</div><br>
							<form id="frmVenta" name="frmVenta" method="post">
								<form name="nuevo" method="post">
									<div class="col-sm-12">
										<button type="button" class="btn btn-info"
											onclick="jQuery('#modal-1').modal('show');"><span
												class="glyphicon glyphicon-search"></span> BUSCAR</button>
									</div>
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
								<button type="button" class="btn btn-info" onClick="location.href='limpiar.php'"><span
										class="glyphicon glyphicon-refresh"> Nuevo</span></button>
								<button type="submit" name="btn_guardar" id="btn_guardar" class="btn btn-primary"><span
										class="glyphicon glyphicon-floppy-saved"> Registrar</span></button>

							</div>
						</div>
					</div>
					<div id="msn"></div>
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
									<label>TIPO COMPROBANTE:</label>
									<select name="tico" id="tico" class="form-control" required>
										<option value="">SELECCIONE</option>
										<option value="00">TICKET</option>
										<option value="01">FACTURA</option>
										<option value="03">BOLETA</option>
									</select>
									<table class="table">
										<tr>
											<td>SERIE<input type="text" class="form-control" required readonly="true"
													name="serie" id="serie" /></td>
											<td>CORRELATIVO<input type="text" class="form-control" required
													 name="correl" id="correl" readonly="true"/></td>
										</tr>
									</table>

									<!-- 	<label>Tipo Registro:</label>
																	<select name="tire" id="tire" class="form-control" required>
																					<option value="">SELECCIONE</option>
																					<option value="noenviado">SOLO GUARDAR VENTA</option>
																					<option value="enviado">ENVIAR A SUNAT AHORA</option>
																	</select> -->

									<!-- 	<label>FORMA DE PAGO:</label>
																		  <input type="text" id="fp" name="fp" value="CONTADO" class="form-control" readonly /><br>
 -->
									<label>FECHA DE EMISION:</label>
									<input type="date" id="fecha" name="fecha" value="<?php echo (date('Y-m-d')); ?>"
										class="form-control" /><br>




									<label>FORMA DE PAGO:</label>
									<select name="forma" id="forma" required class="form-control">
										<option value="">SELECCIONE</option>
										<option value="EFECTIVO">EFECTIVO</option>
										<option value="YAPE">YAPE</option>
										<option value="PLIN">PLIN</option>
										<option value="TRANSFERENCIA">TRANSFERENCIA</option>
										<option value="TARJETA">TARJETA</option>
										<option value="DEPOSITO EN CUENTA">DEPÓSITO EN CUENTA</option>
										<option value="OTRO">OTRO</option>
									</select><br>
									<table id="tarjeta">
										<tr>
											<td><label>Nº operación / Referencia:</label></td>
											<td><input type="text" id="numope" name="numope" class="form-control"
												placeholder="Opcional: número de operación" /></td>
										</tr>
									</table><br>

									<label>Tipo documento:</label>
									<select name="td" id="td" class="form-control" required>
										<option value="1" id="11" <?php if ($tipo == '1') {
											echo 'selected';
										} ?>>SIN
											DOCUMENTO</option>
										<option value="2" id="22" <?php if ($tipo == '2') {
											echo 'selected';
										} ?>>DNI
										</option>
										<option value="3" id="33" <?php if ($tipo == '3') {
											echo 'selected';
										} ?>>CARNET DE
											EXTRANJERIA</option>
										<option value="4" id="44" <?php if ($tipo == '4') {
											echo 'selected';
										} ?>>RUC
										</option>
										<option value="5" id="55" <?php if ($tipo == '5') {
											echo 'selected';
										} ?>>PASAPORTE
										</option>
										<option value="6" id="66" <?php if ($tipo == '6') {
											echo 'selected';
										} ?>>Ced.
											Diplomática de identidad</option>
									</select><br>

									<label>Numero Documento:</label>
									<div class="input-group">
									<input type="text" name="numero" class="form-control" id="numero"
										placeholder="Ingrese su número de documento">
									<span class="input-group-btn">
										<a href="#" id="search_button" class="btn btn-default"
											onclick="buscarDocumento(); return false;" title="Buscar desde la Sunat">
											<img src="../apifacturacion/sunat/sunat.png" height="17" width="17"
												aria-hidden="true">
										</a>
									</span>
									</div>
									<br>

									<label>Cliente-Razon social:</label>
									<!-- <input type="hidden" name="idcli" id="idcli" value="0"> -->
									<textarea rows="2" name="rz" id="datosCompletos" required class="form-control"
										value="publico en general">publico en general</textarea>
									<br>
									<label>Direccion:</label>
									<textarea rows="2" name="dir" id="direccion" class="form-control"></textarea><br>

									<div class="table-responsive">
										<div id="live_igv"></div>
									</div>


									<table id="efectivo">
										<tr>
											<td width="100">EFECTIVO:</td>
											<td width="200">
												<div class="input-group">
													<input type="number" min="1" id="recibo" name="recibo"
														class="form-control" placeholder="P.Enter" />
													<span class="input-group-btn">
														<button type="button" value="calcular" id="calcular"
															class="btn btn-info"><i class="entypo-minus"></i></button>
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<td width="65">VUELTO:</td>
											<td width="144">
												<h5></h5>
												<input type="text" id="vuelto" name="vuelto" readonly
													class="form-control" />
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!-- Modal busquedaproductos-->
	<div class="modal fade" id="modal-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Productos Farmaceuticos</h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="my-example" class="table table-striped">
							<thead>
								<tr>
									<th><a href="#">Descripcion</a></th>
									<th><a href="#">Presentacion</a></th>
									<th data-hide="phone"><a href="#">Precio</a></th>
									<th><a href="#">Sintoma</a></th>
									<th><a href="#">Con receta</a></th>
									<th data-hide="phone"><a href="#">Estado</a></th>
									<th data-hide="phone"><a href="#">Stock</a></th>
									<th data-hide="phone,tablet"><a href="#">Tipo</a></th>
									<th>Accion</th>
								</tr>
							</thead>
						</table>
					</div>
					<?php include_once("../central/pieproducto.php"); ?>
					<script type="text/javascript">
						$(document).ready(function () {
							tabla = $('#my-example').dataTable(
								{
									"aProcessing": true,//Activamos el procesamiento del datatables
									"aServerSide": true,//Paginación y filtrado realizados por el servidor
									dom: 'Bfrtip',//Definimos los elementos del control de tabla
									buttons: [
										// 'copyHtml5',
										// 'excelHtml5',
										// 'csvHtml5',
										// 'pdf'
									],
									"ajax":
									{
										url: 'datatable.php',
										type: "get",
										dataType: "json",
										error: function (e) {
											console.log(e.responseText);
										}
									},
									"bDestroy": true,
									"iDisplayLength": 5,//Paginación
									"order": [[0, "desc"]]//Ordenar (columna,orden)
								}).DataTable();
						});
					</script>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	</div>
	<script src="../assets/alert/alertify/alertify.js"></script>
	<script src="../assets/ui/jquery-ui.min.js"></script>
	<script src="../assets/alert/jquery-ui.js"></script>
	<script type="text/javascript">
		$(function () {
			$("#des").autocomplete({
				//autoFocus:true,
				source: "busquedaproductos.php",
				minLength: 2,
				select: function (event, ui) {
					event.preventDefault();
					//$('#cod').val(ui.item.codigo);
					$('#des').val(ui.item.descripcion);
					$('#pres').val(ui.item.presentacion);
					$('#pre').val(ui.item.precio);
					$('#dsc').val(ui.item.descuento);
					$('#idproducto').val(ui.item.idproducto);
					//	guardar();
				}
			});
		});
		//busqueda de clientes
		$(function () {
			$("#numero").autocomplete({
				source: "busquedaclientes.php",
				minLength: 2,
				select: function (event, ui) {
					event.preventDefault();
					$('#numero').val(ui.item.nrodoc);
					$('#datosCompletos').val(ui.item.nombres);
					$('#direccion').val(ui.item.direccion);
					$('#td').val(ui.item.id_tipo_docu);
				}
			});
		});
	</script>
	<script type="text/javascript">
		function VentanaCentrada(theURL, winName, features, myWidth, myHeight, isCenter) { //v3.0
			if (window.screen) if (isCenter) if (isCenter == "true") {
				var myLeft = (screen.width - myWidth) / 2;
				var myTop = (screen.height - myHeight) / 2;
				features += (features != '') ? ',' : '';
				features += ',left=' + myLeft + ',top=' + myTop;
			}
			win = window.open(theURL, winName, features + ((features != '') ? ',' : '') + 'width=' + myWidth + ',height=' + myHeight);
			var timer = setInterval(function () {
				if (win.closed) {
					clearInterval(timer);
					// alert('closed');
					window.location = 'index.php';
				}
			}, 1000);
		}
	</script>
	<script>
		$(document).ready(function () {
			function fetch_data() {
				$.ajax({
					url: "consultacarrito.php",
					method: "POST",
					success: function (data) {
						$('#live_data').html(data);
					}
				});
			}
			fetch_data();
			//calculo del igv , subtotal, etc
			function fetch_igv() {
				$.ajax({
					url: "consultaigv.php",
					method: "POST",
					success: function (data) {
						$('#live_igv').html(data);

					}
				});
			}
			fetch_igv();

			function fetch_total() {
				$.ajax({
					url: "consultatotal.php",
					method: "POST",
					success: function (data) {
						$('#live_total').html(data);

					}
				});
			}
			fetch_total();

			$('#tarjeta').hide();
			// Muestra campos según forma de pago: efectivo (recibo/vuelto) o otros (Nº operación opcional)
			$('#forma').change(function () {
				var f = $('#forma').val();
				if (f == 'EFECTIVO') {
					$('#efectivo').show();
					$('#recibo').val('');
					$('#vuelto').val('');
					$('#tarjeta').hide();
					$('#numope').val('');
				} else if (f == 'TARJETA' || f == 'YAPE' || f == 'PLIN' || f == 'TRANSFERENCIA' || f == 'OTRO') {
					$('#tarjeta').show();
					$('#efectivo').hide();
					$('#numope').val('');
				} else {
					$('#tarjeta').hide();
					$('#efectivo').hide();
					$('#numope').val('');
				}
			});
			// guardar por codigo de barra
			$(document).on('submit', '#barcode_form', function (event) {
				event.preventDefault();
				var cod = $('#cod').val();
				$.ajax({
					url: "guardarcarrito.php",
					method: "POST",
					data: { cod: cod },
					dataType: "text",
					success: function (data) {
						console.log(cod);
						console.log(data);
						//alertify.alert('Agregar',data);
						fetch_data();
						fetch_igv();
						fetch_total();
						limpiar();
					}
				})
			});

			// guardar por descripcion
			$(document).on('click', '.btn_add', function () {
				var idproducto = $(this).data("id1");
				var des = $(this).data("id2");
				var pres = $(this).data("id3");
				var pre = $(this).data("id4");
				//var dsc = $(this).data("id5");
				//console.log("Datos enviados:", { idproducto, des, pres, pre});
				$.ajax({
					url: "guardarcarrito2.php",
					method: "POST",
					data: { idproducto: idproducto, des: des, pres: pres, pre: pre},
					dataType: "text",
					success: function (data) {
						//console.log("Respuesta del servidor:", data); // Ver respuesta del servidor
						fetch_data();
						fetch_igv();
						fetch_total();
						limpiar();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						//console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
					}
				});
			});

			$(document).on('click', '.btn_delete', function () {
				var id = $(this).data("id3");

				$.ajax({
					url: "eliminarcarrito.php",
					method: "POST",
					data: { id: id },
					dataType: "text",
					success: function (data) {
						//   alertify.alert('Venta','Producto Eliminado del carrito.', function(){
						//
						// });
						fetch_data();
						fetch_igv();
						fetch_total();
					}
				});
			});

			function limpiar() {
				$('#cod').val('');
				$('#des').val('');
				$('#pres').val('');
				$('#pre').val('');
				$('#idproducto').val('');
				$('#dsc').val('');
				$('#cod').focus();
			}
			function edit_data(id, text, cantidad) {
				//var cantidad=$('#cantidad').val();
				$.ajax({
					url: "actualizarcarrito.php",
					method: "POST",
					data: { id: id, text: text, cantidad: cantidad },
					dataType: "text",

				}).success(function (data) {
					alertify.alert('mensaje', data);
					//alert(data);
					fetch_data();
					fetch_igv();
					fetch_total();
				});
			}
			function edit_datap(id, text, precio_unitario) {
				//var cantidad=$('#cantidad').val();
				$.ajax({
					url: "actualizarcarritop.php",
					method: "POST",
					data: { id: id, text: text, precio_unitario: precio_unitario },
					dataType: "text",

				}).success(function (data) {
					alertify.alert('mensaje', data);
					//alert(data);
					fetch_data();
					fetch_igv();
					fetch_total();
				});
			}
			$(document).on('blur', '.cantidad', function (event) {
				event.preventDefault();
				//var id = $(this).data("id2");
				var id = $(this).attr("id2");
				var cantidad = $(this).text();
				edit_data(id, cantidad, "cantidad");
			});

			$(document).on('blur', '.precio_unitario', function (event) {
				event.preventDefault();
				//var id = $(this).data("id2");
				var id = $(this).attr("id1");
				var precio_unitario = $(this).text();
				edit_datap(id, precio_unitario, "precio_unitario");
			});

			$(document).on('blur', '.descuento', function (event) {
				event.preventDefault();
				//var id = $(this).data("id2");
				var id = $(this).attr("id4");
				var descuento = $(this).text();
				edit_datad(id, descuento, "descuento");
			});


		});
	</script>

	<script>
		$(document).ready(function () {
			// Deshabilitar el botón de calcular inicialmente
			$("#calcular").prop("disabled", true);

			// Función para verificar y habilitar el botón
			function verificarMontos() {
				var recibo = parseFloat($("#recibo").val()) || 0;
				var total = parseFloat($("#total").val()) || 0;

				if (recibo >= total) {
					$("#calcular").prop("disabled", false);
				} else {
					$("#calcular").prop("disabled", true);
				}
			}

			// Verificar montos cada vez que se cambia el valor de los campos
			$("#recibo, #total").on("input", function () {
				verificarMontos();
			});

			// Calcular el vuelto al hacer clic en el botón
			$("#calcular").click(function (e) {
				e.preventDefault();

				var recibo = parseFloat($("#recibo").val()) || 0;
				var total = parseFloat($("#total").val()) || 0;

				// Calcular el vuelto si el monto recibido es suficiente
				var vuelto = recibo - total;
				$("#vuelto").val(vuelto.toFixed(2));
			});
		});
	</script>
	<!-- <script>
$("#recibo").keypress(function(e){
	if(e.keyCode == 13)
	{
	  var recibo = $("#recibo").val();
	  var total = $("#total").val();
	  var vuelto = parseFloat(recibo) - parseFloat(total);
	  $("#vuelto").val(vuelto.toFixed(2));
	}
});
</script> -->
	<!-- guardar venta -->
	<script type="text/javascript">
    $(document).ready(function () {
        $('#frmVenta').on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData($("#frmVenta")[0]);
            var td = $("#td").val(); // Tipo de documento
            var numero = $("#numero").val() || ''; // Número de documento
            var razonSocial = $("#datosCompletos").val().trim().toLowerCase(); // Cliente-Razón social
            var direccion = $("#direccion").val().trim(); // Dirección

            // Validaciones SOLO si el tipo de documento es RUC (4)
            if (td === '4') {
                if (numero.length !== 11 || isNaN(numero)) {
                    alert("El RUC debe tener exactamente 11 dígitos numéricos.");
                    return;
                }
                if (razonSocial === "publico en general") {
                    alert("No se puede registrar un cliente con el nombre 'Público en general' para RUC.");
                    return;
                }
                if (direccion === "") {
                    alert("La dirección no puede estar vacía para RUC.");
                    return;
                }
            }

            // Si td es 1, cambiar su valor a 2
            if (td === '1') {
                $("#td").val('2');
                formData.set('td', '2'); // Cambiar el valor en FormData
            }

            // Si el campo dni está vacío, establecer su valor a 00000000
            if (numero === '') {
                formData.set('numero', '00000000'); // Asignar valor predeterminado
            }

            // Imprimir todos los valores del FormData para verificación
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Enviar formulario por AJAX
            $.ajax({
                method: "POST",
                url: 'guardarventa.php',
                data: formData,
                contentType: false,
                processData: false,
            })
            .done(function (html) {
                $("#msn").html(html);
               /*  setTimeout(function () {
                    location.reload();
                }, 2000); */
            });
        });
    });
</script>

<!--
	<script src="../apifacturacion/sunat/search.js"></script> -->
	<script>
		$('#tico').change(function () {
			var tico = $('#tico').val();
			var serie = $('#serie').val();
			var correl = $('#correl').val();
			$.ajax({
				url: "obtenercomprobante.php",
				method: "POST",
				data: { tico: tico, serie: serie, correl: correl },
				success: function (data) {
					if (tico == '01') {
						$('#serie').val('F001');
						$('#correl').val(data);
					} else if (tico == '00') {
						$('#serie').val('T001');
						$('#correl').val(data);
					} else if (tico == '03') {
						$('#serie').val('B001');
						$('#correl').val(data);
					} else if (tico == '') {
						$('#serie').val('');
						$('#correl').val('');
					}
				}
			});
		});

		$("#tico").change(function () {
			var tico = $('#tico').val();
			if (tico == '') {
				// Habilitar todas las opciones si no se selecciona ningún tipo de comprobante
				$("#11, #22, #33, #44, #55, #66").prop('disabled', false);
			} else if (tico == '00') {
				$("#11, #22, #33, #44, #55, #66").prop('disabled', false);
			} else if (tico == '01') {
				// Deshabilitar todo menos la opción 44
				$("#11, #22, #33, #55, #66").prop('disabled', true);
				$("#44").prop('disabled', false);
			} else if (tico == '03') {
				// Habilitar todo menos la opción 44
				$("#11, #22, #33, #55, #66").prop('disabled', false);
				$("#44").prop('disabled', true);
			}
		});

		$("#td").change(function () {
			var td = $('#td').val();
			var sn = $('#11').val();
			var dni = $('#22').val();
			var ce = $('#33').val();
			var ruc = $('#44').val();
			var pas = $('#55').val();
			var cedula = $('#66').val();
			if (td == sn) {
				$("#numero").prop('maxlength', '15');
			}
			if (td == dni) {
				$("#numero").prop('maxlength', '8');
			}
			if (td == ce) {
				$("#numero").prop('maxlength', '12');
			}
			if (td == ruc) {
				$("#numero").prop('maxlength', '11');
			}
			if (td == pas) {
				$("#numero").prop('maxlength', '12');
			}
			if (td == cedula) {
				$("#numero").prop('maxlength', '15');
			}
		});

	</script>

<script>
	function buscarDocumento() {
		let documento = document.getElementById("numero").value.trim();
		if (/^\d{8}$/.test(documento)) {
			consultarAPI(documento, "dni");
		} else if (/^\d{11}$/.test(documento)) {
			consultarAPI(documento, "ruc");
		} else {
			alert("⚠ Ingrese un número de documento válido (DNI: 8 dígitos, RUC: 11 dígitos)");
			limpiarCampos();
		}
	}
	function consultarAPI(numero, tipo) {
		//console.log(`🔍 Consultando API con ${tipo.toUpperCase()}: ${numero}`);
		fetch(`../apifacturacion/sunat/buscar_dni_ruc.php?numero=${numero}&tipo=${tipo}`)
			.then(response => {
				if (!response.ok) {
					throw new Error(`Error HTTP: ${response.status}`);
				}
				return response.json();
			})
			.then(data => {
				//console.log("📩 Datos recibidos:", data);
				// ✅ Manejo de error si no hay resultados
				if (data.success === false) {
					// console.warn(`❌ ${data.message}`);
					alert(`❌ ${data.message}`);
					limpiarCampos();
					return;
				}
				let nombreCompleto = "";
				let direccion = "";
				if (tipo === "dni") {
					let apellidoPaterno = data.apellidoPaterno || "";
					let apellidoMaterno = data.apellidoMaterno || "";
					let nombres = data.nombres || "";
					nombreCompleto = `${apellidoPaterno} ${apellidoMaterno} ${nombres}`;
				} else if (tipo === "ruc") {
					nombreCompleto = data.razonSocial || "";
					direccion = data.direccion || "";
				}

				// ✅ Mostrar en los inputs
				document.getElementById("datosCompletos").value = nombreCompleto.trim();
				if (tipo === "ruc") {
					document.getElementById("direccion").value = direccion;
				}
			})
			.catch(error => {
				//console.error("⚠ Error en la consulta:", error);
				alert("❌ Error al consultar la API. Intente nuevamente.");
				limpiarCampos();
			});
	}
	// 🔹 Función para limpiar los campos
	function limpiarCampos() {
		document.getElementById("datosCompletos").value = "";
		document.getElementById("direccion").value = "";
	}
</script>
</body>

</html>