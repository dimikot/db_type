<?php
class DB_Type_Date extends DB_Type_Abstract_Primitive
{
    private $_trunc;
	private $_format;
	private $_timezone;

    const TRUNC_DAY = 3;
    const TRUNC_MONTH = 4;
    const TRUNC_YEAR = 5;

    public function __construct($trunc = self::TRUNC_DAY, $format = null, $timezone = null)
    {
        $this->_trunc = $trunc;
		$this->_format = $format;
		$this->_timezone = $timezone;
    }

    public function input($native)
    {
    	if ($native === null) {
    		return null;
    	}
		if ($this->_format) {
			if ($this->_timezone) $date = DateTime::createFromFormat('Y-m-d', $native, $this->_timezone);
			else $date = DateTime::createFromFormat('Y-m-d', $native);

			if ($date === false) return $native;

			return $date->format($this->_format);
		}
    	else return self::truncDate($native, $this->_trunc);
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
			$value = self::extractDate($value);
		} elseif ($this->_format != null) {
			$value = self::convertFromFormat($this->_format, $value, $this->_timezone);
		}

        return self::truncDate($value, $this->_trunc);
    }

    public static function truncDate($date, $trunc)
    {
    	if (preg_match('/^\d+$/s', $date)) {
    		$date .= "-01-01";
    	} else if (preg_match('/^\d+-[01]?\d$/s', $date)) {
            $date .= "-01";
    	} else if (preg_match('/^\d+-[01]?\d-[0123]?\d$/s', $date)) {
    		// ok
    	} else {
    		throw new DB_Type_Exception_Date(new self($trunc), $date);
    	}
    	$parts = explode("-", $date);
        if ($trunc > self::TRUNC_DAY) $parts[2] = 1;
        if ($trunc > self::TRUNC_MONTH) $parts[1] = 1;
        if ($parts[0] >= 0 && $parts[0] < 70) $parts[0] += 2000;
        if ($parts[0] >= 70 && $parts[0] < 100) $parts[0] += 1900;
        $parts[1] = str_pad($parts[1], 2, '0', STR_PAD_LEFT);
        $parts[2] = str_pad($parts[2], 2, '0', STR_PAD_LEFT);
        return join("-", $parts);
    }

    public function getNativeType()
    {
    	return 'DATE';
    }

	private static function convertFromFormat($format, $time, $timezone=null)
	{
		// for except php warning
		// DateTime::createFromFormat() expects parameter 3 to be DateTimeZone, null given
		if ($timezone) $date = DateTime::createFromFormat($format, $time, $timezone);
		else $date = DateTime::createFromFormat($format, $time);

		if ($date === false) return $time;

		return $date->format('Y-m-d');
	}

	public static function extractDate($array)
	{
		$format   = $array[0];
		$time     = $array[1];
		$timezone = isset($array[2]) ? $array[2] : null;

		return self::convertFromFormat($format, $time, $timezone);
	}
}
