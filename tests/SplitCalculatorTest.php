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
        $this->assertEquals(101, $splitCalculator->getNumberOfPieces());
    }

    public function testCanHandleUnevenNumbers()
    {
        $splitCalculator = new SplitCalculator(3, 77);
        $this->assertEquals(3, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(40, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(41, $splitCalculator->getRightHalfStart());
        $this->assertEquals(77, $splitCalculator->getRightHalfEnd());
        $this->assertEquals(75, $splitCalculator->getNumberOfPieces());

        $splitCalculator = new SplitCalculator(0, 3);
        $this->assertEquals(0, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(2, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(3, $splitCalculator->getRightHalfStart());
        $this->assertEquals(3, $splitCalculator->getRightHalfEnd());
        $this->assertEquals(4, $splitCalculator->getNumberOfPieces());
    }

    public function testCanHandleEdgeCases()
    {
        $splitCalculator = new SplitCalculator(3, 3);
        $this->assertEquals(3, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(3, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(0, $splitCalculator->getRightHalfStart());
        $this->assertEquals(0, $splitCalculator->getRightHalfEnd());
        $this->assertEquals(1, $splitCalculator->getNumberOfPieces());

        $splitCalculator = new SplitCalculator(7, 2);
        $this->assertEquals(0, $splitCalculator->getLeftHalfStart());
        $this->assertEquals(0, $splitCalculator->getLeftHalfEnd());
        $this->assertEquals(0, $splitCalculator->getRightHalfStart());
        $this->assertEquals(0, $splitCalculator->getRightHalfEnd());
        $this->assertEquals(0, $splitCalculator->getNumberOfPieces());
    }
}
