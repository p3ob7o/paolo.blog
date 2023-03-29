const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InnerBlocks, useBlockProps } = wp.blockEditor;
const { createElement } = wp.element;

registerBlockType('wp-gpt/social-quote', {
    title: __('Social Quote', 'wp-gpt'),
    description: __('A block that generates a shareable quote from the post content.', 'wp-gpt'),
    category: 'widgets',
    icon: 'twitter',
    supports: {
        html: false,
    },
    edit() {
        const blockProps = useBlockProps();
        return createElement('div', blockProps, createElement(InnerBlocks));
    },
    save() {
        const blockProps = useBlockProps.save();
        return createElement('div', blockProps, createElement(InnerBlocks.Content));
    },
});
