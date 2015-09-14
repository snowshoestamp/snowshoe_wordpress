Snowshoe WordPress
============
The Snowshoe WordPress client submits point data to the Snowshoe API for authentication. The client will return a JSON parsed hash, containing either the serial of the matched stamp (a success!) or an error.

## Dependencies
- Wordpress >=4.x

## Installation
Add the Snowshoe plugin to your Wordpress site by downloading and moving the snowshoe_wordpress folder into your_project/wp-content/plugins, where your site's plugins live.

Via your site's admin panel, navigate to the plugins page and activate the Snowshoe plugin.

## Usage: Setting up the client

The client is largely ready to go, but you need to add your Snowshoe application key and application secret to the client. In your Wordpress editor (or the editor of your choice) open the file located in your_project/wp-content/plugins/snowshoe_wordpress/snowshoestamp.php and you'll see in the ```handle_request``` function a place to put your key and secret.

Now your site has an api endpoint at "yourdomain.com/api/stamp" that you can POST stamp data too.

NOTE: Currently, without over-riding the plugin's default behavior, you should be submitting stamp data via AJAX. See our snowshoe_jquery documentation and download the module (both [here](https://github.com/snowshoestamp/snowshoe_jquery) and [here](https://snowshoe.readme.io/docs/part-1-stamp-screen)) to learn how.

## Contribute
Join us in improving this client by making a pull request.

## License
MIT (see LICENSE file)
