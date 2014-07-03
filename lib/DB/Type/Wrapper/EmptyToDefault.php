<?php
class DB_Type_Wrapper_EmptyToDefault extends DB_Type_Wrapper_EmptyToNull
{
    public function __construct($value, DB_Type_Abstract_Base $item = null)
    {
        parent::__construct(new DB_Type_Wrapper_NullToDefault($value, $item));
    }
}
