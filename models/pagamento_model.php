<?php
require_once 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;

class Pagamento_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    
    public function consulta($hash){
        
        $external = $hash.'_'.time();
        if($hash){
            if($this->transacao($hash)->r_situacaoTransacao == 'null'){
                
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'B'){
                redirect('bloqueado'); exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'L'){
                redirect('liquidada'); exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'I'){
                redirect('iniciada'); exit();
            }
        }
    
        $ip_webservice   = ip_webservice;
        $port_webservice   = port_webservice;
        $token   = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/consultalink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_tokenLink":"'.$hash.'"}',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        $json_str = json_decode($response);
        
        if($response->r_documento != ''){
            $this->db->insert('registros', 
            array('hash'=>$hash, 
            'retorno'=>$response, 
            'tipo'=>'token_invalido'
            ));
            redirect('token_invalido');
        }else{
            $this->db->insert('registros', 
            array('hash'=>$hash, 
            'retorno'=>$response, 
            'tipo'=>'consultalink'
            ));
        }
        
        $this->native_session->set('pagamento', json_encode($json_str));
        $this->native_session->set('hash', json_encode($hash));

        return $json_str;

    }

    public function transacao($hash){
    
        $ip_webservice   = ip_webservice;
        $port_webservice   = port_webservice;
        $token   = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/transacaolink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_tokenLink":"'.$hash.'"}',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        $json_str = json_decode($response);
        
        $this->db->insert('registros', 
            array('hash'=>$hash, 
            'retorno'=>$response, 
            'tipo'=>'consulta_transacao'
        ));
        
        return $json_str;

    }
    
    public function inicia_transacao($hash, $acao, $transacao, $data, $meioPagamento, $autorizacao, $p_autenticacao = null, $valorBruto, $valorJuros, $valorLiquido){
            
        $ip_webservice     = ip_webservice;
        $port_webservice   = port_webservice;
        $token             = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/transacaolink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_tokenLink":"'.$hash.'",
                                    "p_acao":"'.$acao.'",
                                    "p_transacao":"'.$transacao.'",
                                    "p_data":"'.$data.'",
                                    "p_meioPagamento":"'.$meioPagamento.'",
                                    "p_autorizacao":"'.$autorizacao.'",
                                    "p_autenticacao":"'.$p_autenticacao.'",
                                    "p_valorBruto":"'.$valorBruto.'",
                                    "p_valorJuros":"0",
                                    "p_valorLiquido":"'.$valorLiquido.'"}',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        $json_str = json_decode($response);
        
        $this->db->insert('registros', 
            array('hash'=>$hash, 
            'retorno'=>$response, 
            'tipo'=>'grava_transacao'
        ));
        
        $this->native_session->set('pagamento', json_encode($json_str));
        
        return $json_str;
    }
    
    public function pix(){
        
        date_default_timezone_set('America/Sao_Paulo');
        
        $pagamento = json_decode($this->native_session->get('pagamento'));
        $hash      = json_decode($this->native_session->get('hash'));
        
        $external = $hash.'_'.time();
        $data = date('Y-m-d');
        if($hash){
            if($this->transacao($hash)->r_situacaoTransacao == 'null'){
                $this->inicia_transacao($hash, 'I', $external, $data, 'Pix', '', date('Y-m-d H:i:s'), $pagamento->r_valorTotal, $pagamento->r_valorTotal, $pagamento->r_valorTotal);
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'B'){
                redirect('bloqueado');
                exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'L'){
                redirect('liquidada');
                exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'I'){
                redirect('iniciada');
                exit();
            }
        }
        
        MercadoPago\SDK::setAccessToken($pagamento->r_accessToken);
        
        $partes = explode(' ', $pagamento->r_nomeRazaoSocial);
        $primeiroNome = array_shift($partes);
        $ultimoNome = array_pop($partes);
        
        if($pagamento->r_tipoPessoa == "F"){ $tipo = 'CPF'; }else{ $tipo = 'CNPJ'; }
        
         $payment = new MercadoPago\Payment();
         $payment->transaction_amount = $pagamento->r_valorTotal;
         $payment->description = "Pagamento Fiber";
         $payment->payment_method_id = "pix";
         $payment->external_reference = $external;
         $payment->payer = array(
             "email" => $pagamento->r_email,
             "first_name" => $primeiroNome,
             "last_name" => $ultimoNome,
             "identification" => array(
                 "type" => $tipo,
                 "number" => str_pad($pagamento->r_cnpjCpfIdEstangeiro, 11, '0', STR_PAD_LEFT)
              ),
             "address"=>  array(
                 "zip_code" => $pagamento->r_cep,
                 "street_name" => $pagamento->r_logradouro,
                 "street_number" => $pagamento->r_numero,
                 "neighborhood" => $pagamento->r_bairro,
                 "city" => $pagamento->r_municipio,
                 "federal_unit" => $pagamento->r_uf
              )
           );
         $payment->notification_url = "https://pagamentos.fiberoficial.com.br/pagamento/retorno_pix";
        
         $payment->save();
         
         $this->inicia_transacao($hash, 'I', $external, $data, 'Pix', $payment->id, date('Y-m-d H:i:s'), $pagamento->r_valorTotal, $pagamento->r_valorTotal, $pagamento->r_valorTotal);
         $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'I', 'transacao'=>$external, 'meioPagamento'=>'Pix', 'autorizacao'=>$payment->id, 'valorBruto'=>$pagamento->r_valorTotal, 'valorJuros'=>$pagamento->r_valorTotal, 'valorLiquido'=>$pagamento->r_valorTotal, 'json'=>serialize($payment), 'nome'=>$pagamento->r_nomeRazaoSocial, 'cpf_cartao'=>str_pad($pagamento->r_cnpjCpfIdEstangeiro, 11, '0', STR_PAD_LEFT)));
         
         $this->native_session->unset_userdata('hash');
         $this->native_session->unset_userdata('pagamento');
         return $payment; 
    }
    
    public function GeraPix($pix){
        return '<img src="'.(new QRCode)->render($pix).'" />'; 
    }
    
    public function autoriza_cartao_credito(){
        
        date_default_timezone_set('America/Sao_Paulo');
        
        $pagamento = json_decode($this->native_session->get('pagamento'));
        $hash      = json_decode($this->native_session->get('hash'));
        $external = $hash.'_'.time();
        $data = date('Y-m-d');
        
        if($hash){
            if($this->transacao($hash)->r_situacaoTransacao == 'null'){
                
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'B'){
                redirect('bloqueado');
                exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'L'){
                redirect('liquidada');
                exit();
            }elseif($this->transacao($hash)->r_situacaoTransacao == 'I'){
                redirect('iniciada');
                exit();
            }
        }
        
        MercadoPago\SDK::setAccessToken($pagamento->r_accessToken);
        $pagamento = json_decode($this->native_session->get('pagamento'));
        $partes = explode(' ', $pagamento->r_nomeRazaoSocial);
        $primeiroNome = array_shift($partes);
        $ultimoNome = array_pop($partes);
        
        $numero = $pagamento->r_telefone;
        $ddd_cliente = substr($numero, 0, 2);
        $numero_cliente = substr($numero, 2);
        
        foreach($pagamento->r_listaProdutos as $item){ 
            $arrayP = array("id"=>$item->id, "title"=>$item->descricao, "quantity"=>$item->quantidade);
        }
        
        if($pagamento->r_tipoPessoa == "F"){ $tipo = 'CPF'; }else{ $tipo = 'CNPJ'; }
        
            $this->inicia_transacao($hash, 'I', $external, $data, 'Crédito', '', $primeiroNome.' '.$ultimoNome.' - Token:'.$hash.' External: '.$external, $pagamento->r_valorTotal, $pagamento->r_valorTotal, $pagamento->r_valorTotal);
            $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'I', 'transacao'=>$external, 'meioPagamento'=>'MercadoPago', 'autorizacao'=>$payment->id, 'valorBruto'=>$pagamento->r_valorTotal, 'valorJuros'=>$pagamento->r_valorTotal, 'valorLiquido'=>$pagamento->r_valorTotal,'nome'=>$pagamento->r_nomeRazaoSocial, 'telefone'=>$numero_cliente, 'cpf_cartao'=>$_POST['titular_doc']));
            
        
                if (isset($_POST['token'])) {
                            
                         $payment = new MercadoPago\Payment();
                         $payment->token = $_POST['token'];
                         $payment->installments = (int)$_POST['parcelas_quantidade'];
                         $payment->transaction_amount = $pagamento->r_valorTotal;
                         $payment->external_reference = $external;
                         $payment->statement_descriptor = "Pagamento Fiber";
                         $payment->notification_url = "https://pagamentos.fiberoficial.com.br/pagamento/retorno_cartao";
                         $payment->description = "Pagamento Fiber";
                         $payment->payment_method_id = $_POST['paymentMethodId'];
                         $payment->binary_mode = true;
                         $payment->additional_info = array(
                                "items" => array($arrayP),
                                "payer" => array( //INFORMAÇÕES PESSOAIS DO COMPRADOR
                                    "first_name" => $primeiroNome,
                                    "last_name" => $ultimoNome,
                                    "phone" => array( //Telefone do Comprador
                                        "area_code" => $ddd_cliente, //DDD
                                        "number" => $numero_cliente //NÚMERO
                                    ),
                                     "address"=>  array(
                                         "zip_code" => $pagamento->r_cep,
                                         "street_name" => $pagamento->r_logradouro,
                                         "street_number" => $pagamento->r_numero
                                      )
                                )
                           );
                           
                         $payment->payer = array( 
                                "first_name" => $primeiroNome,
                                "last_name" => $ultimoNome, 
                                "entity_type" => "individual",
                                "type" => "customer",
                                "email" => $pagamento->r_email,
                                "identification" => array(
                                     "type" => $tipo,
                                     "number" => $_POST['titular_doc']
                                  )
                           );
                        
                         $payment->save();
                         
                         if($payment->status_detail == 'accredited'){
                             $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'L', 'transacao'=>$external, 'meioPagamento'=>'MercadoPago', 'autorizacao'=>$payment->id, 'valorBruto'=>$pagamento->r_valorTotal, 'valorJuros'=>$pagamento->r_valorTotal, 'valorLiquido'=>$pagamento->r_valorTotal, 'json'=>serialize($payment),'nome'=>$pagamento->r_nomeRazaoSocial, 'telefone'=>$numero_cliente, 'cpf_cartao'=>$_POST['titular_doc']));
                             $this->db->insert('registros', 
                                array('hash'=>$hash, 
                                'retorno'=>serialize($payment), 
                                'tipo'=>'grava_transacao_retorno'
                            ));
                         }else{
                            $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'R', 'transacao'=>$external, 'meioPagamento'=>'MercadoPago', 'autorizacao'=>$payment->id, 'valorBruto'=>$pagamento->r_valorTotal, 'valorJuros'=>$pagamento->r_valorTotal, 'valorLiquido'=>$pagamento->r_valorTotal, 'json'=>serialize($payment),'nome'=>$pagamento->r_nomeRazaoSocial, 'telefone'=>$numero_cliente, 'cpf_cartao'=>$_POST['titular_doc']));
                            $this->db->insert('registros', 
                                array('hash'=>$hash, 
                                'retorno'=>serialize($payment), 
                                'tipo'=>'grava_transacao_retorno'
                            ));
                             
                         }
                         
                        $this->native_session->unset_userdata('hash');
                        $this->native_session->unset_userdata('pagamento');
                        
                        return $payment;
                         
                }
    }
    
    public function retorno_pix(){
       
            MercadoPago\SDK::setAccessToken("APP_USR-6041773241522952-050903-46e43a05581f1cdd0ba0a093c744b738-565331377");
         
            $merchant_order = null;
         
            switch($_GET["topic"]) {
               case "payment":
                   $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
                   $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
                   break;
               case "merchant_order":
                   $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
                   break;
            }
         
            $paid_amount = 0;
           
            $json = json_encode($payment);
           
            $external = explode("_", $payment->external_reference);
            $hash = $external['0'];
            $time = $external['1'];
          
            if($payment->status_detail == 'accredited'){
                   $this->inicia_transacao($hash, 'L', $payment->external_reference, date('Y-m-d'), 'Pix', $payment->id, '', $payment->transaction_amount, $payment->transaction_amount, $payment->transaction_amount);
                   $this->db->insert('registros', 
                                array('hash'=>$hash, 
                                'retorno'=>serialize($payment), 
                                'tipo'=>'retorno_pix_automatico'
                            ));
                   $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'L', 'transacao'=>$payment->external_reference, 'meioPagamento'=>'Pix', 'autorizacao'=>$payment->id, 'valorBruto'=>$payment->transaction_amount, 'valorJuros'=>$payment->transaction_amount, 'valorLiquido'=>$payment->transaction_amount, 'json'=>serialize($payment)));
            }
           
    }
    
    public function retorno_cartao(){
       
            MercadoPago\SDK::setAccessToken("APP_USR-6041773241522952-050903-46e43a05581f1cdd0ba0a093c744b738-565331377");
         
            $merchant_order = null;
         
            switch($_GET["topic"]) {
               case "payment":
                   $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
                   $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
                   break;
               case "merchant_order":
                   $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
                   break;
            }
           
            echo "<pre>";
            print_r($payment);
            $json = json_encode($payment);
           
            $external = explode("_", $payment->external_reference);
            $hash = $external['0'];
            $time = $external['1'];
          
            if($payment->status_detail == 'accredited'){
                   $this->inicia_transacao($hash, 'L', $payment->external_reference, date('Y-m-d'), 'Crédito', $payment->id, '', $payment->transaction_amount, $payment->transaction_amount, $payment->transaction_amount);
                   $this->db->insert('registros', 
                                array('hash'=>$hash, 
                                'retorno'=>serialize($payment), 
                                'tipo'=>'retorno_cartao_automatico'
                            ));
                   $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'L', 'transacao'=>$payment->external_reference, 'meioPagamento'=>'Crédito', 'autorizacao'=>$payment->id, 'valorBruto'=>$payment->transaction_amount, 'valorJuros'=>$payment->transaction_amount, 'valorLiquido'=>$payment->transaction_amount, 'json'=>serialize($payment)));
            }else{       
                $this->inicia_transacao($hash, 'R', $payment->external_reference, date('Y-m-d'), 'Crédito', $payment->id, '', $payment->transaction_amount, $payment->transaction_amount, $payment->transaction_amount);
                   
                if($hash){
                    $this->db->insert('registros', 
                                array('hash'=>$hash, 
                                'retorno'=>serialize($payment), 
                                'tipo'=>'retorno_cartao_automatico'
                            ));
                    $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'R', 'transacao'=>$payment->external_reference, 'meioPagamento'=>'MercadoPago', 'autorizacao'=>$_GET["id"], 'valorBruto'=>$payment->transaction_amount, 'valorJuros'=>$payment->transaction_amount, 'valorLiquido'=>$payment->transaction_amount, 'json'=>serialize($payment)));
                }
                
            }
           
    }
    
    public function consulta_mercadopago($id){
       
            MercadoPago\SDK::setAccessToken("APP_USR-6041773241522952-050903-46e43a05581f1cdd0ba0a093c744b738-565331377");
         
            $merchant_order = null;
         
            $payment = MercadoPago\Payment::find_by_id($id);
      
            $paid_amount = 0;
           
            echo "<pre>";
            print_r($payment);
            $json = json_encode($payment);
           
            $external = explode("_", $payment->external_reference);
            $hash = $external['0'];
            $time = $external['1'];
          
           
    }
    
    public function consulta_transacao($hash){
       
            MercadoPago\SDK::setAccessToken("APP_USR-6041773241522952-050903-46e43a05581f1cdd0ba0a093c744b738-565331377");
         
            $merchant_order = null;
         
            $payment = MercadoPago\Payment::find_by_id($id);
      
            $paid_amount = 0;
           
            echo "<pre>";
            print_r($payment);
            $json = json_encode($payment);
           
            $external = explode("_", $payment->external_reference);
            $hash = $external['0'];
            $time = $external['1'];
          
            exit();
          
            if($payment->status_detail == 'accredited'){
                   $this->inicia_transacao($hash, 'L', $payment->external_reference, date('Y-m-d'), 'Pix', $payment->id, '', $payment->transaction_amount, $payment->transaction_amount, $payment->transaction_amount);
                   $this->db->insert('transacao', array('hash'=>$hash,'acao'=>'L', 'transacao'=>$payment->external_reference, 'meioPagamento'=>'Pix', 'autorizacao'=>$payment->id, 'valorBruto'=>$payment->transaction_amount, 'valorJuros'=>$payment->transaction_amount, 'valorLiquido'=>$payment->transaction_amount, 'json'=>serialize($payment)));
            }
           
    }
    public function gravaLink($hash){
        
        $cep = str_replace("-", "", $this->input->post('r_cep'));
        $cep = str_replace(".", "", $cep);
        $cep = str_replace(" ", "", $cep);
        
        $cpf_cnpj = str_replace("-", "", $this->input->post('r_cnpjCpfIdEstangeiro'));
        $cpf_cnpj = str_replace(".", "", $cpf_cnpj);
        $cpf_cnpj = str_replace("/", "", $cpf_cnpj);
        $cpf_cnpj = str_replace(" ", "", $cpf_cnpj);
        
        $telefone = str_replace("-", "", $this->input->post('r_telefone'));
        $telefone = str_replace(".", "", $telefone);
        $telefone = str_replace("/", "", $telefone);
        $telefone = str_replace(" ", "", $telefone);
        $telefone = str_replace("(", "", $telefone);
        $telefone = str_replace(")", "", $telefone);
        
        $conta_cpfcnpj = strlen($cpf_cnpj);
        
        if($conta_cpfcnpj == 11){
            $pessoa = 'F';
        }else{
            $pessoa = 'J';
        }
        
        $json_enviado = '{"p_tokenLink":"'.$hash.'",
                                    "p_tipoPessoa":"'.$pessoa.'",
                                    "p_cnpjCpfIdEstrangeiro":"'.$cpf_cnpj.'",
                                    "p_nomeRazaoSocial":"'.$this->input->post('r_nomeRazaoSocial').'",
                                    "p_dataNascimentoFundacao":"'.$this->input->post('r_dataNascimentoFundacao').'",
                                    "p_sexo":"'.$this->input->post('r_sexo').'",
                                    "p_telefone":"'.$telefone.'",
                                    "p_email":"'.$this->input->post('r_email').'",
                                    "p_cep":"'.$cep.'",
                                    "p_logradouro":"'.$this->input->post('r_logradouro').'",
                                    "p_bairro":"'.$this->input->post('r_bairro').'",
                                    "p_municipio":"'.$this->input->post('r_municipio').'",
                                    "p_uf":"'.$this->input->post('r_uf').'",
                                    "p_numero":"'.$this->input->post('r_numero').'",
                                    "p_complemento":"'.$this->input->post('r_complemento').'"}';
                                    
        $this->db->insert('alteracao_insercao', array('hash'=>$hash,'json_token'=>serialize($this->consulta($hash)),'json_enviado'=>serialize($json_enviado), 'ip'=>$_SERVER['REMOTE_ADDR']));

        $ip_webservice     = ip_webservice;
        $port_webservice   = port_webservice;
        $token             = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/gravalink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_tokenLink":"'.$hash.'",
                                    "p_tipoPessoa":"'.$pessoa.'",
                                    "p_cnpjCpfIdEstrangeiro":"'.$cpf_cnpj.'",
                                    "p_nomeRazaoSocial":"'.$this->input->post('r_nomeRazaoSocial').'",
                                    "p_dataNascimentoFundacao":"'.$this->input->post('r_dataNascimentoFundacao').'",
                                    "p_sexo":"",
                                    "p_telefone":"'.$telefone.'",
                                    "p_email":"'.$this->input->post('r_email').'",
                                    "p_cep":"'.$cep.'",
                                    "p_logradouro":"'.$this->input->post('r_logradouro').'",
                                    "p_bairro":"'.$this->input->post('r_bairro').'",
                                    "p_municipio":"'.$this->input->post('r_municipio').'",
                                    "p_uf":"'.$this->input->post('r_uf').'",
                                    "p_numero":"'.$this->input->post('r_numero').'",
                                    "p_complemento":"'.$this->input->post('r_complemento').'"}',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        $json_str = json_decode($response);
       
        redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash);
    }
    
    public function catalogo(){
        libxml_use_internal_errors(true);
        $basketXML=$_REQUEST['basket'];
        $basketXML_decoded = urldecode($basketXML);
        $objXmlDocument = simplexml_load_string($basketXML_decoded, 'SimpleXMLElement', LIBXML_NOCDATA);
        
        if ($objXmlDocument === false) {
            
            foreach (libxml_get_errors() as $error) {
                echo $error->message;
            }
        }
        $objJsonDocument = json_encode($objXmlDocument);
        $arrOutput = json_decode($objJsonDocument, true);
       
        $url = str_replace('/pagamento/catalogo?', '', $_SERVER['REQUEST_URI']);
       
        $orderId = strtoupper(($arrOutput['@attributes']['orderId']));
        $orderDate = explode("T", ($arrOutput['@attributes']['orderDate']));
        
        $exportorigin = $arrOutput['@attributes']['exportorigin'];
        
        
        $flipbookName = $arrOutput['@attributes']['flipbookName'];
        
        $rep_num = 'rep_num=';
        $repNum = explode($rep_num, $exportorigin);
        
        $p_idPromotor = $repNum[1];
        $re    = '/(?:(\?)|&)page=\d+(?(1)(?:&|$)|(&|$))/';
        $subst = '$1$2';
        
        $p_idPromotor = preg_replace($re, $subst, $p_idPromotor);
        
        if($p_idPromotor){
            
        }else{
            $p_idPromotor = $url;
        }
        
        if($basketXML){
            if($p_idPromotor == null){
                redirect('/semrepresentante');
            }
        }
        
        $valor = 0;
        foreach ($arrOutput['item'] as $item){
           $p_valorTotal += $item['price'] * $item['amount'];
        }
        
        return array('p_idCatalogo'=>$orderId,'p_data'=>$orderDate[0],'p_jsonCatalogo'=>json_encode($arrOutput),'p_idPromotor'=>$p_idPromotor, 'p_nomeCatalogo'=>$url, 'p_valorTotal'=>$p_valorTotal);
    }
    
    public function catalogoGrava($p_idCatalogo, $p_data, $p_cnpjCpfIdEstrangeiro, $p_telefone, $p_email, $p_jsonCatalogo, $p_idPromotor, $flipbookName, $p_valorTotal, $p_nomeRazaoSocial){
    
        $ip_webservice   = ip_webservice;
        $port_webservice   = port_webservice;
        $token   = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/catalogoLink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_idCatalogo":"'.$p_idCatalogo.'",
                                    "p_data":"'.$p_data.'",
                                    "p_cnpjCpfIdEstrangeiro":"'.$p_cnpjCpfIdEstrangeiro.'",
                                    "p_nomeRazaoSocial":"'.$p_nomeRazaoSocial.'",
                                    "p_telefone":"'.$p_telefone.'",
                                    "p_email":"'.$p_email.'",
                                    "p_idPromotor":"'.$p_idPromotor.'",
                                    "p_nomeCatalogo":"'.$flipbookName.'",
                                    "p_jsonCatalogo":"'.$p_jsonCatalogo.'"}',
                                    
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        
        //"p_nomeRazaoSocial":"'.$p_nomeRazaoSocial.'",
        
        $this->db->insert('requisicaoCatalogo', array('json'=>'{"p_idCatalogo":"'.$p_idCatalogo.'",
                                    "p_data":"'.$p_data.'",
                                    "p_cnpjCpfIdEstrangeiro":"'.$p_cnpjCpfIdEstrangeiro.'",
                                    "p_nomeRazaoSocial":"'.$p_nomeRazaoSocial.'",
                                    "p_telefone":"'.$p_telefone.'",
                                    "p_email":"'.$p_email.'",
                                    "p_idPromotor":"'.$p_idPromotor.'",
                                    "p_nomeCatalogo":"'.$flipbookName.'",
                                    "p_jsonCatalogo":"'.$p_jsonCatalogo.'"}'));
        
        $json_str = json_decode($response);
        $this->db->insert('retornoCatalogo', array('retorno'=>$response));
        
        if($json_str->r_tokenLink){
            redirect($json_str->r_tokenLink);
        }else{
            redirect('https://pagamentos.fiberoficial.com.br/invalido');
        }

    }
    public function aplicarCupom(){
        $cupom = $this->input->post('voucher');
        $hash  = $this->input->post('hash');
        $ip_webservice   = ip_webservice;
        $port_webservice   = port_webservice;
        $token   = token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $port_webservice,
            CURLOPT_URL => "http://$ip_webservice:$port_webservice/v1/descontolink",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"p_tokenLink":"'.$hash.'",
                                    "p_idValeDesconto":"'.$cupom.'"}',
                                    
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        $json_decode = htmlspecialchars(json_decode($response), ENT_QUOTES, 'UTF-8');
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        }
        $json_str = json_decode($response);
                                     if($json_str == 'S'){
                                            redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash.'?cupom=S');
                                     }elseif($json_str == 'E'){
                                            redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash.'?cupom=E');
                                     }elseif($json_str == 'I'){
                                            redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash.'?cupom=I');
                                     }elseif($json_str == 'C'){
                                            redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash.'?cupom=C');
                                     }elseif($json_str == 'U'){ 
                                            redirect('https://pagamentos.fiberoficial.com.br/pagamento/token/'.$hash.'?cupom=U');
                                     }
    }    
}
?>