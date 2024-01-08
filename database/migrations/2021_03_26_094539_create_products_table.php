<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('other_description')->nullable();
            $table->text('other_description_api')->nullable();
            $table->longtext('tag')->nullable();
            $table->longtext('tag_api')->nullable();
            
            $table->integer('category_id')->default(0)->comment('maincategory');
            $table->integer('subcategory_id')->default(0);
            $table->string('cover_image_path')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->float('price')->default(0);
            $table->string('discount_type')->comment('percentage, flat')->default('percentage');
            $table->float('discount_amount')->default(0);
            $table->integer('product_stock')->default(0);

            $table->boolean('variant_product')->default(1)->comment('0 => no variant, 1 => variant');
            $table->string('variant_id')->nullable();
            $table->text('variant_attribute',1000)->nullable();
            $table->integer('default_variant_id')->default(0)->nullable();
            $table->integer('trending')->default('0')->comment('0 => no, 1 => yes');
            
            $table->float('average_rating')->default('0');
            $table->string('slug')->nullable();            
            
            $table->string('theme_id')->nullable();
            $table->integer('status')->default(1)->comment('0 => Inactive, 1 => Active');    
            
            $table->text('product_option')->nullable();
            $table->text('product_option_api')->nullable();
            
            $table->integer('store_id');
            $table->integer('created_by');
            $table->integer('is_active')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
