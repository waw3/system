<?php

namespace Modules\Gallery\Models;

use Modules\Acl\Models\User;
use Modules\Base\Models\BaseModel;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Traits\EnumCastable;
use Modules\Slug\Traits\SlugTrait;

/**
 * Gallery class.
 *
 * @extends BaseModel
 */
class Gallery extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'is_featured',
        'order',
        'image',
        'status',
    ];

    /**
     * casts
     *
     * @var array
     * @access protected
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * user function.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
