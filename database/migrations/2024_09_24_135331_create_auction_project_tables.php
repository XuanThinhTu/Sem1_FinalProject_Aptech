<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->notNullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title', 255)->notNullable();
            $table->integer('bid_count')->default(0);
            $table->text('description')->nullable();
            $table->decimal('starting_price', 10, 2)->notNullable();
            $table->timestamps();
            $table->string('image_path')->nullable(); // Đường dẫn ảnh
        });

        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->decimal('start_price', 10, 2)->notNullable();
            $table->decimal('end_price', 10, 2)->notNullable();
            $table->decimal('step', 10, 2)->notNullable();
            $table->dateTime('start_date')->notNullable();
            $table->dateTime('end_date')->notNullable();
            $table->enum('status', ['pending', 'active', 'closed'])->default('pending');
            $table->timestamps();
        });

        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained('auctions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('bid_amount', 10, 2)->notNullable();
            $table->timestamps();
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->primary(['item_id', 'category_id']);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained('auctions');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('payment_amount', 10, 2)->notNullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('rating')->checkBetween(1, 5);
            $table->text('review_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('item_categories');
        Schema::dropIfExists('bids');
        Schema::dropIfExists('auctions');
        Schema::dropIfExists('items');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};
