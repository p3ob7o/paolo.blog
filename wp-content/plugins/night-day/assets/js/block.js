import { registerBlockType } from '@wordpress/blocks';
import edit from './edit';
import save from './save';

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
