$(document).ready(function(){
    $('input#calendario').datepicker( {
        changeYear: true, 
        changeMonth: true,
        yearRange: "-100Y:+0Y"
    });
    $('input.invia').click(function(event) {
        controlloCampi('#codicefiscale',16,'Il codice fiscale deve essere di 16 cifre');
        controlloCampi('.obbligatorio',1,'Questo campo &egrave obbligatorio');
        controlloCampi('#codiceprodotto',8,'Il codice prodotto deve essere di 8 cifre');
    });
});

function controlloCampi(campo, lunghezza, messaggio){
    $(campo).each(function(){
        if ($.trim($(this).val()).length < lunghezza){
            $(this).next('.errore').remove();
            $(this).addClass('evidenzia');
            $(this).after('<span class="errore">'+messaggio+'</span>');
            event.preventDefault();
        } else {
            $(this).removeClass("evidenzia");
            $(this).next('.errore').remove();
        }
    });
}