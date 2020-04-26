<?php

namespace Modules\Plugins\Product\Models;

use Modules\ACL\Models\User;
use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Revision\Traits\Revisionable;
use Modules\Slug\Traits\SlugTrait;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use DB;

/**
 * Cart class.
 *
 * @extends BaseModel
 */
class Cart extends BaseModel
{
    use Revisionable;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * fillable
     *
     * @var array
     * @access protected
     */
    protected $fillable = [
        'name',
        'author_id',
        'author_type',
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
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * orderstatus function.
     *
     * @access public
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderstatus(): BelongsToMany
    {
        return $this->belongsToMany(Orderstatus::class, 'product_orderstatuses', 'cart_id', 'orderstatuses_id');
    }

    /**
     * payment function.
     *
     * @access public
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payment(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'product_payments', 'cart_id', 'payments_id');
    }

    /**
     * shipping function.
     *
     * @access public
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shipping(): BelongsToMany
    {
        return $this->belongsToMany(Shipping::class, 'product_shippings', 'cart_id', 'shippings_id');
    }

    /**
     * author function.
     *
     * @access public
     * @return void
     */
    public function author()
    {
        return $this->morphTo();
    }

    /**
     * boot function.
     *
     * @access protected
     * @static
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Cart $cart) {

          /*  $cart->orderstatus()->detach();
            $cart->payment()->detach();
            $cart->shipping()->detach();*/
        });
    }

    /**
     * insertData function.
     *
     * @access public
     * @static
     * @param mixed $data
     * @return void
     */
    public static function insertData($data)
    {

        //$value=DB::table('product_carts')->where('username', $data['username'])->get();
          //if($value->count() == 0){
              //$insertid = DB::table('product_carts')->insertGetId($data);
              return $data;
          //}else{
             //return 0;
          //}
    }
}
