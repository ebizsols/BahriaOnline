/*
 * Admin Test
 */
jQuery("#bank_alfalah_testing_button").click(function(){
    
    var _check_form = jQuery("#form-status").val();
    var _hs_requesthash = jQuery("#HS_RequestHash").val();
    
    jQuery("#bank_alfalah_testing_responce_wait").css( 'display', 'block' );
    
    jQuery.post(
        bank_alfalah_AuthToken.ajaxurl,
        { 
            action          : 'bank_alfalah_AuthToken',
            hs_requesthash  : _hs_requesthash,
            CheckForm       : _check_form
        },
        function( response ){
            console.log(response);
            if( response.status == 'true' ){
                jQuery("#bank_alfalah_testing_responce_wait").css( 'display', 'none' );
                jQuery("#bank_alfalah_testing_responce_success").css( 'display', 'block' );
            }else{
                jQuery("#bank_alfalah_testing_responce_wait").css( 'display', 'none' );
                jQuery("#bank_alfalah_testing_responce_error").css( 'display', 'block' );
            }
        });
    return false;
});
jQuery( "body" ).on( "click", "#alfalah-card, #alfalah-wallet, #alfalah-account",  function(){
    jQuery("#payment_method_bank_alfalah_gateway").prop("checked", true);
});

/**/
jQuery( "body" ).on( "click", ".payment_method_cod", function(){
    jQuery("#payment_method_bank_alfalah_gateway").prop("checked", false);
    jQuery("#alfalah-card, #alfalah-wallet, #alfalah-account").prop("checked", false);
});
