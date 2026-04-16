<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('logo_url')->nullable();
            $table->longText('description')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('industry')->nullable();
            $table->string('company_size')->nullable();
            $table->timestamps();
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->after('company_id')->constrained('job_categories')->cascadeOnDelete();
            $table->bigInteger('salary_min')->nullable()->after('deadline');
            $table->bigInteger('salary_max')->nullable()->after('salary_min');
            $table->string('location')->nullable()->after('salary_max');
            $table->string('job_type')->default('Full-time')->after('location');
            $table->string('experience_level')->default('Entry Level')->after('job_type');
            $table->longText('requirements')->nullable()->after('experience_level');
        });
    }

    public function down(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['company_id']);
            $table->dropForeignKeyIfExists(['category_id']);
            $table->dropColumn(['company_id', 'category_id', 'salary_min', 'salary_max', 'location', 'job_type', 'experience_level', 'requirements']);
        });

        Schema::dropIfExists('companies');
        Schema::dropIfExists('job_categories');
    }
};
