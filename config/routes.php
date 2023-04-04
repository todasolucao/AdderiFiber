<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = "pagamento";
$route['404_override'] = '';


/****** CONTA DO CLIENTE ******/
$route['pagamento/(:num)'] = 'pagamento/token/$1';
$route['pagamento/autoriza_cartao_credito'] = 'pagamento/autoriza_cartao_credito';
$route['pagamento/autoriza_cartao_debito'] = 'pagamento/autoriza_cartao_debito';

$route['pagamento/retorno_pix'] = 'pagamento/retorno_pix';
$route['pagamento/retorno_cartao'] = 'pagamento/retorno_cartao';
$route['pagamento/consulta_mercadopago/(:any)'] = 'pagamento/consulta_mercadopago/$1';

$route['bloqueado'] = 'pagamento/informa/bloqueado';
$route['liquidado'] = 'pagamento/informa/liquidado';
$route['iniciada'] = 'pagamento/informa/iniciada';
$route['invalido'] = 'pagamento/informa/invalido';
$route['semrepresentante'] = 'pagamento/semrepresentante';


$route['pagamento/token'] = 'pagamento/informa/invalido';