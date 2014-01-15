<?php
/**
 * Wrappers which modifies any primitive type or other wrappers.
 * 
 * Examples: Trim, Length (length validator), Numeric etc.
 */
abstract class DB_Type_Abstract_Wrapper extends DB_Type_Abstract_Base
{
    protected $_item;
    
    public function __construct(DB_Type_Abstract_Base $item = null)
    {
        $this->_item = $item? $item : new DB_Type_String();
    }
    
    public final function input($native)
    {
        if ($native === null) {
            return $this->_item->input(null);
        }
        // We call wrapped convertor first, then - self converter, to
        // allow constructions like:
        // - new DB_Type_Wrapper_Trim(new DB_Type_Date()),
        // - new DB_Type_Pgsql_Array(new DB_Type_Date()),
        return $this->_input($this->_item->input($native));
    }
    
    public final function output($value)
    {
        if ($value === null) {
            return $this->_item->output(null);
        }
        // We call self convertor first, then - convertor of a wrapped type, to
        // allow constructions like:
        // - new DB_Type_Wrapper_Trim(new DB_Type_Date()),
        // - new DB_Type_Pgsql_Array(new DB_Type_Date()),
        return $this->_item->output($this->_output($value));
    }
        
    public function getNativeType()
    {
        return $this->_item->getNativeType();
    }
        
    protected abstract function _input($native);
    
    protected abstract function _output($value);
}
