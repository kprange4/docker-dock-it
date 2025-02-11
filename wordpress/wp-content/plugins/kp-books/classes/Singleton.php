<?php

namespace KP\BookPlugin;

abstract class Singleton {
	/** Static property to hold singleton instance */
	protected static $instance;

	/**
	 * This is the constructor
	 *
	 * @return void
	 */
	abstract protected function __construct();

	/**
	 * Prevents cloning
	 *
	 * @return void
	 */
	private function __clone(){}

	/** If an instance exists, this returns it.  If not, it creates one and returns it. */
	public static function getInstance() {
		if (!static::$instance )
			static::$instance = new static;
		return static::$instance;

	}
}