<?php
/**
 * Plugin Name: My Custom Redirect
 * Description: A simple plugin to redirect to the #home anchor on the homepage if no anchor tag is present in the URL, and change the site title and site logo links to include #top.
 * Version: 1.1.0
 * Author: Paolo Belcastro
 * License: GPL-2.0+
 */

function my_home_redirect_scripts() {
    if ( is_front_page() ) {
        wp_register_script( 'my-home-redirect', '', [], '', true );
        wp_enqueue_script( 'my-home-redirect' );
        wp_add_inline_script( 'my-home-redirect', '
            document.addEventListener("DOMContentLoaded", function() {
                if (!window.location.hash) {
                    window.location.hash = "home";
                }
            });
        ' );
    }
}
add_action( 'wp_enqueue_scripts', 'my_home_redirect_scripts' );

function my_site_title_logo_links_scripts() {
    wp_register_script( 'my-site-title-logo-links', '', [], '', true );
    wp_enqueue_script( 'my-site-title-logo-links' );
    
    $custom_js = '
        document.addEventListener("DOMContentLoaded", function() {
            var siteTitleLink = document.querySelector(".wp-block-site-title a");
            var siteLogoLink = document.querySelector(".wp-block-site-logo a");

            if (siteTitleLink) {
                siteTitleLink.href = siteTitleLink.href.replace(/\/$/, "") + "#top";
            }
            if (siteLogoLink) {
                siteLogoLink.href = siteLogoLink.href.replace(/\/$/, "") + "#top";
            }
        });
    ';

    wp_add_inline_script( 'my-site-title-logo-links', $custom_js );
}
add_action( 'wp_enqueue_scripts', 'my_site_title_logo_links_scripts' );
