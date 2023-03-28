const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { Fragment } = wp.element;

registerBlockType('wp-gpt/social-quote', {
    title: __('Social Quote', 'wp-gpt'),
    icon: 'twitter',
    category: 'common',
    edit: (props) => {
        return (
            <Fragment>
                <div>{__('Social Quote Block', 'wp-gpt')}</div>
            </Fragment>
        );
    },
    save: () => {
        return null;
    },
});
