<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Jekkilekki
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
            <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'jekkilekki' ); ?></a>
                
                <div class="top-nav-bar">
                    <div class="top-nav-button"><?php jekkilekki_top_menu(); ?></div>
                    <div class="search-toggle">
                        <i class="fa fa-search"></i>
                        <a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'jekkilekki' ); ?></a>
                    </div>
                    <?php jekkilekki_social_menu(); ?>
                
                    <!-- The Search bar (referenced by the #anchor above) -->
                    <div id="search-container" class="search-box-wrapper clear">
                        <div class="search-box clear">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div> <!-- End top-nav-bar -->
            
                <!-- Check for header image -->
            	<?php if ( get_header_image() && ( 'blank' == get_header_textcolor() ) ) : ?>
                <figure class="header-image">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
                    </a>
                </figure>
                <?php endif; // End header image check. ?>
            
                <!-- Check for header image WITH header text -->
                <?php 
                    if ( get_header_image() && !( 'blank' == get_header_textcolor() ) ) {
                        echo '<div class="site-branding header-background-image" style="background-image: url(' . get_header_image() . ');">';
                    } else {
                        echo '<div class="site-branding">';
                    } // End header image + text check.
                ?>
                                                   
                            <!-- Check if there is a Logo and apply it.
                                From Kirk Wight: http://kwight.ca/2012/12/02/adding-a-logo-uploader-to-your-wordpress-site-with-the-theme-customizer/
                            -->
                            <?php if ( get_theme_mod( 'themeslug_logo' ) /*&& !( 'blank' == get_header_textcolor() )*/ ) : ?>
                            <div class="logo-border">
                            <div class="site-logo">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'themeslug_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
                            </div>
                            </div>
                            <?php endif; // End logo check. ?>
                            
                    <div class="title-box">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    </div>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>                                            
                </div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( '<div class="screen-reader-text">Menu</div>', 'jekkilekki' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
