<?php namespace App\Helpers\Classes;

use SupportBaseModel as Model;

/**
 * Class ActivityLogHelper
 */
class ActivityLogHelper
{

    /**
     * Log changes of related objects
     *
     * @param Model $model
     * @param string $attribute
     * @return array
     */
    public static function getRelatedModelAttributeValue(Model $model, string $attribute): array
    {
        if (substr_count($attribute, '.') > 1) {
        }

        list($relatedModelName, $relatedAttribute) = explode('.', $attribute);

        $relatedModel = $model->$relatedModelName ?? $model->$relatedModelName();

        return ["{$relatedModelName}.{$relatedAttribute}" => $relatedModel->$relatedAttribute ?? null ];
    }
}
