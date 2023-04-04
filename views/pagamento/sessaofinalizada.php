<div class="container">
  <div class="row">
    <div class="col">
      <div class="payment-status">
        <img src="<?=base_url('dist/img/payment-methods/pagamento_falho.png')?>" alt="<?=$status?>">
        <h3>Sessão Finalizada!</h3>
        <p class="nome">Isto ocorre quando você efetua pagamentos e <br>tenta realizar outro por uma aba aberta anteriormente</p>
        Selecione as parcelas desejadas e efetue seu pagamento e/ou por tempo expirado de sessão!
        <div class="button-pane">
          <a href="<?=base_url('conta')?>" class="btn btn-color">Voltar para minha conta</a>
        </div>
      </div>
    </div>
  </div>
</div>