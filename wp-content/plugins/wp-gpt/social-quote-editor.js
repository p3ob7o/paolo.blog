const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InnerBlocks, useBlockProps } = wp.blockEditor;
const { createElement, useEffect } = wp.element;
const { useState } = wp.react;
const { TextControl, Button } = wp.components;
const { useSelect } = wp.data;
const { apiFetch } = wp;



registerBlockType('wp-gpt/social-quote', {
    title: __('Social Quote', 'wp-gpt'),
    description: __('A block that generates a shareable quote from the post content.', 'wp-gpt'),
    category: 'widgets',
    icon: 'twitter',
    supports: {
        html: false,
    },
    edit() {
    try {
    const [quote, setQuote] = useState(null);
    const [loading, setLoading] = useState(false);

    const blockProps = useBlockProps();

    const content = useSelect((select) => {
        const blockEditor = select('core/block-editor');
        if (!blockEditor) {
            return '';
        }
        const blocks = blockEditor.getBlocks();
        const contentBlocks = blocks.slice(0, -1); // Exclude the last block (our Social Quote block)
        return contentBlocks.map((block) => block.originalContent).join('\n');
    }, []);

    useEffect(() => {
        if (!content) {
            return;
        }

        setLoading(true);

        apiFetch({
            path: '/wp-gpt/proxy.php',
            method: 'POST',
            data: {
                prompt: "As a social content expert creator, extract the best quote from the provided text. 'Best quote' means the one more likely to drive readers to want to read the content if they were to see the quote on Twitter. Limit the quote to 200 characters maximum",
                context: content,
            },
        })
            .then((data) => {
                setLoading(false);
                setQuote(data.choices[0].text.trim());
            })
            .catch(() => {
                setLoading(false);
            });
    }, [content]);

    function tweetQuote() {
        if (!quote) {
            return;
        }

        const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(quote)}`;
        window.open(tweetUrl, '_blank');
    }

    return createElement(
        'div',
        blockProps,
        loading ? (
            createElement(Spinner)
        ) : (
            createElement('div', { className: 'wp-gpt-social-quote' }, [
                createElement('p', {}, quote),
                createElement(Button, { isSecondary: true, onClick: tweetQuote }, 'Tweet this'),
            ])
        )
    );
     } catch (error) {
        console.error('Error in Social Quote block:', error);
    }
},
    save() {
        const blockProps = useBlockProps.save();
        return createElement('div', blockProps, createElement(InnerBlocks.Content));
    },
});
