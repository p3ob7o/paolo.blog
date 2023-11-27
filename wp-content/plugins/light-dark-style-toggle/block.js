( function( blocks, element, editor, components ) {
    var el = element.createElement;
    var InspectorControls = editor.InspectorControls;
    var SelectControl = components.SelectControl;

    blocks.registerBlockType( 'ldst/toggle-block', {
        title: 'Light/Dark Style Toggle',
        icon: 'lightbulb',
        category: 'widgets',
        attributes: {
            currentStyle: {
                type: 'string',
                default: 'light' // Default style
            }
        },

        edit: function( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onChangeStyle( newStyle ) {
                setAttributes( { currentStyle: newStyle } );
            }

            return [
                el(
                    InspectorControls,
                    { key: 'controls' },
                    el(
                        SelectControl,
                        {
                            key: 'style-select',
                            label: 'Select Style',
                            value: attributes.currentStyle,
                            options: [
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' }
                            ],
                            onChange: onChangeStyle
                        }
                    )
                ),
                el(
                    'div',
                    { className: props.className },
                    'Click to toggle between Light and Dark styles.'
                )
            ];
        },

        save: function() {
            // This block will be rendered dynamically with PHP, so return null
            return null;
        },
    });
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
