<?php
global $wpdb;

// $user_id =  get_current_user_id();
$user_id =  76;
$contactId = get_user_meta($user_id, '_contactId', true );

$contact = dynamic365_get_contact($contactId);

// print_r($contact);

$first_name = $contact->firstname;
$last_name = $contact->lastname;
$full_name = $first_name . ' ' . $last_name;
$email = $contact->emailaddress1;
$job_title = $contact->jobtitle;
$direct_line = $contact->telephone1;


?>

<div id="email_alert_wrap">
	
	<h3>Your email address</h3>
	
	<img class="icon" src="<?php echo plugins_url( '/img/email-icon.png', __FILE__ ); ?>">
	<form class="email_alert" method="post" action="#">
		<input type="hidden" name="contact_id" value="<?php echo $contactId; ?>">
			
		<p><label> We'll send email newsletters to </label> <span><strong><?php echo $email; ?></strong></span>
			<input type="text" name="email_address" value="<?php echo $email; ?>" class="inputField" style="display:none">
			<a style="float: right" class="changeBtn">Change</a></p>
			
		<input type="hidden" name="action" value="update_user_profile" />
		<?php wp_nonce_field('wp_nonce','update_email_alert'); ?>	
	</form>
</div>

<hr>

<div id="your_subscription_wrap">

<img class="icon" src="<?php echo plugins_url( '/img/subscriptions-icon.png', __FILE__ ); ?>">
	<h3>Your Subscriptions</h3>
	<span class="desc">You are subscribed to following publications:</span>

<form class="your_subscription" method="post" action="#">
	<input type="hidden" name="contact_id" value="<?php echo $contactId; ?>">
	
	<p><label class="subscribed"> <strong>Portfolio Advisor Newsletter</strong>_Monthly (1st) </label>
		<a style="float: right" class="changeBtn" subscribed="true">Unsubscribe</a></p>
	<p><label class="subscribed"> <strong>Instant Alerts</strong>_Instant </label>
		<a style="float: right" class="changeBtn" subscribed="true">Unsubscribe</a></p>
	<p><label> <strong>Dapibus Purus</strong>_Weekly (Thursday) </label>
		<a style="float: right" class="changeBtn" subscribed="false">Subscribe</a></p>
	<p><label> <strong>Ullamcorper Inceptos Partiruent</strong>_Monthly</label>
		<a style="float: right" class="changeBtn" subscribed="false">Subscribe</a></p>
		
</form>
</div>

<script>
	jQuery(document).on("click",".email_alert .changeBtn", function() { 
		var inputField =  jQuery(this).closest('p').find('.inputField').focus().show();
		jQuery(this).closest('p').find('span').hide();
		
		if(jQuery(inputField).is(":visible"))
		{	
		   jQuery(inputField ).focus();
		}
	});
	

    jQuery(".email_alert input").blur(function(e){// when a div is clicked my form cames to the interface  
		var new_value = jQuery(this).val();
		var new_label = jQuery(this).parent().find('span strong');
		
		jQuery('span').show();
		jQuery('.inputField').hide();
        e.preventDefault();
		new_label.html(new_value);
		
        jQuery.ajax({
			  type: "POST",
              url: lastword.ajaxurl,
              timeout: 30000,
              data : jQuery('.email_alert').serialize(),
              cache: false,
              error: function(){
                    alert('server not responding');
                },
                success: function( msg ) {
                        // new_label.html(new_value);
                }
        });
    });

</script>

<script>	

    jQuery(".your_subscription .changeBtn").on( 'click', function(e){// when a div is clicked my form cames to the interface  
		var curr_element = jQuery(this);
		var curr_val = curr_element.attr('subscribed');
		var curr_label = curr_element.parent().find('label');
		
		var data = {
			action: 'update_your_subscription',
			'curr_val': curr_val,                    
			'contactId': '<?php echo $contactId ?>',                    
		};
		// alert(curr_val);
		if(curr_val=='true'){			
			curr_element.html('Subscribe');
			curr_element.attr('subscribed', "false");
			curr_label.removeClass('subscribed');
		}else{			
			curr_element.html('Unsubscribe');
			curr_element.attr('subscribed', "true");
			curr_label.addClass('subscribed');
		}
		
        jQuery.ajax({
			  type: "POST",
              url: lastword.ajaxurl,
              timeout: 30000,
              data : data,
              cache: false,
              error: function(){
                   alert('server not responding');
                },
                success: function( response ) {
					var data = jQuery.parseJSON(response);
                    if(data.new_status){
					}else{
					}
                }
        });
		
        e.preventDefault();
    });

</script>

<style>
	.email_alert a, .your_subscription a{
		cursor: pointer;
	}
</style>