<?php 
//echo "<pre>";
//print_r($status);
//echo "</pre>";

if ($status) {
				
				    switch($status->status_detail) {
                    case "accredited":
                        $retorno = "Aprovado";
            		break;
            		case "pending_contingency":
                       $retorno = "Estamos processando o pagamento. Em até 2 dias úteis informaremos por e-mail o resultado.";
                    break;
            
                    case "pending_review_manual":
                         $retorno = "Estamos processando o pagamento. Em até 2 dias úteis informaremos por e-mail se foi aprovado ou se precisamos de mais informações.";
                    break;
            
                    case "cc_rejected_bad_filled_card_number":
                         $retorno = "Confira o número do cartão.";
                    break;
            
                    case "cc_rejected_bad_filled_date":
                    	 $retorno = "Confira a data de validade.";
                    break;
            							  case "cc_rejected_bad_filled_other":
                    	 $retorno = "Confira os dados.";
                    break;
            							  case "cc_rejected_bad_filled_security_code":
                    	 $retorno = "Confira o código de segurança.";
                    break;
            							  case "cc_rejected_blacklist":
                    	 $retorno = "Não conseguimos processar seu pagamento.";
                    break;
            							  case "cc_rejected_call_for_authorize":
                    	 $retorno = "Você deve autorizar em seu banco o pagamento do valor ao Mercado Pago.";
                    break;
            							  case "cc_rejected_card_disabled":
                    	 $retorno = "Ligue para o payment_method_id para ativar seu cartão. O telefone está no verso do seu cartão.";
                    break;
            							  case "cc_rejected_card_error":
                    	 $retorno = "Não conseguimos processar seu pagamento. Tente novamente mais tarde.";
                    break;
            							
            							case "cc_rejected_duplicated_payment":
                    	 $retorno = "Você já efetuou um pagamento com esse valor. Caso precise pagar novamente, utilize outro cartão ou outra forma de pagamento.";
                    break;
            							case "cc_rejected_high_risk":
                    	 $retorno = "Seu pagamento foi recusado. Escolha outra forma de pagamento. Recomendamos meios de pagamento por boleto.";
                    break;
            							case "cc_rejected_insufficient_amount":
                    	 $retorno = "O seu cartão possui saldo insuficiente. Tente outro cartão ou selecione a opção boleto.";
                    break;
            							case "cc_rejected_invalid_installments":
                    	 $retorno = "O seu cartão não processa pagamentos parcelados.";
                    break;
            							case "cc_rejected_max_attempts":
                    	 $retorno = "Você atingiu o limite de tentativas permitido. Escolha outro cartão ou outra forma de pagamento.";
                    break;
            							case "cc_rejected_other_reason":
                    	 $retorno = "O seu banco não conseguiu processar o seu pagamento. Tente novamente em instantes.";
                    break;
                }
            }

?>


<div class="container">
  <div class="row">
    <div class="col">
      <div class="payment-status">
        <h3><?=$retorno?></h3>
        <p class="nome"></p>
        <table class="table table-striped resumo-list">
          <tr>
            <td>Cartão de Crédito</td>
            <td>XXXX XXXX XXXX <?php echo $status->card->last_four_digits; ?></td>
          </tr>
          <tr>
            <td>Validade do Cartão</td>
            <td><?php echo $status->card->expiration_month; ?>/<?php echo $status->card->expiration_year; ?></td>
          </tr>
          <tr>
            <td>Parcelamento</td>
            <td><?php echo $status->installments; ?> x <?='R$ ' . number_format($status->transaction_details->installment_amount,2,",",".");?></td>
          </tr>
          <tr>
            <td>Valor</td>
            <td><?='R$ ' . number_format($status->transaction_details->total_paid_amount,2,",",".");?></td>
          </tr>
        </table>
        <div class="button-pane">
          <a href="<?=base_url('')?>" class="btn btn-color">Voltar para o inicio</a>
        </div>
      </div>
    </div>
  </div>
</div>