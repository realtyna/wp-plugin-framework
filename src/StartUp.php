<?php

namespace Realtyna;

/**
 * Class StartUp
 *
 * Provides a framework for setting up and initializing WordPress plugins.
 *
 * @package Realtyna
 * @version 0.0.1
 */
class StartUp {
    /**
     * @var array List of component classes to load.
     */
    protected array $components = [];

    /**
     * StartUp constructor.
     *
     * Initializes the plugin, sets up WordPress hooks, and loads components.
     */
    public function __construct() {
        // Setup WordPress hooks
        add_action('init', [$this, 'init']);
        add_action('admin_init', [$this, 'admin_init']);

        // Run startup procedures
        $this->startup();
        $this->components();
        $this->load_components();
    }

    /**
     * Method to run any startup code.
     */
    protected function startup() {
        // Initialization code can go here
    }

    /**
     * Method to add components.
     *
     * This method should be overridden in the subclass to add components using addComponent method.
     */
    protected function components() {
        // Example: $this->addComponent(Example::class)
    }

    /**
     * Method to hook into the 'init' action.
     */
    public function init() {
        // Init code
    }

    /**
     * Method to hook into the 'admin_init' action.
     */
    public function admin_init() {
        // Admin init code
    }

    /**
     * Adds a component class to the list of components to load.
     *
     * @param string $component The fully qualified class name of the component.
     * @throws \Exception If the component class does not exist or does not extend Component.
     */
    public function addComponent(string $component): void {
        if (class_exists($component) && is_subclass_of($component, Component::class)) {
            $this->components[] = $component;
        } else {
            throw new \Exception("Invalid component class: $component");
        }
    }

    /**
     * Loads and registers all components.
     */
    protected function load_components(): void {
        foreach ($this->components as $component) {
            $instance = new $component();
            $instance->register();
        }
    }
}
