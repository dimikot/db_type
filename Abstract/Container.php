<?php
/**
 * Container (composite) type.
 * Consists of elements of sime other type.
 *
 * Examples: Array, Row, Hstore.
 */
abstract class DB_Pgsql_Type_Abstract_Container extends DB_Pgsql_Type_Abstract_Base
{
    protected $_item;
    
    public function __construct(DB_Pgsql_Type_Abstract_Base $item)
    {
        $this->_item = $item;
    }
	
	/**
	 * Move $p to skip spaces from position $p of the string.
	 * Return next non-space character at position $p or
	 * false at the string end.
	 *
	 * @param string $str
	 * @param int $p
	 * @return string
	 */
	protected function _charAfterSpaces($str, &$p)
	{
        $p += strspn($str, " \t\r\n", $p);
        return self::substr($str, $p, 1);
	}
	
    /**
     * Parse a native value into PHP variable.
     * Throws exception if parsing process is finished
     * before the string is ended.
     *
     * @param string $native
     * @return mixed
     */
    public function input($native)
    {
    	if ($native === null) {
    		return null;
    	}
        $pos = 0;
        $value = $this->_parseInput($native, $pos);
        if ($pos != self::strlen($native)) {
            throw new DB_Pgsql_Type_Exception_Common($this, "input", "end of string", $native, $pos);
        }
        return $value;
    }	

    /**
     * Parse a native value into PHP variable from position $pos.
     * Parameter $pos is set to the next character after the 
     * parsed data.  This method is used from within other
     * types.
     *
     * @param string $native
     * @param int $pos
     * @return mixed
     */
    abstract protected function _parseInput($native, &$pos);

    /**
     * This is an always-binary function, no mater if mbstring
     * overloading is active or not.
     *
     * @return mixed
     */
    public static function substr()
    {
    	$args = func_get_args();
    	if (extension_loaded('mbstring') && (ini_get('mbstring.func_overload') & 2)) {
    		return call_user_func_array('mb_orig_' . __FUNCTION__, $args);
    	} else {
            return call_user_func_array(__FUNCTION__, $args);
    	}
    }

    /**
     * This is an always-binary function, no mater if mbstring
     * overloading is active or not.
     *
     * @return mixed
     */
    public static function strlen()
    {
        $args = func_get_args();
        if (extension_loaded('mbstring') && (ini_get('mbstring.func_overload') & 2)) {
            return call_user_func_array('mb_orig_' . __FUNCTION__, $args);
        } else {
            return call_user_func_array(__FUNCTION__, $args);
        }
    }
}
