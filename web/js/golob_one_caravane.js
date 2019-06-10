function Update_etat_dep()
{
    //$.get('etats_depart.golob',"", function(res){ $("#menu").html(res); });
  var url=window.location.href ;
$.ajax({
    url: 'etats_depart.golob',
    success: function(res){
        $("#sidebar2").append(res);
    }, 
    global: false,     // this makes sure ajaxStart is not triggered
    dataType: 'html'
});
}	
//==========Afficher la liste des inscrits par appel AJAX===================
     $('body').on('click','.liste_inscrit, .liste_depart, .liste_chiffre', function(e){
         e.preventDefault();
          $.ajax({
                  url:$(this).attr('href'),
                  ContentType: "text/html",
                  dataType:"html",
                  success:function(reponse){$('#content_body').html(reponse);},
                  error:function(error,type,ErrorThrown){ alert(ErrorThrown);}
     });
     
     });
     //====================Traiter de mani�re uniformis�e les boutons d'action dans les listes==========
   
     $(document).ajaxStart(function()
						{
							showLoader();	
						}
				);
				$(document).ajaxComplete(function()
						{
								hideLoader();
						}
				);
$(document).ready(function()
{
 //=============================MODULE RESERVATION=============================================================
 var caravane_bundle="go_caravanebundle";
    var module_form=caravane_bundle+"_reservationtype";

 $("#"+module_form+"_client_prenom, #"+module_form+"_client_nom").attr('required',false);
 $("#"+module_form+"_client_prenom_div,"+"#"+module_form+"_client_nom_div").hide();
 $('#details_client').hide();
 
 //===================Traitement lors de la selection d'un d�part====================
 $("#"+module_form+"_depart").change(function(e)
        { 
                var trajet=$(this,"option:selected").val();
                var trajet_dep=$(this).find('option:selected').attr('trajet');
                var dep_ugb_dk=1;
                var dep_dk_ugb=2;
                if(trajet_dep==dep_ugb_dk)
                {
                $("#"+module_form+"_pointDep").find('option[trajet='+dep_ugb_dk+']').show();
                $("#"+module_form+"_pointDep").find('option[trajet='+dep_dk_ugb+']').hide();
                $("#"+module_form+"_des").find('option[trajet='+dep_ugb_dk+']').show();
                $("#"+module_form+"_des").find('option[trajet='+dep_dk_ugb+']').hide();
                }else
                {
                $("#"+module_form+"_pointDep").find('option[trajet='+dep_dk_ugb+']').show();
                $("#"+module_form+"_pointDep").find('option[trajet='+dep_ugb_dk+']').hide();
                $("#"+module_form+"_des").find('option[trajet='+dep_dk_ugb+']').show();
                $("#"+module_form+"_des").find('option[trajet='+dep_ugb_dk+']').hide();
                
                }
                if(trajet_dep==2)
                {
                 $("#"+module_form+"_paye").attr('required',false);
                 $("#"+module_form+"_paye_0").attr('required',false);
                 $("#"+module_form+"_paye_1").attr('required',false);
                 $("#"+module_form+"_paye_div").hide();
                }
                else if(trajet_dep==1)
                {
                 $("#"+module_form+"_paye").attr('required',true);
                 $("#"+module_form+"_paye_div").show();
                }
			}
			);
   //==================traitement lors de la saisie du num�ro de t�l�phone
 $("#"+module_form+"_client").on(
    {
        keyup:function(e)
        {
            $('#details_client').hide();
            $('#invalid_client_form').hide();
            var tel=$(this).val();
            var len_tel=tel.length;
            if(len_tel==9)
            {
                if(isValideTelephone(tel))
                {
                    $.ajax({
                        url:'details_client-'+tel+'.golob',
                        dataType:"html",
                        success:function(reponse){
                        $('#details_client').show();
                        $('#details_client .panel-body').html(reponse);
                    }
                });
                    $("#"+module_form+"_client_prenom_div,"+"#"+module_form+"_client_nom_div").show();

                    /*function(result, data1, xch)
            {
        reponse=JSON.parse(result);
    if(reponse[0].client_exist==1)
        {
        $("#formulaire_detail_client").show();
        $("#div_prenom_res").hide();	
        $("#div_nom_res").hide();	
        $("#nom_res").attr("required", false);
        $("#prenom_res").attr("required", false);
        $("#prenom_detail").html(reponse[0].prenom_client);
        $("#nom_detail").html(reponse[0].nom_client);
        $("#num_voy_detail").html(reponse[0].nombre_voyage);
        $("#voy_en_cours_detail").html(reponse[0].voyage_en_cours);
         if(reponse[0].voyage_en_cours!="")
         {
                 alert("Ce client a fait une r�servation sur le  d�part  "+reponse[0].voyage_en_cours);

//$("#formulaire_reservation :input").prop("disabled", true); 
         }


}
else
{
$("#formulaire_detail_client").hide();
$("#div_prenom_res").show();
$("#prenom_res").attr("required", true);	
$("#div_nom_res").show();	
$("#nom_res").show().attr("required", true);	
}
}*/
    }else{
    show_alert("Erreur: le num�ro du t�l�phone entr� n'est pas valide!");

    }
    }
    else
    {

    }
}
});

//_____ actualisation des �tats des d�parts toutes les 5 minutes--------------------->>>		
setInterval('Update_etat_dep()', 50000);	


});
