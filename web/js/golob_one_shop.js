function Update_etat_caisse()
{
$.ajax({
    url: Routing.generate("caisse_show_balance"),
    success: function(res){
        $("#caisse").text(res);
    }, 
    global: false,     // this makes sure ajaxStart is not triggered, we don't wan to show loader when updating caissse
    dataType: 'html'
});
}
    
$(document).ready(function(){
// actualiser l'état de la caisse toutes les cinq minutes 
    setInterval('Update_etat_caisse()',50000);
    // récupération des produits à suggérer pour l'autocomplete
    //alert('same page');
            var donnees1=produits_autocomplete.split(",");
             $("body").on('focus','input.auto_com',function(){ 
               $( function(){
                 $( "input.auto_com" ).autocomplete({
                  source: function(request, response) {
                 var results = $.ui.autocomplete.filter(donnees1, request.term);
                response(results.slice(0, 10));
                }
                });
              });
             });
    
//================ENd of ready
});
    
