<!-- Loader global (todas las páginas) -->
<div id="global-loader-overlay" aria-hidden="true" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center; flex-direction:column;">
	<div style="width:48px; height:48px; border:4px solid #f3f3f3; border-top:4px solid #3498db; border-radius:50%; animation: global-loader-spin 0.8s linear infinite;"></div>
	<div id="global-loader-msg" style="color:#fff; margin-top:12px; font-size:14px;">Cargando...</div>
</div>
<style>@keyframes global-loader-spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}</style>
<script>
window.showLoader=function(msg){ var o=document.getElementById('global-loader-overlay'); var m=document.getElementById('global-loader-msg'); if(o){ o.style.display='flex'; if(m) m.textContent=msg||'Cargando...'; } };
window.hideLoader=function(){ var o=document.getElementById('global-loader-overlay'); if(o) o.style.display='none'; };
</script>
<!-- jQuery -->
<!-- <script src="../public/js/jquery-3.1.1.min.js"></script> -->
	<script src="../assets/js/jquery-1.11.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../public/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->

<script src="../assets/js/gsap/main-gsap.js"></script>
<script src="../assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="../assets/js/joinable.js"></script>
<script src="../assets/js/resizeable.js"></script>
<script src="../assets/js/neon-api.js"></script>
<script src="../assets/js/neon-chat.js"></script>
<script src="../assets/js/neon-custom.js"></script>
<script src="../assets/js/neon-demo.js"></script>
<!-- DATATABLES -->

<script src="../public/datatables/jquery.dataTables.min.js"></script>
<script src="../public/datatables/dataTables.buttons.min.js"></script>
<script src="../public/datatables/buttons.html5.min.js"></script>
<script src="../public/datatables/buttons.colVis.min.js"></script>
<script src="../public/datatables/jszip.min.js"></script>
<script src="../public/datatables/pdfmake.min.js"></script>
<script src="../public/datatables/vfs_fonts.js"></script>

</body>
</html>
