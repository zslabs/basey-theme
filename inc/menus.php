<?php

/**
 * foundation walker
 * https://gist.github.com/3184243
 */

/**
 * customize the output of menus for Foundation nav bar classes
 */
class nav_bar_walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		$element->has_children = !empty( $children_elements[$element->ID] );
		$element->classes[] .= ( $element->current || in_array( 'current-menu-ancestor', $element->classes ) ) ? 'active' : '';
		$element->classes[] .= ( $element->has_children && $depth < 1) ? 'has-flyout' : '';

		//print_r( $children_elements);

		parent::display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output );
	}

	function start_el( &$output, $item, $depth, $args ) {
		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		$classes = empty( $item->classes ) ? array() : ( array ) $item->classes;

		if(in_array( 'has-flyout', $classes ) ) {
			$item_html = str_replace( '</a>', '</a><a href="' . esc_attr( $item->url) . '" class="flyout-toggle"><span> </span></a>', $item_html );
		}

		$output .= $item_html;
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"sub-menu flyout\">\n";
	}

} // end nav bar walker

/**
 * customize the output of page list for foundation nav classes in main_nav_fb
 * http://forrst.com/posts/Using_Short_Page_Titles_for_wp_list_pages_Wordp-uV9
 */
class page_walker extends Walker_Page {
	function start_el( &$output, $page, $depth, $args, $current_page ) {

		$indent = ( $depth) ? str_repeat("\t", $depth) : '';

		extract( $args, EXTR_SKIP);
		$classes = array( 'page_item', 'page-item-' . $page->ID );
		if ( !empty( $current_page) ) {
			$_current_page = get_page( $current_page );
		if ( isset( $_current_page->ancestors ) && in_array( $page->ID, ( array ) $_current_page->ancestors ) )
			$classes[] = 'current_page_ancestor';
		if ( $page->ID == $current_page )
			$classes[] = 'current_page_item active';
		elseif ( $_current_page && $page->ID == $_current_page->post_parent )
			$classes[] = 'current_page_parent';
		} elseif ( $page->ID == get_option( 'page_for_posts' ) ) {
			$classes[] = 'current_page_parent';
		}
		if ( get_children( $page->ID ) )
			$classes[] = 'has-flyout';

		$classes = implode( ' ', apply_filters( 'page_css_class', $classes, $page ) );

		$output .= $indent . '<li class="' . $classes . '">';
		$output .= '<a href="' . get_page_link( $page->ID ) . '" title="'.esc_attr( wp_strip_all_tags( $page->post_title ) ).'">';
		$output .= $args['link_before'] . $page->post_title . $args['link_after'];
		$output .= '</a>';
	}
	function end_el( &$output, $item, $depth ) {
		$output .= "</li>\n";
	}
	function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu flyout\">\n";
	}
	function end_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent</ul>\n";
	}
} // end page walker