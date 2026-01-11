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
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		window.addEventListener("load", function () {
			miformulario.txtdo.addEventListener("keypress", soloNumeros, false);
		});

		//Solo permite introducir numeros.
		function soloNumeros(e) {
			var key = window.event ? e.which : e.keyCode;
			if (key < 48 || key > 57) {
				e.preventDefault();
			}
		}
	</script>

</head>
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
							Registrar Cliente-Laboratorio
						</div>
					</div>
					<div class="panel-body">
						<form role="form" name="miformulario" action="capturar.php" method="post">
							<!-- <input type="hidden" name="txtidsucu_c" value=<?php echo "$idsucursal"; ?>> -->
							<div class="col-md-6 form-group">
								<label><strong>Razon social(*)</strong></label>
								<input type="text" name="txtno" class="form-control" required
									placeholder="ingrese su nombre" id="datosCompletos">
							</div>

							<div class="col-md-6 form-group">
								<label><strong>Direccion:</strong></label>
								<input type="text" name="txtdi" class="form-control" placeholder="ingrese su direccion"
									id="direccion">
							</div>

							<div class="col-md-6 form-group">
								<label><strong>Tipo Documento(*)</strong></label>
								<select name="td" class="form-control" required id="td">
									<option value="1" <?php if ($tipo == '1') {
										echo 'selected';
									} ?>>SIN DOCUMENTO
									</option>
									<option value="2" <?php if ($tipo == '2') {
										echo 'selected';
									} ?>>DNI</option>
									<option value="3" <?php if ($tipo == '3') {
										echo 'selected';
									} ?>>CARNET DE
										EXTRANJERIA
									</option>
									<option value="4" <?php if ($tipo == '4') {
										echo 'selected';
									} ?>>RUC</option>
									<option value="5" <?php if ($tipo == '5') {
										echo 'selected';
									} ?>>PASAPORTE</option>
									<option value="6" <?php if ($tipo == '6') {
										echo 'selected';
									} ?>>Ced. Diplomática de
										identidad</option>
								</select>
							</div>

							<div class="col-md-6 form-group">
								<label><strong>N. Documento(*)</strong></label>
								<div class="input-group">
									<input type="text" name="txtnrodoc" class="form-control" id="dni"
										placeholder="Ingrese su número de documento">
									<span class="input-group-btn">
										<a href="#" id="search_button" class="btn btn-default"
											onclick="buscarDocumento(); return false;" title="Buscar desde la Sunat">
											<img src="../apifacturacion/sunat/sunat.png" height="17" width="17"
												aria-hidden="true">
										</a>
									</span>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label><strong>Tipo Cliente(*)</strong></label>
								<select name="txttipo" class="form-control">
									<option value="cliente">cliente</option>
									<option value="laboratorio">laboratorio</option>
								</select>
							</div>
					</div>

					<div class="panel-footer">
						<div align="right">
							<div align="left">
								(*) campos obligatorios
							</div>
							<button type="submit" name="funcion" value="registrar"
								class="btn btn-info btn-icon icon-left"><i class="entypo-check"></i>Registrar</button>
							<a class="btn btn-green btn-icon icon-left" href="index.php"><i
									class="entypo-cancel"></i>Cancelar</a>
						</div>
					</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	function buscarDocumento() {
		let documento = document.getElementById("dni").value.trim();
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
</html>
<?php include("../central/pieproducto.php"); ?>
<!-- <script src="../apifacturacion/sunat/search.js"></script> -->