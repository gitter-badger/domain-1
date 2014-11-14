<?php

namespace Domain\Aggregates;

use Domain\Events\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
trait Reconstitution
{
    /**
     * @param CommitedEvents $history
     * @return static
     */
    public static function reconstituteFrom(CommittedEvents $history)
    {
        /** @var $instance Reconstitution */
        $instance = new static($history->getIdentity());
        $instance->whenAll($history); // trait will call when{format}(event)

        return $instance;
    }

    abstract protected function whenAll($events);
}