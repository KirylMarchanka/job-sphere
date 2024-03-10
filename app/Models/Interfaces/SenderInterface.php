<?php

namespace App\Models\Interfaces;

interface SenderInterface
{
    /** @return string */
    public function getMorphClass();
    /** @return mixed */
    public function getKey();
}
