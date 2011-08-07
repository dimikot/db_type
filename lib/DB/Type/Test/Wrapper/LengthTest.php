<?php
class DB_Type_Test_Rwapper_LengthTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Wrapper_Length(new DB_Type_String(), 20),
                "1234567890",
                new DB_Type_Exception_Length(
                    new DB_Type_Wrapper_Length(new DB_Type_String(), 20),
                    "1234567890"
                ),
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_Length(new DB_Type_String(), 0, 2),
                "1234567890",
                new DB_Type_Exception_Length(
                    new DB_Type_Wrapper_Length(new DB_Type_String(), 0, 2),
                    "1234567890"
                ),
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_Length(new DB_Type_String(), 10),
                "1234567890",
                "1234567890",
                'VARCHAR',
            ),
        );
    }    
}
