<?php

class DB_Pgsql_Type_Row extends DB_Pgsql_Type_Abstract_Container
{
	private $_items;

	private $_notNull = false;

	public function __construct(array $items, $notNull = false)
	{
	    if (count($items) == 0) {
	        throw new DB_Pgsql_Type_Exception_Common($this, "__construct", "array must have more than zero items", $items);
	    }

	    $this->_items = $items;

	    $this->_notNull = $notNull;

		$this->_init();
	}

	public function getItems()
	{
	    return $this->_items;
	}

    public function output($value)
    {
        if ($value === null && !$this->_notNull) {
            return null;
        }

        if (is_object($value)) {
            $value = (array) $value;
        }

        if (!is_array($value) && $value !== null) {
            throw new DB_Pgsql_Type_Exception_Common($this, "output", "row or null", $value);
        }

        $parts = array();

        foreach ($this->_items as $field => $type) {
            $v = $type->output(isset($value[$field]) ? $value[$field] : null);
            if ($v === null) {
                $parts[] = '';
            } else {
            	// ROW() doubles ["] and [\] characters: src\backend\adt\rowtypes.c
                $parts[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'), $v) . '"';
            }

        }
        return '(' . join(",", $parts) . ')';
    }

    protected function _parseInput($str, &$p)
    {
        reset($this->_items);
    	$result = array();
    	$m = null;

        // Leading "(".
        $c = $this->_charAfterSpaces($str, $p);
        if ($c != '(') {
            throw new DB_Pgsql_Type_Exception_Common($this, "input", "start of a row '('", $str, $p);
        }
        $p++;

        // Check for immediate trailing ')'.
        $c = $this->_charAfterSpaces($str, $p);
        if ($c == ')') {
            list ($field,) = each($this->_items);
            if (count($this->_items) > 1) {
                // '()' literal for ROW(a,b) is bogus.
                throw new DB_Pgsql_Type_Exception_Common($this, "input", "field '$field' value", $str, $p);
            } else {
                // '()' literal for ROW(a) is acceptable.
                $result[$field] = null;
            }
            $p++;
            return $result;
        }

        // Row may contain:
        // - "-quoted strings (escaping: ["] is doubled)
        // - unquoted strings (before first "," or ")")
        // - empty string (it is treated as NULL)
        // Nested rows and all other things are represented as strings.
        while (1) {
        	// We read a value in this iteration, then - delimiter.
            $c = $this->_charAfterSpaces($str, $p);

            // Check if we have more fields left.
            if (!(list ($field, $type) = each($this->_items))) {
            	throw new DB_Pgsql_Type_Exception_Common($this, "input", "end of the row: no more fields left", $str, $p);
            }

            // Always read a next element value.
            if ($c == ',' || $c == ')') {
            	// Comma or end of row instead of value: treat as NULL.
            	$result[$field] = null;
            } else if ($c != '"') {
                // Unquoted string. NULL here is treated as "NULL" string, but NOT as a null value!
               	$len = strcspn($str, ",)", $p);
	           	$v = call_user_func(self::$_substr, $str, $p, $len);
                $result[$field] = $type->input($v);
	           	$p += $len;
	        } else if (preg_match('/" ((?' . '>[^"]+|"")*) "/Asx', $str, $m, 0, $p)) {
                // Quoted string.
               	$v = str_replace(array('""', '\\\\'), array('"', '\\'), $m[1]);
               	$result[$field] = $type->input($v);
	            $p += call_user_func(self::$_strlen, $m[0]);
	        } else {
                // Error.
                throw new DB_Pgsql_Type_Exception_Common($this, "input", "balanced quoted or unquoted string", $str, $p);
	        }

	        // Delimiter or the end of row.
            $c = $this->_charAfterSpaces($str, $p);
            if ($c == ',') {
            	$p++;
            	continue;
            } else if ($c == ')') {
            	$p++;
            	break;
            } else {
                throw new DB_Pgsql_Type_Exception_Common($this, "input", "delimiter ',' or ')'", $str, $p);
            }
        }

        return $result;
    }
}