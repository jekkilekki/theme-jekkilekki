<?php
/**
 * @package Jekkilekki
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="index-box">
	<header class="entry-header">
            
            <?php
                if (is_sticky()) {
                    echo '<i class="fa fa-thumb-tack sticky-post"></i>'; 
                }
            ?>
            
		


	</header><!-- .entry-header -->

	<div class="entry-content">
                <?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer continue-reading">
            		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $category_list = get_the_category_list( __( ', ', 'jekkilekki' ) );

                        if (jekkilekki_categorized_blog() ) {
                            echo '<!--<div class="category-list">-->' . $category_list . '<!--</div>-->';
                        }
                    ?>
                    <?php jekkilekki_posted_on(); ?>
                    <?php
                        if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
                            echo '<span class="comments-link">';
                            comments_popup_link( __( 'Leave a comment', 'jekkilekki' ), __( '1 Comment', 'jekkilekki'), __( '% Comments', 'jekkilekki' ) );
                            echo '</span>';
                        }
                    ?>
                    <?php edit_post_link( __( 'Edit', 'jekkilekki' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</footer><!-- .entry-footer -->
    </div><!-- .index-box -->
</article><!-- #post-## -->