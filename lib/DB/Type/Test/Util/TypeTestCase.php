<?php

abstract class DB_Type_Test_Util_TypeTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Return test pairs in form of:
     * array($type, $input, $expectedOutput)
     *
     * @return array
     */
    protected function _getPairsInput()
    {
        return array();
    }

    /**
     * Return test pairs in form of:
     * array($type, $expectedInput, $output)
     *
     * @return array
     */
    abstract protected function _getPairsOutput();

    /**
     * Test input method.
     *
     * @return void
     */
    public function testInput()
    {
        foreach ($this->_getPairsInput() as $i => $pair) {
            if ($pair[2] instanceof Exception) {
                continue;
            }
            if ($pair[1] instanceof Exception) {
                try {
                    $pair[0]->input($pair[2]);
                } catch (Exception $e) {
                    $this->assertEquals($pair[1]->getMessage(), $e->getMessage(), "pair #$i: {$pair[2]}");
                    continue;
                }
                $this->fail("pair #$i: Expected exception: " . get_class($pair[1]) . ':' . $pair[1]->getMessage());

            } else {
                $this->assertSame(
                    $pair[1],
                    $pair[0]->input($pair[2]),
                    "pair #$i: {$pair[2]}"
                );
            }
        }
        $this->assertEquals(1, 1);
    }

    /**
     * Test output method.
     *
     * @return void
     */
    public function testOutput()
    {
        foreach ($this->_getPairsOutput() as $i => $pair) {
            if ($pair[1] instanceof Exception) {
                continue;
            }
            if ($pair[2] instanceof Exception) {
                try {
                    $pair[0]->output($pair[1]);
                } catch (Exception $e) {
                    $this->assertEquals($pair[2]->getMessage(), $e->getMessage(), "pair #$i: {$pair[2]}");
                    continue;
                }
                $this->fail("pair #$i: Expected exception: " . get_class($pair[2]) . ':' . $pair[2]->getMessage());
            } else {
                $this->assertSame(
                    $pair[2],
                    $pair[0]->output($pair[1]),
                    "pair #$i: {$pair[2]}"
                );
                if (!isset($pair[3])) continue;
                $this->assertSame(
                    $pair[3],
                    $pair[0]->getNativeType(),
                    "pair #$i: {$pair[3]}"
                );
            }
        }
    }

    public function testOutputInputOutput()
    {
        foreach ($this->_getPairsOutput() as $i => $pair) {
            if ($pair[1] instanceof Exception || $pair[2] instanceof Exception) {
                continue;
            }
            $this->assertSame(
                $pair[2],
                $pair[0]->output($pair[0]->input($pair[0]->output($pair[1]))),
                "pair #$i: {$pair[2]}"
            );
        }
    }

    public function testInputOutputInput()
    {
        foreach ($this->_getPairsInput() as $i => $pair) {
            if ($pair[1] instanceof Exception || $pair[2] instanceof Exception) {
                continue;
            }
            $this->assertSame(
                $pair[1],
                $pair[0]->input($pair[0]->output($pair[0]->input($pair[2]))),
                "pair #$i: {$pair[2]}"
            );
        }
    }
}
