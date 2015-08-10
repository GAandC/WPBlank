<?php

/**
 * Navigation Posts
 */
if ( ! function_exists( 'the_posts_navigation' ) ) :

	function the_posts_navigation() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation posts-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'wordpress' ); ?></h2>
			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'wordpress' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'wordpress' ) ); ?></div>
				<?php endif; ?>

			</div>
		</nav>
		<?php
	}

endif;


/**
 * Navigation Post
 */
if ( ! function_exists( 'the_post_navigation' ) ) :

	function the_post_navigation() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'wordpress' ); ?></h2>
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
					next_post_link( '<div class="nav-next">%link</div>', '%title' );
				?>
			</div>
		</nav>
		<?php
	}

endif;




/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'wordpress_posted_on' ) ) :

	function wordpress_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'wordpress' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'wordpress' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}

endif;



/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
if ( ! function_exists( 'wordpress_entry_footer' ) ) :

	function wordpress_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'wordpress' ) );
			if ( $categories_list && wordpress_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'wordpress' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'wordpress' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wordpress' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'wordpress' ), esc_html__( '1 Comment', 'wordpress' ), esc_html__( '% Comments', 'wordpress' ) );
			echo '</span>';
		}

	}

endif;



/**
 * Returns true if a blog has more than 1 category.
 */
function wordpress_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wordpress_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wordpress_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wordpress_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wordpress_categorized_blog should return false.
		return false;
	}
}



// Custom excerpt
function gaandc_excerpt()
{
    global $post;
     
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}
