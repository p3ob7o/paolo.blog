/**
 * File: block-script.js
 * This script handles the block's behavior on the front-end.
 */

jQuery(document).ready(function($) {
    // When the button is clicked.
    $('.night-and-day-toggle').click(function() {
        // Get the current body class.
        var currentClass = $('body').attr('class');

        // Get the styles from the button's data attributes.
        var styleOne = $(this).data('style-one');
        var styleTwo = $(this).data('style-two');

        // If the current class is style one, switch to style two.
        if (currentClass === styleOne) {
            $('body').removeClass(styleOne);
            $('body').addClass(styleTwo);
        }
        // If the current class is style two, switch to style one.
        else if (currentClass === styleTwo) {
            $('body').removeClass(styleTwo);
            $('body').addClass(styleOne);
        }
        // If the current class is neither style one nor style two, set to style one.
        else {
            $('body').addClass(styleOne);
        }
    });
});
