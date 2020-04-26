<?php

namespace Modules\Acl\Models;

use BaseModel;

class Activation extends BaseModel
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'activations';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'code',
        'completed',
        'completed_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'completed' => 'bool',
    ];
}
