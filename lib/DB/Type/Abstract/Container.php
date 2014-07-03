<?php
/**
 * Container (composite) type.
 * Consists of elements of sime other type.
 *
 * Examples: Array, Row, Hstore.
 */
abstract class DB_Type_Abstract_Container extends DB_Type_Abstract_Base
{
    protected $_item;
    protected static $_substr = null;
    protected static $_strlen = null;

    public function __construct(DB_Type_Abstract_Base $item = null)
    {
        $this->_item = $item;
    }

    /**
     * Inits some constants.
     *
     * @return void
     */
    public static function _init()
    {
        self::$_substr = function_exists('mb_orig_substr')? 'mb_orig_substr' : 'substr';
        self::$_strlen = function_exists('mb_orig_strlen')? 'mb_orig_strlen' : 'strlen';
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
        return call_user_func(self::$_substr, $str, $p, 1);
    }
    
    /**
     * Parse a native value into PHP variable.
     * Throws exception if parsing process is finished
     * before the string is ended.
     *
     * @param string $native
     * @param bool $ignoreInputTail
     * @return mixed
     * @throws DB_Type_Exception_Common
     */
    public function input($native, $ignoreInputTail = false)
    {
        if ($native === null) {
            return null;
        }
        $pos = 0;
        $value = $this->_parseInput($native, $pos);
        if (!$ignoreInputTail && $pos != call_user_func(self::$_strlen, $native)) {
            throw new DB_Type_Exception_Common($this, "input", "end of string", $native, $pos);
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
}

// We initialize static constants here, because we want it to be
// done only once (e.g. for a case when we store pre-created
// DB_Type objects in APC cache via apc_store()).
DB_Type_Abstract_Container::_init();
