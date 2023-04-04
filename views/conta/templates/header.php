<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Fiber - Finalize seu Pedido</title>
	<meta name="description" content="Confira e preencha os dados para concluir seu pedido!">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="<?=base_url('dist/img/fiber/favicon_fadda772-8c70-4740-a5a4-ff320f3b9527_96x.png')?>"/>
	<link rel="stylesheet" href="<?=base_url('dist/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('dist/css/conta.css')?>">
  <?php if (isset($custom_styles)) {
    foreach($custom_styles as $style) {
      echo "<link rel=\"stylesheet\" href=\"$style\">";
    }
  }?>
  <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
</head>
<style>
    .button-pane p {
        color:#fff;
        padding:13px 0px 0px 0px !important;
        margin-right:10px !important;
    }
</style>
<body>
<div id="site">
   <nav class="navbar">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand">
              <img src="<?=base_url('dist/img/fiber/logo-white.png')?>" alt="Fiber" width="90px" height="61px">
            </a>
          </div>
          <div class="button-pane">
             
              </div>
        </div>
   </nav>