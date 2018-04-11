<?php
global $wpdb;

$user_id =  get_current_user_id();
$wp_user = get_user_by( 'ID', $user_id );
//$contactId = get_user_meta($user_id, '_contactId', true );
$contactEmail = $wp_user->user_email;

//$contact = dynamic365_get_contact($contactId);

$websiteId = get_current_blog_id();
$blogs = get_blogs_of_user($user_id);
$blogids = Array();
foreach ($blogs as $blog) {
	$blogid = $blog->userblog_id;
	array_push($blogids, $blogid);
}

if (in_array($websiteId, $blogids)) {

// print_r($contact);

$first_name = $wp_user->first_name;
$last_name = $wp_user->last_name;
$full_name = $first_name . ' ' . $last_name;
$email = $contactEmail;
//$direct_line = $contact->telephone1;
$direct_line = get_user_meta($user_id, '_direct_line', true);

$userdata = array(
		'ID' => $user_id,
		'first_name'  =>  $first_name,
		'last_name'  =>  $last_name
	);

$userid = wp_update_user( $userdata ) ;
	
/**
 * Save wp user meta
 */
update_user_meta( $user_id, '_direct_line', $direct_line);	

?>

<div id="your_profile_wrap">
	<img class="icon" src="<?php echo plugins_url( '/img/profile-icon.png', __FILE__ ); ?>">
	<form class="your_profile" method="post" action="#">
		<input type="hidden" name="contact_id" value="<?php echo $contactId; ?>">
		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
		
		<p><label> First name </label> <span><strong><?php echo $first_name; ?></strong></span>
			<?php  ?><input type="text" name="first_name" value="<?php echo $first_name; ?>" class="inputField" style="display:none">
			<a style="float: right" class="changeBtn">Change</a></p><?php ?>
			
		<p><label> Last name </label> <span><strong><?php echo $last_name; ?></strong></span>
			<?php ?><input type="text" name="last_name" value="<?php echo $last_name; ?>" class="inputField" style="display:none">
			<a style="float: right" class="changeBtn">Change</a></p><?php ?>
			
		<p><label> Email newsletters </label> <span><strong><?php echo $email; ?></strong></span></p>
			
		<p><label> Telephone </label> <span><strong><?php echo $direct_line; ?></strong></span>
			<?php ?><input type="text" name="telephone" value="<?php echo $direct_line; ?>" class="inputField" style="display:none">
			<a style="float: right" class="changeBtn">Change</a></p><?php ?>
		<input type="hidden" name="action" value="update_user_profile" />
		<?php wp_nonce_field('wp_nonce','update_profile'); ?>	
	</form>
	<a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
</div>

<hr>

<div class="subscriptions">
<h2 class="title">Your Subscriptions</h2>

<?php 

$id = $user_id;
$websites = Array(2,3,4,5);
?>

<p>Portfolio Adviser <?php if(in_array(2, $blogids)) { ?><strong>Subscribed</strong><?php } else { ?> <a target="_blank" href="https://pa.cms-lastwordmedia.com/subscribe/?user=<?php echo$id; ?>&blog=2">Subscribe</a><?php } ?></p>
<p>International Adviser <?php if(in_array(3, $blogids)) { ?> <strong>Subscribed</strong> <?php } else { ?> <a target="_blank" href="https://ia.cms-lastwordmedia.com/subscribe/?user=<?php echo$id; ?>&blog=3">Subscribe</a><?php } ?></p>
<p>Expert Investor <?php if(in_array(5, $blogids)) { ?> <strong>Subscribed</strong> <?php } else { ?> <a target="_blank" href="https://ei.cms-lastwordmedia.com/subscribe/?user=<?php echo$id; ?>&blog=5">Subscribe</a><?php } ?></p>
<p>Fund Selector Asia <?php if(in_array(4, $blogids)) { ?> <strong>Subscribed</strong> <?php } else { ?> <a target="_blank" href="https://fsa.cms-lastwordmedia.com/subscribe/?user=<?php echo$id; ?>&blog=4">Subscribe</a><?php } ?></p>

</div>

<hr>

<div class="saved-articles">
<h2 class="title">Your saved articles</h2>

<?php 

if (isset($_POST["unsave"])) {
	$saved1 =  get_user_meta($user_id, 'saved_posts');
	$savedarr1 = $saved1[0];
	$unsave = $_POST["unsave"];

	if (($key = array_search($unsave, $savedarr1)) !== false) {
    	unset($savedarr1[$key]);
	}

	$savedarr1 = update_user_meta($user_id, 'saved_posts', $savedarr1);
}

$saved =  get_user_meta($user_id, 'saved_posts');
$savedarr = $saved[0];
$counts = count($savedarr);

if ($counts > 0) {
	$sargs = array('numberposts' => 5, 'post__in' => $savedarr);
	$savedposts = get_posts($sargs);

	foreach ($savedposts as $savedpost) { ?>


	<div class="row loop-list">
		<div class="col-md-4 content-image">
			<?php echo get_the_post_thumbnail( $savedpost->ID, 'section-article' ); ?>
		</div>
		<div class="col-md-8 content-des">
			<p class="name-cat">
                <?php $category = get_the_category($savedpost->ID); ?>
                <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
            </p>
			<a class="savedlink" href="<?php echo get_the_permalink($savedpost->ID); ?>"><h3><?php echo apply_filters( 'the_title', $savedpost->post_title ); ?></h3></a>
			<form method="post">
				<input type="hidden" name="unsave" value="<?php echo $savedpost->ID; ?>">
				<button type="submit" class="unsbutt">Unsave</button>
			</form>
		</div>
	</div>

	<?php }} 
	//delete_user_meta($user_id, 'saved_posts');
	?>
</div>

<?php /* ?>
<div id="key_interest_wrap">

<img class="icon" src="<?php echo plugins_url( '/img/interests-icon.png', __FILE__ ); ?>">
<h3>Key Interest</h3>
<span class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span>

<form class="key_interest" method="post" action="#">
	<input type="hidden" name="contact_id" value="<?php echo $contactId; ?>">
	<?php

		$operator = 'and';
        $output = 'objects';
        $args = Array('public' => true);
        $taxonomies = get_taxonomies( $args, $output, $operator);
        $exclude = array( 'post_tag', 'lw_ad_unit_group', 'post_format' );

        if ( $taxonomies ) {

            foreach ( $taxonomies  as $taxonomy ) {

                if( in_array( $taxonomy->name, $exclude ) ) {
                    continue;
                }

                $terms = get_terms( array(
                    'taxonomy' => $taxonomy->name,
                    'hide_empty' => 0,
                ) );

                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

                   	$term_list = '<div class="key-list">';

                    foreach ( $terms as $term ) {
                        $term_list .= '<p><label>' . $term->name . '</label><a style="float: right" class="changeBtn" subscribed="false">Subscribe</a></p>';          
                    }

                    echo $term_list;
                }

            }

        }

	?>
		
</form>
</div>
<?php */ ?>

<script>
	jQuery(document).on("click",".your_profile .changeBtn", function() { 
		var inputField =  jQuery(this).closest('p').find('.inputField').focus().show();
		jQuery(this).closest('p').find('span').hide();
		
		if(jQuery(inputField).is(":visible"))
		{	
		   jQuery(inputField ).focus();
		}
	});
	

    jQuery(".your_profile input").blur(function(e){// when a div is clicked my form cames to the interface  
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
              data : jQuery('.your_profile').serialize(),
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

    jQuery(".key_interest .changeBtn").on( 'click', function(e){// when a div is clicked my form cames to the interface  
		var curr_element = jQuery(this);
		var curr_val = curr_element.attr('subscribed');
		var curr_label = curr_element.parent().find('label');
		
		var data = {
			action: 'update_key_interest',
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
	.your_profile a, .key_interest a{
		cursor: pointer;
	}

	.subscriptions a {
		float: right;
	}

	.subscriptions strong {
		float: right;
	}
</style>

<?php

} else {
	echo "You don't have access to this content.";
}

?>