

          <?php $i = 0;  foreach ($parcelas_verifica as $parcela_verifica) { ?>
                    <?php $data_primeiraparcela = date('d/m/Y', strtotime($parcela_verifica->DataVencimento)); if (++$i == 1) break; ?>
          <?php } ?>
    

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<div class="side-menu">
				<div class="image-container">
					<img src="<?=base_url('dist/img/alana/logo.png')?>" alt="Alana">
				</div>
				<ul id="side-menu-list">
					<li><a href="#" class="active"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Carnês</a></li>
					<li><a href="<?=base_url('conta/limites')?>"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Limite</a></li>
					<li><a href="<?=base_url('conta/pontuacao')?>"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Pontuação</a></li>
					<li><a href="<?=base_url('conta/minhaconta')?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Minha Conta</a></li>
				</ul>
				<p class="info">
					Central de Renegociação<br>
					49 3030-8318<br>
					Segunda a sexta - 8h às 18h<br>
					Sábado - 8h às 12h
				</p>
			</div>
		</div>
		
		<?php //print_r($parcelas); ?>

		<div id="parcela-col" class="col-sm-9">
			<div class="card">
				<h3><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Carnês</h3>
				<div class="button-pane">
					<button id="clear-table-btn" class="btn" type="button">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						Limpar seleção
					</button>
          <div id="sort-dropdown" class="dropdown">
            <button id="sort-dropdown-btn" class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
              Mais próximas <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sort-dropdown-btn">
              <li><a data-sort="proximas"><span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span> Mais próximas</a></li>
              <li><a data-sort="documento"><span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span> Por documento</a></li>
            </ul>
          </div>
				</div>

				<div class="row custom-table table-header">
						<div class="col col-xs-6 truncate" data-toggle="tooltip" data-placement="top" title="Parcela">Parcela</div>
						<div class="col col-xs-3 truncate" data-toggle="tooltip" data-placement="top" title="Vencimento">Vencimento</div>
						<div class="col col-xs-3 truncate" data-toggle="tooltip" data-placement="top" title="Valor Atualizado">Valor Atualizado</div>
				</div>

        <div id="parcela-rows">
          <?php foreach ($parcelas as $parcela) { ?>
          <div class="row custom-table table-body"
                data-type="parcela"
                data-documento="<?=$parcela->Documento?>"
                data-id-financeiro="<?=$parcela->IdFinanceiro?>"
                data-parcela-atual="<?=$parcela->ParcelaAtual?>"
                data-valor-bruto="<?=$parcela->ValorBruto?>"
                data-valor-juros="<?=$parcela->ValorJuros?>"
                data-valor-seguro="<?=$parcela->ValorSeguro?>"
                data-valor-descontos="<?=$parcela->ValorDescontos?>"
                data-valor-liquido="<?=$parcela->ValorLiquido?>"
                data-vencimento="<?=$parcela->DataVencimento?>"
                data-selected="0">
            <div class="col input-col">
              <input type="checkbox" class="pointer-events-none">
            </div>
            <div class="col col-xs-6">
                <img src="<?=base_url('dist/img/alana/icon.png')?>" alt="Alana">
                Parcela (<?php echo $parcela->ParcelaAtual ?> de <?php echo $parcela->TotalParcelas ?>)<br>
                Doc.: <?=$parcela->IdFinanceiro?>
            </div>
            <div class="col col-xs-3 font-medium"><?=date("d/m/Y", strtotime($parcela->DataVencimento))?></div>
            <div class="col col-xs-3 font-medium"><?='R$ '.number_format($parcela->ValorLiquido,2,",",".")?></div>
          </div>
          <?php } ?>
        </div>
				<?php if (count($parcelas) == 0) echo '<p style="text-align: center">Nenhuma parcela encontrada.</p>' ?>
			</div>

			<?php if (count($parcelas) > 0) {?>
			<div class="pagamento card-p0">
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
					  <button id="pagar-btn" data-loading-text="Pagar" type="button" class="btn btn-color"><b>Pagar</b></button>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>