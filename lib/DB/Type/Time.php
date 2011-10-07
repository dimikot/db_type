<?php
class DB_Type_Time extends DB_Type_Abstract_Primitive
{
    private $_trunc;

    const TRUNC_SECOND = 0;
    const TRUNC_MINUTE = 1;
    const TRUNC_HOUR = 2;

    public function __construct($trunc = self::TRUNC_SECOND)
    {
        $this->_trunc = $trunc;
    }

    public function input($native, $for = '')
    {
    	if ($native === null) {
    		return null;
    	}
    	return self::truncTime($native, $this->_trunc);
    }

    public function output($value)
    {
    	if ($value === null) {
            return null;
        }
        return self::truncTime($value, $this->_trunc, true);
    }

    public static function truncTime($time, $trunc, $forOutput = false)
    {
    	if (preg_match('/^[012]{0,1}\d$/s', $time)) {
    		$time .= ":00:00";
    	} else if (preg_match('/^[012]{0,1}\d:\d\d?$/s', $time)) {
            $time .= ":00";
    	} else if (preg_match('/^[012]{0,1}\d:\d\d?:\d\d?$/s', $time)) {
    		// ok
    	} else {
    		throw new DB_Type_Exception_Time(new self($trunc), $time);
    	}
    	$parts = explode(":", $time);
        if ($trunc > self::TRUNC_SECOND) { if ($forOutput) $parts[2] = 0; else unset($parts[2]); }
        if ($trunc > self::TRUNC_MINUTE) { if ($forOutput) $parts[1] = 0; else unset($parts[1]); }
        foreach ($parts as $i => $part) {
            $parts[$i] = str_pad($part, 2, '0', STR_PAD_LEFT);
        }
        return join(":", $parts);
    }

    public function getNativeType()
    {
    	return 'TIME';
    }
}
