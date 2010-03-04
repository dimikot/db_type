<?php
class DB_Pgsql_Type_Test_Type_DefaultTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Default(
                    new DB_Pgsql_Type_Row(array(
                        'bool' => new DB_Pgsql_Type_Boolean()
                    )),
                    array(
                        'bool' => true
                    )
                ),
                null,
                '("t")',
            ),
            array(
                new DB_Pgsql_Type_Default(
                    new DB_Pgsql_Type_Row(array(
                        'bool' => new DB_Pgsql_Type_Boolean()
                    )),
                    array(
                        'bool' => true
                    )
                ),
                array(),
                '()',
            ),
            array(
                new DB_Pgsql_Type_Default(
                    new DB_Pgsql_Type_Row(array(
                        'bool' => new DB_Pgsql_Type_Boolean()
                    )),
                    array(
                        'bool' => true
                    )
                ),
                array('bool' => false),
                '("f")',
            ),
        );
    }
}
