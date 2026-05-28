<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom extra ke tabel users yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'fullname')) {
                $table->string('fullname', 100)->nullable()->after('username');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city', 100)->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'zip')) {
                $table->string('zip', 20)->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->integer('is_admin')->default(0)->after('zip');
            }
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->string('user_type', 50)->default('user')->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'cart_data')) {
                $table->text('cart_data')->nullable()->after('user_type');
            }
        });

        // Tabel Kategori
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
        });

        // Tabel Produk
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('sku', 50)->unique();
            $table->string('name', 150);
            $table->text('description');
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->text('datasheet_tips')->nullable();
            $table->text('pinout_data')->nullable();
            $table->text('image_url')->nullable();
        });

        // Tabel Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20);
            $table->integer('total_price');
            $table->string('status', 20)->default('PENDING');
            $table->timestamps();
        });

        // Tabel Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'fullname', 'phone', 'address', 'city', 'zip', 'is_admin', 'user_type', 'cart_data']);
        });
    }
};
