<?php
//************************************************************************************************
// Section: 		SEO SCHEMA.ORG Structured Data
// Description:		Module for managing the structured data output
//************************************************************************************************

function lai_display_publisher_schema() {
	$logo = site_setting('publisher_logo');
	
	echo '<span style="display:none;" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
		<span itemprop="name">' . site_setting('publisher_name') . '</span>
		<span itemprop="legalName">' . site_setting('publisher_name') . '</span>
		<span itemprop="email">' . site_setting('publisher_contact_email') . '</span>
		<span itemprop="telephone">' . site_setting('publisher_contact_phone') . '</span>' 
		. lai_get_imageObject_schema($logo['id'], 'full', 'logo') .
	'</span>';
}


function lai_get_imageObject_schema($image_id, $size = 'full', $itemprop = 'image') {
	if (empty($image_id)) {
		return 0;
	}
	
	$attachment_meta = wp_get_attachment_image_src($image_id, $size);
	
	if (!empty($attachment_meta)) {
		return '<span itemprop="' . $itemprop . '" itemscope itemtype="https://schema.org/ImageObject" style="display: none;">
				<meta itemprop="url" content="' . $attachment_meta[0] . '">
				<meta itemprop="width" content="' . $attachment_meta[1] . 'px">
				<meta itemprop="height" content="' . $attachment_meta[2] . 'px">
			</span>';
	}
}