<?php

namespace App\Services;

use App\Models\Application;
use InvalidArgumentException;

class PipelineStageService
{
    private const FORWARD_ORDER = ['applied', 'screening', 'interview', 'offer', 'hired'];

    private const TERMINAL_STAGES = ['hired', 'rejected'];

    public function transitionTo(Application $application, string $newStage): Application
    {
        $currentStage = $application->stage;

        if (in_array($currentStage, self::TERMINAL_STAGES, true)) {
            throw new InvalidArgumentException("Cannot transition out of terminal stage '{$currentStage}'.");
        }

        if ($newStage === 'rejected') {
            $application->stage = 'rejected';
            $application->previous_stage = null;
            $application->save();

            return $application;
        }

        if ($newStage === 'on_hold') {
            if ($currentStage === 'on_hold') {
                throw new InvalidArgumentException('Application is already on hold.');
            }

            $application->previous_stage = $currentStage;
            $application->stage = 'on_hold';
            $application->save();

            return $application;
        }

        // Resuming: return exactly to the stage it was paused at — no forward movement required
        if ($currentStage === 'on_hold') {
            if ($newStage !== $application->previous_stage) {
                throw new InvalidArgumentException(
                    "Invalid resume: application was on hold from '{$application->previous_stage}', cannot resume directly to '{$newStage}'."
                );
            }

            $application->stage = $newStage;
            $application->previous_stage = null;
            $application->save();

            return $application;
        }

        // Normal forward movement (not on_hold)
        $currentIndex = array_search($currentStage, self::FORWARD_ORDER, true);
        $newIndex = array_search($newStage, self::FORWARD_ORDER, true);

        if ($currentIndex === false || $newIndex === false) {
            throw new InvalidArgumentException("'{$newStage}' is not a valid forward stage.");
        }

        if ($newIndex !== $currentIndex + 1) {
            throw new InvalidArgumentException(
                "Invalid transition: cannot move from '{$currentStage}' to '{$newStage}'. Only one step forward is allowed."
            );
        }

        $application->stage = $newStage;
        $application->previous_stage = null;
        $application->save();

        return $application;
    }
}