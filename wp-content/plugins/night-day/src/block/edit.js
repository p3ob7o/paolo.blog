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
    const { content, styleOption, globalStyle1, globalStyle2 } = attributes;

    const globalStylesOptions = window.nightDayGlobals.globalStyles;

    return (
        <div className={ `night-day-block ${ styleOption }` }>
            <InspectorControls>
                <PanelBody title={ __( 'Style Settings' ) }>
                    <SelectControl
                        label="Global Style 1"
                        value={ globalStyle1 }
                        options={ globalStylesOptions }
                        onChange={ ( selectedOption ) => {
                            setAttributes( { globalStyle1: selectedOption } );
                        } }
                    />
                    <SelectControl
                        label="Global Style 2"
                        value={ globalStyle2 }
                        options={ globalStylesOptions }
                        onChange={ ( selectedOption ) => {
                            setAttributes( { globalStyle2: selectedOption } );
                        } }
                    />
                    <SelectControl
                        label="Select Active Style"
                        value={ styleOption }
                        options={ [
                            { label: 'Select Style...', value: '' },
                            { label: globalStyle1, value: globalStyle1 },
                            { label: globalStyle2, value: globalStyle2 },
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

