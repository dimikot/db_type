<?php

class DB_Type_Pgsql_Array extends DB_Type_Abstract_Container
{
    public function output($value)
    {
        if ($value === null) {
            return null;
        }
    	if (!is_array($value)) {
            throw new DB_Type_Exception_Common($this, "output", "PHP-array or null", $value);
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

    protected function _parseInput($str, &$p, $for='')
    {
        $result = array();

        // Leading "{".
        $c = $this->_charAfterSpaces($str, $p);
        if ($c != '{') {
            throw new DB_Type_Exception_Common($this, "input", "'{'", $str, $p);
        }
        $p++;

        // SPEEDUP: in most cases array contains numeric values, so handle this
        // situation separately - it is much faster than universal direct iteration.
        if ($this->_item instanceof DB_Type_Numeric && !$this->_item->skipArrayParseOptimization()) {
            $e = strpos($str, '}', $p);
            if ($e === false) {
                throw new DB_Type_Exception_Common($this, "input", "balanced quoted or unquoted string or sub-array", $str, $p);
            }
            $inner = substr($str, $p, $e - $p);
            $p = $e + 1;
            if (!preg_match_all('/([\d.]+|null)/is', $inner, $m)) return array();
            foreach ($m[0] as $v) {
                $result[] = ctype_alpha($v)? null : $v;
            }
            return $result;
        }

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
            	if (!($this->_item instanceof DB_Type_Pgsql_Array)) {
            		throw new DB_Type_Exception_Common($this, "input", "scalar value", $str, $p);
            	}
                $result[] = $this->_item->_parseInput($str, $p);
                continue;
            }

            // Unquoted string.
            if ($c !== '"' && $c !== false) {
            	$len = strcspn($str, ",}", $p);
            	$v = stripcslashes(call_user_func(self::$_substr, $str, $p, $len));
            	if (!strcasecmp($v, "null")) {
            		$result[] = null;
            	} else {
                    $result[] = $this->_item->input($v, $for);
            	}
            	$p += $len;
                continue;
            }

            // Quoted string.
            $m = null;
            if (preg_match('/" ((?' . '>[^"\\\\]+|\\\\.)*) "/Asx', $str, $m, 0, $p)) {
                $result[] = $this->_item->input(stripcslashes($m[1]), $for);
                $p += call_user_func(self::$_strlen, $m[0]);
                continue;
            }

            // Error.
            throw new DB_Type_Exception_Common($this, "input", "balanced quoted or unquoted string or sub-array", $str, $p);
        }

        return $result;
    }

	public function getNativeType()
    {
    	return $this->_item->getNativeType() . '[]';
    }
}
