<?php

use Realtyna\StartUp;
use Realtyna\Tests\mocks\MockComponent;

/**
 * Class StartUpTest
 *
 * Contains tests for the StartUp class.
 */
class StartUpTest extends WP_UnitTestCase {
    /**
     * @var StartUp A mock instance of the StartUp class.
     */
    private $main;

    /**
     * Set up the test environment.
     */
    public function setUp(): void {
        parent::setUp();

        // Include the MockComponent class
        require_once __DIR__ . '/mocks/MockComponent.php';

        // Create a mock Main class extending StartUp
        $this->main = new class extends StartUp {
            protected function components() {
                // Add a test component
                $this->addComponent(MockComponent::class);
            }
        };
    }

    /**
     * Test if constructor hooks are added correctly.
     */
    public function test_constructor() {
        $this->assertTrue(has_action('init', [$this->main, 'init']) !== false);
        $this->assertTrue(has_action('admin_init', [$this->main, 'admin_init']) !== false);
    }

    /**
     * Test if a component can be added successfully.
     */
    public function test_add_component() {
        $components = $this->main->getComponents();
        $this->assertCount(1, $components);
        $this->assertEquals(MockComponent::class, $components[0]);
    }
}
