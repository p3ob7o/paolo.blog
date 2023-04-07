const EditSocialQuote = (props) => {
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

        const path = addQueryArgs('/wp-gpt/proxy.php', {});
        console.log('Generated path:', path);

        fetch('/wp-content/plugins/wp-gpt/proxy.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                prompt: "As a social content expert creator, extract the best quote from the provided text. 'Best quote' means the one more likely to drive readers to want to read the content if they were to see the quote on Twitter. Limit the quote to 200 characters maximum, and avoid using hashtags",
                context: content,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log('Data received:', data);
                if (!data.choices || data.choices.length === 0) {
                    console.error('No choices found in the response data');
                    setLoading(false);
                    return;
                }
                setLoading(false);
                const assistantMessage = data.choices[0].message.content;
                setQuote(assistantMessage.trim());
                props.setAttributes({ quote: assistantMessage.trim() });
            })
            .catch((error) => {
                console.error('Fetch error:', error);
                setLoading(false);
            });
    }, [content]);

    async function tweetQuote() {
        if (!quote) {
            return;
        }

        const postId = wp.data.select('core/editor').getCurrentPostId();
        const response = await fetch(`/wp-json/wp/v2/posts/${postId}`);
        const post = await response.json();
        const permalink = post.link;

        const tweetContent = `${quote}\n${permalink}`;
        const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetContent)}`;
        window.open(tweetUrl, '_blank');
    }

    return createElement(
        "div",
        blockProps,
        loading
            ? createElement(Spinner)
            : createElement(InnerBlocks, {
                  template: [
                      [
                          "core/paragraph",
                          { content: quote, placeholder: "Generated quote will appear here..." },
                      ],
                  ],
                  templateLock: "all",
              })
    );
};

registerBlockType("wp-gpt/social-quote", {
    apiVersion: 2,
    title: __("Social Quote", "wp-gpt"),
    description: __("A block to generate and display a social quote from the content.", "wp-gpt"),
    category: "widgets",
    icon: "format-quote",
    supports: {
        html: false,
    },
    edit: EditSocialQuote,
    save: function () {
        return createElement(InnerBlocks.Content);
    },
});
