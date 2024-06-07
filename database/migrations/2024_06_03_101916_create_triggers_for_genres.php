<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Trigger for INSERT
        DB::unprepared('
            CREATE TRIGGER after_genres_insert
            AFTER INSERT ON genres
            FOR EACH ROW
            BEGIN
                INSERT INTO log_activities (user_id, action, table_affected, description, action_date, created_at, updated_at)
                VALUES (@user_id, "insert", "genres", CONCAT("Inserted a new row with ID ", NEW.id), NOW(), NOW(), NOW());
            END
        ');

        // Trigger for UPDATE
        DB::unprepared('
            CREATE TRIGGER after_genres_update
            AFTER UPDATE ON genres
            FOR EACH ROW
            BEGIN
                INSERT INTO log_activities (user_id, action, table_affected, description, action_date, created_at, updated_at)
                VALUES (@user_id, "update", "genres", CONCAT("Updated row with ID ", NEW.id), NOW(), NOW(), NOW());
            END
        ');

        // Trigger for DELETE
        DB::unprepared('
            CREATE TRIGGER after_genres_delete
            AFTER DELETE ON genres
            FOR EACH ROW
            BEGIN
                INSERT INTO log_activities (user_id, action, table_affected, description, action_date, created_at, updated_at)
                VALUES (@user_id, "delete", "genres", CONCAT("Deleted row with ID ", OLD.id), NOW(), NOW(), NOW());
            END
        ');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_genres_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_genres_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_genres_delete');
    }
};
