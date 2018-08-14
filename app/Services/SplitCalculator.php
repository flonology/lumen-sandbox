<?php
namespace App\Services;

class SplitCalculator
{
    private $start;
    private $end;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getNumberOfPieces()
    {
        if ($this->end < $this->start) {
            return 0;
        }

        return ($this->end - $this->start) + 1;
    }

    public function getLeftHalfStart(): int
    {
        if ($this->end < $this->start) {
            return 0;
        }

        return $this->start;
    }

    public function getLeftHalfEnd(): int
    {
        if ($this->end < $this->start) {
            return 0;
        }

        return floor($this->getNumberOfPieces() / 2) + $this->start;
    }

    public function getRightHalfStart(): int
    {
        if ($this->end <= $this->start) {
            return 0;
        }

        return $this->getLeftHalfEnd() + 1;
    }

    public function getRightHalfEnd(): int
    {
        if ($this->end <= $this->start) {
            return 0;
        }

        return $this->end;
    }
}
