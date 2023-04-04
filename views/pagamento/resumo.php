<style>
    .row { margin:0px; }
    .container { padding:0px; }
    p { margin: 0 0 0px; }
    input#r_valorDesconto { background: #ffffff!important; display:none;}
    input#r_valorFrete { background: #ffffff!important; display:none;}
    div#campos-aqui { display: grid; margin-bottom: 40px; }
    input[type="text"]:not(:placeholder-shown) { background: #ffffff!important ; }
    input[type="number"]:not(:placeholder-shown) { background: #ffffff!important ; }
    input#cidade { width: 100%; min-height: 33px!important; padding: 10px; border-radius: 6px; margin: 10px; border: 0; }
    input::placeholder { text-transform: capitalize; }
    select { min-height: 33px; padding: 10px; border-radius: 6px; margin: 10px; border: 0; width: 100%; background-color: #ffc1c1; }
    select#estado { max-width: 96%; } input#cidade { max-width: 96%; }
    input#r_complemento { background: #ffffff!important; }
    input#r_dataNascimentoFundacao::before { content: 'Data de nascimento '; margin-right: 10px;  }
    input#r_dataNascimentoFundacao { background: #ffffff!important; }
    input#r_cnpjCpfIdEstangeiro::before { content: 'CPF ou CNPJ '; margin-right: 10px; }
    div#sexo { display: flex; align-items: center; } 
    div#bloco-sexo { display: none; }
    div#sexo input { margin: 0!important; padding: 0!important; min-height: auto!important; } 
    div#sexo label { margin-right: 24px; }
    div#form-pendentes { width: 100%; display: block; position: relative; background: #f1f1f1; padding: 20px; margin: 30px 0; } 
    form#enviar-dados { display: grid; } 
    form#enviar-dados input { min-height: 33px; padding: 10px; border-radius: 6px; margin: 10px; border: 0; background: #ffc1c1; } 
    form#enviar-dados input[type="submit"] { background: #d61f3e; height: 40px; border-radius: 6px; color: #ffffff; border: 0; max-width: 50%; margin: 0 auto 20px auto; padding: 0 20px; }
    input.preenchido { display: none; cursor: no-drop; background: #e6e6e6!important; } 
    input#r_clientId { display: none; } 
    input#r_clientSecret { display: none; } 
    input#r_publicKey { display: none; } 
    input#r_accessToken { display: none; } 
    input#r_clientSecret { display: none; } 
    input#r_documento { display: none; } 
    input#r_listaProdutos {display: none;} 
    input#r_valorTotal { display: none; } 
    input#r_tipoPessoa { display: none; }
    input#r_idValeDesconto { display: none !important; }
    input.municipio { background-color: #e6e6e6!important; display:none; }
    input#r_enderecoEntrega { display: none; }
    input#r_municipioDescricao { display: none; }
    div#bloco-estado { width: 100%; display: none; position: relative; } 
    select[name="sexo"] { max-width: 96%; }
    .termos {  padding-left:15px !important; }
    @media(max-width: 800px){
        input#r_dataNascimentoFundacao {
            width: 94%;
        }
    }
</style>
<?php
if(json_decode($this->native_session->get('hash')) == 'B2B77CE4A3101580227A3DF978BB2D98'){
    //echo "<pre>"; print_r($resumo); echo "</pre>"; 
}
$resumo->r_sexo = 'null';

?>
<input type="hidden" value='<?php echo json_encode($resumo); ?>' name="jsonRetorno" id="jsonRetorn" />

    <div class="row">
        <div class="container">
               <br>
               <div class="col col-md-6 col-xs-12" style="border: 0px solid #ccc;">
                         <div style="padding:0px 0px;">
                            <b style="padding:5px 0px; font-size: 12px;">ITENS DO PEDIDO</b>
                        </div>
                        <hr>
                      <div style="padding-left:0px;">
                      <?php foreach($resumo->r_listaProdutos as $item){ ?>
                        <div style="padding:5px 0px;">
                            <div class="row" style="margin-right: -5px !important;">
                                    <div class="col-md-1 col-xs-1"><span style="border-bottom: 0px solid #ccc; padding:0px; font-size:12px;"><?php echo $item->quantidade; ?></span></div>
                                    <div class="col-md-9 col-xs-8"><span style="border-bottom: 0px solid #ccc; font-size:12px"> <?php echo $item->descricao; ?></span></div>
                                    <div class="col-md-2 col-xs-3 text-right">
                                        <b style=" border:0px solid #ccc; padding:0px; margin-right: -5px !important; font-size:12px"><?='R$ ' . number_format($item->total,2,",",".");?></b>
                                    </div>
                                </div>
                            </div>
                      <?php } ?>
                      </div>
                       <table class="table table-striped resumo-list">
                        <tr>
                          <td>Sub Total</td>
                          <td><?='R$ ' . number_format($resumo->r_valorSubTotal,2,",",".");?></td>
                        </tr>
                        <?php if($resumo->r_valorDesconto > 0){ ?>
                                <tr>
                                  <td>Desconto <?php echo '('.$resumo->r_idValeDesconto.')'; ?></td>
                                  <td><?='R$ ' . number_format($resumo->r_valorDesconto,2,",",".");?></td>
                                </tr>
                        <?php } ?>
                         <tr>
                          <td>Frete</td>
                          <td><?='R$ ' . number_format($resumo->r_valorFrete,2,",",".");?></td>
                        </tr>
                        
                        <tr>
                          <td>Total</td>
                          <td><?='R$ ' . number_format($resumo->r_valorTotal,2,",",".");?></td>
                        </tr>
                      </table>
                      <?php 
                      
                      if($resumo->r_idValeDesconto != ' '){ ?>
                            <?php if($retornoCupom == 'S'){ ?>
                            
                              <span style="color:green">CUPOM APLICADO COM SUCESSO!</span>
                            <?php } ?>
                        <?php }else{ ?>
                            <div style="background:#f9f9f9; padding:20px">
                                    <?php if($retornoCupom == 'E'){ ?>
                                      <span style="color:red">CUPOM EXPIRADO!</span>
                                    <?php }elseif($retornoCupom == 'I'){ ?>
                                      <span style="color:red">CUPOM INVÁLIDO!</span>
                                    <?php }elseif($retornoCupom == 'C'){ ?>
                                      <span style="color:red">CUPOM CANCELADO!</span>
                                    <?php }elseif($retornoCupom == 'U'){ ?>
                                      <span style="color:red">CUPOM JÁ FOI UTILIZADO!</span>
                                    <?php } ?> 
                                    <form action="" method="post">
                                    <div><b>CUPOM DE DESCONTO</b></div>
                                    <input type="hidden" value="<?php echo json_decode($this->native_session->get('hash')); ?>" name="hash">
                                    <input type="text" placeholder="Digite aqui..." name="voucher" class="form-control" style="margin:10px 0px;">
                                    <input type="submit" value="Aplicar" class="btn btn-success" name="cupom" style="background:#d61f3e; color:#fff">
                                    </form>
                            </div>
                        <?php } ?>
              
                </div>
                <div class="col col-md-6 col-xs-12">
                    <div style="padding:0px 0px;"><b style="padding:0px 0px">DADOS DO PAGADOR</b></div>
                    <hr>
                      <div style="padding-left:0px;">
                          <?php if(strlen($resumo->r_nomeRazaoSocial) > 1){ ?>
                             <b style="font-size:12px">NOME: </b> <br><?php echo $resumo->r_nomeRazaoSocial; ?><br>
                          <?php } ?>
                          <?php if(strlen($resumo->r_cnpjCpfIdEstangeiro) > 1){ ?>
                          <b style="font-size:12px">CPF/CNPJ: </b> <br><?php echo str_pad($resumo->r_cnpjCpfIdEstangeiro, 11, '0', STR_PAD_LEFT); ?><br>
                          <?php } ?>
                          <?php if(strlen($resumo->r_telefone) > 1){ ?>
                          <b style="font-size:12px">TELEFONE: </b> <br><?php echo $resumo->r_telefone; ?><br>
                          <?php } ?>
                          <?php if(strlen($resumo->r_dataNascimentoFundacao) > 1){ ?>
                          <b style="font-size:12px">DATA NASCIMENTO: </b> <br><?php echo date("d/m/Y", strtotime($resumo->r_dataNascimentoFundacao)); ?><br>
                          <?php } ?>
                          <?php if(strlen($resumo->r_enderecoEntrega) > 1){ ?>
                          <b style="font-size:12px">ENDEREÇO DE ENTREGA: </b> <br><?php echo $resumo->r_enderecoEntrega; ?>
                          <?php } ?>
                          <br><a href="#" class="btn btn-warning" onclick="alterarDados()">Alterar Dados</a>
                          <br><br>
                      </div>
                      
                      <div id="checa-endereco" style="display: none;">
                          <p>Preencha os campos destacados em vermelho e salve as informações</p>
                          <div id="form-pendentes" style="display:none;">
                              <form method="POST" action="" id="enviar-dados">
                                  <div id="campos-aqui">
                                            <div id="bloco-sexo" style="display:none">
                                            <select name="sexo" id="sexo" style="display:none">
                                                <option value="null" selected>Sexo Não informado</option>   
                                                <option value="M">Masculino</option>  
                                                <option value="F">Feminino</option>  
                                            </select>
                                            </div>
                                            <div id="bloco-estado" style="display:none;">
                                            <p style="display: none; padding-left: 10px;">Estado</p>
                                            <select id="estado" name="estado">
                                                <option value="null">Selecione...</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                                <option value="EX">Estrangeiro</option>
                                            </select>
                                            </div>
                                        </div>
                                  <input type="text" value="null" id="cidade" name="cidade" disabled="true" style="display:none">
                                  <input type="submit" name="submit" value="Salvar dados">
                              </form>
                          </div>
                      </div>
                </div>
        </div>
    </div>
    <div class="container termos">
            <div id="termoTexto">
                <div class="" id="ck_permissao">
                    <div class="">
                        <div class="">
                              <p class="forma-pagamento-title">Escolha sua forma de pagamento:</p>
                              <div class="forma-pagamento">
                                    <?php if($resumo->r_condicaoPagamento == 'Todos'){ ?>
                                        <a href="<?=base_url('pagamento/credito')?>">
                                          <img src="<?=base_url('dist/img/payment-methods/cartao-credito.png')?>" alt="Cartão de Crédito">Cartão de Crédito
                                        </a>
                                        <a href="<?=base_url('pagamento/pix')?>">
                                          <img src="<?=base_url('dist/img/payment-methods/pagamento-pix.png')?>" alt="Pix">Pix
                                        </a>
                                    <?php }elseif($resumo->r_condicaoPagamento == 'Pix'){ ?>
                                        <a href="<?=base_url('pagamento/pix')?>">
                                          <img src="<?=base_url('dist/img/payment-methods/pagamento-pix.png')?>" alt="Pix">Pix
                                        </a>
                                    <?php }elseif($resumo->r_condicaoPagamento == 'Cartão'){ ?>
                                        <a href="<?=base_url('pagamento/credito')?>">
                                          <img src="<?=base_url('dist/img/payment-methods/cartao-credito.png')?>" alt="Cartão de Crédito">Cartão de Crédito
                                        </a>
                                    <?php } ?>
                              </div>
                        </div>
                    </div>
              </div>
          </div>
  </div>
<script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
   
 
$('.container.termos').hide();  
   
var jsonTRATAR = JSON.parse($('input#jsonRetorn').val());
var count = 0;



$.each(jsonTRATAR, function(i,v){
  
    if(v == ' ' || v == 0 || v == null || v == 'SELECIONE'){
    
        $('#checa-endereco').show();
        if(i == 'r_sexo'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: 'null',
                placeholder: i,
                class: 'preenchido',
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_dataNascimentoFundacao'){
            $('<input>', {
                type: 'date',
                id: i, 
                name: i,
                value: '',
                placeholder: i,
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_municipio'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: '',
                placeholder: i,
            }).appendTo('div#form-pendentes form #campos-aqui');
            
        }else if(i == 'r_uf'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: '',
                placeholder: i,
            }).appendTo('div#form-pendentes form #campos-aqui');
            $("#bloco-estado").insertAfter('#r_complemento');
            $('#bloco-estado').show();
            $('#estado').show();
            
        }else if(i == 'r_complemento'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_','') + ' (opcional)',
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_valorDesconto'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_','') + ' (opcional)',
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_valorFrete'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_','') + ' (opcional)',
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_valorSubTotal'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_','') + ' (opcional)',
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_documento' || i == 'r_numero'){
            $('<input>', {
                type: 'number',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_',''),
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_cep'){
            $('<input>', {
                type: 'number',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_',''),
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_cnpjCpfIdEstangeiro'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i,
            }).appendTo('div#form-pendentes form #campos-aqui');
              
        }else{
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: '',
                placeholder: i.replace('r_','')
            }).appendTo('div#form-pendentes form #campos-aqui');
        }
      
        $('#r_logradouro').hide();
        $('#r_bairro').hide();
        $('#r_municipio').hide();
        $('#r_complemento').hide();
        $('#r_uf').hide();
        $('#r_estado').hide();
        $('#estado').hide();
        

}else{
        $('#checa-endereco').show();
        if(i == 'r_sexo'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                placeholder: i,
                value: 'null',
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            document.getElementById("sexo").value = v;
            document.getElementById("sexo").style = "background-color: #fff;"
        }else if(i == 'r_dataNascimentoFundacao'){
            $('<input>', {
                type: 'date',
                id: i, 
                name: i,
                value: v,
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            document.getElementById("r_dataNascimentoFundacao").style = "background-color: #fff;";
        }else if(i == 'r_municipio'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: v,
                placeholder: i,
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
        }else if(i == 'r_uf'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: v,
                placeholder: i,
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            $("#bloco-estado").insertAfter('#r_complemento');
            $('#bloco-estado').show();
            document.getElementById("estado").value = v;
            $('#estado').show();
            document.getElementById("estado").style = "background-color: #fff;";
            
        }else if(i == 'r_complemento'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_','') + ' (opcional)',
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_valorDesconto'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_','') + ' (opcional)',
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_valorFrete'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_','') + ' (opcional)',
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_valorSubTotal'){
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_','') + ' (opcional)',
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_documento'){
            $('<input>', {
                type: 'number',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_',''),
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_cep'){
            $('<input>', {
                type: 'number',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_',''),
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }else if(i == 'r_cnpjCpfIdEstangeiro'){
            $('<input>', {
                type: 'hidden',
                id: i, 
                name: i,
                value: v,
                placeholder: i,
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            $('#r_cnpjCpfIdEstangeiro').hide();
            count = count + 1;
        }else if(i == 'r_numero'){
            $('<input>', {
                type: 'number',
                id: i, 
                name: i,
                value: v,
                placeholder: i,
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            $('#r_cnpjCpfIdEstangeiro').hide();
            count = count + 1;
        }else{
            $('<input>', {
                type: 'text',
                id: i, 
                name: i,
                value: v,
                placeholder: i.replace('r_',''),
                class: 'preenchido'
            }).appendTo('div#form-pendentes form #campos-aqui');
            count = count + 1;
        }
} 
    
});


        
if(count >= 20){
    
    if($('#r_numero').val() == ''){
        $('#form-pendentes').toggle("show",function(){});
        
    }else{
        
        $('.container.termos').show();
        $('#form-pendentes').toggle("hide",function(){});
        $('#form-pendentes').hide();
    }
    
    function alterarDados(){
        
        if($('#r_numero').val() == ''){
            
            $('#form-pendentes').toggle("hide",function(){});
            $('#form-pendentes').toggle("show",function(){});
        }else{
            
            $('#form-pendentes').toggle("show",function(){});
        }
        
        $('.preenchido').show();
        $('#r_publicKey').hide();
        $('#r_accessToken').hide();
        $('#r_clientId').hide();
        $('#r_clientSecret').hide();
        $('#r_documento').hide();
        $('#r_municipio').hide();
        $('#r_condicaoPagamento').hide();
        $('#r_listaProdutos').hide();
        $('#r_valorTotal').hide();
        $('#r_tipoPessoa').hide();
        $('#r_enderecoEntrega').hide();
        $('#r_valorSubTotal').hide();
        $('#r_valorDesconto').hide();
        $('#r_valorFrete').hide();
        $('#r_uf').hide();
        $('#bloco-estado').show();
        $('#sexo').hide();
        $('#bloco-sexo').hide();
        $('#estado').show();
        $('#r_numero').show();
        $('#r_complemento').show();
        $('#r_idValeDesconto').hide();
        $('#r_valorSubTotal').hide();    
        $('#r_municipioDescricao').hide();    
    }
    
    
}else{
    
    
        if($('#r_numero').val() == ''){
            $('#form-pendentes').toggle("show",function(){});
        }else{
            $('#form-pendentes').toggle("hide",function(){});
        }
        
    function alterarDados(){
        
        if($('#r_numero').val() == ''){
            $('#form-pendentes').toggle("hide",function(){});
            $('#form-pendentes').toggle("show",function(){});
        }else{
            $('#form-pendentes').toggle("hide",function(){});
        }
        
        $('.preenchido').show();
        $('#r_publicKey').hide();
        $('#r_accessToken').hide();
        $('#r_clientId').hide();
        $('#r_clientSecret').hide();
        $('#r_documento').hide();
        $('#r_municipio').hide();
        $('#r_condicaoPagamento').hide();
        $('#r_listaProdutos').hide();
        $('#r_valorTotal').hide();
        $('#r_tipoPessoa').hide();
        $('#r_enderecoEntrega').hide();
        $('#r_valorSubTotal').hide();
        $('#r_valorDesconto').hide();
        $('#r_valorFrete').hide();
        $('#r_uf').hide();
        $('#bloco-estado').show();
        $('#sexo').hide();
        $('#bloco-sexo').hide();
        $('#estado').show();
        $('#r_numero').show();
        $('#r_complemento').show();
        $('#r_idValeDesconto').hide();
        $('#r_valorSubTotal').hide();    
        $('#r_municipioDescricao').hide();    
    }
}

if($('input#r_sexo').length){
$('select[name="sexo"]').on("change", function(){
    $('input#r_sexo').val($(this).val()) 
    $(this).attr('style','background-color:#ffffff')
});
}

if($('input#r_sexo').val() == 'M' || $('input#r_sexo').val() == 'F'){
    
    $('div#sexo').hide();
}

var array = [];
$('#enviar-dados input').each(function(){
    if($(this).val() == ''){
        array.push($(this).attr('name'));
    }
});


//if(array.length == 1 || array[0] == 'r_complemento' || array[0] == 'r_valorDesconto' || array[0] == 'r_valorFrete' || array[0] == 'r_valorSubTotal'){  $('.container.termos').show(); }

        $(document).ready(function() {
            function limpa_formulário_cep() {
                $("#r_logradouro").val("");
                $("#r_bairro").val("");
                $("#r_municipio").val("");
                $("#r_uf").val("");
                $("#ibge").val("");
                $("#cidade").val("");
            }
            
            $("#r_cep").blur(function() {
                $("#r_municipio").val("");
               
                var cep = $(this).val().replace(/\D/g, '');

                if (cep != "") {

                    var validacep = /^[0-9]{8}$/;

                    if(validacep.test(cep)) {
                        $('#r_logradouro').show();
                        $('#r_bairro').show();
                        $('#r_numero').show();
                        $('#r_municipio').show();
                        $('#r_complemento').show();
                        $('#r_uf').show();
                        $("#r_logradouro").val("...");
                        $("#r_bairro").val("...");
                        $("#r_municipio").val("...");
                        $("#r_uf").val("...");
                        $("#r_ibge").val("...");
                                            
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                $("#r_logradouro").val(dados.logradouro);
                                $("#r_bairro").val(dados.bairro);
                                $("#r_cidade").val(dados.localidade);
                                $("#r_uf").val(dados.uf);
                                $("#r_municipio").val(dados.ibge);
                                $("#cidade").val(dados.localidade);
                                $("#cidade").show();
                                $("#cidade").insertAfter('input#r_complemento');
                                $("select#estado option").each(function(){
                                    if($(this).val() == dados.uf){
                                        $(this).prop("selected",true).trigger("change");
                                        $('select#estado').attr('style','background-color: #ffffff!important')
                                    }
                                });
                                $("#bloco-estado").insertAfter('#cidade');
                 
                            }
                            else {
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    }
                    else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                }
                else {
                    limpa_formulário_cep();
                }
            });
        });

var numero = setInterval(function(){
    if($('input#r_numero').length){
        $('input#r_numero').attr('placeholder','Número');
        clearInterval(numero);
    }
},500);

var telefone = setInterval(function(){
    if($('input#r_telefone').length){
        $('input#r_telefone').attr('placeholder','Whatsapp');
        clearInterval(telefone);
    }
},500);

var rua = setInterval(function(){
    if($('input#r_logradouro').length){
        $('input#r_logradouro').attr('placeholder','Rua');
        clearInterval(rua);
    }
},500);

var r_cnpjCpfIdEstangeiro = setInterval(function(){
    if($('input#r_cnpjCpfIdEstangeiro').length){
        $('input#r_cnpjCpfIdEstangeiro').attr('placeholder','CPF/CNPJ');
        clearInterval(r_cnpjCpfIdEstangeiro);
    }
},500);

var r_nomeRazaoSocial = setInterval(function(){
    if($('input#r_nomeRazaoSocial').length){
        $('input#r_nomeRazaoSocial').attr('placeholder','Nome/Razão Social');
        clearInterval(r_nomeRazaoSocial);
    }
},500);

var r_email = setInterval(function(){
    if($('input#r_email').length){
        $('input#r_email').attr('placeholder','E-mail');
        clearInterval(r_email);
    }
},500);

$('input#r_dataNascimentoFundacao').on("change", function(){
    $(this).attr('style','background-color: #ffffff')
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>

var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#r_cnpjCpfIdEstangeiro').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$('#r_cnpjCpfIdEstangeiro').length > 11 ? $('#r_cnpjCpfIdEstangeiro').mask('00.000.000/0000-00', options) : $('#r_cnpjCpfIdEstangeiro').mask('000.000.000-00#', options);

$('#r_cep').mask('00000000', options);



var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('#r_telefone').mask(behavior, options);
$('select#estado').on("change", function(){
    $('#r_uf').val($(this).val()) 
});
</script>