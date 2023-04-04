<div class="row">
        <div class="container">
            
               <div class="col col-md-4 hidden-xs"></div>
                   <div class="col col-md-4 col-xs-12" >
                                <p>Preencha os campos e clique em continuar</p>
                              
                                <form method="POST" action="">
                                           
                                      <label>CPF</label>       
                                      <input type="text" value="" id="p_cnpjCpfIdEstangeiro" name="p_cnpjCpfIdEstangeiro" class="form-control" required="true">
                                      <label>Nome</label>       
                                      <input type="text" value="" id="p_nomeRazaoSocial" name="p_nomeRazaoSocial" class="form-control" required="true">
                                      <label>Telefone</label>   
                                      <input type="text" value="" id="p_telefone" name="p_telefone" class="form-control" required="true">
                                      <label>E-mail</label>   
                                      <input type="mail" value="" id="p_email" name="p_email" class="form-control" required="true">
                                      <br>
                                      
                                      <input type="hidden" value='<?php echo json_encode($exibe) ?>' id="catalogo" name="catalogo">
                                      <input type="submit" name="submit" class="btn" value="Continuar">
                                      
                                </form>
                    </div>
                    <div class="col col-md-4 hidden-xs"></div>
                </div>
        </div>
</div>
     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#p_cnpjCpfIdEstangeiro').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}
$('#p_cnpjCpfIdEstangeiro').length > 11 ? $('#p_cnpjCpfIdEstangeiro').mask('00.000.000/0000-00', options) : $('#p_cnpjCpfIdEstangeiro').mask('000.000.000-00#', options);
var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};
$('#p_telefone').mask(behavior, options);
</script>