$(document).ready(function() {
    $('#register-link').on('click', function() {
         $('.apollo-login').hide();
         $('.apollo-register').css('display','block');
         $('.apollo-back').css('display','block');
     });
        $('.apollo-back').on('click', function() {
         $('.apollo-register').css('display','none');
         $('.apollo-login').css('display','block');
         $('.apollo-forgotten-password').css('display','none');
         });
         
         
         $('#password-link').on('click',function(){
           
              $('.apollo-login').css('display','none');
              $('.apollo-back').css('display','block');
              $('.apollo-forgotten-password').css('display','block');
            
             
         });
   
    });