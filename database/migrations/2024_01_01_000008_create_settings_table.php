<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default values
        $defaults = [
            ['key' => 'store_name',               'value' => 'ThreadHouse'],
            ['key' => 'store_email',              'value' => 'hello@threadhouse.ng'],
            ['key' => 'store_phone',              'value' => '+234 800 847 3232'],
            ['key' => 'store_address',            'value' => 'Wuse Zone 4, Abuja FCT, Nigeria'],
            ['key' => 'delivery_fee',             'value' => '1500'],
            ['key' => 'free_delivery_threshold',  'value' => '25000'],
        ];

        foreach ($defaults as $setting) {
            \DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
