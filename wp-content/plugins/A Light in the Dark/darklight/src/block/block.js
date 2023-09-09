import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('darklight/dark-light-mode-toggle', {
    title: __('Dark/Light Mode Toggle', 'darklight'),
    icon: 'admin-appearance',
    category: 'layout',
    attributes: {
        lightStyle: {
            type: 'string',
            default: 'light-mode',
        },
        darkStyle: {
            type: 'string',
            default: 'dark-mode',
        },
    },
    edit: ({ attributes, setAttributes }) => {
        const { lightStyle, darkStyle } = attributes;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Styles', 'darklight')}>
                        <TextControl
                            label={__('Light Style', 'darklight')}
                            value={lightStyle}
                            onChange={(lightStyle) => setAttributes({ lightStyle })}
                        />
                        <TextControl
                            label={__('Dark Style', 'darklight')}
                            value={darkStyle}
                            onChange={(darkStyle) => setAttributes({ darkStyle })}
                        />
                    </PanelBody>
                </InspectorControls>
                <button className="dark-light-mode-toggle">
                    {__('Toggle Mode', 'darklight')}
                </button>
            </>
        );
    },
    save: () => {
        return (
            <button className="dark-light-mode-toggle">
                {__('Toggle Mode', 'darklight')}
            </button>
        );
    },
});
