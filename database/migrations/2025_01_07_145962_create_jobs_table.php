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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('media_id')->nullable();
            $table->foreignId('job_category_id')->constrained('job_categories');
            $table->foreignId('job_type_id')->constrained('job_types');
            $table->text('description')->nullable();
            $table->text('detail')->nullable();
            $table->text('business_skill')->nullable();
            $table->text('knowledge')->nullable();
            $table->string('location')->nullable();
            $table->text('activity')->nullable();
            $table->boolean('academic_degree_doctor')->default(false);
            $table->boolean('academic_degree_master')->default(false);
            $table->boolean('academic_degree_professional')->default(false);
            $table->boolean('academic_degree_bachelor')->default(false);
            $table->string('salary_statistic_group')->nullable();
            $table->string('salary_range_first_year')->nullable();
            $table->string('salary_range_average')->nullable();
            $table->text('salary_range_remarks')->nullable();
            $table->text('restriction')->nullable();
            $table->integer('estimated_total_workers')->nullable();
            $table->text('remarks')->nullable();
            $table->string('url')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('publish_status')->default(1);
            $table->integer('version')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->boolean('deleted')->nullable();
            $table->boolean('created')->default(true);
            $table->boolean('modified')->nullable();

            // Add standard indexes
            $table->index('job_category_id', 'idx_job_category_id');
            $table->index('job_type_id', 'idx_job_type_id');
            $table->index('publish_status', 'idx_publish_status');
            $table->index('deleted', 'idx_deleted');

            // Add a composite index for sorting
            $table->index(['sort_order', 'id'], 'idx_sort_order_id');

            // Add a full-text index for text search columns
            $table->fullText([
                'name',
                'description',
                'detail',
                'business_skill',
                'knowledge',
                'location',
                'activity',
                'salary_statistic_group',
                'salary_range_remarks',
                'restriction',
                'remarks'
            ], 'idx_job_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
