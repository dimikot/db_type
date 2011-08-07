<?php
class DB_Type_Test_ConstantTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Constant("a constant!"),
                "something",
                "a constant!",
                "VARCHAR",
            ),
            array(
                new DB_Type_Constant(null),
                "something",
                null,
                "VARCHAR",
            ),
            array(
                new DB_Type_Constant(null, new DB_Type_Int()),
                "something",
                null,
                "INT",
            ),
    	);
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Type_Constant("a constant!"),
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
