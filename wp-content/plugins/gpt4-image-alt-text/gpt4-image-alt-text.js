const { createHigherOrderComponent } = wp.compose;
const { createElement, Fragment, useState, useEffect } = wp.element;
const { addFilter } = wp.hooks;
const { InspectorControls } = wp.blockEditor;
const { Button, PanelBody } = wp.components;

const addGPT4Button = createHigherOrderComponent((BlockEdit) => {
    return function (props) {
        const [apiKey, setApiKey] = useState(null);

        useEffect(() => {
            async function fetchApiKey() {
                const option = await wp.apiFetch({ path: 'gpt4/v1/get-api-key' });
                setApiKey(option.gpt4_api_key);
            }
            fetchApiKey();
        }, []);

        if (props.name !== 'core/image') {
            return createElement(BlockEdit, props);
        }

        const { attributes: { url, alt }, setAttributes } = props;

        const generateAltText = async () => {
            const description = await getGPT4Description(url);
            setAttributes({ alt: description });
        };

        const buttonLabel = apiKey ? 'Generate Alt Text with GPT-4' : 'Set OpenAI API key';
        const buttonAction = apiKey ? generateAltText : () => window.location.href = '/wp-admin/options-general.php?page=gpt4-image-alt-text';

        return createElement(
            Fragment,
            null,
            createElement(BlockEdit, props),
            createElement(
                InspectorControls,
                null,
                createElement(
                    PanelBody,
                    {
                        title: 'GPT-4 Alt Text',
                        initialOpen: false,
                    },
                    createElement(
                        Button,
                        {
                            isSecondary: true,
                            onClick: buttonAction,
                            disabled: !url,
                            className: 'gpt4-image-alt-text-button',
                        },
                        buttonLabel
                    )
                )
            )
        );
    };
}, 'addGPT4Button');

addFilter(
    'editor.BlockEdit',
    'gpt4-image-alt-text/add-gpt4-button',
    addGPT4Button
);

async function getGPT4Description(imageUrl) {
    const prompt = `Describe the following image in English: ${imageUrl}`;

    const response = await fetch('/wp-content/plugins/gpt4-image-alt-text/proxy.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            prompt: prompt,
            max_tokens: 30,
            n: 1,
            stop: null,
            temperature: 0.8,
        }),
    });

    const data = await response.json();
    alert(`Full API response: ${JSON.stringify(data)}`);
    const description = data.choices && data.choices[0] && data.choices[0].text.trim();
    return description;
}
