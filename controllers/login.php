<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){

                if($this->native_session->get('user_id')){
                    redirect('conta');
                }

                $data = array();

                if($this->input->post('submit')){

                    $data['message'] = $this->usuario_model->Logar();
                }

                 $data['titulos'] = 'index';
                 $data['titulo'] = ' - Central de Pagamentos';
                 $data['custom_styles'] = [
                   base_url('dist/css/login.css'),
                   
                  ];

                $this->load->view('conta/templates/header', $data);
                $this->load->view('login');
                $this->load->view('conta/templates/footer');
	}

}