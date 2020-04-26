<?php

return [
    [
        'name' => 'Ecomerce',
        'flag' => 'plugins.product',
    ],
    [
        'name'        => 'Posts',
        'flag'        => 'product.index',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product.create',
        'parent_flag' => 'product.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product.edit',
        'parent_flag' => 'product.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product.destroy',
        'parent_flag' => 'product.index',
    ],

    [
        'name'        => 'Categories',
        'flag'        => 'procategories.index',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'procategories.create',
        'parent_flag' => 'procategories.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'procategories.edit',
        'parent_flag' => 'procategories.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'procategories.destroy',
        'parent_flag' => 'procategories.index',
    ],

    [
        'name'        => 'Features',
        'flag'        => 'features.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'features.create',
        'parent_flag' => 'features.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'features.edit',
        'parent_flag' => 'features.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'features.destroy',
        'parent_flag' => 'features.index',
    ],

    [
        'name'        => 'Stores',
        'flag'        => 'store.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'store.create',
        'parent_flag' => 'store.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'store.edit',
        'parent_flag' => 'store.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'store.destroy',
        'parent_flag' => 'store.index',
    ],


    [
        'name' => 'Carts',
        'flag' => 'cart.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'cart.create',
        'parent_flag' => 'cart.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'cart.edit',
        'parent_flag' => 'cart.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'cart.destroy',
        'parent_flag' => 'cart.index',
    ],

    [
        'name' => 'Orderstatuses',
        'flag' => 'orderstatus.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'orderstatus.create',
        'parent_flag' => 'orderstatus.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'orderstatus.edit',
        'parent_flag' => 'orderstatus.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'orderstatus.destroy',
        'parent_flag' => 'orderstatus.index',
    ],



    [
        'name'        => 'Product Tags',
        'flag'        => 'protags.index',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'protags.create',
        'parent_flag' => 'protags.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'protags.edit',
        'parent_flag' => 'protags.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'protags.destroy',
        'parent_flag' => 'protags.index',
    ],

    [
        'name' => 'Payments',
        'flag' => 'payment.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'payment.create',
        'parent_flag' => 'payment.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'payment.edit',
        'parent_flag' => 'payment.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'payment.destroy',
        'parent_flag' => 'payment.index',
    ],
    
    [
        'name' => 'Shippings',
        'flag' => 'shipping.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'shipping.create',
        'parent_flag' => 'shipping.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'shipping.edit',
        'parent_flag' => 'shipping.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'shipping.destroy',
        'parent_flag' => 'shipping.index',
    ],
];