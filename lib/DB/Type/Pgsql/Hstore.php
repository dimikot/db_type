<?php

class DB_Type_Pgsql_Hstore extends DB_Type_Abstract_Container 
{
    const ESCAPE = '"\\';
    
    public function output($value)
    {
        if (is_null($value)) {
            return null;
        }
        if (!is_array($value)) {
            throw new DB_Type_Exception_Common($this, "output", "PHP-array or null", $value);
        }
        $parts = array();
        foreach ($value as $key => $value) {
            $parts[] = 
                '"' . addcslashes($key, self::ESCAPE) . '"' .
                '=>' .
                ($value === null? "NULL" : '"' . addcslashes($this->_item->output($value), self::ESCAPE) . '"');
        }
        return join(",", $parts);
    }

    protected function _parseInput($str, &$p) 
    {
        $result = array();
        while (1) {
            // End of string?
            $c = $this->_charAfterSpaces($str, $p);
            if ($c === false) {
                break;
            }
            
            // Key.
            $key = $this->_readString($str, $p);
            
            // '=>' sequence.
            $this->_charAfterSpaces($str, $p);
            if (call_user_func(self::$_substr, $str, $p, 2) != '=>') {
                throw new DB_Type_Exception_Common($this, "input", "'=>'", $str, $p);
            }
            $p += 2;
            $this->_charAfterSpaces($str, $p);
            
            // Value.
            $value = $this->_readString($str, $p);
            if (!strcasecmp($value, "null")) {
                $result[$key] = null;
            } else {
                $result[$key] = $this->_item->input($value);
            }

            // Next element.
            $c = $this->_charAfterSpaces($str, $p);
            if ($c == ',') {
                $p++;
                continue;
            } else {
                break;
            }
        }
        
        return $result;
    }
    
    private function _readString($str, &$p)
    {
        $c = call_user_func(self::$_substr, $str, $p, 1);
        
        // Unquoted string.
        if ($c != '"') {
            $len = strcspn($str, " \r\n\t,=>", $p);
            $value = call_user_func(self::$_substr, $str, $p, $len);
            $p += $len;
            return stripcslashes($value);
        }
            
        // Quoted string.
        $m = null;
        if (preg_match('/" ((?' . '>[^"\\\\]+|\\\\.)*) "/Asx', $str, $m, 0, $p)) {
            $value = stripcslashes($m[1]);
            $p += call_user_func(self::$_strlen, $m[0]);
            return $value;
        }
            
        // Error.
        throw new DB_Type_Exception_Common($this, "input", "quoted or unquoted string", $str, $p);
    }
    
    public function getNativeType()
    {
        return 'hstore';
    }    
}