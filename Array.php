<?php

class DB_Pgsql_Type_Array extends DB_Pgsql_Type_Abstract_Container
{
    public function output($value)
    {
        if ($value === null) {
            return null;
        }
    	if (!is_array($value) && !($value instanceof IteratorAggregate)) {
            throw new DB_Pgsql_Type_Exception_Common($this, "output", "PHP-array or null", $value);
        }
        $parts = array();
        foreach ($value as $v) {
            $inner = $this->_item->output($v);
        	if ($inner === null) {
                $parts[] = 'NULL';
            } else {
            	// ARRAY() adds a slash before ["] and [\] only: src\backend\utils\adt\arrayfuncs.c
                $parts[] = (($this->_item instanceof self)? $inner : '"' . addcslashes($inner, "\"\\") . '"');
            }
        }
        return '{' . join(",", $parts) . '}';
    }

    protected function _parseInput($str, &$p)
    {
        $result = array();

        // Leading "{".
        $c = $this->_charAfterSpaces($str, $p);
        if ($c != '{') {
            throw new DB_Pgsql_Type_Exception_Common($this, "input", "'{'", $str, $p);
        }
        $p++;

        // Array may contain:
        // - "-quoted strings
        // - unquoted strings (before first "," or "}")
        // - sub-arrays
        while (1) {
            $c = $this->_charAfterSpaces($str, $p);

            // End of array.
            if ($c == '}') {
                $p++;
                break;
            }

            // Next element.
            if ($c == ',') {
                $p++;
                continue;
            }

            // Sub-array.
            if ($c == '{') {
            	if (!($this->_item instanceof DB_Pgsql_Type_Array)) {
            		throw new DB_Pgsql_Type_Exception_Common($this, "input", "scalar value", $str, $p);
            	}
                $result[] = $this->_item->_parseInput($str, $p);
                continue;
            }

            // Unquoted string.
            if ($c != '"') {
            	$len = strcspn($str, ",}", $p);
            	$v = stripcslashes(call_user_func(self::$_substr, $str, $p, $len));
            	if (!strcasecmp($v, "null")) {
            		$result[] = null;
            	} else {
                    $result[] = $this->_item->input($v);
            	}
            	$p += $len;
                continue;
            }

            // Quoted string.
            $m = null;
            if (preg_match('/" ((?' . '>[^"\\\\]+|\\\\.)*) "/Asx', $str, $m, 0, $p)) {
                $result[] = $this->_item->input(stripcslashes($m[1]));
                $p += call_user_func(self::$_strlen, $m[0]);
                continue;
            }

            // Error.
            throw new DB_Pgsql_Type_Exception_Common($this, "input", "balanced quoted or unquoted string or sub-array", $str, $p);
        }

        return $result;
    }
}