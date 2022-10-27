const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2
                });
                
    
function editField(inputId){
    $('#'+inputId).removeAttr("disabled");
}
function saveField(inputId){
    $('#'+inputId).attr("disabled","disabled");   
}


(function(){
 
    function removeAccents ( data ) {
        if ( data.normalize ) {
            // Use I18n API if avaiable to split characters and accents, then remove
            // the accents wholesale. Note that we use the original data as well as
            // the new to allow for searching of either form.
            return data +' '+ data
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }
      
        return data;
    }
     
    var searchType = jQuery.fn.DataTable.ext.type.search;
     
    searchType.string = function ( data ) {
        return ! data ?
            '' :
            typeof data === 'string' ?
                removeAccents( data ) :
                data;
    };
     
    searchType.html = function ( data ) {
        return ! data ?
            '' :
            typeof data === 'string' ?
                removeAccents( data.replace( /<.*?>/g, '' ) ) :
                data;
    };
 
}());


function displayOptions(element,selectionArray,source,sourceKeyArray,selected){
    let Options = "";
    let isSelected     = "";
    let selectionObj  = source.filter(function(source) {
        let isValid = 0;
        selectionArray.forEach(function(selection,key){
            let Key = sourceKeyArray[key];
            if(source[Key] == selection){
                isValid++;
            }
        });
        return (isValid == selectionArray.length);
    });
    $(`#${element} .dinamic`).remove();
    selectionObj.forEach(function(select){
        isSelected = (select.Id == selected) ? " selected='selected' " : "";
        Options += `<option class="dinamic" ${isSelected} value="${select.Id}" >${select.Nombre}</option>`;
    });
    $(`#${element}`).append(Options);
}

$(function() {
    $(document).on('click', '.edit', function(){
        let inputId      = $(this).attr('input');
        $(this).parent().append('<button class="edit-save-btn save" input="'+inputId+'">Guardar</button>');
        $(this).parent().find( ".edit" ).remove();
        editField(inputId);
    });
    $(document).on('click', '.save', function(){
        let inputId = $(this).attr('input');
        saveField(inputId);
        $(this).removeClass('save');
        $(this).addClass('edit');
        $(this).html('edit');
    });
    
    $(".amount").each(function() {
        let amount        = $(this).val();
        let amountNumeric = Number(amount.replace(/[^-0-9\.]+/g,""));
        amountNumeric     = parseFloat(amountNumeric).toFixed(2);
        $(this).val(amountNumeric);
        $(this).attr("value",amountNumeric);
        $(this).select();
    });
    $( ".amount" ).keyup(function() {
        let amount       = $(this).val();
        amount           = (!isNaN(parseFloat(amount)) && isFinite(amount)) ? amount : 0;
        amount           = parseFloat(amount).toFixed(2);
        $(this).attr("value",amount);
    });

    $(".amount").focus(function() {
        let amount        = $(this).val();
        let amountNumeric = Number(amount.replace(/[^-0-9\.]+/g,""));
        amountNumeric     = parseFloat(amountNumeric).toFixed(2);
        $(this).val(amountNumeric);
        $(this).select();
    });
    $(".amount").focusout(function() {
        let amount = $(this).val();
        amount = (!isNaN(parseFloat(amount)) && isFinite(amount)) ? amount : 0;
        amount = parseFloat(amount).toFixed(2);
        $(this).attr("value",amount);
        $(this).val(formatter.format(amount));
    });
    
    
    /*
	
    $(".amount").keyup(function() {
    });
    $(".amount").focus(function() {
        let discount        = $(this).val();
        let discountNumeric = Number(discount.replace(/[^0-9\.]+/g,""));
        discountNumeric     = parseFloat(discountNumeric).toFixed(2);
        $(this).val(discountNumeric);
        $(this).select();
    });
    $(".amount").focusout(function() {
        let amount = $(this).val();
        amount = (!isNaN(parseFloat(amount)) && isFinite(amount)) ? amount : 0;
        amount = parseFloat(amount).toFixed(2);
        $(this).attr("value",amount);
        $(this).val(formatter.format(amount));
    });
    */
}); 