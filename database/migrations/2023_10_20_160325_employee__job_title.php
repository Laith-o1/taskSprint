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
         Schema::create('employee_jobTitle', function (Blueprint $table) {

                $table->unsignedBigInteger('employee_id');
                $table->unsignedBigInteger('jobTitle_id');
                $table->timestamps();
                $table->primary(['employee_id', 'jobTitle_id']);
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
                $table->foreign('jobTitle_id')->references('id')->on('jobTitles')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
