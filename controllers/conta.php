<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conta extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index() {
        
        $data['custom_scripts'] = [
            base_url('dist/js/views/conta.min.js'),
            base_url('dist/js/progress-ring.min.js')
        ];

        $data['usuario'] = $this->conta_model->user();
        $data['parcelas'] = $this->conta_model->parcelas();
        $data['parcelas_verifica'] = $this->conta_model->parcelas_verifica();
        $data['titulo'] = ' - Olá '.$data['user']->NomeRazaoSocial;

        $this->load->view('conta/templates/header', $data);
        $this->load->view('conta/index', $data);
        $this->load->view('conta/templates/footer', $data);
    }

    public function pontuacao() {

        $data['custom_scripts'] = [
            base_url('dist/js/views/conta.js'),
            base_url('dist/js/progress-ring.js')
        ];

        $data['usuario'] = $this->conta_model->user();
        $data['titulo'] = ' - Pontuação';

        $this->load->view('conta/templates/header', $data);
        $this->load->view('conta/pontuacao/index', $data);
        $this->load->view('conta/templates/footer');
    }

    public function limites(){
        
        $data['custom_scripts'] = [
            base_url('dist/js/views/conta.js'),
            base_url('dist/js/progress-ring.js')
        ];
        
        
        if($this->input->post('submit')){
            $data['message'] = $this->conta_model->AumentodeLimite();
        }
        

        $data['usuario'] = $this->conta_model->user();
        $data['titulo'] = ' - Limites';    
        $this->load->view('conta/templates/header', $data);
        $this->load->view('conta/limites/index');
        $this->load->view('conta/templates/footer');
    }

    public function minhaconta(){

        $data['custom_scripts'] = [
            base_url('dist/js/views/conta.js'),
            base_url('dist/js/progress-ring.js')
        ];
        
        
        if($this->input->post('submit2')){

            $data['message'] = $this->conta_model->AlterarSenha();
        }
        

        $data['usuario'] = $this->conta_model->user();
        $data['titulo'] = ' - Minha Conta';    
        $this->load->view('conta/templates/header', $data);
        $this->load->view('conta/usuario/configuracoes');
        $this->load->view('conta/templates/footer');
    }

    public function redirecionar($id){
        $redirecionamento = $this->conta_model->Redirecionar($id);
        if($redirecionamento !== false){
            redirect($redirecionamento);
        }else{
            redirect('conta');
        }
    }

    public function sair(){
        $this->native_session->unset_userdata('user_id');
        redirect('login');
    }

    public function MudarSenha(){

        $data['custom_scripts'] = [
            base_url('dist/js/views/conta.js'),
            base_url('dist/js/progress-ring.js')
        ];

        $data['usuario'] = $this->conta_model->user();
        $data['titulo'] = '- Mudar Senha';

        if($this->input->post('submit2')){

            $data['message'] = $this->conta_model->AlterarSenha();
        }
        
        $this->load->view('conta/templates/header', $data);
        $this->load->view('conta/usuario/mudarsenha');
        $this->load->view('conta/templates/footer');
    }
 
}