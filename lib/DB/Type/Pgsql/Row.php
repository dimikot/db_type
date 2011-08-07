<?php

class DB_Type_Pgsql_Row extends DB_Type_Abstract_Container
{
	private $_items;
	private $_nativeType;

	public function __construct(array $items, $nativeType = null)
	{
		$this->_items = $items;
		$this->_nativeType = $nativeType;
		// ROW() has no base item type, so pass null to parent::__construct().
		parent::__construct(null);
	}

	public function getItems()
	{
		return $this->_items;
	}
	
    public function output($value)
    {
        if ($value === null) {
            return null;
        }

        if (is_object($value)) {
            $value = (array) $value;
        }

        if (!is_array($value)) {
            throw new DB_Type_Exception_Common($this, "output", "row or null", $value);
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
            throw new DB_Type_Exception_Common($this, "input", "start of a row '('", $str, $p);
        }
        $p++;

        // Check for immediate trailing ')'.
        $c = $this->_charAfterSpaces($str, $p);
        if ($c == ')') {
        	if (list ($field,) = each($this->_items)) {
                throw new DB_Type_Exception_Common($this, "input", "field '$field' value", $str, $p);
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
            	throw new DB_Type_Exception_Common($this, "input", "end of the row: no more fields left", $str, $p);
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
                throw new DB_Type_Exception_Common($this, "input", "balanced quoted or unquoted string", $str, $p);
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
                throw new DB_Type_Exception_Common($this, "input", "delimiter ',' or ')'", $str, $p);
            }
        }

        return $result;
    }
    
	public function getNativeType()
    {
    	return $this->_nativeType;
    }
}