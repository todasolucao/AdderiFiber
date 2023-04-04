<?php 
  
switch ($retorno['Payment']['Status']) {
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
      
      $decimal = substr($retorno['Payment']['Amount'], -2);
      $retira = strlen($retorno['Payment']['Amount']) - strlen($decimal);
      $result = substr($retorno['Payment']['Amount'],0, $retira);
      $montavalor = $result.'.'.$decimal;
      

?>


<div class="container">
  <div class="row">
    <div class="col">
      <div class="payment-status">
        <img src="<?=base_url('dist/img/payment-methods/'.$statusIcone.'.png')?>" alt="<?=$status?>">
        <h3><?=$status?></h3>
        <p class="nome"><?=$retorno['Payment']['DebitCard']['Holder'];?></p>
        <table class="table table-striped resumo-list">
          <tr>
            <td>Tid</td>
            <td><?=$retorno['Payment']['Tid'];?></td>
          </tr>
          <tr>
            <td>ID de Pagamento</td>
            <td><?=$retorno['Payment']['PaymentId'];?></td>
          </tr>
          <tr>
            <td>Cartão de Débito</td>
            <td><?=$retorno['Payment']['DebitCard']['CardNumber'];?></td>
          </tr>
          <tr>
            <td>Validade do Cartão</td>
            <td><?=$retorno['Payment']['DebitCard']['ExpirationDate'];?></td>
          </tr>
          <tr>
            <td>Valor</td>
            <td><?='R$ ' . number_format($montavalor,2,",",".");?></td>
          </tr>
        </table>
        <div class="button-pane">
          <a href="<?=base_url('conta')?>" class="btn btn-color">Voltar para minha conta</a>
        </div>
      </div>
    </div>
  </div>
</div>