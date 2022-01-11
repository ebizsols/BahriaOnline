jQuery.ajax( {
    url: wpApiSettings.root + 'wp-json/users/current',
    method: 'POST',
    beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
    },
    data:{
        'title' : 'Hello Moon'
    }
} ).done( function ( response ) {
    console.log( response );
} );