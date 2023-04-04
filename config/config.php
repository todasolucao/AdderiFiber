<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// DEBUG
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

//DADOS DO CLIENTE
$config['base_url'] = 'https://pagamentos.fiberoficial.com.br/';
define('link_irlojavirtual','https://pagamentos.fiberoficial.com.br/');
define('nome_cliente','Adderi');
define('descricao','Central de Pagamento das Adderi! Utilize suas credenciais para logar!');
define('email_cliente','no-reply@adderi.com.br');

define('ip_webservice','adderiapp01.begcloud.com');
define('port_webservice','4076');
define('token','VcJx6FciCWE7D8TgirETVLb5EUuvH1wBADgyLO2cA7AEkDUMWHhCPlCF6R04aMb');

//STATUS SISTEMAS DE PAGAMENTO
define('status_credito','1');
define('status_debito','0');
define('status_pix','1');

$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd';
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['encryption_key'] = '-@w3__c0T4S--.';
$config['sess_cookie_name']		= 'ci_session_cota';
$config['sess_expiration']		= 100000000000;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= FALSE;
$config['sess_time_to_update']	= 10000000000;
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 72000;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
$config['composer_autoload'] = FCPATH.'gerencianet/autoload.php';