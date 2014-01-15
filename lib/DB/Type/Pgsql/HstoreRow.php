<?php

class DB_Type_Pgsql_HstoreRow extends DB_Type_Pgsql_Hstore
{
    private $_items;

    public function __construct(array $items)
    {
        $this->_items = $items;
        parent::__construct(new DB_Type_String());
    }

    public function output($value)
    {
        if (is_array($value)) {
            $newValue = array();
            foreach ($value as $key => $v) {
                if (isset($this->_items[$key])) {
                    $newValue[$key] = $this->_items[$key]->output($v);
                }
            }
            $value = $newValue;
        }

        return parent::output($value);
    }

    protected function _parseInput($str, &$p)
    {
        $result = parent::_parseInput($str, $p);
        foreach ($result as $key => $v) {
            if (isset($this->_items[$key])) {
                $result[$key] = $this->_items[$key]->input($v);
            } else {
                // Extra column in hstore must not break the program execution!
                $result[$key] = null;
                //throw new DB_Type_Exception_Common($this, "input", "unexpected key", $key);
            }
        }

        return $result;
    }
    
    public function getNativeType()
    {
        return 'hstore';
    }    
}