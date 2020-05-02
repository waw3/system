<?php

namespace Modules\Gallery\Models;

use Modules\Base\Models\BaseModel;

/**
 * GalleryMeta class.
 *
 * @extends BaseModel
 */
class GalleryMeta extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallery_meta';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * getImagesAttribute function.
     *
     * @access public
     * @param string $value
     * @return array
     */
    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }
}
