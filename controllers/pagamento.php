<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagamento extends CI_Controller {

	public function index()
	{
		$data['resumo'] = $resumo;
		$data['custom_styles'] = [base_url('dist/css/resumo.css')];
		$data['titulo'] = ' - Resumo do Pagamento';
		
		$this->load->view('conta/templates/header', $data);
		$this->load->view('login', $data);
		$this->load->view('conta/templates/footer', $data);
	}
	
	public function token($hash)
	{
		$data['resumo'] = $resumo;
		$data['custom_styles'] = [base_url('dist/css/resumo.css')];
		$data['titulo'] = ' - Resumo do Pagamento';
        
        $data['resumo'] = $this->pagamento_model->consulta($hash);
        
	    $data['retornoCupom'] = $_GET['cupom'];
	        
        if($this->input->post('submit')){
            $this->pagamento_model->gravaLink($hash);
        }
        
        
	    if($this->input->post('cupom')){
	        $this->pagamento_model->aplicarCupom();
	    }

		$this->load->view('conta/templates/header', $data);
		$this->load->view('pagamento/resumo', $data);
		$this->load->view('conta/templates/footer', $data);
	}
	
	
	public function informa($tipo)
	{
		$data['resumo'] = $resumo;
        $data['custom_styles'] = [base_url('dist/css/realizado.css')];
		$data['titulo'] = ' - Resumo do Pagamento';
		$data['status'] = $tipo;

		$this->load->view('conta/templates/header', $data);
		$this->load->view('informa', $data);
		$this->load->view('conta/templates/footer', $data);
	}
	
	public function retorno_pix()
	{
		$this->pagamento_model->retorno_pix();
	}
	public function retorno_cartao()
	{
		$this->pagamento_model->retorno_cartao();
	}
	
	public function sessaofinalizada(){
	    
	    $data['titulo'] = ' - Sessão Finalizada';

        $data['custom_styles'] = [base_url('dist/css/realizado.css')];
		$this->load->view('conta/templates/header', $data);
		$this->load->view('pagamento/sessaofinalizada', $data);
		$this->load->view('conta/templates/footer', $data);
		
	}
	public function credito(){
	   
        $data['pagamento'] = json_decode($this->native_session->get('pagamento'));
        $data['hash'] = json_decode($this->native_session->get('hash'));
        
    	$data['titulo'] = ' - Pagamento Cartão de Crédito';
    	$data['custom_styles'] = [base_url('dist/css/cartao.css')];
    	$data['custom_scripts'] = [
    		base_url('dist/js/imask.min.js'),
    		base_url('dist/js/views/cartao.js')
    	];
    
        $this->load->view('conta/templates/header', $data);
        $this->load->view('pagamento/credito', $data);
        $this->load->view('conta/templates/footer', $data);
	}
    public function pix(){
        $data['titulo'] = ' - PIX';

        $data['custom_styles'] = [base_url('dist/css/realizado.css')];
        $data['pix'] = $this->pagamento_model->pix();
		$this->load->view('conta/templates/header', $data);
		$this->load->view('pagamento/pix', $data);
		$this->load->view('conta/templates/footer', $data);
    }
    public function transacao_credito(){
	   $this->pagamento_model->credito();
	}
    public function consulta_mercadopago($id){
	   $this->pagamento_model->consulta_mercadopago($id);
	}
	public function autoriza_cartao_credito(){
	    $data['status'] = $this->pagamento_model->autoriza_cartao_credito();
        
        $data['custom_styles'] = [base_url('dist/css/realizado.css')];
	   
		$this->load->view('conta/templates/header', $data);
		$this->load->view('pagamento/realizado', $data);
		$this->load->view('conta/templates/footer', $data);
	}
	
	public function catalogo(){
	    
        $data['titulo'] = ' - Catalogo';
	    
	    $data['exibe']  = $this->pagamento_model->catalogo();
	   
	   
	    if($this->input->post('submit')){
	        
	        $catalogo = json_decode($this->input->post('catalogo'));
    	            
            $cpf_cnpj = str_replace("-", "", $this->input->post('p_cnpjCpfIdEstangeiro'));
            $cpf_cnpj = str_replace(".", "", $cpf_cnpj);
            $cpf_cnpj = str_replace("/", "", $cpf_cnpj);
            $cpf_cnpj = str_replace(" ", "", $cpf_cnpj);
            
            $telefone = str_replace("-", "", $this->input->post('p_telefone'));
            $telefone = str_replace(".", "", $telefone);
            $telefone = str_replace("/", "", $telefone);
            $telefone = str_replace(" ", "", $telefone);
            $telefone = str_replace("(", "", $telefone);
            $telefone = str_replace(")", "", $telefone);
            
	        $p_email = $this->input->post('p_email');
	        $p_nomeRazaoSocial = $this->input->post('p_nomeRazaoSocial');
	        
	        $p_idCatalogo = $catalogo->p_idCatalogo;
	        $p_data       = $catalogo->p_data;
	        $p_idPromotor   = $catalogo->p_idPromotor;
	       
            $p_jsonCatalogo = str_replace('"', "'", $catalogo->p_jsonCatalogo);
	   
	        $this->pagamento_model->catalogoGrava($p_idCatalogo, $p_data, $cpf_cnpj, $telefone, $p_email, $p_jsonCatalogo, $p_idPromotor, $flipbookName, $p_valorTotal, $p_nomeRazaoSocial);
	        
        }
        
	    
		$this->load->view('conta/templates/header', $data);
		$this->load->view('pagamento/catalogo', $data);
		$this->load->view('conta/templates/footer', $data);
	}
  
	public function semrepresentante(){
	    
	    $data['titulo'] = ' - Sem Representante';

        $data['custom_styles'] = [base_url('dist/css/realizado.css')];

		$this->load->view('conta/templates/header', $data);
		$this->load->view('erro', $data);
		$this->load->view('conta/templates/footer', $data);
		
	}
}