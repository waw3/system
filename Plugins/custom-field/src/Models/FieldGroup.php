<?php

namespace Modules\Plugins\CustomField\Models;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Traits\EnumCastable;
use Modules\Plugins\CustomField\Repositories\Interfaces\FieldItemInterface;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldGroup extends BaseModel
{
    use EnumCastable;

    /**
     * @var string
     */
    protected $table = 'field_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'order',
        'rules',
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return HasMany
     */
    public function fieldItems()
    {
        return $this->hasMany(FieldItem::class, 'field_group_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (FieldGroup $fieldGroup) {
            app(FieldItemInterface::class)->deleteBy(['field_group_id' => $fieldGroup->id]);
        });
    }
}
