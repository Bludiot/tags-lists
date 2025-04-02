<?php
/**
 * Functions
 *
 * @package    Tags Lists
 * @subpackage Core
 * @category   Functions
 * @since      1.0.0
 */

namespace TagLists;

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

/**
 * Plugin instance
 *
 * @since  1.0.0
 * @return object
 */
function plugin() {
	return new \Tags_Lists;
}

/**
 * Tags database
 *
 * @since  1.0.0
 * @global object $tags The Tags class.
 * @return mixed False if no tags in database.
 */
function tags_db() {

	// Access global variables.
	global $tags;

	if ( 0 == count( $tags->db ) ) {
		return false;
	}
	return $tags->getDB();
}

/**
 * Get tags
 *
 * Gets all available tags.
 *
 * @param  string $get `key`, `key_name`, or `name`
 * @return mixed False if no tags in database.
 */
function get_tags( $get = 'key' ) {

	// False if no tags in the database.
	if ( 0 == count_tags() ) {
		return false;
	}

	$tags = [];
	foreach ( tags_db() as $key => $cat ) {

		if ( 'key_name' == $get ) {
			$entry = [ $key => $cat['name'] ];
			$tags  = array_merge( $tags, $entry );
		} elseif ( 'name' == $get ) {
			$tags[] = $cat['name'];
		} else {
			$tags[] = $key;
		}
	}
	return $tags;
}

/**
 * Count tags
 *
 * Total number of tags in the
 * database, including those not used
 * for any post.
 *
 * @since  1.0.0
 * @return integer
 */
function count_tags() {
	return count( tags_db() );
}

/**
 * Get tags by post count
 *
 * @since  1.0.0
 * @global object $tags The Tags class.
 * @return array
 */
function tags_by_count() {

	// Access global variables.
	global $tags;

	if ( 0 == count( $tags->db ) ) {
		return false;
	}
	usort( $tags->db, function( $a, $b ) {
		return count( $a['list'] ) < count( $b['list'] );
	} );
	return $tags->db;
}

/**
 * Tags list
 *
 * @since  1.0.0
 * @param  mixed $args Arguments to be passed.
 * @param  array $defaults Default arguments.
 * @return string Returns the list markup.
 */
function tags_list( $args = null, $defaults = [] ) {

	// Access global variables.
	global $tags;

	// Default arguments.
	$defaults = [
		'wrap'       => false,
		'wrap_class' => 'list-wrap tags-list-wrap',
		'direction'  => 'horz', // horz or vert
		'separator'  => false,
		'list_class' => 'tags-list standard-taxonomy-list',
		'label'      => false,
		'label_el'   => 'h2',
		'links'      => true,
		'sort_by'    => 'abc', // abc or count
		'show_count' => false,
		'count_size' => false
	];

	// Maybe override defaults.
	if ( is_array( $args ) && $args ) {
		if ( isset( $args['direction'] ) && 'horz' == $args['direction'] && ! isset( $args['list_class'] ) ) {
			$defaults['list_class'] = 'tags-list inline-taxonomy-list';
		}
		$args = array_merge( $defaults, $args );
	} else {
		$args = $defaults;
	}

	// Label wrapping elements.
	$get_open  = str_replace( ',', '><', $args['label_el'] );
	$get_close = str_replace( ',', '></', $args['label_el'] );

	$label_el_open  = "<{$get_open}>";
	$label_el_close = "</{$get_close}>";

	// Tags separator.
	$sep = null;
	if ( 'horz' == $args['direction'] && is_string( $args['separator'] ) ) {
		$sep = $args['separator'];
	}

	// List markup.
	$html = '';
	if ( $args['wrap'] ) {
		$html = sprintf(
			'<div class="%s">',
			$args['wrap_class']
		);
	}
	if ( $args['label'] ) {
		$html .= sprintf(
			'%1$s%2$s%3$s',
			$label_el_open,
			$args['label'],
			$label_el_close
		);
	}
	$html .= sprintf(
		'<ul class="%s">',
		$args['list_class']
	);

	// Maybe sort by post count.
	if ( 'count' == $args['sort_by'] ) {
		usort( $tags->db, function( $a, $b ) {
			return count( $a['list'] ) < count( $b['list'] );
		} );
	}

	// By default the database of tags are alphanumeric sorted.
	foreach ( tags_db() as $key => $fields ) {

		$get_count = count( $fields['list'] );
		$get_name  = $fields['name'];

		// Hide empty tags.
		if ( $get_count == 0 ) {
			continue;
		}

		/**
		 * No separator after the last tag.
		 * Needs PHP 7.3 or greater.
		 */
		if ( function_exists( 'array_key_last' ) ) {
			if ( $key == array_key_last( tags_db() ) ) {
				$sep = null;
			}
		}

		// Font size by count.
		$font_size = '1em';
		if ( $args['count_size'] ) {
			if ( $get_count >= 21 ) {
				$font_size = '1.3em';
			} elseif ( $get_count >= 14 ) {
				$font_size = '1.2em';
			} elseif ( $get_count >= 7 ) {
				$font_size = '1.1em';
			}
		}

		$name = $get_name;
		if ( $args['show_count'] ) {
			$name = sprintf(
				'%s (%s)',
				$get_name,
				$get_count
			);
		}
		$html .= "<li style='font-size:{$font_size};'>";
		if ( $args['links'] ) {
			$html .= '<a href="' . DOMAIN_TAGS . $key . '">';
		}
		$html .= $name;
		if ( $args['links'] ) {
			$html .= '</a>';
		}
		$html .= '</li>' . $sep;
	}
	$html .= '</ul>';

	if ( $args['wrap'] ) {
		$html .= '</div>';
	}
	return $html;
}

/**
 * Sidebar list
 *
 * @since  1.0.0
 * @global object $L The Language class.
 * @return string Returns the list markup.
 */
function sidebar_list() {

	// Access global variables.
	global $L;

	$tags = tags_db();
	if ( 'count' == plugin()->sort_by() ) {
		$tags = tags_by_count();
	}

	// Label wrapping elements.
	$get_open  = str_replace( ',', '><', plugin()->label_wrap() );
	$get_close = str_replace( ',', '></', plugin()->label_wrap() );

	$label_el_open  = "<{$get_open}>";
	$label_el_close = "</{$get_close}>";

	// List class.
	$list_class = 'tags-list inline-taxonomy-list';
	if ( 'vert' == plugin()->list_view() ) {
		$list_class = 'tags-list standard-taxonomy-list';
	}

	// Tags separator.
	$sep = null;
	if ( 'horz' == plugin()->list_view() && plugin()->separator() ) {
		$sep = ' | ';
	}

	// List markup.
	$html = '<div class="list-wrap tags-list-wrap-wrap plugin plugin-tags-list">';
	if ( ! empty( plugin()->label() ) ) {
		if ( plugin()->label_wrap() ) {
			$html .= sprintf(
				'%1$s%2$s%3$s',
				$label_el_open,
				plugin()->label(),
				$label_el_close
			);
		} else {
			$html .= plugin()->label();
		}
	}
	$html .= sprintf(
		'<ul class="%s">',
		$list_class
	);

	// List entries.
	foreach ( $tags as $key => $value ) {

		if ( ! array_key_exists( 'name', $value ) ) {
			continue;
		}

		$get_count = count( $value['list'] );
		$get_name  = $value['name'];

		/**
		 * No separator after the last tag.
		 * Needs PHP 7.3 or greater.
		 */
		if ( function_exists( 'array_key_last' ) ) {
			if ( $key == array_key_last( $tags ) ) {
				$sep = null;
			}
		}

		// Font size by count.
		$font_size = '1em';
		if ( plugin()->count_size() ) {
			if ( $get_count >= 21 ) {
				$font_size = '1.3em';
			} elseif ( $get_count >= 14 ) {
				$font_size = '1.2em';
			} elseif ( $get_count >= 7 ) {
				$font_size = '1.1em';
			}
		}

		$name = $get_name;
		if ( plugin()->post_count() ) {
			$name = sprintf(
				'%s (%s)',
				$get_name,
				$get_count
			);
		}
		$html .= sprintf(
			"<li style='font-size:{$font_size};'><a href='%s'>%s</a></li>%s",
			DOMAIN_TAGS . $key,
			$name,
			$sep
		);
	}
	$html .= '</ul></div>';

	return $html;
}
