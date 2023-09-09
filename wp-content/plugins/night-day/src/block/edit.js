import { __ } from '@wordpress/i18n';
import {
    InspectorControls,
    RichText,
} from '@wordpress/block-editor';
import {
    PanelBody,
    SelectControl,
} from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
    const { content, styleOption } = attributes;

    return (
        <div className={ `night-day-block ${ styleOption }` }>
            <InspectorControls>
                <PanelBody title={ __( 'Style Settings' ) }>
                    <SelectControl
                        label="Select Style"
                        value={ styleOption }
                        options={ [
                            { label: 'Style 1', value: 'style1' },
                            { label: 'Style 2', value: 'style2' },
                        ] }
                        onChange={ ( selectedOption ) => {
                            setAttributes( { styleOption: selectedOption } );
                        } }
                    />
                </PanelBody>
            </InspectorControls>
            <RichText
                tagName="p"
                value={ content }
                onChange={ ( content ) => setAttributes( { content } ) }
            />
        </div>
    );
}
