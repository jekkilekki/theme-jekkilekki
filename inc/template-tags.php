<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Jekkilekki
 */

if ( ! function_exists( 'jekkilekki_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function jekkilekki_paging_nav() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }
    
    $paged          = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link   = html_entity_decode( get_pagenum_link() );
    $query_args     = array();
    $url_parts      = explode( '?', $pagenum_link );
    
    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }
    
    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
    
    $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
    
    // Set up paginated links.
    $links = paginate_links( array(
        'base'      => $pagenum_link,
        'format'    => $format,
        'total'     => $GLOBALS['wp_query']->max_num_pages,
        'current'   => $paged,
        'mid_size'  => 2,
        'add_args'  => array_map( 'urlencode', $query_args ),
        'prev_text' => __( '< Previous', 'jekkilekki' ),
        'next_text' => __( 'Next >', 'jekkilekki' ),
        'type'      => 'list',
    ) );
    
    if ( $links ) :
        
    ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'jekkilekki' ); ?></h1>
            <?php echo $links; ?>
    </nav><!-- .navigation -->
    <?php
    endif;
}
endif;

if ( ! function_exists( 'jekkilekki_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function jekkilekki_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
            <div class="post-nav-box clear">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'jekkilekki' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous"><div class="nav-indicator">' . _x( 'Previous Post:', 'Previous post', 'jekkilekki' ) .   '</div><h1>%link</h1></div>', '%title' );
				next_post_link(     '<div class="nav-next"><div class="nav-indicator">' .     _x( 'Next Post:', 'Next post',     'jekkilekki' ) .       '</div><h1>%link</h1></div>', '%title' );
			?>
		</div><!-- .nav-links -->
            </div><!-- .post-nav-box -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'jekkilekki_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jekkilekki_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '/ %s', 'post date', 'jekkilekki' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( '/ %s', 'post author', 'jekkilekki' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function jekkilekki_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'jekkilekki_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'jekkilekki_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so jekkilekki_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so jekkilekki_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in jekkilekki_categorized_blog.
 */
function jekkilekki_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'jekkilekki_categories' );
}
add_action( 'edit_category', 'jekkilekki_category_transient_flusher' );
add_action( 'save_post',     'jekkilekki_category_transient_flusher' );

/*
 * Optional Top Menu
 */
function jekkilekki_top_menu() {
    if ( has_nav_menu( 'top-menu' ) ) {
    wp_nav_menu(
        array(
            'theme_location'    => 'top-menu',
            'container'         => 'div',
            'container_id'      => 'top-content-menu',
            'container_class'   => 'top-content-menu',
            'menu_id'           => 'top-content-menu-items',
            'menu_class'        => 'menu-items menu nav-menu',
            'depth'             => 1,
            'fallback_cb'       => '',
        )
    );
    }
}

/*
 * Social media icon menu as per http://justintadlock.com/archives/2013/08/14/social-nav-menu
 */
function jekkilekki_social_menu() {
    if ( has_nav_menu( 'social' ) ) {
    wp_nav_menu(
        array(
            'theme_location'    => 'social',
            'container'         => 'div',
            'container_id'      => 'menu-social',
            'container_class'   => 'menu-social',
            'menu_id'           => 'menu-social-items',
            'menu_class'        => 'menu-items',
            'depth'             => 1,
            'link_before'       => '<span class="screen-reader-text">',
            'link_after'        => '</span>',
            'fallback_cb'       => '',
        )
    );
    }
}

/*
 * Optional Footer Menu
 */
function jekkilekki_footer_menu() {
    if ( has_nav_menu( 'footer-menu' ) ) {
    wp_nav_menu(
        array(
            'theme_location'    => 'footer-menu',
            'container'         => 'div',
            'container_id'      => 'menu-footer',
            'container_class'   => 'menu-footer',
            'menu_id'           => 'menu-footer-items',
            'menu_class'        => 'menu-items',
            'depth'             => 1,
            'fallback_cb'       => '',
        )
    );
    }
}