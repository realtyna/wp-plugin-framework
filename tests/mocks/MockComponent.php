<?php
namespace Realtyna\Tests\mocks;

use Realtyna\Component;

/**
 * Class TestComponent
 *
 * A mock component class for testing purposes.
 */
class MockComponent extends Component {
    /**
     * @var bool Indicates whether the component has been registered.
     */
    private $registered = false;

    /**
     * Register the component.
     */
    public function register() {
        $this->registered = true;
    }

    /**
     * Check if the component is registered.
     *
     * @return bool
     */
    public function isRegistered(): bool {
        return $this->registered;
    }
}
