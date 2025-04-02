<?php
/**
 * Tags lists guide
 *
 * @package    Tags Lists
 * @subpackage Views
 * @category   Guides
 * @since      1.0.0
 */

// Form page URL.
$form_page = DOMAIN_ADMIN . 'configure-plugin/' . $this->className();

?>
<style>
	pre.tags-code,
	code.tags-code {
		user-select: all;
		cursor: pointer;
	}
	pre.tags-code {
		max-width: 720px;
		margin: 1rem 0;
		white-space: pre-wrap;
	}
</style>

<h1><span class="page-title-icon fa fa-book"></span> <span class="page-title-text"><?php $L->p( 'Tags Lists Guide' ) ?></span></h1>

<div class="alert alert-primary alert-tags-lists" role="alert">
	<p class="m-0"><?php $L->p( "Go to the <a href='{$form_page}'>sidebar settings</a> page." ); ?></p>
</div>

<h2 class="form-heading "><?php $L->p( 'Sidebar Tags List' ) ?></h2>

<p><?php $L->p( 'The sidebar tags list requires no coding and is enabled by default. It can be disabled on the settings page. The HTML markup and the CSS classes for the list are nearly identical to the original Bludit tags plugin for those who have already written custom CSS for the sidebar tags list.' ) ?></p>

<p><?php $L->p( 'When enabled, the sidebar tags list has several options for customizing to your needs.' ) ?></p>

<h2 class="form-heading "><?php $L->p( 'Default Settings' ) ?></h2>

<p><?php $L->p( 'The array below is the complete array of arguments used to construct a tags list. Any of these can be overridden with an array of arguments passed to a function call. These are also used by the sidebar tags list but array values are overridden by the plugin with settings values.' ) ?></p>

<pre lang="PHP" class="tags-code">
&lt;?php
$defaults = [
	'wrap'       => false,
	'wrap_class' => 'list-wrap tags-list-wrap',
	'direction'  => 'vert', // horz or vert
	'separator'  => false, // false or string
	'list_class' => 'tags-list standard-taxonomy-list',
	'label'      => false,
	'label_el'   => 'h2',
	'links'      => true,
	'show_count' => false
];
?&gt;
</pre>

<h2 class="form-heading "><?php $L->p( 'Template Tags' ) ?></h2>

<p><?php $L->p( 'The tags list function accepts an array of arguments to override the function defaults. It is also namespaced so the function must be preceded by the namespace or aliased.' ); ?></p>

<p><?php $L->p( 'Following is an example of displaying a default list in a theme template.<br />Note the TagLists namespace and backslash before the function call.' ); ?></p>

<pre lang="PHP">&lt;?php TagLists\tags_list(); ?&gt;</pre>

<p><?php $L->p( 'The following example demonstrates the addition of a list label.' ); ?></p>

<pre lang="PHP">&lt;?php TagLists\tags_list( [ 'label' => $L->get( '<?php $L->p( 'Content Types' ) ?>' ) ] ); ?&gt;</pre>

<p><?php $L->p( 'The following example shows the post count, modifies the heading element, and changes the direction. Changing the direction of the list requires you to add CSS if you override the default classes.' ); ?></p>

<pre lang="PHP" class="tags-code">
&lt;?php
$tags_list = [
	'show_count' => true,
	'label_el'   => 'h3',
	'direction'  => 'horz'
];
echo TagLists\tags_list( $tags_list );
?&gt;
</pre>

<p><?php $L->p( 'Please raise issues and make suggestions on the plugin\'s GitHub page: <a href="https://github.com/Bludiot/tags-lists">https://github.com/Bludiot/tags-lists</a>' ); ?></p>
