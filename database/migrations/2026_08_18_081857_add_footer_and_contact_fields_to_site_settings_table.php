<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('footer_text')->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('bottom_right_text')->nullable();
            $table->string('email_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('social_ig')->nullable();
            $table->string('social_fb')->nullable();
            $table->string('social_p')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_text', 'copyright_text', 'bottom_right_text', 
                'email_id', 'phone_number', 'address', 
                'social_ig', 'social_fb', 'social_p'
            ]);
        });
    }
};
