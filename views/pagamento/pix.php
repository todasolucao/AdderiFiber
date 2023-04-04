<?php 
if($pix->error->message){
    echo 'ERRO: '. $pix->error->message;
    exit();
}
?>
<div class="container">

    <div class="payment-title text-center">
        <h3>Pague com PIX</h3>
    </div>

    <div class="row text-center">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="container-wrapper preload" style="border: 1px solid">
                        <br>
                        <h5>Aproxime seu celular e leia o QRCode</h5>
						<?php 
						
                            echo $this->pagamento_model->GeraPix($pix->point_of_interaction->transaction_data->qr_code);
						
						    if($pix->point_of_interaction->transaction_data->qr_code){
						        
						    }else{
						        redirect('https://adderi.todasolucao.com.br/');
						    }
						
						?>
                        <br>
                        <div class="col-md-12">
                            <input type="text" value="<?php echo $pix->point_of_interaction->transaction_data->qr_code; ?>" id="qrcode" class="form-control">
                        </div>
                        <br>
                        <br>
                    <div class="tooltipss">
                        <button onclick="copy()" onmouseout="outFunc()" style="background: var(--primary-color); color: #fff; border: none; padding: 10px">
                            <span class="tooltiptext" id="myTooltip">Para copiar o QRCode clique aqui!</span>
                        </button>
                    </div>

                    <br>
                </div>
            </div>


        </div>
    </div>
</div>

<style>
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>

<script>
    function copy() {
        var copyText = 0;
        var copyText = document.getElementById("qrcode");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

    }

    function outFunc() {
        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "QRCode Copiado com Sucesso!";
    }
</script>