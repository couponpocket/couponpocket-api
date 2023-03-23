<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardTypesAndCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('card_types', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name', 255)->nullable();
            $table->string('coupon_category_id', 36)->nullable()->index('fk_card_types_coupon_categories1_idx');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->bigInteger('number');
            $table->string('user_id', 36)->index('fk_cards_users1_idx');
            $table->string('card_type_id', 36)->index('fk_cards_card_types1_idx');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });

        Schema::table('card_types', function (Blueprint $table) {
            $table->foreign(['coupon_category_id'], 'fk_card_types_coupon_categories1')->references(['id'])->on('coupon_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->foreign(['card_type_id'], 'fk_cards_card_types1')->references(['id'])->on('card_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'fk_cards_users1')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign('fk_cards_card_types1');
            $table->dropForeign('fk_cards_users1');
        });

        Schema::table('card_types', function (Blueprint $table) {
            $table->dropForeign('fk_card_types_coupon_categories1');
        });

        Schema::dropIfExists('cards');

        Schema::dropIfExists('card_types');
    }
}
