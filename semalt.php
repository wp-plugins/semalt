<?php
/*
Plugin Name:  Semalt Redirect Manager
Plugin URI:   http://peadig.com/wordpress-plugins/semalt/?utm_source=WordPress&utm_medium=Admin&utm_campaign=Semalt
Description:  We all know how annoying it is when we see Semalt mess up our analytics data. This plugin helps you stop that from happening by referring Semalt's crawler elsewhere! Based on an idea by Rishi Lakhani.
Version:      1.1.3
Author: Alex Moss
Author URI: http://peadig.com/author/alex-moss/
License: GPL v3

Copyright (C) 2010-2010, Alex Moss - alex@peadig.com
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Alex Moss or pleer nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	require 'class-admin.php';
} else {
	//ADD SEMALT REDIRECT
/*
	function semalt_redir() {
		$options = get_option( 'semalt' );
		if ( isset( $options['enabled'] ) && $options['enabled'] ) {

			if(isset($_SERVER['HTTP_REFERER'])) {

				$referrer = $_SERVER['HTTP_REFERER'];

				if ( preg_match( "/semalt.com/", $referrer ) ) {
					$location = $options['url'];
					wp_redirect( $location );
					exit;
				}
			
			}
		}
	}
*/




	function semalt_redir() {
		$options = get_option( 'semalt' );
		if ( isset( $options['enabled']) && isset($_SERVER['HTTP_REFERER'])) {
				$referrer = $_SERVER['HTTP_REFERER'];
				$domain  = $_SERVER['SERVER_NAME'];
				foreach(explode("\n", $options['domains']) as $line) {
					$line = preg_replace('/\s+/', '', $line);
					if (!empty($line)) {
					$line = '/'.$line.'/';
					if ( preg_match( $line, $referrer ) && !preg_match($domain, $line) ) {
						$location = $options['url'];
						wp_redirect( $location );
						exit;
					}
				}
				
			}
		}
	}
	add_action( 'init', 'semalt_redir', 1 );
}
// Add settings link on plugin page
function semalt_link( $links ) {
	$settings_link = '<a href="options-general.php?page=semalt">Settings</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'semalt_link' );
?>
