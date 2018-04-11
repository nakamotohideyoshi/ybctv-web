<?php
/**
 * Create dynamic365 contact
 */ 
function dynamic365_create_contact( $args ){	
	
	if( ! is_array($args) )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	/**
	 * create a new contact
	 */ 
	$record = $service->entity( 'asl_websiterecord' );
	
	/**
	 * set contact fields
	 */ 
	foreach( $args as $key=>$val ){
		if( isset($record->$key)){
			
			switch( $key ){
				case "asl_title1":
						$title = dynamic365_get_title_id($val);
						$label = $val;
						$val = new AlexaCRM\CRMToolkit\OptionSetValue($title, $label);
						$record->__set( $key, $val );
					break;
				case "asl_u11joblevel1":
						$joblevel = dynamic365_get_joblevel_id($val);
						$label = $val;
						$val = new AlexaCRM\CRMToolkit\OptionSetValue($joblevel, $label);
						$record->__set( $key, $val );
					break;
				case "asl_accept3pc":
						$accept3pc = dynamic365_get_terms_id($val);
						$accept3pc_int = (int) $accept3pc;
						if ($accept3pc_int == 1) {
							$label = 'Yes';
						} else {
							$label = 'No';
						}
						$val = new AlexaCRM\CRMToolkit\OptionSetValue($accept3pc_int, $label);
						$record->__set( $key, $val );
					break;
				case "asl_acceptterms":
						$acceptterms = dynamic365_get_terms_id($val);
						$acceptterms_int = (int) $acceptterms;
						if ($acceptterms_int == 1) {
							$label = 'Yes';
						} else {
							$label = 'No';
						}
						$val = new AlexaCRM\CRMToolkit\OptionSetValue($acceptterms_int, $label);
						$record->__set( $key, $val );
					break;
				case "asl_country":
						$country_id = dynamic365_get_country_id($val);
						try{
							$asl_country=$service->entity( 'asl_country', $country_id);
						}catch( Exception $e ){
						}
						if ( $asl_country->exists ) {							
							$record->__set( $key, $asl_country );							
						}
					break;
				case "asl_jobrole":
						$jobrole_id = dynamic365_get_jobrole_id($val);
						try{
							$asl_jobrole=$service->entity( 'asl_jobfunction', $jobrole_id);
						} catch ( Exception $e ) {
						}
						if ( $asl_jobrole->exists ) {			
							$record->__set( $key, $asl_jobrole );					
						}
					break;
				case "asl_product":
						try{
							$asl_product=$service->entity( 'asl_product', $val);
						} catch ( Exception $e ) {
						}
						if ( $asl_product->exists ) {			
							$record->__set( $key, $asl_product );					
						}
					break;
				case "asl_companytype":
					$companytype_id = dynamic365_get_companytype_id($val);
					try{
						$asl_companytype=$service->entity( 'asl_companytype', $companytype_id);
					} catch ( Exception $e ) {
					}
					if ( $asl_companytype->exists ) {							
						$record->__set( $key, $asl_companytype );							
					}
				break;
				case "asl_magtype1":						
						switch( $val ){
							case 'printed and digital':
									$magtype_code = '860000000';
									$magtype_label = 'Print and Digital';
								break;
							case 'digital':
									$magtype_code = '860000001';
									$magtype_label = 'Digital';
								break;
						}
						$record->$key = new AlexaCRM\CRMToolkit\OptionSetValue($magtype_code, $magtype_label);
					break;
				case "asl_source1":
						switch( $val ){
							case '860000000':
									$source_label = 'NEWSLETTER';
								break;
							case '860000001':
									$source_label = 'ABC DATAMA';
								break;
							case '860000002':
									$source_label = 'ABC EMAIL';
								break;
							case '860000003':
									$source_label = 'MAGAZINE';
								break;
							case '860000004':
									$source_label = 'NEWS';
								break;
							case '860000005':
									$source_label = 'BCC 16';
								break;
							case '860000006':
									$source_label = 'WEB';
								break;
							case '860000007':
									$source_label = 'ABC - BCC';
								break;
							case '860000008':
									$source_label = 'EVENTS';
								break;
							case '860000009':
									$source_label = 'EMAIL CAMP';
								break;
							case '860000010':
									$source_label = 'AUTO MAG';								
								break;
							default:
									$source_label =  "";
								break;
						}
						
						$record->$key = new AlexaCRM\CRMToolkit\OptionSetValue($val, $source_label);
					break;
				case "asl_purchasesource1":
				
						switch( $val ){
							case '860000000':
									$purchase_label = 'Email Campaign';
								break;
							case '860000001':
									$purchase_label = 'BCC';
								break;
							case '860000002':
									$purchase_label = 'Email';
								break;
							case '860000003':
									$purchase_label = 'Website';
								break;
							case '860000004':
									$purchase_label = 'Telephone';
								break;
							case '860000005':
									$purchase_label = 'In person';
								break;
							default:
									$purchase_label =  "";
								break;
						}
						
						$record->$key = new AlexaCRM\CRMToolkit\OptionSetValue($val, $purchase_label);
					break;
				case "asl_telephone1":
					$record->$key = $val;
					break;
				case "asl_title":
					$record->$key = $val;
					break;	
				default:
						$record->$key = $val;
					break;	
			}		
		}
		/**
		 * ex:		
		 * $contact->firstname = 'John';
		 * $contact->lastname = 'Doe';
		 * $contact->emailaddress1 = 'john.doe@example.com';
		 */
	}
	
	// echo "<pre>"; print_r( $contact ); echo "</pre>";
	// echo "<pre>"; print_r( $contact->propertyValues ); echo "</pre>";
	
	/**
	 * create contact
	 */ 
	 
	try{
		$contactId = $record->create();
	}catch( Exception $e ){
		echo "<pre>"; print_r( $e ); echo "</pre>"; 
	}
	// echo "<pre>"; print_r( $contactId ); echo "</pre>";
	
	return $contactId;
	
	// execute an action
	// $whoAmIResponse = $service->executeAction( 'WhoAmI' );
	// echo 'Organization ID: ' . $whoAmIResponse->OrganizationId;

	// inject cache repo
	// must be instance of AlexaCRM\CRMToolkit\CacheInterface
	// $cacheRepo = Cache::instance();
	// $service = new Client( $serviceSettings, $cacheRepo );
}

/**
 * Update dynamic365 contact
 */ 

function dynamic365_update_contact( $contactId, $args ){	
	
	if( ! $contactId )
		return false;
	
	if( ! is_array($args) )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );

	/**
	 * get contact from id
	 */ 	
	$contact = $service->entity( 'asl_websiterecord', $contactId );
	
	// is contact exists ?
	if( ! $contact->asl_email ){
		return false;
	}
	
	/**
	 * set contact fields
	 */ 
	foreach( $args as $key=>$val ){
		if( isset($contact->$key) )
			$contact->$key = $val;
	}
	
	/**
	 * Update contact
	 */ 
	$contact->update();
	
	return true;	
}

/**
 * Delete dynamic365 contact
 */ 
function dynamic365_delete_contact( $contactId ){
	
	if( ! $contactId )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );

	/**
	 * get contact from id
	 */ 	
	$contact = $service->entity( 'contact', $contactId );
	
	// is contact exists ?
	if( ! $contact->emailaddress1 ){
		return false;
	}
	
	/**
	 * Delete contact
	 */ 
	$contact->delete();
	
	return true;
	
}

/**
 * Create web activity
 */ 
function dynamic365_create_web_activity( $args ){
	
	if( ! is_array($args) )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	/**
	 * create a new contact
	 */ 
	$activity = $service->entity( 'asl_webactivity' );
		
	/**
	 * set activity fields
	 */ 
	foreach( $args as $key=>$val ){
		if( isset($activity->$key)){
			
			switch( $key ){
				case "asl_contact":
						$contact = $service->entity( 'contact', $val );		
						
						if( $contact->exists )
							$activity->asl_contact = $contact;
					break;
				case "asl_articletype":
						$article_type_id = dynamic365_get_article_type_id($val);
						$label = $val;
						$val =  new AlexaCRM\CRMToolkit\OptionSetValue($article_type_id, $label);
						$activity->__set( $key, $val );
					break;
				case "asl_site":
						$site = dynamic365_get_website_id($val);
						$label = $val;
						$val =  new AlexaCRM\CRMToolkit\OptionSetValue($site, $label);
						$activity->__set( $key, $val );
					break;
				case "asl_contenttype":
						$contenttype = dynamic365_get_content_type_id($val);
						try{
							$asl_contenttype=$service->entity( 'asl_contenttype', $contenttype);
						} catch ( Exception $e ) {
						}
						if ( $asl_contenttype->exists ) {			
							$activity->__set( $key, $asl_contenttype );
						}
					break;
				case "asl_contentcategory":
						$contentcategory = dynamic365_get_contentcategory_id($val);
						try{
							$asl_contentcategory=$service->entity( 'asl_contentcategory', $contentcategory);
						} catch ( Exception $e ) {
						}
						if ( $asl_contentcategory->exists ) {			
							$activity->__set( $key, $asl_contentcategory );
						}
					break;
				default:
						$activity->$key = $val;
					break;	
			}		
		}
	}
	
	/**
	 * create activity
	 */ 
	 
	try{
		$activityId = $activity->create();
	}catch( Exception $e ){
		echo "<pre>"; print_r( $e ); echo "</pre>"; 
	}
	// echo "<pre>"; print_r( $activityId ); echo "</pre>";
	
	return $activityId;
}

/**
 * Update web activity
 */ 
function dynamic365_update_web_activity( $activityId, $args ){
	
	if( ! is_array($args) )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	/**
	 * create a new contact
	 */ 
	$activity = $service->entity( 'asl_webactivity', $activityId );
		
	/**
	 * set activity fields
	 */ 
	foreach( $args as $key=>$val ){
		if( isset($activity->$key)){
			
			switch( $key ){
				case "asl_contact":
						$contact = $service->entity( 'contact', $val );		
						
						if( $contact->exists )
							$activity->asl_contact = $contact;
					break;
				case "asl_articletype":
						$article_type_id = dynamic365_get_article_type_id($val);
						$label = $val;
						$val =  new AlexaCRM\CRMToolkit\OptionSetValue($article_type_id, $label);
						$activity->__set( $key, $val );
					break;
				default:
						$activity->$key = $val;
					break;
				case "asl_site":
						$site = dynamic365_get_website_id($val);
						$label = $val;
						$val =  new AlexaCRM\CRMToolkit\OptionSetValue($site, $label);
						$activity->__set( $key, $val );
					break;
				case "asl_contenttype":
						$contenttype = dynamic365_get_content_type_id($val);
						try{
							$asl_contenttype=$service->entity( 'asl_contenttype', $contenttype);
						} catch ( Exception $e ) {
						}
						if ( $asl_contenttype->exists ) {			
							$activity->__set( $key, $asl_contenttype );
						}
					break;
				case "asl_contentcategory":
						$contentcategory = dynamic365_get_contentcategory_id($val);
						try{
							$asl_contentcategory=$service->entity( 'asl_contentcategory', $contentcategory);
						} catch ( Exception $e ) {
						}
						if ( $asl_contentcategory->exists ) {			
							$activity->__set( $key, $asl_contentcategory );
						}
					break;
				default:
						$activity->$key = $val;
					break;
					
			}		
		}
	}
	
	/**
	 * update activity
	 */ 
	 
	try{
		$activity->update();
	}catch( Exception $e ){
		echo "<pre>"; print_r( $e ); echo "</pre>";
		return false;
	}
	// echo "<pre>"; print_r( $activityId ); echo "</pre>";
	
	return true;
}

function dynamic365_magazine_request( $args ){
			
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	$productconnection = $service->entity( 'asl_productconnection');
	
	/**
	 * set productconnection fields
	 */ 
	foreach( $args as $key=>$val ){
		if( isset($productconnection->$key)){
			
			switch( $key ){
				case "statuscode":
						$productconnection->$key = $val?$val:1;	
					break;
				// case "asl_startdate":
						// $productconnection->$key = strtotime(date("Y-m-d H:i:s"));
					break;
				case "asl_source1":
						switch( $val ){
							case '860000000':
									$source_label = 'NEWSLETTER';
								break;
							case '860000001':
									$source_label = 'ABC DATAMA';
								break;
							case '860000002':
									$source_label = 'ABC EMAIL';
								break;
							case '860000003':
									$source_label = 'MAGAZINE';
								break;
							case '860000004':
									$source_label = 'NEWS';
								break;
							case '860000005':
									$source_label = 'BCC 16';
								break;
							case '860000006':
									$source_label = 'WEB';
								break;
							case '860000007':
									$source_label = 'ABC - BCC';
								break;
							case '860000008':
									$source_label = 'EVENTS';
								break;
							case '860000009':
									$source_label = 'EMAIL CAMP';
								break;
							case '860000010':
									$source_label = 'AUTO MAG';								
								break;
							default:
									$source_label =  "";
								break;
						}
						
						$productconnection->$key = new AlexaCRM\CRMToolkit\OptionSetValue($val, $source_label);
					break;
				case "asl_purchasesource1":
				
						switch( $val ){
							case '860000000':
									$purchase_label = 'Email Campaign';
								break;
							case '860000001':
									$purchase_label = 'BCC';
								break;
							case '860000002':
									$purchase_label = 'Email';
								break;
							case '860000003':
									$purchase_label = 'Website';
								break;
							case '860000004':
									$purchase_label = 'Telephone';
								break;
							case '860000005':
									$purchase_label = 'In person';
								break;
							default:
									$purchase_label =  "";
								break;
						}
						
						$productconnection->$key = new AlexaCRM\CRMToolkit\OptionSetValue($val, $purchase_label);
					break;
				case "asl_magtype1":						
						switch( $val ){
							case 'printed and digital':
									$magtype_code = '860000000';
									$magtype_label = 'Print and Digital';
								break;
							case 'digital':
									$magtype_code = '860000001';
									$magtype_label = 'Digital';
								break;
						}
						$productconnection->$key = new AlexaCRM\CRMToolkit\OptionSetValue($magtype_code, $magtype_label);
					break;
				case "asl_abcanswer1":
				
						switch( $val ){
							case '860000000':
									$abcanswer_label = 'Yes';
								break;
							case '860000001':
									$abcanswer_label = 'No';
								break;
						}						
						$productconnection->$key = new AlexaCRM\CRMToolkit\OptionSetValue($val, $abcanswer_label);	
						
					break;
				case "asl_contact":
						$contact = $service->entity( 'contact', $val );
						if( $contact->exists )
							$productconnection->$key = $contact;
						
						// echo "<pre>"; print_r( $asl_country ); echo "</pre>";
					break;
				case "asl_product":
						$product = $service->entity( 'asl_product', $val );
						if( $product->exists )
							$productconnection->$key = $product;
						
						// echo "<pre>"; print_r( $asl_country ); echo "</pre>";
					break;
				default:
						$productconnection->$key = $val;
					break;			
			}		
		}
		/**
		 * ex:		
		 * $contact->firstname = 'John';
		 * $contact->lastname = 'Doe';
		 * $contact->emailaddress1 = 'john.doe@example.com';
		 */
	}	
	
	// echo "<pre>"; print_r($args); echo "</pre>";
	// echo "<pre>"; print_r($productconnection); echo "</pre>";
	
	// $productconnection->create();
	try{		
		$id=$productconnection->create();
	}catch( Exception $e ){
		echo "<pre>"; print_r( $e ); echo "</pre>"; 
	}
	
	return $id;
	
}

/**
 * Get all contacts
 */ 
function dynamic365_get_contacts($pageNumber=1,$limitCount=10){
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}

	$isRetrievedByEmail = false;
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	$metadata = AlexaCRM\CRMToolkit\Entity\MetadataCollection::instance($service);
	$contacts = $service->retrieveMultipleEntities("contact", $allPages = false, $pagingCookie = null, $limitCount, $pageNumber, $simpleMode = false);
	
	// echo "<pre>"; print_r( $contacts ); echo "</pre>";
	
	if( $contacts ){
		return $contacts->Entities;
	}
	return false;
}

/**
 * Get account by contactId
 */ 
function dynamic365_get_contact($contactKeyValue){
	
	if( ! $contactKeyValue )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	$metadata = AlexaCRM\CRMToolkit\Entity\MetadataCollection::instance( $service );
	
	/**
	 * defined contact key
	 */
	$isRetrievedByEmail=false;
    if ( filter_var( $contactKeyValue, FILTER_VALIDATE_EMAIL ) ) {
        $isRetrievedByEmail = true;
    } elseif ( $service->isGuid( $contactKeyValue ) ) {
        $isRetrievedByEmail = false;
    } 
	
	$contactKey = null;
	if ( $isRetrievedByEmail ) {
		$contactKey = new \AlexaCRM\CRMToolkit\KeyAttributes();
		$contactKey->add( 'emailaddress1', $contactKeyValue );
	} else {
		$contactKey = $contactKeyValue;
	}
		
	/**
	 * get contact from id
	 */ 	
	$contact = $service->entity( 'contact', $contactKey );
	
	// $contact->firstname = str_replace( '', '', $contact->firstname );
	// $contact->__set( 'parentcustomerid', $contact->parentcustomerid );
	// $contact->__setxx( 'parentcustomerid', true );
	
	// $contact->update();
	
	return $contact;
}

function dynamic365_get_pconn($guid){
	
	if( ! $guid )
		return false;
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}
	
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	
	$metadata = AlexaCRM\CRMToolkit\Entity\MetadataCollection::instance( $service );

	/**
	 * get contact from id
	 */ 	
	$productconnection = $service->entity( 'asl_productconnection', $guid );

	
	return $productconnection;
}

/* Get all product connections */
function dynamic365_get_productconnections($pageNumber=1,$limitCount=10000){
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}

	$isRetrievedByEmail = false;
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	$metadata = AlexaCRM\CRMToolkit\Entity\MetadataCollection::instance($service);
	$productconnections = $service->retrieveMultipleEntities("asl_productconnection", $allPages = false, $pagingCookie = null, $limitCount, $pageNumber, $simpleMode = false);
	
	// echo "<pre>"; print_r( $accounts ); echo "</pre>";
	
	if( $accounts ){
		return $productconnections->Entities;
	}
	return false;
}

function dynamic365_check_productconnection($guid){
	
	$productconnections = dynamic365_get_productconnections();
	$counter = 0;
	$product = 'FB218BCE-8985-E711-80FA-00155DD1690D';
	$contact = get_user_meta( $userid, '_contactId', true );
	$inteli = get_user_meta($userid, 'lw_product_ei_market_intelligence', true);

	foreach ($productconnections as $pconn) {
		if ($pconn->asl_contact == $contact && $pconn->asl_product == $product && $pconn->statuscode == 1) {
			$counter++;
		} else {
			//
		}
	}
	echo $counter;
	if ($counter > 0) {
			update_user_meta( $userid, 'lw_product_ei_market_intelligence', '1');
	} else {
		//
	}
}

/**
 * Get all accounts
 */ 
function dynamic365_get_accounts($pageNumber=1,$limitCount=10){
	
	/**
	 * check if integration dynamic plugin installed, run this func
	 */ 
	if( ! class_exists('AlexaCRM\CRMToolkit\Settings') )
		return false;
	
	$options = get_option( 'msdyncrm_options' );
	
	/**
	 * check if options not defined
	 */ 
	 if ( !isset( $options["serverUrl"] ) ||
		 !isset( $options["username"] ) ||
		 !isset( $options["password"] ) ||
		 !$options["serverUrl"] ||
		 !$options["username"] ||
		 !$options["password"]
	) {
		return false;
	}

	$isRetrievedByEmail = false;
	$serviceSettings = new AlexaCRM\CRMToolkit\Settings( $options );
	$service = new AlexaCRM\CRMToolkit\Client( $serviceSettings );
	$metadata = AlexaCRM\CRMToolkit\Entity\MetadataCollection::instance($service);
	$accounts = $service->retrieveMultipleEntities("account", $allPages = false, $pagingCookie = null, $limitCount, $pageNumber, $simpleMode = false);
	
	// echo "<pre>"; print_r( $accounts ); echo "</pre>";
	
	if( $accounts ){
		return $accounts->Entities;
	}
	return false;
}


/**
 * Get account by name
 */ 
function dynamic365_get_account($accountName){
	
	$accounts = dynamic365_get_accounts( 1, 100);
	
	if( sizeof($accounts) ){
		foreach( $accounts as $account ){

		}
	}
	
	return false;
}

/**
 * Sync all contacts
 */ 
function sync_dynamic_crm_contacts(){
	global $wpdb;
	
	$contacts = dynamic365_get_contacts();
	
	if( $contacts ){
		foreach( $contacts as $contact ){
			$contactId = $contact->entityID;
			$user_id = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='_contactId'" );
			$wp_user = get_user_by( 'ID', $user_id );
			
			if( is_wp_error( $wp_user ) )
				continue;
			// echo "<pre>"; print_r( $wp_user ); echo "</pre>";
			// echo "<pre>"; print_r( $contact ); echo "</pre>";
			
			$title = ''; //none
			$first_name = $contact->firstname;
			$last_name = $contact->lastname;
			$job_title = $contact->jobtitle;
			$country = $contact->address1_country;
			$direct_line = $contact->telephone1;

			$fullname = $first_name.' '.$last_name;
			$email = $contact->emailaddress1;
			
			$description  = $contact->description;
			
			$userdata = array(
				'ID' => $user_id,
				'first_name'  =>  $first_name,
				'last_name'  =>  $last_name,
				'user_email'  =>  $email,
				'display_name'  =>  trim($fullname)
			);

			$user_id = wp_update_user( $userdata ) ;
			
			/**
			 * Save wp user meta
			 */
			update_user_meta( $user_id, '_job_title', $job_title);
			update_user_meta( $user_id, '_country', $country);
			update_user_meta( $user_id, '_direct_line', $direct_line);	
			update_user_meta( $user_id, '_description', $description);
		}
	}
}

function dynamic365_sync_crm_contact($user_id){
	
	$contactId = get_user_meta($user_id, '_contactId', true );

	$contact = dynamic365_get_contact($contactId);
	
	$wp_user = get_user_by( 'ID', $user_id );
	
	if( is_wp_error( $wp_user ) )
		continue;
	// echo "<pre>"; print_r( $wp_user ); echo "</pre>";
	// echo "<pre>"; print_r( $contact ); echo "</pre>";
	
	$title = ''; //none
	$first_name = $contact->firstname;
	$last_name = $contact->lastname;
	$direct_line = $contact->telephone1;
	$fullname = $first_name.' '.$last_name;
	
	$userdata = array(
		'ID' => $user_id,
		'first_name'  =>  $first_name,
		'last_name'  =>  $last_name,
		'display_name'  =>  trim($fullname)
	);

	$userid = wp_update_user( $userdata ) ;
	
	/**
	 * Save wp user meta
	 */
	update_user_meta( $userid, '_direct_line', $direct_line);	
}

function dynamic365_get_joblevel_id($string){	
	
	$joblevel = array(
		'A' => '860000000',
		'AA' => '860000001',
		'AAA' => '860000002',
		'Associate' => '860000003',
		'Banker/RM' => '860000004',
		'CEO/President/Chairman' => '860000005',
		'Consultant' => '860000006',
		'Exec Management (EVP/SVP/MD)' => '860000007',
		'Fund selector' => '860000008',
		'Head' => '860000009',
		'Manager' => '860000010',
		'Other C-Level' => '860000011',
		'Owner/Partner/Proprietor' => '860000012',
		'Portfolio manager' => '860000013',
		'Project Manager' => '860000014',
		'Secretary/Treasurer' => '860000015',
		'Senior Manager/Dept. Head' => '860000016',
		'Technical Business Specialist' => '860000017',
		'VP/Director' => '860000018'
	);
	
	return isset( $joblevel[$string] ) ? $joblevel[$string] : '';
}

function dynamic365_get_website_id($string){	
	
	$website = array(
		'2' => '860000003',
		'3' => '860000002',
		'4' => '860000001',
		'5' => '860000000'
	);
	
	return isset( $website[$string] ) ? $website[$string] : '';
}

function dynamic365_get_title_id($string){	
	
	$title = array(
		'Mr' => '860000000',
		'Miss' => '860000001',
		'Mrs' => '860000002',
		'Ms' => '860000003',
		'Dr' => '860000004',
		'Prof' => '860000005'
	);
	
	return isset( $title[$string] ) ? $title[$string] : '';
}

function dynamic365_get_terms_id($string){	
	
	$terms = array(
		true => 1,
		false => 0
	);
	
	return isset( $terms[$string] ) ? $terms[$string] : '';
}

function dynamic365_get_country_id($string){
	
	$country = array(
		'Afghanistan' => '14ABC09D-6491-E711-80FB-00155DD1690D',
		'Albania' => '16ABC09D-6491-E711-80FB-00155DD1690D',
		'Algeria' => '18ABC09D-6491-E711-80FB-00155DD1690D',
		'Andorra' => '1AABC09D-6491-E711-80FB-00155DD1690D',
		'Angola' => '1CABC09D-6491-E711-80FB-00155DD1690D',
		'Argentina' => '1EABC09D-6491-E711-80FB-00155DD1690D',
		'Australia' => '20ABC09D-6491-E711-80FB-00155DD1690D',
		'Austria' => '22ABC09D-6491-E711-80FB-00155DD1690D',
		'Azerbaijan' => '24ABC09D-6491-E711-80FB-00155DD1690D',
		'Bahamas' => '26ABC09D-6491-E711-80FB-00155DD1690D',
		'Bahrain' => '28ABC09D-6491-E711-80FB-00155DD1690D',
		'Bangladesh' => '2AABC09D-6491-E711-80FB-00155DD1690D',
		'Barbados' => '2CABC09D-6491-E711-80FB-00155DD1690D',
		'Belarus' => '2EABC09D-6491-E711-80FB-00155DD1690D',
		'Belgium' => '30ABC09D-6491-E711-80FB-00155DD1690D',
		'Belize' => '32ABC09D-6491-E711-80FB-00155DD1690D',
		'Bermuda' => '34ABC09D-6491-E711-80FB-00155DD1690D',
		'Bolivia' => '36ABC09D-6491-E711-80FB-00155DD1690D',
		'Bosnia and Herzegovina' => '38ABC09D-6491-E711-80FB-00155DD1690D',
		'Botswana' => '3AABC09D-6491-E711-80FB-00155DD1690D',
		'Brazil' => '3CABC09D-6491-E711-80FB-00155DD1690D',
		'British Virgin Islands' => '3EABC09D-6491-E711-80FB-00155DD1690D',
		'Brunei' => '40ABC09D-6491-E711-80FB-00155DD1690D',
		'Bulgaria' => '42ABC09D-6491-E711-80FB-00155DD1690D',
		'Cambodia' => '44ABC09D-6491-E711-80FB-00155DD1690D',
		'Cameroon' => '46ABC09D-6491-E711-80FB-00155DD1690D',
		'Canada' => '48ABC09D-6491-E711-80FB-00155DD1690D',
		'Cayman Islands' => '4AABC09D-6491-E711-80FB-00155DD1690D',
		'Channel Islands' => '4CABC09D-6491-E711-80FB-00155DD1690D',
		'Chile' => '4EABC09D-6491-E711-80FB-00155DD1690D',
		'China' => '50ABC09D-6491-E711-80FB-00155DD1690D',
		'Colombia' => '52ABC09D-6491-E711-80FB-00155DD1690D',
		'Costa Rica' => '54ABC09D-6491-E711-80FB-00155DD1690D',
		'Croatia' => '56ABC09D-6491-E711-80FB-00155DD1690D',
		'Cuba' => '58ABC09D-6491-E711-80FB-00155DD1690D',
		'Cyprus' => '5AABC09D-6491-E711-80FB-00155DD1690D',
		'Czech Republic' => '5CABC09D-6491-E711-80FB-00155DD1690D',
		'Denmark' => '5EABC09D-6491-E711-80FB-00155DD1690D',
		'Dominican Republic' => '60ABC09D-6491-E711-80FB-00155DD1690D',
		'Ecuador' => '62ABC09D-6491-E711-80FB-00155DD1690D',
		'Egypt' => '64ABC09D-6491-E711-80FB-00155DD1690D',
		'El Salvador' => '66ABC09D-6491-E711-80FB-00155DD1690D',
		'Estonia' => '68ABC09D-6491-E711-80FB-00155DD1690D',
		'Finland' => '6AABC09D-6491-E711-80FB-00155DD1690D',
		'France' => '6CABC09D-6491-E711-80FB-00155DD1690D',
		'Gambia' => '6EABC09D-6491-E711-80FB-00155DD1690D',
		'Georgia' => '70ABC09D-6491-E711-80FB-00155DD1690D',
		'Germany' => '72ABC09D-6491-E711-80FB-00155DD1690D',
		'Ghana' => '74ABC09D-6491-E711-80FB-00155DD1690D',
		'Gibraltar' => '76ABC09D-6491-E711-80FB-00155DD1690D',
		'Greece' => '78ABC09D-6491-E711-80FB-00155DD1690D',
		'Greenland' => '7AABC09D-6491-E711-80FB-00155DD1690D',
		'Guatemala' => '7CABC09D-6491-E711-80FB-00155DD1690D',
		'Guyana' => '7EABC09D-6491-E711-80FB-00155DD1690D',
		'Hong Kong' => '80ABC09D-6491-E711-80FB-00155DD1690D',
		'Hungary' => '82ABC09D-6491-E711-80FB-00155DD1690D',
		'Iceland' => '84ABC09D-6491-E711-80FB-00155DD1690D',
		'India' => '86ABC09D-6491-E711-80FB-00155DD1690D',
		'Indonesia' => '88ABC09D-6491-E711-80FB-00155DD1690D',
		'Iran' => '8AABC09D-6491-E711-80FB-00155DD1690D',
		'Israel' => '8CABC09D-6491-E711-80FB-00155DD1690D',
		'Italy' => '8EABC09D-6491-E711-80FB-00155DD1690D',
		'Jamaica' => '90ABC09D-6491-E711-80FB-00155DD1690D',
		'Japan' => '92ABC09D-6491-E711-80FB-00155DD1690D',
		'Jordan' => '94ABC09D-6491-E711-80FB-00155DD1690D',
		'Kazakhstan' => '96ABC09D-6491-E711-80FB-00155DD1690D',
		'Kenya' => '98ABC09D-6491-E711-80FB-00155DD1690D',
		'Kuwait' => '9AABC09D-6491-E711-80FB-00155DD1690D',
		"Lao People's Democratic Republic" => '9CABC09D-6491-E711-80FB-00155DD1690D',
		'Latvia' => '9EABC09D-6491-E711-80FB-00155DD1690D',
		'Lebanon' => 'A0ABC09D-6491-E711-80FB-00155DD1690D',
		'Libya' => 'A2ABC09D-6491-E711-80FB-00155DD1690D',
		'Liechtenstein' => 'A4ABC09D-6491-E711-80FB-00155DD1690D',
		'Lithuania' => 'A6ABC09D-6491-E711-80FB-00155DD1690D',
		'Luxembourg' => 'A8ABC09D-6491-E711-80FB-00155DD1690D',
		'Madagascar' => 'AAABC09D-6491-E711-80FB-00155DD1690D',
		'Malawi' => 'ACABC09D-6491-E711-80FB-00155DD1690D',
		'Malaysia' => 'AEABC09D-6491-E711-80FB-00155DD1690D',
		'Malta' => 'B0ABC09D-6491-E711-80FB-00155DD1690D',
		'Mauritius' => 'B2ABC09D-6491-E711-80FB-00155DD1690D',
		'Mexico' => 'B4ABC09D-6491-E711-80FB-00155DD1690D',
		'Monaco' => 'B6ABC09D-6491-E711-80FB-00155DD1690D',
		'Mongolia' => 'B8ABC09D-6491-E711-80FB-00155DD1690D',
		'Morocco' => 'BAABC09D-6491-E711-80FB-00155DD1690D',
		'Mozambique' => 'BCABC09D-6491-E711-80FB-00155DD1690D',
		'Myanmar' => 'BEABC09D-6491-E711-80FB-00155DD1690D',
		'Namibia' => 'C0ABC09D-6491-E711-80FB-00155DD1690D',
		'Nepal' => 'C2ABC09D-6491-E711-80FB-00155DD1690D',
		'New Zealand' => 'C4ABC09D-6491-E711-80FB-00155DD1690D',
		'Nigeria' => 'C6ABC09D-6491-E711-80FB-00155DD1690D',
		'Northern Ireland' => 'C8ABC09D-6491-E711-80FB-00155DD1690D',
		'Norway' => 'CAABC09D-6491-E711-80FB-00155DD1690D',
		'Oman' => 'CCABC09D-6491-E711-80FB-00155DD1690D',
		'Pakistan' => 'CEABC09D-6491-E711-80FB-00155DD1690D',
		'Panama' => 'D0ABC09D-6491-E711-80FB-00155DD1690D',
		'Paraguay' => 'D2ABC09D-6491-E711-80FB-00155DD1690D',
		'Peru' => 'D4ABC09D-6491-E711-80FB-00155DD1690D',
		'Philippines' => 'D6ABC09D-6491-E711-80FB-00155DD1690D',
		'Poland' => 'D8ABC09D-6491-E711-80FB-00155DD1690D',
		'Portugal' => 'DAABC09D-6491-E711-80FB-00155DD1690D',
		'Qatar' => 'DCABC09D-6491-E711-80FB-00155DD1690D',
		'Republic of Ireland' => 'DEABC09D-6491-E711-80FB-00155DD1690D',
		'Republic of Korea' => 'E0ABC09D-6491-E711-80FB-00155DD1690D',
		'Romania' => 'E2ABC09D-6491-E711-80FB-00155DD1690D',
		'Russian Federation' => 'E4ABC09D-6491-E711-80FB-00155DD1690D',
		'Saint Kitts and Nevis' => 'E6ABC09D-6491-E711-80FB-00155DD1690D',
		'Samoa' => 'E8ABC09D-6491-E711-80FB-00155DD1690D',
		'San Marino' => 'EAABC09D-6491-E711-80FB-00155DD1690D',
		'Saudi Arabia' => 'ECABC09D-6491-E711-80FB-00155DD1690D',
		'Serbia' => 'EEABC09D-6491-E711-80FB-00155DD1690D',
		'Seychells' => 'F0ABC09D-6491-E711-80FB-00155DD1690D',
		'Singapore' => 'F2ABC09D-6491-E711-80FB-00155DD1690D',
		'Slovakia' => 'F4ABC09D-6491-E711-80FB-00155DD1690D',
		'Slovenia' => 'F6ABC09D-6491-E711-80FB-00155DD1690D',
		'South Africa' => 'F8ABC09D-6491-E711-80FB-00155DD1690D',
		'South Korea' => 'FAABC09D-6491-E711-80FB-00155DD1690D',
		'Spain' => 'FCABC09D-6491-E711-80FB-00155DD1690D',
		'Sri Lanka' => 'FEABC09D-6491-E711-80FB-00155DD1690D',
		'St. Vincent & The Grenadines' => '00ACC09D-6491-E711-80FB-00155DD1690D',
		'Sudan' => '02ACC09D-6491-E711-80FB-00155DD1690D',
		'Swaziland' => '04ACC09D-6491-E711-80FB-00155DD1690D',
		'Sweden' => '06ACC09D-6491-E711-80FB-00155DD1690D',
		'Switzerland' => '08ACC09D-6491-E711-80FB-00155DD1690D',
		'Taiwan' => '0AACC09D-6491-E711-80FB-00155DD1690D',
		'Thailand' => '0CACC09D-6491-E711-80FB-00155DD1690D',
		'The Netherlands' => '0EACC09D-6491-E711-80FB-00155DD1690D',
		'Trinidad and Tobago' => '10ACC09D-6491-E711-80FB-00155DD1690D',
		'Tunisia' => '12ACC09D-6491-E711-80FB-00155DD1690D',
		'Turkey' => '14ACC09D-6491-E711-80FB-00155DD1690D',
		'Turks and Caicos Islands' => '16ACC09D-6491-E711-80FB-00155DD1690D',
		'Tuvalu' => '18ACC09D-6491-E711-80FB-00155DD1690D',
		'Uganda' => '1AACC09D-6491-E711-80FB-00155DD1690D',
		'Ukraine' => '1CACC09D-6491-E711-80FB-00155DD1690D',
		'United Arab Emirates' => '1EACC09D-6491-E711-80FB-00155DD1690D',
		'UK' => '20ACC09D-6491-E711-80FB-00155DD1690D',
		'United States' => '22ACC09D-6491-E711-80FB-00155DD1690D',
		'Uruguay' => '24ACC09D-6491-E711-80FB-00155DD1690D',
		'Uzbekistan' => '26ACC09D-6491-E711-80FB-00155DD1690D',
		'Vanuatu' => '28ACC09D-6491-E711-80FB-00155DD1690D',
		'Venezuela' => '2AACC09D-6491-E711-80FB-00155DD1690D',
		'Vietnam' => '2CACC09D-6491-E711-80FB-00155DD1690D',
		'Virgin Islands' => '2EACC09D-6491-E711-80FB-00155DD1690D',
		'Yemen' => '30ACC09D-6491-E711-80FB-00155DD1690D',
		'Zambia' => '32ACC09D-6491-E711-80FB-00155DD1690D',
		'Zimbabwe' => '34ACC09D-6491-E711-80FB-00155DD1690D',
		'Guernsey' => '0EB29661-7C91-E711-80FB-00155DD1690D',
		'Isle of Man' => '8869B56C-7C91-E711-80FB-00155DD1690D',
		'Jersey' => 'D8509A7D-7C91-E711-80FB-00155DD1690D'
	);
	
	return isset( $country[$string] ) ? strtolower($country[$string]) : '';
}

function dynamic365_get_article_type_id($string){
	$type = array(
		'News' => '860000000', 
		'Profile' => '860000001',
		'Gallery'=>'860000002',
		'Analysis'=>'860000003',
		'Video'=>'860000004',
		'Sponsored'=>'860000005', 
		'Features'=>'860000006',
		'Listings'=>'860000007'
	);
	return isset($type[$string])?$type[$string]:'';
}

function dynamic365_get_content_type_id($string){	
	$conttype = array(
		'Analysis' => '35B8A6F5-049A-E711-80FB-00155DD1690D',
		'Features' => '39B8A6F5-049A-E711-80FB-00155DD1690D',
		'Gallery' => '3BB8A6F5-049A-E711-80FB-00155DD1690D',
		'Interviews' => '3DB8A6F5-049A-E711-80FB-00155DD1690D',
		'Listings' => '3FB8A6F5-049A-E711-80FB-00155DD1690D',
		'News' => '41B8A6F5-049A-E711-80FB-00155DD1690D',
		'Profile' => '43B8A6F5-049A-E711-80FB-00155DD1690D',
		'Sponsored' => '45B8A6F5-049A-E711-80FB-00155DD1690D',
		'Surveys' => '47B8A6F5-049A-E711-80FB-00155DD1690D',
		'Video' => '49B8A6F5-049A-E711-80FB-00155DD1690D',
		'Viewpoint' => '4BB8A6F5-049A-E711-80FB-00155DD1690D'
	);
	return isset( $conttype[$string] ) ? strtolower($conttype[$string]) :'';
}

function dynamic365_get_contentcategory_id($string){	

	$category = array(
		'Absolute Return' => '9852F786-059A-E711-80FB-00155DD1690D',
		'Advertorials' => '9A52F786-059A-E711-80FB-00155DD1690D',
		'Africa' =>	'9C52F786-059A-E711-80FB-00155DD1690D',
		'Alliance Trust' =>	'9E52F786-059A-E711-80FB-00155DD1690D',
		'Allianz Global Investors' => 'A052F786-059A-E711-80FB-00155DD1690D',
		'Alpha Club' =>	'A252F786-059A-E711-80FB-00155DD1690D',
		'Alternatives' => 'A452F786-059A-E711-80FB-00155DD1690D',
		'Article List' => 'A652F786-059A-E711-80FB-00155DD1690D',
		'Asia' => 'A852F786-059A-E711-80FB-00155DD1690D',
		'Asian Equities' =>	'AA52F786-059A-E711-80FB-00155DD1690D',
		'Asset Class in Focus' => 'AC52F786-059A-E711-80FB-00155DD1690D',
		'Axa' => 'AE52F786-059A-E711-80FB-00155DD1690D',
		'Belgium' => 'B052F786-059A-E711-80FB-00155DD1690D',
		'Best Practice' => 'B252F786-059A-E711-80FB-00155DD1690D',
		'Bonds'	=> 'B452F786-059A-E711-80FB-00155DD1690D',
		'Charts' =>	'B652F786-059A-E711-80FB-00155DD1690D',
		'Commodities' => 'B852F786-059A-E711-80FB-00155DD1690D',
		'Companies'	=> 'BA52F786-059A-E711-80FB-00155DD1690D',
		'Corporate Bonds' => 'BC52F786-059A-E711-80FB-00155DD1690D',
		'Countries'	=> 'BE52F786-059A-E711-80FB-00155DD1690D',
		'Data' => 'C052F786-059A-E711-80FB-00155DD1690D',
		'Data & Research' => 'C252F786-059A-E711-80FB-00155DD1690D',
		'Denmark' => 'C452F786-059A-E711-80FB-00155DD1690D',
		'Developed Market Corporate Bonds' => 'C652F786-059A-E711-80FB-00155DD1690D',
		'Developed Market Government Bonds'	=> 'C852F786-059A-E711-80FB-00155DD1690D',
		'Developed Market High Yield Bonds'	=> 'CA52F786-059A-E711-80FB-00155DD1690D',
		'Developed Markets'	=> 'CC52F786-059A-E711-80FB-00155DD1690D',
		'Digital Magazine' => 'CE52F786-059A-E711-80FB-00155DD1690D',
		'Directory' => 'D052F786-059A-E711-80FB-00155DD1690D',
		'Economics'	=> 'D252F786-059A-E711-80FB-00155DD1690D',
		'Editors Pick' => 'D452F786-059A-E711-80FB-00155DD1690D',
		'EIE Analysis' => 'D652F786-059A-E711-80FB-00155DD1690D',
		'EIE Morningstar Historic Fund Flows Database' => 'D852F786-059A-E711-80FB-00155DD1690D',
		'Emerging Market Corporate Bonds' => 'DA52F786-059A-E711-80FB-00155DD1690D',
		'Emerging Market Equities' => 'DC52F786-059A-E711-80FB-00155DD1690D',
		'Emerging Market Government Bonds' => 'DE52F786-059A-E711-80FB-00155DD1690D',
		'Emerging Markets' => 'E052F786-059A-E711-80FB-00155DD1690D',
		'Equities' => 'E252F786-059A-E711-80FB-00155DD1690D',
		'Europe' => 'E452F786-059A-E711-80FB-00155DD1690D',
		'European Equities'	=> 'E652F786-059A-E711-80FB-00155DD1690D',
		'European Fund Flows' => 'E852F786-059A-E711-80FB-00155DD1690D',
		'Events' =>	'EA52F786-059A-E711-80FB-00155DD1690D',
		'Featured Video' => 'EC52F786-059A-E711-80FB-00155DD1690D',
		'Finland' => 'EE52F786-059A-E711-80FB-00155DD1690D',
		'Fixed Income' => 'F052F786-059A-E711-80FB-00155DD1690D',
		'Forum Reviews'	=> 'F252F786-059A-E711-80FB-00155DD1690D',
		'France' => 'F452F786-059A-E711-80FB-00155DD1690D',
		'Frontier Market Equities' => 'F652F786-059A-E711-80FB-00155DD1690D',
		'FSA Analysis' => 'F852F786-059A-E711-80FB-00155DD1690D',
		'FSA Awards' => 'FA52F786-059A-E711-80FB-00155DD1690D',
		'Fund Centre' => 'FC52F786-059A-E711-80FB-00155DD1690D',
		'Fund Manager Sentiment' => 'FE52F786-059A-E711-80FB-00155DD1690D',
		'Fund Manager Videos' => '0053F786-059A-E711-80FB-00155DD1690D',
		'Fund Research Centre' => '0253F786-059A-E711-80FB-00155DD1690D',
		'Fund Selector Videos' => '0453F786-059A-E711-80FB-00155DD1690D',
		'Gallery' => '0653F786-059A-E711-80FB-00155DD1690D',
		'Germany' => '0853F786-059A-E711-80FB-00155DD1690D',
		'Global Equities Hub' => '0A53F786-059A-E711-80FB-00155DD1690D',
		'Government Bonds' => '0C53F786-059A-E711-80FB-00155DD1690D',
		'Head To Head' => '0E53F786-059A-E711-80FB-00155DD1690D',
		'Headline Article' => '1053F786-059A-E711-80FB-00155DD1690D',
		'Iceland' => '1253F786-059A-E711-80FB-00155DD1690D',
		'Index Tracking' => '1453F786-059A-E711-80FB-00155DD1690D',
		'Industry' => '1653F786-059A-E711-80FB-00155DD1690D',
		'Industry Comment' => '1853F786-059A-E711-80FB-00155DD1690D',
		'Industry Interviews' => '1A53F786-059A-E711-80FB-00155DD1690D',
		'Insights' => '1C53F786-059A-E711-80FB-00155DD1690D',
		'Investec Asset Management'	=> '1E53F786-059A-E711-80FB-00155DD1690D',
		'Investment' => '2053F786-059A-E711-80FB-00155DD1690D',
		'Investment Strategy' => '2253F786-059A-E711-80FB-00155DD1690D',
		'Investment Trusts'	=> '2453F786-059A-E711-80FB-00155DD1690D',
		'Italy'	=> '2653F786-059A-E711-80FB-00155DD1690D',
		'Japanese Equities'	=> '2853F786-059A-E711-80FB-00155DD1690D',
		'Kames Income hub' => '2A53F786-059A-E711-80FB-00155DD1690D',
		'Latest News' => '2C53F786-059A-E711-80FB-00155DD1690D',
		'Latin America'	=> '2E53F786-059A-E711-80FB-00155DD1690D',
		'Life' => '3053F786-059A-E711-80FB-00155DD1690D',
		'Live' => '3253F786-059A-E711-80FB-00155DD1690D',
		'Luxembourg' => '3453F786-059A-E711-80FB-00155DD1690D',
		'Macro News' => '3653F786-059A-E711-80FB-00155DD1690D',
		'Macro Views' => '3853F786-059A-E711-80FB-00155DD1690D',
		'Macroeconomic Outlook'	=> '3A53F786-059A-E711-80FB-00155DD1690D',
		'Media'	=> '3C53F786-059A-E711-80FB-00155DD1690D',
		'Middle East' => '3E53F786-059A-E711-80FB-00155DD1690D',
		'Misc' => '4053F786-059A-E711-80FB-00155DD1690D',
		'Mobile' => '4253F786-059A-E711-80FB-00155DD1690D',
		'Mostly Viewed News' => '4453F786-059A-E711-80FB-00155DD1690D',
		'Multi Manager'	=> '4653F786-059A-E711-80FB-00155DD1690D',
		'Multi Media' => '4853F786-059A-E711-80FB-00155DD1690D',
		'MultiMedia' => '4A53F786-059A-E711-80FB-00155DD1690D',
		'Neptune' => '4C53F786-059A-E711-80FB-00155DD1690D',
		'Netherlands' => '4E53F786-059A-E711-80FB-00155DD1690D',
		'News' => '5053F786-059A-E711-80FB-00155DD1690D',
		'North America'	=> '5253F786-059A-E711-80FB-00155DD1690D',
		'Norway' => '5453F786-059A-E711-80FB-00155DD1690D',
		'Offshore Bonds' => '5653F786-059A-E711-80FB-00155DD1690D',
		'Offshore Funds' => '5853F786-059A-E711-80FB-00155DD1690D',
		'PA Analysis' => '5A53F786-059A-E711-80FB-00155DD1690D',
		'People Moves' => '5C53F786-059A-E711-80FB-00155DD1690D',
		'Planning Tools' => '5E53F786-059A-E711-80FB-00155DD1690D',
		'Platforms'	=> '6053F786-059A-E711-80FB-00155DD1690D',
		'Portugal' => '6253F786-059A-E711-80FB-00155DD1690D',
		'Product News' => '6453F786-059A-E711-80FB-00155DD1690D',
		'Products' => '6653F786-059A-E711-80FB-00155DD1690D',
		'Profile & Features' => '6853F786-059A-E711-80FB-00155DD1690D',
		'Profiles & Comment' => '6A53F786-059A-E711-80FB-00155DD1690D',
		'Property' => '6C53F786-059A-E711-80FB-00155DD1690D',
		'Regions' => '6E53F786-059A-E711-80FB-00155DD1690D',
		'Regulation' => '7053F786-059A-E711-80FB-00155DD1690D',
		'Research Notes' => '7253F786-059A-E711-80FB-00155DD1690D',
		'Retirement' => '7453F786-059A-E711-80FB-00155DD1690D',
		'Schroders' => '7653F786-059A-E711-80FB-00155DD1690D',
		'Scratch' => '7853F786-059A-E711-80FB-00155DD1690D',
		'Spain' => '7A53F786-059A-E711-80FB-00155DD1690D',
		'Sponsored' => '7C53F786-059A-E711-80FB-00155DD1690D',
		'Square Mile Research' => '7E53F786-059A-E711-80FB-00155DD1690D',
		'Strategies' => '8053F786-059A-E711-80FB-00155DD1690D',
		'Structured Products' => '8253F786-059A-E711-80FB-00155DD1690D',
		'Sweden' => '8453F786-059A-E711-80FB-00155DD1690D',
		'Switzerland' => '8653F786-059A-E711-80FB-00155DD1690D',
		'Tax & Regulation' => '8853F786-059A-E711-80FB-00155DD1690D',
		'Tax & Technical' => '8A53F786-059A-E711-80FB-00155DD1690D',
		'Technology' => '8C53F786-059A-E711-80FB-00155DD1690D',
		'Uncategorised'	=> '8E53F786-059A-E711-80FB-00155DD1690D',
		'United Kingdom' => '9053F786-059A-E711-80FB-00155DD1690D',
		'US Equities' => '9253F786-059A-E711-80FB-00155DD1690D',
		'Video'	=> '9453F786-059A-E711-80FB-00155DD1690D',
		'Viewpoints' => '9653F786-059A-E711-80FB-00155DD1690D',
		'Views & Comment' => '9853F786-059A-E711-80FB-00155DD1690D',
		'Wealth Manager' => '9A53F786-059A-E711-80FB-00155DD1690D',
		'Yield Bonds' => '9C53F786-059A-E711-80FB-00155DD1690D',
	);
	return isset( $category[$string] ) ? strtolower($category[$string]) :'';
}


function dynamic365_get_jobrole_id($string){	
	$jobfunction = array(
		'Accountant' => '61DFED87-C481-E711-80FA-00155DD1690D',
		'Actuarial' => '63DFED87-C481-E711-80FA-00155DD1690D',
		'Advisor' => '65DFED87-C481-E711-80FA-00155DD1690D',
		'Advisory' => '67DFED87-C481-E711-80FA-00155DD1690D',
		'Alternatives' => '69DFED87-C481-E711-80FA-00155DD1690D',
		'Analyst' => '6BDFED87-C481-E711-80FA-00155DD1690D',
		'Asset Manager' => '6DDFED87-C481-E711-80FA-00155DD1690D',
		'Business Development' => '6FDFED87-C481-E711-80FA-00155DD1690D',
		'CEO' => '71DFED87-C481-E711-80FA-00155DD1690D',
		'CFO' => '73DFED87-C481-E711-80FA-00155DD1690D',
		'CIO' => '75DFED87-C481-E711-80FA-00155DD1690D',
		'Communications' => '77DFED87-C481-E711-80FA-00155DD1690D',
		'Consultant' => '79DFED87-C481-E711-80FA-00155DD1690D',
		'Consulting Actuary' => '7BDFED87-C481-E711-80FA-00155DD1690D',
		'C-Suite' => '7DDFED87-C481-E711-80FA-00155DD1690D',
		'Discretionary Portfolio Manager' => '7FDFED87-C481-E711-80FA-00155DD1690D',
		'Discretionary/Strategy' => '81DFED87-C481-E711-80FA-00155DD1690D',
		'Distributor' => '83DFED87-C481-E711-80FA-00155DD1690D',
		'Family Office Employee' => '85DFED87-C481-E711-80FA-00155DD1690D',
		'Financial Adviser' => '87DFED87-C481-E711-80FA-00155DD1690D',
		'Financial Advisor' => '89DFED87-C481-E711-80FA-00155DD1690D',
		'Fund Influencer' => '8BDFED87-C481-E711-80FA-00155DD1690D',
		'Fund Manager' => '8DDFED87-C481-E711-80FA-00155DD1690D',
		'Fund of Funds Manager' => '8FDFED87-C481-E711-80FA-00155DD1690D',
		'Fund Selector' => '91DFED87-C481-E711-80FA-00155DD1690D',
		'Independent Financial Adviser' => '93DFED87-C481-E711-80FA-00155DD1690D',
		'International Life Officer' => '95DFED87-C481-E711-80FA-00155DD1690D',
		'Investment' => '97DFED87-C481-E711-80FA-00155DD1690D',
		'Investment Analyst' => '99DFED87-C481-E711-80FA-00155DD1690D',
		'Investment Counsellor/Private Banker' => '9BDFED87-C481-E711-80FA-00155DD1690D',
		'Investment IFA' => '9DDFED87-C481-E711-80FA-00155DD1690D',
		'Investment Manager' => '9FDFED87-C481-E711-80FA-00155DD1690D',
		'Investment Researcher/Analyst' => 'A1DFED87-C481-E711-80FA-00155DD1690D',
		'Life Company Employee' => 'A3DFED87-C481-E711-80FA-00155DD1690D',
		'Marketing' => 'A5DFED87-C481-E711-80FA-00155DD1690D',
		'Multi-Manager' => 'A7DFED87-C481-E711-80FA-00155DD1690D',
		'Owner' => 'A9DFED87-C481-E711-80FA-00155DD1690D',
		'Partner' => 'ABDFED87-C481-E711-80FA-00155DD1690D',
		'Portfolio Manager' => 'ADDFED87-C481-E711-80FA-00155DD1690D',
		'Private Banker' => 'AFDFED87-C481-E711-80FA-00155DD1690D',
		'Private Client Lawyer' => 'B1DFED87-C481-E711-80FA-00155DD1690D',
		'Private Client Stockbroker' => 'B3DFED87-C481-E711-80FA-00155DD1690D',
		'Research' => 'B5DFED87-C481-E711-80FA-00155DD1690D',
		'Retail' => 'B7DFED87-C481-E711-80FA-00155DD1690D',
		'Risk Management' => 'B9DFED87-C481-E711-80FA-00155DD1690D',
		'Sales' => 'BBDFED87-C481-E711-80FA-00155DD1690D',
		'Treasury' => 'BDDFED87-C481-E711-80FA-00155DD1690D',
		'Trustee' => 'BFDFED87-C481-E711-80FA-00155DD1690D',
		'Wealth Manager' => 'C1DFED87-C481-E711-80FA-00155DD1690D'
	);
	return isset( $jobfunction[$string] ) ? strtolower($jobfunction[$string]) :'';
}

function dynamic365_get_companytype_id($string){	
	$companytype = array(
		'Advisory' => '9A6759D8-C381-E711-80FA-00155DD1690D',
		'Asset Management' => '9C6759D8-C381-E711-80FA-00155DD1690D',
		'Asset Manager' => '9E6759D8-C381-E711-80FA-00155DD1690D',
		'Bank' => 'A06759D8-C381-E711-80FA-00155DD1690D',
		'Consultant' => 'A26759D8-C381-E711-80FA-00155DD1690D',
		'Discretionary portfolio management' => 'A46759D8-C381-E711-80FA-00155DD1690D',
		'Family Office' => 'A66759D8-C381-E711-80FA-00155DD1690D',
		'Financial Adviser' => 'A86759D8-C381-E711-80FA-00155DD1690D',
		'Fund-of-Fund' => 'AA6759D8-C381-E711-80FA-00155DD1690D',
		'GFI' => 'AC6759D8-C381-E711-80FA-00155DD1690D',
		'Hedge & PE Fund' => 'AE6759D8-C381-E711-80FA-00155DD1690D',
		'IAM' => 'B06759D8-C381-E711-80FA-00155DD1690D',
		'IFA Network' => 'B26759D8-C381-E711-80FA-00155DD1690D',
		'Institutional' => 'B46759D8-C381-E711-80FA-00155DD1690D',
		'Institutional Investor' => 'B66759D8-C381-E711-80FA-00155DD1690D',
		'Insurance' => 'B86759D8-C381-E711-80FA-00155DD1690D',
		'Insurance & Life Company' => 'BA6759D8-C381-E711-80FA-00155DD1690D',
		'International Life Company' => 'BC6759D8-C381-E711-80FA-00155DD1690D',
		'Investment Bank' => 'BE6759D8-C381-E711-80FA-00155DD1690D',
		'Investment Fund' => 'C06759D8-C381-E711-80FA-00155DD1690D',
		'Law Firm' => 'C26759D8-C381-E711-80FA-00155DD1690D',
		'Life company' => 'C46759D8-C381-E711-80FA-00155DD1690D',
		'Life Office' => 'C66759D8-C381-E711-80FA-00155DD1690D',
		'Local Asset Management' => 'C86759D8-C381-E711-80FA-00155DD1690D',
		'Media Agency' => 'CA6759D8-C381-E711-80FA-00155DD1690D',
		'Pension Fund' => 'CC6759D8-C381-E711-80FA-00155DD1690D',
		'PR Agency' => 'CE6759D8-C381-E711-80FA-00155DD1690D',
		'Private Bank' => 'D06759D8-C381-E711-80FA-00155DD1690D',
		'Publishing' => 'D26759D8-C381-E711-80FA-00155DD1690D',
		'Retail Bank' => 'D46759D8-C381-E711-80FA-00155DD1690D',
		'Securities' => 'D66759D8-C381-E711-80FA-00155DD1690D',
		'Trust Company' => 'D86759D8-C381-E711-80FA-00155DD1690D',
		'VCB Capital' => 'DA6759D8-C381-E711-80FA-00155DD1690D',
		'Wealth Management' => 'DC6759D8-C381-E711-80FA-00155DD1690D'
	);
	return isset( $companytype[$string] ) ? strtolower($companytype[$string]) :'';
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Remove admin bar for subscribers

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
	if (current_user_can('administrator') || current_user_can('editor') || current_user_can('author') || current_user_can('last_word_administrator')) {
	  show_admin_bar(true);
	}
	else {
	  show_admin_bar(false);
	}
}


function disallow_unsubscribed_visit() {
	if (is_user_logged_in()) {
		$websiteId = get_current_blog_id();
	    $userid = get_current_user_id();
		$blogs = get_blogs_of_user($userid);
		$blogids = Array();
	
		foreach ($blogs as $blog) {
			$blogid = $blog->userblog_id;
			array_push($blogids, $blogid);	
		}

		if (!in_array($websiteId, $blogids)) {
			wp_logout();
			header('Location: '.$_SERVER['REQUEST_URI']);
		}
	}	
}

add_action('wp_head', 'disallow_unsubscribed_visit');


function disallow_unsubscribed_login_message() {
    $websiteId = get_current_blog_id();
    $userid = get_current_user_id();
	$blogs = get_blogs_of_user($userid);
	$blogids = Array();
	
	foreach ($blogs as $blog) {
		$blogid = $blog->userblog_id;
		array_push($blogids, $blogid);	
	}

	if (!in_array($websiteId, $blogids)) {
		return "<p>You don't have access to this website. Please subscribe.</p>";
	} else {
        return $message;
    }
}

add_filter( 'login_messages', 'disallow_unsubscribed_login_message' );

function get_user_by_meta_data( $meta_key, $meta_value ) {

	// Query for users based on the meta data
	$user_query = new WP_User_Query(
		array(
			'meta_key'	  =>	$meta_key,
			'meta_value'	=>	$meta_value
		)
	);

	// Get the results from the query, returning the first user
	$users = $user_query->get_results();

	return $users[0];

} // end get_user_by_meta_data
/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function lw_get_dynamic_user_data(WP_REST_Request $request) {
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
	$type = $request['type'];
	$contactId = $request['guid'];
	$user_id = $request['websiteuid'];

	$contact = dynamic365_get_contact($contactId);
	$user_email = $contact->emailaddress1;
	$first_name = $contact->firstname;
	$last_name = $contact->lastname;
	$full_name = $first_name . ' ' . $last_name;
	$direct_line = $contact->telephone1;

	if ($type == 'NewContact') {
		if ($user_id == '') {
			if (is_null($contact)) {
				$returnval = 'ERROR - Contact with guid: '.$contactId.' does not exist on CRM.';		
			} elseif (is_null($user_email)) {
				$returnval = 'ERROR - Incomplete data for contact with guid: '.$contactId.' on CRM - Missing email address.';			
			} else {
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$userdata = array(
					'user_login' => $user_email,
					'first_name'  =>  $first_name,
					'last_name'  =>  $last_name,
					'user_email' => $user_email,
					'display_name'  =>  trim($fullname),
					'user_pass' => $random_password,
					'role' => 'subscriber',
					'user_url' => 'www.lastword.com'
				);
	
				$userid = wp_insert_user( $userdata );
	
				if( !is_wp_error( $userid ) ) {

					add_user_meta($userid, '_contactId', $contactId);
		
					remove_user_from_blog($userid, 2);
		
					add_user_to_blog( 1, $userid, 'subscriber' );

					$returnval = 'OK - New user with GUID: '. $contactId .' and Website UID: '. $userid .' created!';
				} else {
					$returnval='ERROR - ';
					foreach( $userid->errors as $error ){
						foreach( $error as $text ){
							$returnval .= $text;
						}
					}
				}
			}			
		} else {
			/*$haveguid = get_user_meta($user_id, '_contactId', false);
			if ($haveguid) {
				update_user_meta($user_id, '_contactId', $contactId);
			} else {*/
				add_user_meta($user_id, '_contactId', $contactId);
			//}		
			$returnval = 'OK - user with GUID: '. $contactId .' updated!';
		}
	} else {
		$returnval = 'ERROR - Transaction type is not correct!';
	}
    return rest_ensure_response( $returnval );

	if ($type == 'NewContact') {
	    if ($user_id == '') {
	    	if( !is_wp_error( $userid ) ) {
				$args = array(
					'asl_transactiontype' => 'WebsiteUID',
					'asl_websiteuid' => $userid,
					'asl_contactId' => $contactId
				);
				$createcontact = dynamic365_create_contact($args);
			}
	    }   	
	}
}

/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function lw_get_dynamic_product_data(WP_REST_Request $request) {

    $type = $request['status'];
	$guid = $request['guid'];
	$productguid = $request['productguid'];
	$product = strtoupper($productguid);
	$contact = $request['contactguid'];

	$getcontact = dynamic365_get_contact($contact);
	$tempid = $getcontact->asl_websiteuid;
	

	$blogs = array(1,2,3,4,5);

	foreach ($blogs as $blog) {
		$user = get_users(
		  array(
		   'blog_id' => $blog,
		   'meta_key' => '_contactId',
		   'meta_value' => $contact,
		   'number' => 1,
		   'count_total' => false,
		   'fields' => 'ids'
		  )
		 );

		$tempid = $user[0];

		if ($tempid != '') {
			$userid = $tempid;
		}
	}

	$wpuser = get_userdata($userid);
	$login = $wpuser->user_login;
	$email = $wpuser->user_email;

	if ($type == 'Current Subscriber') {
		switch( $product ){
		case "FB218BCE-8985-E711-80FA-00155DD1690D": //EIMI
				update_user_meta( $userid, 'lw_product_ei_market_intelligence', 'yes');
				$returnval = 'OK - Successfully added product EI - Market Intelligence to user';
			break;
		case "25258BCE-8985-E711-80FA-00155DD1690D": //PA MAG
				update_user_meta( $userid, 'lw_product_pa_magazine_print_digital', 'yes');
				$returnval = 'OK - Successfully added product PA MAG to user';
			break;
		case "B1238BCE-8985-E711-80FA-00155DD1690D": //IA MAG
				update_user_meta( $userid, 'lw_product_ia_magazine_print_digital', 'yes');
				$returnval = 'OK - Successfully added product IA MAG to user';
			break;
		case "F9218BCE-8985-E711-80FA-00155DD1690D": //EI MAG 
				update_user_meta( $userid, 'lw_product_ei_magazine_print_digital', 'yes');
				$returnval = 'OK - Successfully added product EI MAG to user';
			break;
		/*case "2B228BCE-8985-E711-80FA-00155DD1690D": //EIE MAG FREE
				update_user_meta( $userid, 'lw_product_ei_magazine_free_print_digital', 'yes');
				$returnval = 'OK - Successfully added product EIE MAG FREE to user';
			break;
		case "B3238BCE-8985-E711-80FA-00155DD1690D": //IA MAG FREE
				update_user_meta( $userid, 'lw_product_ia_magazine_free_print_digital', 'yes');
				$returnval = 'OK - Successfully added product IA MAG FREE to user';
			break;
		case "1B258BCE-8985-E711-80FA-00155DD1690D": //IATUR
				update_user_meta( $userid, 'lw_product_ia_tur_magazine_free_print_digital', 'yes');
				$returnval = 'OK - Successfully added product IATUR to user';
			break;*/
		case "27258BCE-8985-E711-80FA-00155DD1690D": //PA MAG FREE
				update_user_meta( $userid, 'lw_product_pa_magazine_free_print_digital', 'yes');
				$returnval = 'OK - Successfully added product PA MAG FREE to user';
			break;
		case "29258BCE-8985-E711-80FA-00155DD1690D": //PA MAG IRE
				update_user_meta( $userid, 'lw_product_pa_magazine_ire_print_digital', 'yes');
				$returnval = 'OK - Successfully added product PA MAG IRE to user';
			break;
		case "FD218BCE-8985-E711-80FA-00155DD1690D": //EI NEWS
				$blogs = get_blogs_of_user($userid);
				$blogscount = count($blogs);

				if ($blogscount < 2) {
					$msgcontent = '<img src="https://expertinvestoreurope.com/wp-content/themes/lw_expert_inv/images/logo.png" width="200" height="auto" />';
					$msgcontent .= '<p>Welcome to Expert Investor Europe.</p></p>To set up your password, please follow <a href="https://expertinvestoreurope.com/welcome?user=' . $login . '">this link</a>.</p>';
					$msgcontent .= '<p>Thank you!</p>';

					$to = $email;
					$subject = "Welcome to Expert Investor Europe";
					$header = "From:noreply@expertinvestoreurope.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail($to,$subject,$msgcontent,$header);
				} else {
					//
				}

				add_user_to_blog( 5, $userid, 'subscriber' );
				update_user_meta( $userid, 'lw_product_ei_news', 'yes');
				$returnval = 'OK - Successfully added product EI NEWS to user';
			break;
		
		case "43238BCE-8985-E711-80FA-00155DD1690D": //FSA NEWS
				$blogs = get_blogs_of_user($userid);
				$blogscount = count($blogs);

				if ($blogscount < 2) {
					$msgcontent = '<img src="https://fundselectorasia.com/wp-content/themes/lw_expert_inv/images/logo.png" width="200" height="auto" />';
					$msgcontent .= '<p>Welcome to Fund Selector Asia.</p></p>To set up your password, please follow <a href="https://fundselectorasia.com/welcome?user=' . $login . '">this link</a>.</p>';
					$msgcontent .= '<p>Thank you!</p>';

					$to = $email;
					$subject = "Welcome to Fund Selector Asia";
					$header = "From:noreply@fundselectorasia.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail($to,$subject,$msgcontent,$header);
				} else {
					//
				}
				add_user_to_blog( 4, $userid, 'subscriber' );
				update_user_meta( $userid, 'lw_product_fsa_news', 'yes');
				$returnval = 'OK - Successfully added product FSA NEWS to user';
			break;
		case "B5238BCE-8985-E711-80FA-00155DD1690D": //IA NEWS
				$blogs = get_blogs_of_user($userid);
				$blogscount = count($blogs);

				if ($blogscount < 2) {
					$msgcontent = '<img src="https://international-adviser.com/wp-content/themes/lw_expert_inv/images/logo.png" width="200" height="auto" />';
					$msgcontent .= '<p>Welcome to International Adviser.</p></p>To set up your password, please follow <a href="https://international-adviser.com/welcome?user=' . $login . '">this link</a>.</p>';
					$msgcontent .= '<p>Thank you!</p>';

					$to = $email;
					$subject = "Welcome to International Adviser";
					$header = "From:noreply@international-adviser.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail($to,$subject,$msgcontent,$header);
				} else {
					//
				}

				add_user_to_blog( 3, $userid, 'subscriber' );
				update_user_meta( $userid, 'lw_product_ia_news', 'yes');
				$returnval = 'OK - Successfully added product IA NEWS to user';
			break;
		case "2B258BCE-8985-E711-80FA-00155DD1690D": //PA NEWS
				$blogs = get_blogs_of_user($userid);
				$blogscount = count($blogs);

				if ($blogscount < 2) {
					$msgcontent = '<img src="https://portfolio-adviser.com/wp-content/themes/lw_expert_inv/images/logo.png" width="200" height="auto" />';
					$msgcontent .= '<p>Welcome to Portfolio Adviser.</p></p>To set up your password, please follow <a href="https://portfolio-adviser.com/welcome?user=' . $login . '">this link</a>.</p>';
					$msgcontent .= '<p>Thank you!</p>';

					$to = $email;
					$subject = "Welcome to Portfolio Adviser";
					$header = "From:noreply@portfolio-adviser.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail($to,$subject,$msgcontent,$header);
				} else {
					//
				}

				add_user_to_blog( 2, $userid, 'subscriber' );
				update_user_meta( $userid, 'lw_product_pa_news', 'yes');
				$returnval = 'OK - Successfully added product PA NEWS to user';
			break;
		default:
			$returnval = 'Wrong Product ID or no action taken.';
			break;
		}		

	} else if ($type == 'EX Subscriber') {
		switch( $product ){
		case "FB218BCE-8985-E711-80FA-00155DD1690D": //EIMI
				update_user_meta( $userid, 'lw_product_ei_market_intelligence', '');
				$returnval = 'OK - Successfully removed product EI - Market Intelligence from user';
			break;
		case "25258BCE-8985-E711-80FA-00155DD1690D": //PA MAG
				update_user_meta( $userid, 'lw_product_pa_magazine_print_digital', '');
				$returnval = 'OK - Successfully removed product PA MAG from user';
			break;
		case "B1238BCE-8985-E711-80FA-00155DD1690D": //IA MAG
				update_user_meta( $userid, 'lw_product_ia_magazine_print_digital', '');
				$returnval = 'OK - Successfully removed product IA MAG from user';
			break;
		case "F9218BCE-8985-E711-80FA-00155DD1690D": //EI MAG 
				update_user_meta( $userid, 'lw_product_ei_magazine_print_digital', '');
				$returnval = 'OK - Successfully removed product EI MAG from user';
			break;
		/*case "2B228BCE-8985-E711-80FA-00155DD1690D": //EIE MAG FREE
				update_user_meta( $userid, 'lw_product_ei_magazine_free_print_digital', '1');
				$returnval = 'OK - Successfully added product EIE MAG FREE to user';
			break;
		case "B3238BCE-8985-E711-80FA-00155DD1690D": //IA MAG FREE
				update_user_meta( $userid, 'lw_product_ia_magazine_free_print_digital', '1');
				$returnval = 'OK - Successfully added product IA MAG FREE to user';
			break;
		case "1B258BCE-8985-E711-80FA-00155DD1690D": //IATUR
				update_user_meta( $userid, 'lw_product_ia_tur_magazine_free_print_digital', '1');
				$returnval = 'OK - Successfully added product IATUR to user';
			break;*/
		case "27258BCE-8985-E711-80FA-00155DD1690D": //PA MAG FREE
				update_user_meta( $userid, 'lw_product_pa_magazine_free_print_digital', '');
				$returnval = 'OK - Successfully removed product PA MAG FREE from user';
			break;
		case "29258BCE-8985-E711-80FA-00155DD1690D": //PA MAG IRE
				update_user_meta( $userid, 'lw_product_pa_magazine_ire_print_digital', '');
				$returnval = 'OK - Successfully removed product PA MAG IRE from user';
			break;
		case "FD218BCE-8985-E711-80FA-00155DD1690D": //EI NEWS
				remove_user_from_blog($userid, 5);
				update_user_meta( $userid, 'lw_product_ei_news', '');
				$returnval = 'OK - Successfully removed product EI NEWS from user';
			break;
		
		case "43238BCE-8985-E711-80FA-00155DD1690D": //FSA NEWS
				remove_user_from_blog($userid, 4);
				update_user_meta( $userid, 'lw_product_fsa_news', '');
				$returnval = 'OK - Successfully removed product FSA NEWS from user';
			break;
		case "B5238BCE-8985-E711-80FA-00155DD1690D": //IA NEWS
				remove_user_from_blog($userid, 3);
				update_user_meta( $userid, 'lw_product_ia_news', '');
				$returnval = 'OK - Successfully removed product IA NEWS from user';
			break;
		case "2B258BCE-8985-E711-80FA-00155DD1690D": //PA NEWS
				remove_user_from_blog($userid, 2);
				update_user_meta( $userid, 'lw_product_pa_news', '');
				$returnval = 'OK - Successfully removed product PA NEWS from user';
			break;
		default:
			$returnval = 'Wrong Product ID or no action taken.';
			break;
		}		
	} else {
		$returnval = 'ERROR - Transaction type is not correct!';
	}
	
	return rest_ensure_response($returnval);
}
 
/**
 * This function is where we register our routes for our example endpoint.
 */
function lw_register_crm_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'lwdynamic/v1', '/user', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => POST,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'lw_get_dynamic_user_data',
    ) );
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'lwdynamic/v1', '/product', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => POST,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'lw_get_dynamic_product_data',
    ) );
}
 
add_action( 'rest_api_init', 'lw_register_crm_routes' );

?>