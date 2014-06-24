<?php
/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from Bootstrap
 * The number of columns must be a factor of 12.
 *
 * @link http://twbs.github.io/bootstrap/components/#thumbnails
 * @source http://roots.io
 */
function basey_gallery($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if (!empty($attr['ids'])) {
		if (empty($attr['orderby'])) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr);

	if ($output != '') {
		return $output;
	}

	if (isset($attr['orderby'])) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if (!$attr['orderby']) {
			unset($attr['orderby']);
		}
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => '',
		'icontag'    => '',
		'captiontag' => '',
		'columns'    => 4,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => 'file'
	), $attr));

	$id = intval($id);
	$grid = sprintf('uk-grid-width-medium-1-%1$s', $columns);

	if ($order === 'RAND') {
		$orderby = 'none';
	}

	if (!empty($include)) {
		$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($exclude)) {
		$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	} else {
		$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	}

	if (empty($attachments)) {
		return '';
	}

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}
		return $output;
	}

	$unique = (get_query_var('page')) ? $instance . '-p' . get_query_var('page'): $instance;
	$output = '<div class="gallery gallery-' . $id . '-' . $unique . '">';

	$output .= '<ul class="uk-grid ' . $grid . '" data-uk-grid-margin>';

	$i = 0;
	foreach ($attachments as $id => $attachment) {

		$attachment_link = get_attachment_link($id);
		$attachment_image = wp_get_attachment_image( $id, $size );

		$output .= '<li class="uk-text-center">';
			$output .= $link !== 'none' ? '<a class="uk-thumbnail uk-overlay-toggle" href="' . $attachment_link . '">' : '<div class="uk-thumbnail uk-overlay-toggle">';
				$output .= '<figure class="uk-overlay uk-margin-remove">';
					$output .= $attachment_image;
					if (trim($attachment->post_excerpt)) {
						$output .= '<figcaption class="uk-overlay-caption">' . wptexturize($attachment->post_excerpt) . '</figcaption>';
					}
				$output .= '</figure>';
			$output .= $link !== 'none' ? '</a>' : '</div>';

		$output .= '</li>';
		$i++;
	}
	$output .= '</ul>';
	$output .= '</div>';

	return $output;
}
remove_shortcode('gallery');
add_shortcode('gallery', 'basey_gallery');
add_filter('use_default_gallery_style', '__return_null');