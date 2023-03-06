<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChangedIdFromIntToUuidForCouponsAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // remove CONSTRAINT
        DB::statement('ALTER TABLE `coupons` DROP CONSTRAINT `fk_coupons_coupon_categories`;');

        // change database field
        DB::statement('ALTER TABLE `coupon_categories` MODIFY `id` VARCHAR(36) NOT NULL;');

        // change coupon_category id
        DB::statement("UPDATE `coupon_categories` SET `id` = 'f22959ea-81be-43fd-aba6-d659953c50d9' WHERE `id` = '1';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '9e06c83a-d28d-4181-84c1-ee2bc260ff8c' WHERE `id` = '2';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'f678fa75-d004-49dd-a726-016c6128bb68' WHERE `id` = '3';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '064da2f9-4b0b-4cec-ba44-699960756b0f' WHERE `id` = '4';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'b33435c2-4f08-43bb-aca9-3a60764143c0' WHERE `id` = '5';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '54b12eba-1431-4149-8808-d66a5a5035cf' WHERE `id` = '6';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '601e5713-cf6b-4ac2-80a0-9201beb8fa6b' WHERE `id` = '7';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '0391ec9d-fd56-4660-8457-2a0f960dba77' WHERE `id` = '8';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '3605c937-fd47-4c56-bf51-3f47f0b99102' WHERE `id` = '9';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '0d924886-7116-4fa1-a3ef-6f0f03ac03a4' WHERE `id` = '10';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '08f7d59e-f921-465b-a162-194880dfcb2f' WHERE `id` = '11';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'a449ca47-ed5b-4744-be2c-6177fe0910d3' WHERE `id` = '12';");
        DB::statement("UPDATE `coupon_categories` SET `id` = '8e36ac58-7d9a-4d21-a91e-b4c74d5bbb05' WHERE `id` = '13';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'dd6d6e12-842f-49de-b374-2ad468e144b6' WHERE `id` = '14';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'f5727cee-03ad-42f7-8547-07afd653f6b4' WHERE `id` = '15';");
        DB::statement("UPDATE `coupon_categories` SET `id` = 'e9eb7907-22ad-48fc-81cf-d094b25a08be' WHERE `id` = '16';");

        // change database field
        DB::statement('ALTER TABLE `coupons` MODIFY `coupon_category_id` VARCHAR(36) NOT NULL;');

        // change coupons reference to coupon_category
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'f22959ea-81be-43fd-aba6-d659953c50d9' WHERE `coupon_category_id` = '1';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '9e06c83a-d28d-4181-84c1-ee2bc260ff8c' WHERE `coupon_category_id` = '2';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'f678fa75-d004-49dd-a726-016c6128bb68' WHERE `coupon_category_id` = '3';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '064da2f9-4b0b-4cec-ba44-699960756b0f' WHERE `coupon_category_id` = '4';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'b33435c2-4f08-43bb-aca9-3a60764143c0' WHERE `coupon_category_id` = '5';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '54b12eba-1431-4149-8808-d66a5a5035cf' WHERE `coupon_category_id` = '6';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '601e5713-cf6b-4ac2-80a0-9201beb8fa6b' WHERE `coupon_category_id` = '7';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '0391ec9d-fd56-4660-8457-2a0f960dba77' WHERE `coupon_category_id` = '8';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '3605c937-fd47-4c56-bf51-3f47f0b99102' WHERE `coupon_category_id` = '9';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '0d924886-7116-4fa1-a3ef-6f0f03ac03a4' WHERE `coupon_category_id` = '10';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '08f7d59e-f921-465b-a162-194880dfcb2f' WHERE `coupon_category_id` = '11';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'a449ca47-ed5b-4744-be2c-6177fe0910d3' WHERE `coupon_category_id` = '12';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = '8e36ac58-7d9a-4d21-a91e-b4c74d5bbb05' WHERE `coupon_category_id` = '13';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'dd6d6e12-842f-49de-b374-2ad468e144b6' WHERE `coupon_category_id` = '14';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'f5727cee-03ad-42f7-8547-07afd653f6b4' WHERE `coupon_category_id` = '15';");
        DB::statement("UPDATE `coupons` SET `coupon_category_id` = 'e9eb7907-22ad-48fc-81cf-d094b25a08be' WHERE `coupon_category_id` = '16';");

        DB::statement('ALTER TABLE `coupons` ADD CONSTRAINT `fk_coupons_coupon_categories` FOREIGN KEY (`coupon_category_id`) REFERENCES `coupon_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION');

        // change database field
        DB::statement('ALTER TABLE `coupons` MODIFY `id` VARCHAR(36) NOT NULL;');

        // replace id with a random uuid
        $coupons = DB::table('coupons')
            ->get();

        foreach ($coupons as $coupon) {
            DB::table('coupons')
                ->where('id', $coupon->id)
                ->update([
                    'id' => (string)Str::uuid(),
                    'updated_at' => $coupon->updated_at
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {

    }
}
