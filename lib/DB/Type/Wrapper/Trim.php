<?php
class DB_Type_Wrapper_Trim extends DB_Type_Abstract_Wrapper
{
	private $_both;

	public function __construct(DB_Type_Abstract_Base $item = null, $both = false)
	{
		$this->_both = $both;
		parent::__construct($item);
	}

	protected function _input($native)
    {
		if ( $this->_both ) return trim($native);
        return $native;
    }

    protected function _output($value)
    {
        return trim($value);
    }
}
