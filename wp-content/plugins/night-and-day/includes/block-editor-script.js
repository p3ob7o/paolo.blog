/**
 * File: block-editor-script.js
 * This script handles the block's behavior in the WordPress editor.
 */

( function( wp ) {
	var el = wp.element.createElement;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var TextControl = wp.components.TextControl;

	wp.blocks.registerBlockType( 'night-and-day/block', {
		title: 'Night & Day',
		icon: 'admin-appearance',
		category: 'layout',
		attributes: {
			styleOne: {
				type: 'string',
				default: 'night',
			},
			styleTwo: {
				type: 'string',
				default: 'day',
			},
		},

		edit: function( props ) {
			var attributes = props.attributes;

			return [
				el(
					InspectorControls,
					{ key: 'inspector' }, // key is needed for React!
					el( TextControl, {
						label: 'Style One',
						value: attributes.styleOne,
						onChange: function( value ) {
							props.setAttributes( { styleOne: value } );
						},
					} ),
					el( TextControl, {
						label: 'Style Two',
						value: attributes.styleTwo,
						onChange: function( value ) {
							props.setAttributes( { styleTwo: value } );
						},
					} )
				),
				el( 'button', { className: 'night-and-day-toggle' }, 'Toggle Styles' ),
			];
		},

		save: function() {
			// We're going to render this block with PHP, so save() can return null.
			return null;
		},
	} );
} )( window.wp );
