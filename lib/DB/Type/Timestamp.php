<?php
class DB_Type_Timestamp extends DB_Type_Abstract_Primitive
{
    private $_trunc;
	private $_format;
	private $_timezone;

	const TRUNC_SECOND = 0;
    const TRUNC_MINUTE = 1;
    const TRUNC_HOUR = 2;
    const TRUNC_DAY = 3;
    const TRUNC_MONTH = 4;
    const TRUNC_YEAR = 5;

    public function __construct($trunc = self::TRUNC_SECOND, $format = null, $timezone = null)
    {
        $this->_trunc = $trunc;
		// todo add unit tests for this feature
		$this->_format = $format;
		$this->_timezone = $timezone;
	}

    public function input($native, $for = '')
    {
    	if ($native === null) {
    		return null;
    	}
		if ($this->_format) {
			if ($this->_timezone) $date = new DateTime($native, $this->_timezone);
			else $date = new DateTime($native);

			if ($date === false) return $native;

			return $date->format($this->_format);
		}
		else return self::truncTimestamp(strtotime($native), $this->_trunc);
    }

    public function output($value)
    {
    	if ($value === null) {
            return null;
        }

		/**
		 * Value may be array of DateTime::createFromFormat parameters
		 */
		if (is_array($value)) {
			$value = DB_Type_Date::extractDate($value);
		} elseif ($this->_format != null) {
			$value = DB_Type_Date::convertFromFormat($this->_format, $value, $this->_timezone);
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
