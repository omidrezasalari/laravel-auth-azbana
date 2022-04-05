<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->mediumText('slogan')->nullable();//شعار
            $table->string('national_id')->unique()->nullable();
            $table->string('mobile')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->boolean('active')->default(false);
            $table->timestamp('birthday')->nullable();
            $table->set('role', ['user', 'technician', 'admin'])->default('user');
            $table->string('avatar')->nullable();
            $table->string('custom_color')->nullable();
            $table->string('cover')->nullable();
            $table->string('api_token')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            //$table->unsignedBigInteger('pin_video_id')->nullable(); // ویدیو معرفی
//            $table->foreign('pin_video_id')->references('id')->on('videos')
//                ->onDelete('cascade')->onUpdate('cascade');

            // شغل اضافه گردد.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
