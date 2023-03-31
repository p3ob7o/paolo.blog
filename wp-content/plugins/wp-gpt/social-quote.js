const { registerBlockType } = wp.blocks;
const { useSelect } = wp.data;
const { useState, useEffect } = wp.element;
const { RichText } = wp.editor;
const { Button } = wp.components;

registerBlockType('wp-gpt/social-quote', {
    title: 'Social Quote',
    icon: 'twitter',
    category: 'common',
    attributes: {
        quote: {
            type: 'string',
            default: '',
        },
    },

    edit: (props) => {
        const { attributes, setAttributes } = props;
        const [isLoading, setIsLoading] = useState(false);

        const contentBefore = useSelect((select) => {
            const blocks = select('core/block-editor').getBlocks();
            const currentBlockIndex = blocks.findIndex((block) => block.clientId === props.clientId);

            const content = blocks
                .slice(0, currentBlockIndex)
                .map((block) => block.attributes.content || '')
                .join('\n');

            return content;
        }, []);

        useEffect(() => {
            if (!attributes.quote && contentBefore) {
                setIsLoading(true);

                const prompt = "As a social content expert creator, extract the best quote from the provided text. 'Best quote' means the one more likely to drive readers to want to read the content if they were to see the quote on Twitter. Limit the quote to 200 characters maximum";
                const input = {
                    prompt: prompt,
                    context: contentBefore,
                };

                fetch(pluginDirUrl + 'proxy.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(input),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        const quote = data.choices[0].text.trim();
                        setAttributes({ quote: quote });
                        setIsLoading(false);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        setIsLoading(false);
                    });
            }
        }, [contentBefore]);

        const tweetQuote = () => {
            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(attributes.quote)}`;
            window.open(url, '_blank');
        };

        return (
            <div className={props.className}>
                <RichText.Content tagName="blockquote" value={attributes.quote} />
                {isLoading ? (
                    <p>Loading...</p>
                ) : (
                    <Button isPrimary onClick={tweetQuote}>
                        Tweet this
                    </Button>
                )}
            </div>
        );
    },

const { useBlockProps } = wp.blockEditor;

save: (props) => {
    const blockProps = useBlockProps.save();
    return (
        <div {...blockProps} className="wp-gpt-social-quote">
            <blockquote className="wp-gpt-social-quote">
                {props.attributes.quote}
            </blockquote>
        </div>
    );
},
});
