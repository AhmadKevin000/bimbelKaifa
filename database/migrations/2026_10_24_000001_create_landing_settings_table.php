<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Editable landing-page copy, managed from the admin panel.
 *
 * Additive only: this creates a new table and never touches existing data.
 * Image slots stay in `landing_photos`, pricing stays in `tarif_spp`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_settings', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();

            // About
            $table->text('about_description')->nullable();
            $table->text('about_vision')->nullable();
            $table->text('about_mission')->nullable();

            // Repeating content, stored as JSON so one row stays authoritative.
            $table->json('faqs')->nullable();
            $table->json('process_steps')->nullable();

            // Contact details
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_hours')->nullable();
            $table->string('contact_instagram')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_settings');
    }
};
