<?php

use Modules\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('description', 400)->nullable();
            $table->text('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->text('image')->nullable();
            $table->text('imagedl')->nullable();
            $table->text('images')->nullable();
            $table->string('pricecost', 255)->nullable();
            $table->string('pricesell', 255);
            $table->string('pricetime', 255)->nullable();
            $table->string('amound', 40)->nullable();
            $table->string('color', 400)->nullable();
            $table->string('colors', 400)->nullable();
            $table->string('sizes', 400)->nullable();
            $table->string('pricesale', 255)->nullable();
            $table->string('price_sale_start', 400)->nullable();
            $table->string('price_sale_end', 400)->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->string('format_type', 30)->nullable();
            $table->timestamps();
        });



        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });



        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 120);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });

        } else {

            Schema::table('payments', function (Blueprint $table) {
                $table->string('name', 120);
                $table->string('status', 60)->default('published');
            });

        }


        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->text('products')->nullable();
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('orderstatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('protags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('description', 400)->nullable()->default('');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });



        Schema::create('product_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('protag_id')->unsigned()->references('id')->on('protags')->onDelete('cascade')->nullable();;
            $table->integer('pro_tag_id')->unsigned()->references('id')->on('protags')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procategory_id')->unsigned()->references('id')->on('procategories')->onDelete('cascade')->nullable();
            $table->integer('pro_category_id')->unsigned()->references('id')->on('procategories')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carts_id')->unsigned()->references('id')->on('carts')->onDelete('cascade')->nullable();
            $table->string('carts_size', 255)->nullable();
            $table->string('carts_amound', 255)->nullable();
            //$table->integer('pro_features_id')->unsigned()->references('id')->on('features')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');
        });


        Schema::create('product_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('features_id')->unsigned()->references('id')->on('features')->onDelete('cascade')->nullable();
            //$table->integer('pro_features_id')->unsigned()->references('id')->on('features')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stores_id')->unsigned()->references('id')->on('stores')->onDelete('cascade')->nullable();
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_orderstatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderstatuses_id')->unsigned()->references('id')->on('orderstatuses')->onDelete('cascade')->nullable();
            //$table->integer('pro_orderstatuses_id')->unsigned()->references('id')->on('orderstatuses')->onDelete('cascade');
            $table->integer('cart_id')->unsigned()->references('id')->on('carts')->onDelete('cascade');
        });
        Schema::create('product_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payments_id')->unsigned()->references('id')->on('payments')->onDelete('cascade')->nullable();
            $table->integer('cart_id')->unsigned()->references('id')->on('carts')->onDelete('cascade');
        });

        Schema::create('product_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shippings_id')->unsigned()->references('id')->on('shippings')->onDelete('cascade')->nullable();
            $table->integer('cart_id')->unsigned()->references('id')->on('carts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_features');
        Schema::dropIfExists('product_stores');
        Schema::dropIfExists('product_orderstatuses');
        Schema::dropIfExists('product_payments');
        Schema::dropIfExists('product_shippings');
        Schema::dropIfExists('product_carts');
        Schema::dropIfExists('products');
        Schema::dropIfExists('features');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('shippings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orderstatuses');
        Schema::dropIfExists('procategories');
        Schema::dropIfExists('protags');
    }
}
