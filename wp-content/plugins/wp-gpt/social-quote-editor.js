const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InnerBlocks, useBlockProps } = wp.blockEditor;
const { createElement, useState, useEffect } = wp.element;
const { TextControl, Button, Spinner } = wp.components;
const { useSelect, withDispatch } = wp.data;
const apiFetch = wp.apiFetch || wp.api.apiFetch;
const { addQueryArgs } = wp.url;

const EditSocialQuote = withDispatch((dispatch) => {
  return {
    updateBlockAttributes: dispatch("core/block-editor").updateBlockAttributes,
  };
})((props) => {
  const [quote, setQuote] = useState(null);
  const [loading, setLoading] = useState(false);

  const blockProps = useBlockProps();

  const content = useSelect((select) => {
    const blockEditor = select('core/block-editor');
    if (!blockEditor) {
      return '';
    }
    const blocks = blockEditor.getBlocks();
    const contentBlocks = blocks.slice(0, -1);
    return contentBlocks.map((block) => block.originalContent).join('\n');
  }, []);

  useEffect(() => {
    if (!content) {
      return;
    }

    setLoading(true);

    const path = addQueryArgs('/wp-gpt/proxy.php', {});

    fetch('/wp-content/plugins/wp-gpt/proxy.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        prompt: "As a social content expert creator, extract the best quote from the provided text...",
        context: content,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data.choices || data.choices.length === 0) {
          console.error('No choices found in the response data');
          setLoading(false);
          return;
        }
        setLoading(false);
        const assistantMessage = data.choices[0].message.content;
        setQuote(assistantMessage.trim());
        props.setAttributes({ quote: assistantMessage.trim() });

        if (quote) {
          const childBlocks = wp.data
            .select("core/block-editor")
            .getBlock(props.clientId).innerBlocks;
          if (childBlocks.length > 0) {
            const paragraphBlock = childBlocks[0];
            props.updateBlockAttributes(paragraphBlock.clientId, { content: quote });
          }
        }

      })
      .catch((error) => {
        console.error('Fetch error:', error);
        setLoading(false);
      });
  }, [content, quote]);

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
});

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
  save: function (props) {
    const { quote } = props.attributes;
    return createElement(
      "div",
      null,
      createElement(InnerBlocks.Content),
      createElement(Button, {
        isSecondary: true,
        onClick: () => {
          const postId = wp.data.select("core/editor").getCurrentPostId();
          const response = fetch(`/wp-json/wp/v2/posts/${postId}`);
          const post = response.json();
          const permalink = post.link;

          const tweetContent = `${quote}\n${permalink}`;
          const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetContent)}`;
          window.open(tweetUrl, "_blank");
        },
      }, __("Tweet This"))
    );
  },
});
