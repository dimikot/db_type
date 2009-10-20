<?php

class DB_Pgsql_Type_HstoreRow extends DB_Pgsql_Type_Hstore
{
    private $_items;

    public function __construct(array $items)
    {
        $this->_items = $items;
        parent::__construct(new DB_Pgsql_Type_String());
    }

    public function output($value)
    {
        if (is_array($value)) {
            $new_value = array();
            foreach ($value as $key => $v) {
                if (isset($this->_items[$key])) {
                    $new_value[$key] = $this->_items[$key]->output($v);
                }
            }
            $value = $new_value;
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
                throw new DB_Pgsql_Type_Exception_Common($this, "input", "UnexpectedKey", $key);
            }
        }

        return $result;
    }
}