
<style>
    .row {
        margin:0px;
    }
    .container {
        padding:0px;
    }
</style>
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
                            <b style=" border:0px solid #ccc; padding:5px 5px; font-size:12px"><?php echo $item->quantidade; ?></b>
                            <span style="border-bottom: 0px solid #ccc; padding: 5px 10px; font-size:12px"> <?php echo $item->descricao; ?><br></span>
                        </div>
                      <?php } ?>
                     
                      </div>
                       <table class="table table-striped resumo-list">
                        <tr>
                          <td>Total</td>
                          <td><?='R$ ' . number_format($resumo->r_valorTotal,2,",",".");?></td>
                        </tr>
                      </table>
                </div>
                
               <div class="col col-md-6 col-xs-12" >
                 
                        <div style="padding:0px 0px;">
                            <b style="padding:0px 0px">DADOS DO PAGADOR</b>
                        </div>
                        
                         <hr>
                      <div style="padding-left:0px;">
                          <b style="font-size:12px">NOME: </b> <br><?php echo $resumo->r_nomeRazaoSocial; ?><br>
                          <b style="font-size:12px">CPF/CNPJ: </b> <br><?php echo str_pad($resumo->r_cnpjCpfIdEstangeiro, 11, '0', STR_PAD_LEFT); ?><br>
                          <b style="font-size:12px">ENDEREÇO DE ENTREGA: </b> <br><?php echo $resumo->r_enderecoEntrega; ?>
                          <br><br>
                      </div>
                      
                </div>
        </div>
     
  
    </div>
    
    <style>
        input[type=checkbox]:checked ~ #termoTexto{
            display: block;
        }
        #termoTexto {
            display:none;
        }
        .termos {
            padding-left:15px !important;
            
        }
    </style>   
     
    <div class="container termos">
             <label>Confirmo os dados acima descritos:</label> 
             <input type="checkbox" id="termos" />
     
            <div id="termoTexto">
      
                <div class="" id="ck_permissao">
                    <div class="">
                        <div class="">
                              <p class="forma-pagamento-title">Escolha sua forma de pagamento:</p>
                              <div class="forma-pagamento">
                                    <?php if(status_credito == 1){ ?>
                                    <a href="<?=base_url('pagamento/credito')?>">
                                      <img src="<?=base_url('dist/img/payment-methods/cartao-credito.png')?>" alt="Cartão de Crédito">Cartão de Crédito
                                    </a>
                                    <?php } ?>
                                    
                                    <?php if(status_debito == 1){ ?>
                                    <a href="<?=base_url('pagamento/debito')?>">
                                      <img src="<?=base_url('dist/img/payment-methods/cartao-debito.png')?>" alt="Cartão de Débito">Cartão de Débito
                                    </a>
                                    <?php } ?>
                                    
                                    <?php if(status_pix == 1){ ?>
                                    <a href="<?=base_url('pagamento/pix')?>">
                                      <img src="<?=base_url('dist/img/payment-methods/pagamento-pix.png')?>" alt="Pix">Pix
                                    </a>
                                    <?php } ?>
                              </div>
                        </div>
                    </div>
              </div>
          </div>
  </div>