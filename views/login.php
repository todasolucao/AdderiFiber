<?php
  function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  if(isMobile()){
?>
<?php } else { ?>
<?php } ?>

<div id="conteudo"></div> <!-- ? -->

<div class="container">
 	<div class="col-md-4 col-md-offset-4 login-container">
    <center>
        Nenhum token informado!
    </center>
	</div>
</div>

<script src="<?=base_url('dist/js/jquery-1.5.2.min.js')?>"></script>
<script src="<?=base_url('dist/js/jquery.maskedinput-1.3.min.js')?>"></script>
<script>
jQuery(function($){
   $("#cpf").mask("999.999.999-99");
});
</script>
