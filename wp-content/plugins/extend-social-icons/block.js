const { addFilter } = wp.hooks;
const { __ } = wp.i18n;

addFilter('blocks.registerBlockType', 'my-plugin/extend-social-icons-block', (settings, name) => {
    if (name !== 'core/social-link') {
        return settings;
    }

    const newIcon = {
        name: 'gravatar',
        title: __('Gravatar'),
        icon: <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M60.77,0A12.15,12.15,0,0,0,48.62,12.15V54.69a12.15,12.15,0,0,0,24.3,0V26.39A36.47,36.47,0,1,1,35,35h0A12.16,12.16,0,0,0,17.8,17.8,60.77,60.77,0,1,0,60.77,0Z"></path></svg>,
    };

    return {
        ...settings,
        exampleVariations: [...settings.exampleVariations, newIcon],
    };
});