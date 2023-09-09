( function( wp ) {
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.editor.InspectorControls;
    var RadioControl = wp.components.RadioControl;

    registerBlockType( 'plugin-name/block', {
        title: 'Style Toggle Block',
        icon: 'admin-appearance',
        category: 'layout',

        attributes: {
            selectedStyle: {
                type: 'string',
                default: 'style1'
            }
        },

        edit: function( props ) {
            function updateStyle( newStyle ) {
                props.setAttributes( { selectedStyle: newStyle } );
            }

            return [
                el( InspectorControls, {},
                    el( RadioControl, {
                        label: 'Select Style',
                        selected: props.attributes.selectedStyle,
                        options: [
                            { label: 'Style 1', value: 'style1' },
                            { label: 'Style 2', value: 'style2' }
                        ],
                        onChange: updateStyle
                    } )
                ),
                el( 'div', { className: props.attributes.selectedStyle },
                    el( 'button', {
                        className: 'toggle-button',
                        onClick: function() {
                            var currentStyle = props.attributes.selectedStyle;
                            var newStyle = currentStyle === 'style1' ? 'style2' : 'style1';
                            props.setAttributes( { selectedStyle: newStyle } );
                        }
                    }, 'Toggle Style' )
                )
            ];
        },

        save: function( props ) {
            return el( 'div', { className: props.attributes.selectedStyle },
                el( 'button', {
                    className: 'toggle-button'
                }, 'Toggle Style' )
            );
        }
    } );
} )( window.wp );
