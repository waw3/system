<?php

namespace Modules\Plugins\CustomField\Models;

use Modules\Plugins\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldItem extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'field_items';

    /**
     * @var array
     */
    protected $fillable = [
        'field_group_id',
        'parent_id',
        'order',
        'title',
        'slug',
        'type',
        'instructions',
        'options',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function fieldGroup()
    {
        return $this->belongsTo(FieldGroup::class, 'field_group_id')->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(FieldItem::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function child()
    {
        return $this->hasMany(FieldItem::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (FieldItem $fieldItem) {
            app(CustomFieldInterface::class)->deleteBy(['field_item_id' => $fieldItem->id]);
        });
    }
}
