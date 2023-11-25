const { addFilter } = wp.hooks;
const { __ } = wp.i18n;
const { createElement } = wp.element;

addFilter('blocks.registerBlockType', 'my-plugin/extend-social-icons-block', (settings, name) => {
    if (name !== 'core/social-link') {
        return settings;
    }

    const newIcon = {
        name: 'gravatar',
        title: __('Gravatar'),
        icon: createElement('svg', { width: 24, height: 24, viewBox: "0 0 24 24", xmlns: "http://www.w3.org/2000/svg", 'aria-hidden': true, focusable: false }, 
            createElement('path', { d: "M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Zm0-14a6,6,0,1,0,6,6A6,6,0,0,0,12,6Z" })
        ),
    };

    return {
        ...settings,
        exampleVariations: [...settings.exampleVariations, newIcon],
    };
});