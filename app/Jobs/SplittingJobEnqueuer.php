<?php
namespace App\Jobs;
use App\Services\SplitCalculator;

class SplittingJobEnqueuer extends Job
{
    const NUMBER_OF_PIECES_TO_HANDLE = 50;

    private $startAt;
    private $workTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $startAt, int $workTo)
    {
        $this->startAt = $startAt;
        $this->workTo = $workTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $splitCalculator = new SplitCalculator($this->startAt, $this->workTo);

        if ($splitCalculator->getNumberOfPieces() <= self::NUMBER_OF_PIECES_TO_HANDLE) {
            // Do stuff here…
            return;
        }

        dispatch(new SplittingJobEnqueuer(
            $splitCalculator->getLeftHalfStart(),
            $splitCalculator->getLeftHalfEnd()
        ));

        dispatch(new SplittingJobEnqueuer(
            $splitCalculator->getRightHalfStart(),
            $splitCalculator->getRightHalfEnd()
        ));
    }
}
