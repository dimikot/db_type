<?php
abstract class DB_Type_Abstract_Base
{
    /**
     * Convert PHP variable to a native format.
     *
     * @param mixed $value
     * @return string
     */
    abstract public function output($value);

	/**
	 * Parse a native value into PHP variable.
	 * Throws exception if parsing process is finished
	 * before the string is ended.
	 *
	 * @param string $native
	 * @param string $for used for input customization in user defined descendant classes
	 * @return mixed
	 */
    abstract public function input($native, $for='');

    /**
     * Return native type name for this value.
     *
     * @return string
     */
    abstract public function getNativeType();

	public function getEmpty()
	{
		return null;
	}
}
