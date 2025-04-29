<?php
/**
 * Tags Lists
 *
 * Plugin core class, do not namespace.
 *
 * Improved tags plugin for Bludit CMS.
 *
 * @package    Tags Lists
 * @subpackage Core
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

// Access namespaced functions.
use function TagLists\{
	sidebar_list
};

class Tags_Lists extends Plugin {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Run parent constructor.
		parent :: __construct();

		// Include functionality.
		if ( $this->installed() ) {
			$this->get_files();
		}
	}

	/**
	 * Prepare plugin for installation
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function prepare() {
		$this->get_files();
	}

	/**
	 * Include functionality
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_files() {

		// Plugin path.
		$path = PATH_PLUGINS . 'tags-lists' . DS;

		// Get plugin functions.
		foreach ( glob( $path . 'includes/*.php' ) as $filename ) {
			require_once $filename;
		}
	}

	/**
	 * Initiate plugin
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @return void
	 */
	public function init() {

		// Access global variables.
		global $L;

		$this->dbFields = [
			'in_sidebar' => true,
			'label'      => $L->get( 'Tags' ),
			'label_wrap' => 'h2',
			'sort_by'    => 'abc',
			'post_count' => true,
			'list_view'  => 'horz',
			'separator'  => false,
			'count_size' => false
		];

		// Array of custom hooks.
		$this->customHooks = [
			'tags_list'
		];

		if ( ! $this->installed() ) {
			$Tmp = new dbJSON( $this->filenameDb );
			$this->db = $Tmp->db;
			$this->prepare();
		}
	}

	/**
	 * Admin settings form
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $plugin Plugin class.
	 * @global object $site Site class.
	 * @return string Returns the markup of the form.
	 */
	public function form() {

		// Access global variables.
		global $L, $plugin, $site;

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/form-page.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Admin controller
	 *
	 * Change the text of the `<title>` tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L The Language class.
	 * @global array $layout
	 * @return string Returns the head content.
	 */
	public function adminController() {
		global $L, $layout, $site;
		$layout['title'] = $L->get( 'Tags Lists Guide' ) . ' | ' . $site->title();
	}

	/**
	 * Admin info pages
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $site Site class.
	 * @return string Returns the markup of the page.
	 */
	public function adminView() {

		// Access global variables.
		global $L, $site;

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/page-guide.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Head section
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the head content.
	 */
	public function siteHead() {

		$html = '<style>';
		$html .= '.inline-taxonomy-list { list-style: none; display: inline-flex; flex-direction: row; flex-wrap: wrap; gap: 0 0.5em; }';
		$html .= '</style>';

		return $html;
	}

	/**
	 * Sidebar list
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the list markup.
	 */
	public function siteSidebar() {

		if ( $this->in_sidebar() ) {
			return sidebar_list();
		}
		return false;
	}

	/**
	 * Option return functions
	 *
	 * @since  1.0.0
	 * @access public
	 */

	// @return boolean
	public function in_sidebar() {
		return $this->getValue( 'in_sidebar' );
	}

	// @return string
	public function label() {
		return $this->getValue( 'label' );
	}

	// @return string
	public function label_wrap() {
		return $this->getValue( 'label_wrap' );
	}

	// @return string
	public function sort_by() {
		return $this->getValue( 'sort_by' );
	}

	// @return boolean
	public function post_count() {
		return $this->getValue( 'post_count' );
	}

	// @return string
	public function list_view() {
		return $this->getValue( 'list_view' );
	}

	// @return boolean
	public function separator() {
		return $this->getValue( 'separator' );
	}

	// @return boolean
	public function count_size() {
		return $this->getValue( 'count_size' );
	}

	/**
	 * Custom hook
	 *
	 * Prints the sidebar default list by
	 * calling the `tags_list' hook.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return string Returns the form markup.
	 */
	public function tags_list() {
		return sidebar_list();
	}
}
