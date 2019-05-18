
/*
 * All actions and form handling are ment form Symfony Form base html forms (the input naming is guessed based on Symfony form naming)
 * This class handles Symfony form response (success or failure) coming from ajax request response and REST API responses
 * The response JSON data structure must be based on FosRestBundle's invalid form structure.
 * In order for this code to work, the projet must be returning invalid forms based on FosRest strcuture
 * The main purpose of the Class is to be general, being able to be used in any kind of project
 */
//==================
/* 
 * This function is used to handle response from server with form errors
 * It checks the status code of the response and decides which function to call according to whether the form has success of errors
 */


//Mapp One error message to a specifi field
function mappErrorMessageToField(jQuerySelectorField,error_message)
{
    jQuerySelectorField.closest('div').addClass('has-error');
   jQuerySelectorField.after('<span class="help-block"><ul class="list-unstyled"><li><span class="glyphicon glyphicon-exclamation-sign"></span>'+error_message+'</li></ul></span>' );
                           
}
/* 
 * This function is used when validation fails. Its role  to parse errors from the response and mapp them with there corresponding fields
 * the param "data" structured according to FosRestBundle's invalid form structure based on JSON
 @params form_id 
 @param form_name (the form name to be referenced when selecting input elements
 @param data the structure of the data expected
 **/
function mappFormErrorsToFields(form,data)
            {
                // the argument form name is inspired by symfony form name
                let form_name=form.attr("name");
                let form_id=form.attr("id");
              if("undefined"!==typeof data.errors.errors)
                    {
                       if(data.errors.errors.length>0)
                       {
                         $("div#"+form_name).prepend('<div class="form-group has-error"></div>');
                           for(var i=0;i<data.errors.errors.length;i++)
                           {
                               $("div#"+form_name).children().first('div').prepend('<span class="help-block"><ul class="list-unstyled"><li><span class="glyphicon glyphicon-exclamation-sign">'+data.errors.errors[i]+'</span>');
                           }
                       }
                    }
        
                //mapping errors to their corresponding field
            for(key in data.errors.children)
                {
                    if("undefined"!==typeof data.errors.children[key].errors)
                    {
                        if(data.errors.children[key].errors.length>0)
                        {
                            var selectedField=$("input[name='"+form_name+"["+key+"]'],select[name='"+form_name+"["+key+"]']");
                              //mapp errors to their corresponding fields
                              let errorMessage=data.errors.children[key].errors[0]
                            mappErrorMessageToField(selectedField, errorMessage );
                           
                        }
                    }
                }
            }

/*
 * Clears error message displayed in a field
 */
function clearFieldErrorMessage(jQuerySelector)
{
     jQuerySelector.closest('div').removeClass('has-error');
     jQuerySelector.next("span").remove();                               
}
/*
 * Clears all error message displayed in fields of a form
 */
function clearAllFormErrorMessages(jQuerySelectorForm)
{
    // receives a jQuery Selector representing a form and selects all inputs
     jQuerySelectorForm.find('input, select, checkbox, textarea').each(function()
     {
         clearFieldErrorMessage($(this));
     });
                              
    
}
//Action called after form successfully sumbit with no validation errors
function successAction(form_id)
{
    
}
function resetFormValues(jQuerySelectorFrom)
{
    //alert(jQuerySelectorFrom.find("input").length);
   
    jQuerySelectorFrom.find("input[type!='hidden'][type!='submit'], select").each(
            function()
    {
          $(this).val("");
              
              
    });
    
}

function isFosRestValideData(data)
{
    var condition=true;
if( "undefined"=== typeof data.code|| "undefined"=== typeof data.message|| "undefined"=== typeof data.errors || "undefined" === typeof data.errors.children){
    return false;}
return condition;

}
//Checks if a form has validation errors
function hasValidationErros(response_data)
{
return response_data.code===400;
}
function handleForm(form)
{
    
                
                
                clearAllFormErrorMessages(form);
                var form_data=form.serialize(); 
                let url=form.attr("action"); 
                if("undefined"===typeof url || ""==url)
                {
                    //alert("Impossible de soumettre le formulaire. Url invalide!");
                    url=window.location;
                    //alert(url);return;
                }
             $.ajax({
                url:url,
                headers: {          
                            //"Accept": "application/json",         
                            //"Content-Type": "application/json"   
                          },
                dataType: 'text',
                method: "POST",
                data:form_data,
                success:function(data){
                    resetFormValues(form);
                },
                error:function(error, textStatus, errorThrown)
                {
                    alert(textStatus);
                    if("errorThrown"=="Bad Request")
                    {
                     try
                    {
                        const data=JSON.parse(error.responseText);
                        if(isFosRestValideData(data))
                        {
                            if(hasValidationErros(data))
                            {
                                mappFormErrorsToFields(form,data);
                            }
                        }else
                        {
                            alert("Le formulaire contient des erreurs! Mais elles ne peuvent pas s'afficher. Format de données  retournées par le serveur est invalide");
                        }
                    }catch(e)
                    {
                        // Si on ne parvient pas à parser la réponse c'est parce qu'elle n'est pas du bon format
                        alert("Une erreur s'est produite. Le format de donnée retourné n'est pas valide! "+e);
                    }
                    }
                }
        });
          
    
}