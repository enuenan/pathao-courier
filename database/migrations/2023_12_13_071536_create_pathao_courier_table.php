<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $PATHAO_COURIER_TABLE_NAME;

    public function __construct()
    {
        $this->PATHAO_COURIER_TABLE_NAME = config('pathao-courier.pathao_db_table_name');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->PATHAO_COURIER_TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->uuid('secret_token')->uniqe();
            $table->text('token');
            $table->text('refresh_token');
            $table->string('expires_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->PATHAO_COURIER_TABLE_NAME);
    }
};
