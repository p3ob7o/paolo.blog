document.addEventListener( 'DOMContentLoaded', function() {
    var toggleButton = document.getElementById( 'ldst-toggle' );
    if ( toggleButton ) {
        toggleButton.addEventListener( 'click', function() {
            var body = document.body;
            var isDark = body.classList.contains('dark-theme');

            if ( isDark ) {
                body.classList.remove('dark-theme');
                body.classList.add('light-theme');
            } else {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme');
            }
        } );
    }
} );
