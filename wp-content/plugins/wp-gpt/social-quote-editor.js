const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

registerBlockType('wp-gpt/social-quote', {
    title: __('Social Quote', 'wp-gpt'),
    icon: 'twitter',
    category: 'common',
    edit: () => {
        // Add your edit block code here
        return <div>{__('Social Quote Block', 'wp-gpt')}</div>;
    },
    save: () => {
        // Add your save block code here
        return null;
    },
});
