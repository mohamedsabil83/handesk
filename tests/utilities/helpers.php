<?php

/**
 * @param string $class
 * @param array $attributes
 * @param int $times
 * @return mixed
 */
function create($class, $attributes = [], $times = 1)
{
    return $class::factory()->count($times)->create($attributes);
}
