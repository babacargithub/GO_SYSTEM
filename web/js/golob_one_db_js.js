// Ces deux fonctions seront appelées à chaque fois qu'un appel d'une requête ajax sera lancée 
$(document).ajaxStart(function(){ showLoader(); /* affiche la bare de progression*/	});
$(document).ajaxComplete(function(){ hideLoader(); /* cahce la bare de progression à la fin de l'appel*/});
 $(document).ready(function(){ 
     
   	$('#sidebar a').on('click', function(e)
        {
            e.preventDefault();
            var href=$(this).attr('href');
            if(href!="#")
            {
            $.ajax({
                url:href,
                contentType: "text/plain",
                dataType: "html",
                success: function(serverResponse){
                $("#content_body").html(serverResponse);
            },error:function(serverResponse){
                alert("Une erreur s'est produit, le contenu de \" "+href+"\" n'as pa pu être chargé" );
            }
             });
            
            }else
            {
                //ne fais rien. Les liens avec # ne rendent pas de contenus sonc inutile de les charger 
            }
        }
                );
        
 });
