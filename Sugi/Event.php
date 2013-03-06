<?php namespace Sugi;
/**
 * @package Sugi
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

use \Sugi\Event\Dispatcher;

/**
 * Facades Sugi\Event\Dispatcher and Sugi\Event\Event for lazy people like me
 *
 * There are 2 basic static methods:
 *  - listen - tells the dispatcher to trigger given callback function when some event occurs
 *  - fire   - creates an event and through the dispatcher notifies all listeners for that event
 */
class Event
{
	protected static $dispatcher = null;

	public static function listen($eventName, $callback)
	{
		if (is_null(static::$dispatcher)) {
			static::$dispatcher = new Dispatcher();
		}
		
		static::$dispatcher->listen($eventName, $callback);
	}

	public static function fire($eventName, array $params = array())
	{
		if (is_null(static::$dispatcher)) {
			static::$dispatcher = new Dispatcher();
		}

		$event = new Event\Event($eventName, $params);
		$event->setDispatcher(static::$dispatcher);

		static::$dispatcher->fire($event);
	}

	public static function hasListeners($eventName)
	{
		if (is_null(static::$dispatcher)) {
			return false;
		}

		$listeners = static::$dispatcher->getListeners($eventName);
		return !empty($listeners);
	}
}
