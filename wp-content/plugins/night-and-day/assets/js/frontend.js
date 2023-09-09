document.addEventListener( 'DOMContentLoaded', function() {
    var buttons = document.querySelectorAll( '.toggle-button' );

    buttons.forEach( function( button ) {
        button.addEventListener( 'click', function() {
            var parentDiv = button.parentElement;
            if ( parentDiv.classList.contains( 'style1' ) ) {
                parentDiv.classList.remove( 'style1' );
                parentDiv.classList.add( 'style2' );
            } else {
                parentDiv.classList.remove( 'style2' );
                parentDiv.classList.add( 'style1' );
            }
        } );
    } );
} );
