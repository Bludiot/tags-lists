<?php
/**
 * Tags list options
 *
 * @package    Tags Lists
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Guide page URL.
$guide_page = DOMAIN_ADMIN . 'plugin/' . $this->className();

?>
<style>
.form-control-has-button {
	display: flex;
	align-items: center;
	flex-wrap: nowrap;
	gap: 0.25em;
	width: 100%;
	margin: 0;
	padding: 0;
}
</style>
<div class="alert alert-primary alert-tags-lists" role="alert">
	<p class="m-0"><?php $L->p( "Go to the <a href='{$guide_page}'>tags lists guide</a> page." ); ?></p>
</div>

<fieldset class="mt-4">
	<legend class="screen-reader-text mb-3"><?php $L->p( 'Sidebar List Options' ) ?></legend>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="in_sidebar"><?php echo ucwords( $L->get( 'Sidebar List' ) ); ?></label>
		<div class="col-sm-10">
			<select id="in_sidebar" class="form-select" name="in_sidebar">
				<option value="true" <?php echo ( $this->getValue( 'in_sidebar' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>

				<option value="false" <?php echo ( $this->getValue( 'in_sidebar' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Display a categories list in the sidebar ( <code>siteSidebar</code> hook required in the theme ).' ); ?></small>
		</div>
	</div>

	<div id="tags-lists-options" style="display: <?php echo ( $this->getValue( 'in_sidebar' ) == true ? 'block' : 'none' ); ?>;">

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for=""><?php $L->p( 'List Label' ); ?></label>
			<div class="col-sm-10">
				<div class="form-control-has-button">
					<input type="text" id="label" name="label" value="<?php echo $this->getValue( 'label' ); ?>" placeholder="<?php echo $this->dbFields['label']; ?>" />
					<span class="btn btn-secondary btn-md button hide-if-no-js" onClick="$('#label').val('<?php echo $this->dbFields['label']; ?>');"><?php $L->p( 'Default' ); ?></span>
				</div>
				<small class="form-text text-muted"><?php $L->p( 'List title in the sidebar. Save as empty for no title.' ); ?></small>
			</div>
		</div>

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for="label_wrap"><?php $L->p( 'Label Wrap' ); ?></label>
			<div class="col-sm-10">
				<div class="form-control-has-button">
					<input type="text" id="label_wrap" name="label_wrap" value="<?php echo $this->getValue( 'label_wrap' ); ?>" placeholder="<?php $L->p( 'h2' ); ?>" />
					<span class="btn btn-secondary btn-md button hide-if-no-js" onClick="$('#label_wrap').val('<?php echo $this->dbFields['label_wrap']; ?>');"><?php $L->p( 'Default' ); ?></span>
				</div>
				<small class="form-text text-muted"><?php $L->p( 'Wrap the label in an element, such as a heading. Accepts HTML tags without brackets (e.g. h3), and comma-separated tags (e.g. span,strong,em). Save as blank for no wrapping element.' ); ?></small>
			</div>
		</div>

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for="sort_by"><?php $L->p( 'Sort Order' ); ?></label>
			<div class="col-sm-10">
				<select id="sort_by" class="form-select" name="sort_by">
					<option value="abc" <?php echo ( $this->getValue( 'sort_by' ) === 'abc' ? 'selected' : '' ); ?>><?php $L->p( 'Alphabetically' ); ?></option>
					<option value="count" <?php echo ( $this->getValue( 'sort_by' ) === 'count' ? 'selected' : '' ); ?>><?php $L->p( 'Post Count' ); ?></option>
				</select>
				<small class="form-text text-muted"><?php $L->p( 'Order of the tags list display.' ); ?></small>
			</div>
		</div>

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for="post_count"><?php $L->p( 'Post Count' ); ?></label>
			<div class="col-sm-10">
				<select id="post_count" class="form-select" name="post_count">
					<option value="true" <?php echo ( $this->getValue( 'post_count' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
					<option value="false" <?php echo ( $this->getValue( 'post_count' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
				</select>
				<small class="form-text text-muted"><?php $L->p( 'Display the number of posts and pages attached to the tag.' ); ?></small>
			</div>
		</div>

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for="list_view"><?php $L->p( 'List Direction' ); ?></label>
			<div class="col-sm-10">
				<select id="list_view" class="form-select" name="list_view">
					<option value="vert" <?php echo ( $this->getValue( 'list_view' ) === 'vert' ? 'selected' : '' ); ?>><?php $L->p( 'Vertical' ); ?></option>
					<option value="horz" <?php echo ( $this->getValue( 'list_view' ) === 'horz' ? 'selected' : '' ); ?>><?php $L->p( 'Horizontal' ); ?></option>
				</select>
				<small class="form-text text-muted"><?php $L->p( 'How to display the tags list.' ); ?></small>
			</div>
		</div>

		<div id="separator-wrap" class="form-field form-group row" style="display: <?php echo ( $this->getValue( 'list_view' ) === 'horz' ? 'flex' : 'none' ); ?>;">
			<label class="form-label col-sm-2 col-form-label" for="separator"><?php echo ucwords( $L->get( 'Tags Separator' ) ); ?></label>
			<div class="col-sm-10">
				<select id="separator" class="form-select" name="separator">
					<option value="false" <?php echo ( $this->getValue( 'separator' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>

					<option value="true" <?php echo ( $this->getValue( 'separator' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
				</select>
				<small class="form-text"><?php $L->p( 'Separate tags with a pipe ( | ) character in the horizontal list.' ); ?></small>
			</div>
		</div>

		<div class="form-field form-group row">
			<label class="form-label col-sm-2 col-form-label" for="count_size"><?php $L->p( 'Font Size' ); ?></label>
			<div class="col-sm-10">
				<select id="count_size" class="form-select" name="count_size">
					<option value="false" <?php echo ( $this->getValue( 'count_size' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>

					<option value="true" <?php echo ( $this->getValue( 'count_size' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
				</select>
				<small class="form-text text-muted"><?php $L->p( 'Increase font size by post count. Increases 7 or greater, 14 or greater, 21 or greater.' ); ?></small>
			</div>
		</div>
	</div>
</fieldset>

<script>
jQuery(document).ready( function($) {
	$( '#in_sidebar' ).on( 'change', function() {
		var show = $(this).val();
		if ( show == 'true' ) {
			$( "#tags-lists-options" ).fadeIn( 250 );
		} else if ( show == 'false' ) {
			$( "#tags-lists-options" ).fadeOut( 250 );
		}
	});
	$( '#list_view' ).on( 'change', function() {
		var show = $(this).val();
		if ( show == 'horz' ) {
			$( "#separator-wrap" ).css( 'display', 'flex' );
		} else {
			$( "#separator-wrap" ).css( 'display', 'none' );
		}
	});
});
</script>
