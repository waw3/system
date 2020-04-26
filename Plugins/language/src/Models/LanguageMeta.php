<?php

namespace Modules\Plugins\Language\Models;

use Modules\Base\Models\BaseModel;

class LanguageMeta extends BaseModel
{

    /**
     * @var string
     */
    protected $primaryKey = 'lang_meta_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language_meta';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'lang_meta_code',
        'lang_meta_origin',
        'reference_id',
        'reference_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reference()
    {
        return $this->morphTo();
    }
}