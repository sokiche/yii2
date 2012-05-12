<?php
/**
 * Action class file.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2012 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

/**
 * Action is the base class for all controller action classes.
 *
 * Action provides a way to divide a complex controller into
 * smaller actions in separate class files.
 *
 * Derived classes must implement a method named `run()`. This method
 * will be invoked by the controller when the action is requested.
 * The `run()` method can have parameters which will be filled up
 * with user input values automatically according to their names.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Action extends Component
{
	/**
	 * @var string ID of the action
	 */
	public $id;
	/**
	 * @var Controller the controller that owns this action
	 */
	public $controller;

	/**
	 * @param string $id the ID of this action
	 * @param Controller $controller the controller that owns this action
	 */
	public function __construct($id, $controller)
	{
		$this->id = $id;
		$this->controller = $controller;
	}

	/**
	 * Runs this action with the specified parameters.
	 * This method is mainly invoked by the controller.
	 * @param array $params action parameters
	 * @return integer the exit status (0 means normal, non-zero means abnormal).
	 */
	public function runWithParams($params)
	{
		$method = new \ReflectionMethod($this, 'run');
		$params = \yii\util\ReflectionHelper::bindParams($method, $params);
		if ($params === false) {
			$this->controller->invalidActionParams($this);
			return 1;
		} else {
			return (int)$method->invokeArgs($this, $params);
		}
	}
}