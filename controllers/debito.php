<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debito extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function transacao(){

        $PaymentId = $_POST['PaymentId'];
        $data['retorno'] = $this->debito_model->transacao($PaymentId);
        
        $data['titulo'] = ' - Pagamento Status';
        $data['custom_styles'] = [base_url('dist/css/realizado.css')];
                        
        $this->load->view('conta/templates/header', $data);
        $this->load->view('pagamento/realizado_debito_aut', $data);
        $this->load->view('conta/templates/footer', $data);

	}

}