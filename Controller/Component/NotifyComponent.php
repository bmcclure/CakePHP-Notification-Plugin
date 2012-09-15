<?php
App::uses('Component', 'Controller');

/**
 *
 */
class NotifyComponent extends Component {
	/**
	 * @var Controller
	 */
	protected $_controller;

	/**
	 * @var array
	 */
	//protected $_notifications = array();

	/**
	 * @var array
	 */
	public $defaults = array(
		//'notificationsVar' => 'menus',
		'class' => 'notification closeable',
		'messageWrapper' => '<p>%s</p>'
	);

	public $types = array(
		'flash',
	);

	public $classes = array(
		'success' => 'success',
		'error' => 'error',
		'warning' => 'warning',
		'tip' => 'tip',
		'neutral' => 'neutral',
	);

	/**
	 * Constructor
	 *
	 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
	 * @param array $settings Array of configuration settings.
	 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->_controller = $collection->getController();

		$settings = array_merge($this->defaults, $settings);

		parent::__construct($collection, $settings);
	}

	/**
	 * @param Controller $controller
	 */
	public function beforeRender(Controller $controller) {
		//$controller->View->{$this->settings['menusVar']} = $this->getMenus();
		//$controller->set($this->settings['menusVar'], $this->getMenus());
	}

	public function message($type, $message, $class = 'neutral') {
		if (!in_array($type, $this->types)) {
			return false;
		}

		if (!is_string($class)) {
			$class = "";
		}

		$class = "{$this->settings['class']} $class";

		switch ($type) {
			case 'flash':
				$this->_controller->Session->setFlash(sprintf($this->settings['messageWrapper'], $message), 'default', array('class' => $class));
				return true;
		}

		// Support additional types registered by user somehow...
		return false;
	}

	public function flash($message, $class = 'neutral') {
		return $this->message('flash', $message, $class);
	}
}

?>