<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCodeStyleToCouponCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_categories', function (Blueprint $table) {
            $table->integer('code_type')
                ->default(1)
                ->after('color_foreground');
        });

        // code_type 2
        $ids = [
            '0d924886-7116-4fa1-a3ef-6f0f03ac03a4',
            '54b12eba-1431-4149-8808-d66a5a5035cf',
            'a449ca47-ed5b-4744-be2c-6177fe0910d3',
            'b33435c2-4f08-43bb-aca9-3a60764143c0',
            'dd6d6e12-842f-49de-b374-2ad468e144b6'
        ];
        DB::table('coupon_categories')
            ->whereIn('id', $ids)
            ->update([
                'code_type' => 2
            ]);

        // code_type 3
        DB::table('coupon_categories')
            ->where('id', '08f7d59e-f921-465b-a162-194880dfcb2f')
            ->update([
                'code_type' => 3
            ]);

        DB::table('coupon_categories')
            ->whereIn('id', [
                '601e5713-cf6b-4ac2-80a0-9201beb8fa6b',
                '0391ec9d-fd56-4660-8457-2a0f960dba77',
                '8e36ac58-7d9a-4d21-a91e-b4c74d5bbb05',
                'f5727cee-03ad-42f7-8547-07afd653f6b4'
            ])
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_categories', function (Blueprint $table) {
            $table->dropColumn('code_type');
        });
    }
}
