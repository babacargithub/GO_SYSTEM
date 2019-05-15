
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
function handleResponse(form_id, reponse_data)
{
    
}
/* 
 * This function is used when validation fails. Its role  to parse errors from the response and mapp them with there corresponding fields
 * the param "data" structured according to FosRestBundle's invalid form structure based on JSON
 @params form_id 
 @param form_name (the form name to be referenced when selecting input elements
 @param data the structure of the data expected
 **/
function mappFormErrorsToFields(form_id, form_name,data)
            {
                // handle errors not related to fields
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
                               $("input[name='"+form_name+"["+key+"]'],select[name='"+form_name+"["+key+"]']").closest('div').addClass('has-error');
                              $("input[name='"+form_name+"["+key+"]'],select[name='"+form_name+"["+key+"]']").after('<span class="help-block"><ul class="list-unstyled"><li><span class="glyphicon glyphicon-exclamation-sign"></span>'+data.errors.children[key].errors[0]+'</li></ul></span>' );
                           
                        }
                    }
                }
            }
function mappErrorToField(field_id, error_message)
{
    
}
/*
 * Clears error message from a field
 */
function clearFieldErrorMessage(field_id)
{
    
}

function successAction(form_id)
{
    
}
function validationFailedAction()
{
    
}
function hasValidationErros(response_data)
{
    
return (response_data.code==400);


}
