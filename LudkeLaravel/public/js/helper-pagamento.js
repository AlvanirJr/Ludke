// Contador utilizado para excluir linha com forma de pagamento
let countFormaPagamento = 0;

/**
 * Função que desabilita data de vencimento quando o tipo de pagamento for "à vista" 
 * @param {ThisParameterType} select 
 */
function disableDataVencimento(select){
    // Caso o pagamento seja 'a vista'
    let rowForm = select.parentElement.parentElement;
    let colDate = rowForm.childNodes[3];
    let inputDate = colDate.childNodes[1];
    console.log(inputDate);
    if(select.value == 1){
        inputDate.required = false;
        colDate.style.display = "none";
        let date = new Date();
        let now = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);
        inputDate.value = now;
        
    }else{
        inputDate.required = true;
        inputDate.value = '';
        colDate.style.display = "block";
        
    }
}

    
/**
 * Função que verifica se o valor do pagamento é menor que o valor Total
 * @param {Float} contValorTotalPagamento 
 * @param {Float} valorTotal 
 */
function validPayment(contValorTotalPagamento, valorTotal){

    if( contValorTotalPagamento < valorTotal){
        return false;
    }else{
        return true;
    }

}

/**
 * Cria a linha com os inputs da nova forma de pagamento
 * @param {String} today 
 * @return {String} form
 */
function addFormaDePagamento(today){
        
    // console.log("Nova Forma de Pagamento")
    let form = "<div id='formaPagamento"+countFormaPagamento+"'>"+
                "<div class='row informacoes'>"+
                    "<div class='col-sm-10'>"+
                        "<h3>Informações do Pagamento</h3>"+
                    "</div>"+
                    "<div class='col-sm-2'>"+
                        "<button class='btn btn-secondary-ludke' onclick='excluirFormaPagamento("+countFormaPagamento+")'>Excluir</button>"+
                    "</div>"+
                "</div>"+
                "<div class='row justify-content'>"+
                    "<div class='col-sm-3 form-group'>"+
                        "<label for='formaPagamento'>Tipo de Pagamento <span class='obrigatorio'>*</span></label>"+
                        "<select name='formaPagamento[]' class='form-control' id='formaPagamento' onChange='disableDataVencimento(this)' required>"+
                            "<option value='' disabled>-- Tipo de Pagamento --</option>"+
                            optionsFormaPagamento()+
                        "</select>"+
                        "<span style='color:red' id='spanformaPagamento'></span>"+
                    "</div>"+
                    "<div class='col-sm-3 form-group'>"+
                        "<label for='valorTotalPagamento'>Valor (R$) <span class='obrigatorio'>*</span></label>"+
                        "<input type='number' id='valorTotalPagamento' min='0' step='0.01' onkeyup='validaValorPagamento()' class='form-control' name='valorTotalPagamento[]' required>"+
                        "<span style='color:red' id='spanValorPago'></span>"+
                    "</div>"+
                    "<div class='col-sm-3 form-group'>"+
                        "<label for='descontoPagamento'>Desconto %</label>"+
                        "<input id='descontoPagamento' type='number' class='form-control' value='0' min='0' max='100' name='descontoPagamento[]' disabled>"+
                        "<span style='color:red' id='spanDescontoPagamento'></span>"+
                    "</div>"+
                    "<div class='col-sm-3 form-group' style='display: none'>"+
                        "<label for='dataVencimento'>Data de Vencimento</label>"+
                        "<input type='date' class='form-control' id='dataVencimento' name='dataVencimento[]' value='"+today+"'>"+
                        "<span style='color:red' id='spanDataVencimento'></span>"+
                    "</div>"+
                "</div>"+                    
                "<div class='row justify-content-center'>"+
                    "<div class='col-sm-12 form-group'>"+
                        "<label for='obs'>Observações</label>"+
                        "<textarea class='form-control' name='obs[]' id='' rows='5'></textarea>"+
                    "</div>"+
                "</div>"+
            "</div>";
    countFormaPagamento += 1;
    return form;           
}

// Ao clicar no botão excluir, retira os inputs referente à forma de pagamento
function excluirFormaPagamento(id){
    id = "formaPagamento"+id;
    $(`#${id}`).remove();
}