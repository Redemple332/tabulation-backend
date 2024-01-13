<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->string('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

         // Permission Groups
         Schema::create('permission_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        // Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('permission_group_id')->cascadeOnUpdate();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('route');
            $table->timestamps();
            $table->softDeletes();
        });

        // Role Permissions
        Schema::create('role_permission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('permission_id')->cascadeOnUpdate();
            $table->foreignUuid('role_id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_groups');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_permission');
    }

    
};
