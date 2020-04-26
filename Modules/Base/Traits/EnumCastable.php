<?php

namespace Modules\Base\Traits;

use Modules\Base\Supports\Enum;

trait EnumCastable
{
    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        $castedValue = parent::castAttribute($key, $value);

        if ($castedValue === $value && !is_object($value)) {
            $castType = $this->getCasts()[$key];
            if (class_exists($castType) and is_subclass_of($castType, Enum::class)) {
                $castedValue = new $castType($value);
            }
        }

        return $castedValue;
    }

    /**
     * Determine if the given key is cast using a custom class.
     *
     * @param string $key
     * @return bool
     */
    protected function isClassCastable($key)
    {
        return false;
    }
}
