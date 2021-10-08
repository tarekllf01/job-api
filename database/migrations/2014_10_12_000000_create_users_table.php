<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create(with(new User)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $users = [
            ['name' => 'TAREK HOSSEN','email' => 'tarekllf01@gmail.com','role'=> 'admin','password'=>Hash::make('password')],
            ['name' => 'TEST USER','email' => 'user@gmail.com','role'=> 'user','password'=>Hash::make('password')]
        ];
        User::insert($users);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(with(new User)->getTable());
    }
}
