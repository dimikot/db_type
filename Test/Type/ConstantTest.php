<?php
class DB_Pgsql_Type_Test_Type_ConstantTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Constant("a constant!"),
                "something",
                "a constant!",
            ),
            array(
                new DB_Pgsql_Type_Constant(null),
                "something",
                null,
            ),
        );
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Constant("a constant!"),
                "something",
                "something"
            ),
        );
    }
    
    public function testInputOutputInput()
    {
    	// Do not test that, because not commutative.
    	$this->assertEquals(1, 1);
    }
}
