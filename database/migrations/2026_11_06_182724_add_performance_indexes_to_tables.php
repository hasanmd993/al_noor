<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->index(['is_published', 'is_featured', 'sort_order'], 'props_pub_feat_sort_idx');
            $table->index(['is_published', 'status'], 'props_pub_status_idx');
            $table->index(['is_published', 'location_id'], 'props_pub_loc_idx');
            $table->index(['is_published', 'category_id'], 'props_pub_cat_idx');
            $table->index(['is_published', 'price_from'], 'props_pub_price_idx');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'blogs_pub_date_idx');
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->index(['is_read', 'created_at'], 'inq_read_date_idx');
            $table->index(['source', 'is_read'], 'inq_source_read_idx');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('props_pub_feat_sort_idx');
            $table->dropIndex('props_pub_status_idx');
            $table->dropIndex('props_pub_loc_idx');
            $table->dropIndex('props_pub_cat_idx');
            $table->dropIndex('props_pub_price_idx');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('blogs_pub_date_idx');
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropIndex('inq_read_date_idx');
            $table->dropIndex('inq_source_read_idx');
        });
    }
};
