(function( $ ) {
	'use strict';

	$(document).ready(function () {
		$('#tpmcattt-table').DataTable();

		$("#tpmcattt-tabs").tabs();

		// $('.tp_colorpiker').minicolors();

	});

})( jQuery );

function tpmcattt_restore_term(term_id) {
	//alert(term_id);

	jQuery.ajax({
		type: "post",
		//dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		url: tpmcattt.ajaxurl,
		data: {
			action: "tpmcattt_restore_term",
			nonce: tpmcattt.ajax_nonce,
			term_id: term_id,
			// nonce: nonce
		},
		beforeSend: function() {
			jQuery(".lds-roller-mask").show();
		},
		success: function(response) {
			jQuery(".lds-roller-mask").hide();
			// jQuery("#tr-"+term_id).hide();
			if(response == 'pro') {
				alert('Available for PRO version only');
				jQuery("#tpmcattt-test").html('Available for PRO version only');
			}
			else {
				jQuery("#tr-"+term_id).fadeOut();
				// jQuery("#tppdn-required-validation-"+pid).html(response);
			}

		}
	}); 

}

function tpmcattt_delete_term(term_id) {
	
	var confirm_txt = "You are about to permanently delete these items from your site. This action cannot be undone. Cancel to stop, 'OK' to delete";

	if (confirm(confirm_txt)) {
		jQuery.ajax({
			type: "post",
			//dataType: "json",
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			url: tpmcattt.ajaxurl,
			data: {
				action: "tpmcattt_delete_term",
				nonce: tpmcattt.ajax_nonce,
				term_id: term_id,
				// nonce: nonce
			},
			beforeSend: function() {
				jQuery(".lds-roller-mask").show();
			},
			success: function(response) {
				jQuery(".lds-roller-mask").hide();
				// jQuery("#tr-"+term_id).hide();
				jQuery("#tr-"+term_id).fadeOut();
				// jQuery("#tppdn-required-validation-"+pid).html(response);
				jQuery("#tpmcattt-test").html(response);
	
			}
		}); 
	}
}

//--------------------- Woocommerce ---------------------
function tpmcattt_restore_woo_term(term_id) {
	alert('PRO option only');
}

function tpmcattt_delete_woo_term(term_id) {
	var confirm_txt = "You are about to permanently delete these items from your site. This action cannot be undone. Cancel to stop, 'OK' to delete";

	if (confirm(confirm_txt)) {
		jQuery.ajax({
			type: "post",
			//dataType: "json",
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			url: tpmcattt.ajaxurl,
			data: {
				action: "tpmcattt_delete_woo_term",
				nonce: tpmcattt.ajax_nonce,
				term_id: term_id,
				// nonce: nonce
			},
			beforeSend: function() {
				jQuery(".lds-roller-mask").show();
			},
			success: function(response) {
				jQuery(".lds-roller-mask").hide();
				// jQuery("#tr-"+term_id).hide();
				jQuery("#tr-"+term_id).fadeOut();
				// jQuery("#tppdn-required-validation-"+pid).html(response);
				jQuery("#tpmcattt-test").html(response);
	
			}
		}); 
	}
}
//--------------------- Woocommerce ---------------------