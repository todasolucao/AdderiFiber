<?php
switch ($payment->getStatus()) {
        case 1:
        case 2:
          $status = 'Operação realizada com sucesso';
          $statusIcone = 'pagamento_sucesso';
          // Operação realizada com sucesso
          break;
        case 3:
          $status = 'Operação não autorizada';
          $statusIcone = 'pagamento_falho';
          // Operação negada
          break;
        default:
          $status = 'O sistema de pagamento retornou um erro inesperado, tente mais tarde';
          $statusIcone = 'pagamento_erro';
      }
     
?>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="payment-status">
        <img src="<?=base_url('dist/img/payment-methods/'.$statusIcone.'.png')?>" alt="<?=$statuss?>">
        <h3><?=$status?></h3>
        <p class="nome"><?=$payment->getDebitCard()->getHolder()?></p>
        <table class="table table-striped resumo-list">
          <tr>
            <td>Tid</td>
            <td><?=$payment->getPaymentId()?></td>
          </tr>
          <tr>
            <td>Cartão de Débito</td>
            <td><?=$payment->getDebitCard()->getCardNumber()?></td>
          </tr>
          <tr>
            <td>Validade do Cartão</td>
            <td><?=$payment->getDebitCard()->getExpirationDate()?></td>
          </tr>
          <tr>
            <td>Valor</td>
            <td><?='R$ ' . number_format($resumo['Total'],2,",",".");?></td>
          </tr>
        </table>
        <div class="button-pane">
          <a href="<?=base_url('conta')?>" class="btn btn-color">Voltar para minha conta</a>
        </div>
      </div>
    </div>
  </div>
</div>