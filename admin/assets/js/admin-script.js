jQuery(document).ready(function($) {

	//Autofill the token and id
	var hash = window.location.hash,
        token = hash.substring(14),
        id = token.split('.')[0];

    if( hash ){
    	$('.wpb-is-configure-access-token input[name="wpb_is_access_token"').val( token );
    	$('.wpb-is-configure-access-token input[name="wpb_is_user_id"').val( id );

    	$('.wpb_plugin_btns').append('<div class="alert alert-danger"><b>Important:</b> It\'s time to click the <b>Save Changes</b> button to save the Access Token</div>');
    }
});    