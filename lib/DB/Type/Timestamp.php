<?php
class DB_Type_Timestamp extends DB_Type_Abstract_Primitive
{
    private $_trunc;

    const TRUNC_SECOND = 0;
    const TRUNC_MINUTE = 1;
    const TRUNC_HOUR = 2;
    const TRUNC_DAY = 3;
    const TRUNC_MONTH = 4;
    const TRUNC_YEAR = 5;
    
    public function __construct($trunc = self::TRUNC_SECOND)
    {
        $this->_trunc = $trunc;
    }

    public function input($native)
    {
        if ($native === null) {
            return null;
        }
        return self::truncTimestamp(strtotime($native), $this->_trunc);
    }

    public function output($value)
    {
        if ($value === null) {
            return null;
        }
        $value = self::truncTimestamp($value, $this->_trunc);
        return date("r", $value);
    }
    
    public static function truncTimestamp($timestamp, $trunc)
    {
        $parts = getdate($timestamp);
        if ($trunc > self::TRUNC_SECOND) $parts['seconds'] = 0;
        if ($trunc > self::TRUNC_MINUTE) $parts['minutes'] = 0;
        if ($trunc > self::TRUNC_HOUR) $parts['hours'] = 0;
        if ($trunc > self::TRUNC_DAY) $parts['mday'] = 1;
        if ($trunc > self::TRUNC_MONTH) $parts['mon'] = 1;
        return mktime($parts['hours'], $parts['minutes'], $parts['seconds'], $parts['mon'], $parts['mday'], $parts['year']);
    }
    
    public function getNativeType()
    {
        return 'TIMESTAMP';
    }
}
