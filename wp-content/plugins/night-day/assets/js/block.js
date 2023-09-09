import { registerBlockType } from '@wordpress/blocks';
import edit from '../../src/block/edit';
import save from '../../src/block/save';


registerBlockType( 'night-day/block', {
    title: 'Night & Day Style Toggle',
    icon: 'admin-appearance',
    category: 'layout',
    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'p',
        },
        styleOption: {
            type: 'string',
            default: '',
        },
        globalStyle1: {
            type: 'string',
            default: '',
        },
        globalStyle2: {
            type: 'string',
            default: '',
        },
    },
    edit,
    save,
} );

