<?php

namespace Modules\Plugins\Product;

use Modules\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Schema;
use Modules\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('procategories');
        Schema::dropIfExists('protags');

        app(DashboardWidgetInterface::class)->deleteBy(['name' => 'widget_products_recent']);
    }
}
