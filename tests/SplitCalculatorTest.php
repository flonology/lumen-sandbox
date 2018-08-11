<?php
use App\Services\SplitCalculator;


class SplitCalculatorTest extends TestCase
{
    public function testCalculatesSplitCorrectly()
    {
        $splitCalculator = new SplitCalculator(0, 100);
        $this->assertEquals(0, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(50, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(51, $splitCalculator->getRightHalfStart());
        $this->assertEquals(100, $splitCalculator->getRightHalfEnd());
    }

    public function testCanHandlyUnevenNumbers()
    {
        $splitCalculator = new SplitCalculator(3, 77);
        $this->assertEquals(3, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(40, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(41, $splitCalculator->getRightHalfStart());
        $this->assertEquals(77, $splitCalculator->getRightHalfEnd());

        $splitCalculator = new SplitCalculator(0, 3);
        $this->assertEquals(0, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(1, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(2, $splitCalculator->getRightHalfStart());
        $this->assertEquals(3, $splitCalculator->getRightHalfEnd());
    }

    public function testCanHandleEdgeCases()
    {
        $splitCalculator = new SplitCalculator(3, 3);
        $this->assertEquals(3, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(3, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(0, $splitCalculator->getRightHalfStart());
        $this->assertEquals(0, $splitCalculator->getRightHalfEnd());

        $splitCalculator = new SplitCalculator(7, 2);
        $this->assertEquals(0, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(0, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(0, $splitCalculator->getRightHalfStart());
        $this->assertEquals(0, $splitCalculator->getRightHalfEnd());
    }
}
