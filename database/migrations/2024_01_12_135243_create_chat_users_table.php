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
        Schema::create('chat_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('chat_id');

            $table->index('user_id', 'chat_user_user_idx');
            $table->index('chat_id', 'chat_user_chat_idx');
            

            $table->foreign('user_id', 'chat_user_user_fk')->on('users')->references('id');
            $table->foreign('chat_id', 'chat_user_chat_fk')->on('chats')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_users', function (Blueprint $table) {
            $table->dropForeign('chat_user_user_fk');
            $table->dropForeign('chat_user_chat_fk');
            
        });
        Schema::dropIfExists('chat_users');
    }
};
