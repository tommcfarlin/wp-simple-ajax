/**
 * This file is responsible for setting up the Ajax request each time
 * a WordPress page is loaded. The page could be the main index page,
 * a single page, or any other type of information that WordPress renders.
 *
 * Once the DOM is ready, it will make an Ajax call to the server where
 * the `get_current_user_info` function is defined and will then handle the
 * response based on the information returned from the request.
 *
 * @since    1.0.0
 */
;(function( $ ) {
	'use strict';

	$(function() {

		/* Make an Ajax call via a GET request to the URL specified in the
		 * wp_enqueue_script call. For the data parameter, pass an object with
		 * the action name of the function we defined to return the user info.
		 */
		$.ajax({

			url:    sa_demo.ajax_url,
			method: 'GET',
			data:   { action: 'get_current_user_info' }

		}).done(function( response ) {

			/* Once the request is done, determine if it was successful or not.
			 * If so, parse the JSON and then render it to the console. Otherwise,
			 * display the content of the failed request to the console.
			 */
			if ( true === response.success ) {

				console.log( JSON.parse( response.data ) );

			} else {

				console.log( response.data );

			}

		});

	});

})( jQuery );