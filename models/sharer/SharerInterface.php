<?php

namespace app\models\sharer;

/**
 * Interface SharerInterface
 */
interface SharerInterface
{
    /**
     * @param array $details Possible details:
     * - message
     * - link
     */
    public function post($details);
}
