<?php

namespace Realtyna\Core\Abstracts;

/**
 * Class ComponentAbstract
 *
 * A base class for components in the Realtyna plugin.
 * This class handles the registration of subcomponents, admin pages, custom post types, AJAX handlers, and shortcodes.
 */
abstract class ComponentAbstract
{
    protected array $subComponents = [];
    protected array $adminPages = [];
    protected array $postTypes = [];
    protected array $ajaxHandlers = [];
    protected array $shortcodes = [];
    protected array $restApiEndpoints = [];
    protected array $widgets = [];
    protected array $customTaxonomies = [];
    protected array $adminNotices = [];

    public function __construct()
    {
        $this->postTypes();
        $this->subComponents();
        $this->adminPages();
        $this->ajaxHandlers();
        $this->shortcodes();
        $this->restApiEndpoints();
        $this->widgets();
        $this->customTaxonomies();

        add_action('admin_notices', [$this, 'displayAdminNotices']);
    }

    public function register(): void
    {
    }

    public function postTypes(): void
    {
    }

    public function subComponents(): void
    {
    }

    public function adminPages(): void
    {
    }

    public function ajaxHandlers(): void
    {
    }

    public function shortcodes(): void
    {
    }

    public function restApiEndpoints(): void
    {
    }

    public function widgets(): void
    {
    }

    public function customTaxonomies(): void
    {
    }

    public function addAdminPage(string $adminPageClass): void
    {
        $this->adminPages[] = $adminPageClass;
        $service = new $adminPageClass();
        if ($service instanceof AdminPageAbstract && method_exists($service, 'register')) {
            $service->register();
        }
    }

    public function addPostType(string $postTypeClass): void
    {
        $this->postTypes[] = $postTypeClass;
        $service = new $postTypeClass();
        add_action('after_setup_theme', [$service, 'register']);
    }

    public function addSubComponent(string $subComponentClass): void
    {
        $this->subComponents[] = $subComponentClass;
        $service = new $subComponentClass();
        if ($service instanceof ComponentAbstract && method_exists($service, 'register')) {
            $service->register();
        }
    }

    public function addAjaxHandler(string $ajaxHandlerClass): void
    {
        $this->ajaxHandlers[] = $ajaxHandlerClass;
        $service = new $ajaxHandlerClass();
        if ($service instanceof AjaxHandlerAbstract && method_exists($service, 'register')) {
            $service->register();
        }
    }

    public function addShortcode(string $shortcodeClass): void
    {
        $this->shortcodes[] = $shortcodeClass;
        $service = new $shortcodeClass();
        if ($service instanceof ShortcodeAbstract && method_exists($service, 'register')) {
            $service->register();
        }
    }

    public function addRestApiEndpoint(string $restApiEndpointClass): void
    {
        $this->restApiEndpoints[] = $restApiEndpointClass;
        new $restApiEndpointClass(); // Instantiate directly if there's no need to call register.
    }

    public function addWidget(string $widgetClass): void
    {
        $this->widgets[] = $widgetClass;
        new $widgetClass(); // Instantiate directly for WordPress widget system.
    }

    public function addCustomTaxonomy(string $customTaxonomyClass): void
    {
        $this->customTaxonomies[] = $customTaxonomyClass;
        $service = new $customTaxonomyClass();
        if ($service instanceof CustomTaxonomyAbstract) {
            add_action('init', [$service, 'registerTaxonomy']);
        }
    }

    /**
     * Adds an admin notice to be displayed in the WordPress admin area.
     *
     * @param string $message The message to be displayed in the notice.
     * @param string $type The type of notice ('success', 'warning', 'error', 'info'). Defaults to 'info'.
     * @return void
     */
    public function addAdminNotice(string $message, string $type = 'info'): void
    {
        $this->adminNotices[] = [
            'message' => $message,
            'type' => $type
        ];
    }

    /**
     * Displays the registered admin notices in the WordPress admin area.
     *
     * @return void
     */
    public function displayAdminNotices(): void
    {
        foreach ($this->adminNotices as $notice) {
            $class = "notice notice-{$notice['type']}";
            echo "<div class=\"{$class}\"><p>{$notice['message']}</p></div>";
        }
    }
}
