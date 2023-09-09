const { registerBlockType } = require('@wordpress/blocks');
const edit = require('../../src/block/edit');
const save = require('../../src/block/save');



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
