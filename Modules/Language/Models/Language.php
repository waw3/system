<?php

namespace Modules\Language\Models;

use Modules\Base\Models\BaseModel;

class Language extends BaseModel
{

    /**
     * @var string
     */
    protected $primaryKey = 'lang_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'languages';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'lang_name',
        'lang_locale',
        'lang_is_default',
        'lang_code',
        'lang_is_rtl',
        'lang_flag',
        'lang_order',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleted(function (Language $language) {
            $defaultLanguage = self::where('lang_is_default', 1)->first();
            if (empty($defaultLanguage) && self::count() == 0) {
                LanguageMeta::truncate();
            } else {
                if (empty($defaultLanguage)) {
                    $defaultLanguage = self::first();
                    $defaultLanguage->lang_is_default = 1;
                    $defaultLanguage->save();
                }

                if (!empty($defaultLanguage)) {
                    LanguageMeta::where('lang_meta_code', $language->lang_code)->update(['lang_meta_code' => $defaultLanguage->lang_code]);
                }
            }
        });
    }
}
