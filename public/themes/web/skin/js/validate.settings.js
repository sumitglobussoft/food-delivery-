$(document).ready(function(){
    
  $.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    },
    invalidHandler: function(event,validator) {

      
    },
    submitHandler: function(form) {
    
      form.submit();
    
    }

});
$.validator.addMethod("regex", function(value, element,params) {
            
            if (value == '') {
                return true;
            }

            return params.test(value);
});

    
    
    
    
    
    
    
    
    
    
    
});