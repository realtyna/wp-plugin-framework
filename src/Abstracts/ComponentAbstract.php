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
    /**
     * @var array List of subcomponent class names.
     */
    protected array $subComponents = [];

    /**
     * @var array List of admin page class names.
     */
    protected array $adminPages = [];

    /**
     * @var array List of custom post type class names.
     */
    protected array $postTypes = [];

    /**
     * @var array List of AJAX handler class names.
     */
    protected array $ajaxHandlers = [];

    /**
     * @var array List of shortcode class names.
     */
    protected array $shortcodes = [];

    /**
     * @var array List of REST API endpoint class names.
     */
    protected array $restApiEndpoints = [];

    /**
     * @var array List of widget class names.
     */
    protected array $widgets = [];

    /**
     * @var array List of custom taxonomy class names.
     */
    protected array $customTaxonomies = [];


    // TODO
    //      Add the Following Abstract and Support them here
    //      CronJobAbstract
    //      CustomCapabilityAbstract
    //      CustomRewriteRuleAbstract
    /**
     * ComponentAbstract constructor.
     *
     * Initializes the component by calling methods to define and register post types,
     * subcomponents, admin pages, AJAX handlers, and shortcodes.
     *
     * @throws \ReflectionException
     */
    // In the constructor, add a call to registerRestApiEndpoints
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
        $this->registerAdminPages();
        $this->registerPostTypes();
        $this->registerSubComponents();
        $this->registerAjaxHandlers();
        $this->registerShortcodes();
        $this->registerRestApiEndpoints();
        $this->registerWidgets();
        $this->registerCustomTaxonomies();
        $this->register();
    }

    /**
     * Registers the component, including any additional functionality that needs to be
     * implemented by the subclass.
     *
     * @return void
     */
    abstract public function register(): void;

    /**
     * Defines the custom post types that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function postTypes(): void;

    /**
     * Defines the subcomponents that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function subComponents(): void;

    /**
     * Defines the admin pages that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function adminPages(): void;

    /**
     * Defines the AJAX handlers that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function ajaxHandlers(): void;

    /**
     * Defines the shortcodes that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function shortcodes(): void;

    /**
     * Defines the REST API endpoints that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function restApiEndpoints(): void;

    /**
     * Defines the widgets that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function widgets(): void;


    /**
     * Defines the custom taxonomies that the component should register.
     * This method must be implemented by the subclass.
     *
     * @return void
     */
    abstract public function customTaxonomies(): void;

    /**
     * Adds an admin page to the component.
     *
     * @param string $adminPage The class name of the admin page to add.
     * @return void
     */
    public function addAdminPage(string $adminPage): void
    {
        $this->adminPages[] = $adminPage;
    }

    /**
     * Registers all admin pages associated with the component.
     *
     * @return void
     */
    private function registerAdminPages(): void
    {
        foreach ($this->adminPages as $adminPage) {
            $service = new $adminPage();
            if ($service instanceof AdminPageAbstract && method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Adds a custom post type to the component.
     *
     * @param string $postType The class name of the post type to add.
     * @return void
     */
    public function addPostType(string $postType): void
    {
        $this->postTypes[] = $postType;
    }

    /**
     * Registers all custom post types associated with the component.
     *
     * @return void
     */
    private function registerPostTypes(): void
    {
        foreach ($this->postTypes as $postType) {
            $service = new $postType();
            add_action('after_setup_theme', [$service, 'register']);
        }
    }

    /**
     * Adds a subcomponent to the component.
     *
     * @param string $subComponent The class name of the subcomponent to add.
     * @return void
     */
    public function addSubComponent(string $subComponent): void
    {
        $this->subComponents[] = $subComponent;
    }

    /**
     * Registers all subcomponents associated with the component.
     *
     * @return void
     * @throws \ReflectionException
     */
    private function registerSubComponents(): void
    {
        foreach ($this->subComponents as $subComponent) {
            $service = new $subComponent();
            if ($service instanceof ComponentAbstract && method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Adds an AJAX handler to the component.
     *
     * @param string $ajaxHandler The class name of the AJAX handler to add.
     * @return void
     */
    public function addAjaxHandler(string $ajaxHandler): void
    {
        $this->ajaxHandlers[] = $ajaxHandler;
    }

    /**
     * Registers all AJAX handlers associated with the component.
     *
     * @return void
     */
    private function registerAjaxHandlers(): void
    {
        foreach ($this->ajaxHandlers as $ajaxHandler) {
            $service = new $ajaxHandler();
            if ($service instanceof AjaxHandlerAbstract && method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Adds a shortcode to the component.
     *
     * @param string $shortcode The class name of the shortcode to add.
     * @return void
     */
    public function addShortcode(string $shortcode): void
    {
        $this->shortcodes[] = $shortcode;
    }

    /**
     * Registers all shortcodes associated with the component.
     *
     * @return void
     */
    private function registerShortcodes(): void
    {
        foreach ($this->shortcodes as $shortcode) {
            $service = new $shortcode();
            if ($service instanceof ShortcodeAbstract && method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Adds a REST API endpoint to the component.
     *
     * @param string $restApiEndpoint The class name of the REST API endpoint to add.
     * @return void
     */
    public function addRestApiEndpoint(string $restApiEndpoint): void
    {
        $this->restApiEndpoints[] = $restApiEndpoint;
    }

    /**
     * Registers all REST API endpoints associated with the component.
     *
     * @return void
     */
    private function registerRestApiEndpoints(): void
    {
        foreach ($this->restApiEndpoints as $restApiEndpoint) {
            new $restApiEndpoint();
        }
    }

    /**
     * Adds a widget to the component.
     *
     * @param string $widget The class name of the widget to add.
     * @return void
     */
    public function addWidget(string $widget): void
    {
        $this->widgets[] = $widget;
    }

    /**
     * Registers all widgets associated with the component.
     *
     * @return void
     */
    private function registerWidgets(): void
    {
        foreach ($this->widgets as $widget) {
            new $widget();
            // The widget will automatically register itself via the constructor in WidgetAbstract
        }
    }

    /**
     * Adds a custom taxonomy to the component.
     *
     * @param string $customTaxonomy The class name of the custom taxonomy to add.
     * @return void
     */
    public function addCustomTaxonomy(string $customTaxonomy): void
    {
        $this->customTaxonomies[] = $customTaxonomy;
    }

    /**
     * Registers all custom taxonomies associated with the component.
     *
     * @return void
     */
    private function registerCustomTaxonomies(): void
    {
        foreach ($this->customTaxonomies as $customTaxonomy) {
            $service = new $customTaxonomy();
            if ($service instanceof CustomTaxonomyAbstract) {
                add_action('init', [$service, 'registerTaxonomy']);
            }
        }
    }
}
