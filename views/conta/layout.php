<div class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="side-menu card">
        <div class="image-container">
          <img src="<?=base_url('dist/img/alana/logo.png')?>" alt="Alana">
        </div>
        <ul id="side-menu-list">
          <li><a href="#" class="active"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Carnês</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Limite</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Pontuação</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Minha Conta</a></li>
        </ul>
        <p class="info">
          Central de Renegociação<br>
          49 3030-8318<br>
          Segunda a sexta - 8h às 18h<br>
          Sábado - 8h às 12h
        </p>
      </div>
    </div>
    <div class="col-md-9">
      <div class="limite card">
        <h3>Limite de compra</h3>
        <div class="saldo-pane">
          <div class="saldo-progress">
            <progress-ring stroke="2" radius="50" progress="0"></progress-ring>
            <div class="saldo-icon">
              <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
              <small>disponível</small>
            </div>
          </div>
          <p>
            Saldo disponível para compras<br>
            R$ 360,00<br>
            Utilizado R$ 0,00 de R$ 360,00
          </p>
        </div>
      </div>

      <div class="carnes card">
        <h3><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Carnês</h3>
        <div class="button-pane">
          <button type="button" class="btn" id="clear-table">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            Limpar seleção
          </button>
          <button type="button" class="btn">
            <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
            Mais recentes
          </button>
        </div>

        <div class="table-container">
          <table id="carnes-table" class="table selectable">
            <thead>
              <tr>
                <td width="39px"></td>
                <td>Parcela</td>
                <td class="text-center">Vencimento</td>
                <td class="text-center">Valor Atualizado</td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($carnes as $carne) { ?>
              <tr data-id-financeiro="<?=$carne['IdFinanceiro']?>"
                  data-data-vencimento="<?=$carne['DataVencimento']?>"
                  data-valor-liquido="<?=$carne['ValorLiquido']?>"
                  data-selected="0">
                <td>
                  <input type="checkbox" class="pointer-events-none">
                </td>
                <td>
                  <img src="<?=base_url('dist/img/alana/icon.png')?>" alt="Alana">
                  <?=$carne['IdFinanceiro']?>
                </td>
                <td class="text-center"><?=$carne['DataVencimento']?></td>
                <td class="text-center">R$ <?=$carne['ValorLiquido']?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="pagamento card">
        <div class="row-pagamento">
          <div class="col-pagamento">
            <div class="wrapper">
              <p>Subtotal <span id="subtotal-count"></span></p>
              <p class="valor">R$ <span id="subtotal-value">0,00</span></p>
            </div>
          </div>
          <div class="col-pagamento">
            <div class="wrapper">
              <p>Seguro</p>
              <p class="valor">R$ <span id="seguro-value">0,00</span></p>
            </div>
          </div>
          <div class="col-pagamento">
            <div class="wrapper">
              <p>Encargos</p>
              <p class="valor">R$ <span id="encargos-value">0,00</span></p>
            </div>
          </div>
          <div class="col-pagamento">
            <div class="wrapper">
              <p>Descontos</p>
              <p class="valor">R$ <span id="descontos-value">0,00</span></p>
            </div>
          </div>
          <div class="col-pagamento total">
            <div class="wrapper">
              <p>Total</p>
              <p class="valor">R$ <span id="total-value">0,00</span></p>
            </div>
          </div>
          <button type="button" class="btn btn-color"><b>Pagar</b></button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url('dist/js/views/conta.js')?>"></script>
<script src="<?=base_url('dist/js/progress-ring.js')?>"></script>