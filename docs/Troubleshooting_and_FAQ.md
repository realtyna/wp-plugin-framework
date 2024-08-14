# Troubleshooting and FAQ

Welcome to the Troubleshooting and FAQ section for the Realtyna Base Plugin framework. This section is designed to help you resolve common issues and answer frequently asked questions as you work with the framework.

## FAQ

**Note:** This is a new plugin framework, and there is currently no FAQ available. As the community grows and common questions arise, this section will be updated with answers to the most frequently asked questions.

If you have a question or encounter an issue that is not covered here, please feel free to open an issue on our GitHub repository, and we'll be happy to assist you.

[Open an Issue on GitHub](https://github.com/realtyna/wp-plugin-framework/issues)

## Troubleshooting

### Common Issues and Solutions

#### 1. Plugin Activation Fails

If your plugin fails to activate, it's often due to a syntax error or missing dependency. Check the following:

- Ensure all required files are included in your plugin.
- Review your PHP code for syntax errors.
- Verify that any required PHP extensions are installed and enabled.

You can enable debugging in WordPress to get more detailed error messages by adding the following to your `wp-config.php` file:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

After enabling debugging, check the `wp-content/debug.log` file for any error messages that can help diagnose the issue.

#### 2. Admin Pages Not Displaying Correctly

If your custom admin pages are not displaying correctly:

- Ensure that the paths to your template files are correct.
- Verify that the `enqueuePageAssets()` method in your `AdminPageAbstract` implementation is properly enqueuing styles and scripts.
- Make sure that you have the correct user permissions to access the admin page.

#### 3. AJAX Requests Not Working

If your AJAX requests are not functioning as expected:

- Verify that the `getAction()` method in your `AjaxHandlerAbstract` implementation returns the correct action name.
- Check the browser console for any JavaScript errors that may indicate issues with the AJAX request.
- Ensure that the AJAX action is correctly registered in WordPress using the `wp_ajax_{action}` or `wp_ajax_nopriv_{action}` hooks.

#### 4. REST API Endpoints Returning Errors

If your custom REST API endpoints are returning errors:

- Confirm that your routes are registered correctly in the `registerRoutes()` method.
- Check the request permissions using the `permission_callback` parameter to ensure that users have the necessary capabilities to access the endpoint.
- Use the WordPress REST API console (available as a browser extension) to test and debug your endpoints.

#### 5. Logger Not Writing to File

If the logger is not writing to the log file:

- Ensure that the log file path specified in the `Log::init()` method is correct and writable.
- Check the file permissions of the log directory and ensure that the web server has write access.
- Verify that the log level set in `Log::init()` is not higher than the log messages you are trying to write (e.g., setting the log level to 'error' will ignore 'debug' messages).

## Getting Help

If you're unable to resolve an issue using the troubleshooting steps provided above, or if you encounter a problem that isn't covered here, please don't hesitate to reach out.

You can open an issue on our GitHub repository, and our team or the community will assist you:

[Open an Issue on GitHub](https://github.com/realtyna/wp-plugin-framework/issues)

We appreciate your feedback and contributions, as they help us improve the framework and address any issues you may encounter.
