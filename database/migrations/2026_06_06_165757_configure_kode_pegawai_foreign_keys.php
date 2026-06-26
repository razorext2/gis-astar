<?php

/** Goal: Standardize kode_pegawai data types and configure foreign key cascading constraints, Caller: php artisan migrate, Deps: Schema, DB */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure tb_pegawai.kode_pegawai has a unique index so it can be referenced by foreign keys
        try {
            Schema::table('tb_pegawai', function (Blueprint $table) {
                $table->unique('kode_pegawai');
            });
        } catch (\Exception $e) {
            // Index already exists in database
        }

        // 1. Standardize columns to matching data types (varchar(32))
        try {
            Schema::table('tb_drivers', function (Blueprint $table) {
                $table->string('kode_pegawai', 32)->nullable()->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tb_sales', function (Blueprint $table) {
                $table->string('kode_pegawai', 32)->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tb_team_members', function (Blueprint $table) {
                $table->string('kode_pegawai', 32)->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('kode_pegawai', 32)->nullable()->change();
            });
        } catch (\Exception $e) {}

        // 2. Insert dummy records for orphans to satisfy foreign keys dynamically
        $this->resolveOrphans();

        // 3. Create/recreate foreign key constraints on all target tables safely
        $this->recreateForeignKey('tb_overtime', 'cascade', 'cascade');
        $this->recreateForeignKey('tb_collect', 'set null', 'cascade');
        $this->recreateForeignKey('tb_drivers', 'set null', 'cascade');
        $this->recreateForeignKey('tb_point_transactions', 'cascade', 'cascade');
        $this->recreateForeignKey('tb_sales', 'cascade', 'cascade');
        $this->recreateForeignKey('tb_team_members', 'cascade', 'cascade');
        $this->recreateForeignKey('tb_technician', 'cascade', 'cascade');
        $this->recreateForeignKey('tb_technician_points', 'cascade', 'cascade');
        $this->recreateForeignKey('users', 'set null', 'cascade');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropForeignKeyIfExists('users');
        $this->dropForeignKeyIfExists('tb_technician_points');
        $this->dropForeignKeyIfExists('tb_technician');
        $this->dropForeignKeyIfExists('tb_team_members');
        $this->dropForeignKeyIfExists('tb_sales');
        $this->dropForeignKeyIfExists('tb_point_transactions');
        $this->dropForeignKeyIfExists('tb_drivers');
        $this->dropForeignKeyIfExists('tb_collect');
        $this->dropForeignKeyIfExists('tb_overtime');

        // Revert column types
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('kode_pegawai')->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tb_team_members', function (Blueprint $table) {
                $table->integer('kode_pegawai')->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tb_sales', function (Blueprint $table) {
                $table->string('kode_pegawai', 12)->change();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tb_drivers', function (Blueprint $table) {
                $table->string('kode_pegawai', 255)->nullable()->change();
            });
        } catch (\Exception $e) {}

        // Revert overtime foreign key
        try {
            Schema::table('tb_overtime', function (Blueprint $table) {
                $table->foreign('kode_pegawai', 'overtime_to_pegawai')
                    ->references('kode_pegawai')
                    ->on('tb_pegawai')
                    ->onUpdate('set null')
                    ->onDelete('cascade');
            });
        } catch (\Exception $e) {}

        // Delete dummy records
        try {
            DB::table('tb_pegawai')->whereIn('kode_pegawai', ['5', '23398', '23463', '23392'])->delete();
        } catch (\Exception $e) {}

        // Drop unique index on tb_pegawai.kode_pegawai if it was added
        try {
            Schema::table('tb_pegawai', function (Blueprint $table) {
                $table->dropUnique(['kode_pegawai']);
            });
        } catch (\Exception $e) {}
    }

    /**
     * Dynamically scan referencing tables for orphan kode_pegawai values and insert dummy records in tb_pegawai.
     */
    private function resolveOrphans(): void
    {
        $referencingTables = [
            'tb_overtime',
            'tb_collect',
            'tb_drivers',
            'tb_point_transactions',
            'tb_sales',
            'tb_team_members',
            'tb_technician',
            'tb_technician_points',
            'users'
        ];

        $orphanCodes = [];

        foreach ($referencingTables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'kode_pegawai')) {
                continue;
            }

            $orphans = DB::table($table)
                ->select('kode_pegawai')
                ->whereNotNull('kode_pegawai')
                ->whereNotExists(function ($query) use ($table) {
                    $query->select(DB::raw(1))
                        ->from('tb_pegawai')
                        ->whereColumn('tb_pegawai.kode_pegawai', '=', $table . '.kode_pegawai');
                })
                ->distinct()
                ->pluck('kode_pegawai')
                ->toArray();

            foreach ($orphans as $code) {
                $code = trim((string)$code);
                if ($code !== '') {
                    $orphanCodes[$code] = true;
                }
            }
        }

        if (!empty($orphanCodes)) {
            $insertData = [];
            foreach (array_keys($orphanCodes) as $code) {
                $insertData[] = [
                    'kode_pegawai' => $code,
                    'full_name' => 'Ex-Pegawai ' . $code,
                    'nik_pegawai' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('tb_pegawai')->insertOrIgnore($insertData);
        }
    }

    /**
     * Safely recreate a foreign key constraint.
     */
    private function recreateForeignKey(string $tableName, string $onDelete = 'cascade', string $onUpdate = 'cascade'): void
    {
        if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'kode_pegawai')) {
            return;
        }

        $this->dropForeignKeyIfExists($tableName);

        Schema::table($tableName, function (Blueprint $table) use ($onDelete, $onUpdate) {
            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('tb_pegawai')
                ->onUpdate($onUpdate)
                ->onDelete($onDelete);
        });
    }

    /**
     * Safely drop foreign key constraints referencing tb_pegawai on kode_pegawai column.
     */
    private function dropForeignKeyIfExists(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        $existingFks = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.key_column_usage
            WHERE table_schema = DATABASE()
              AND table_name = ?
              AND column_name = 'kode_pegawai'
              AND referenced_table_name = 'tb_pegawai'
        ", [$tableName]);

        foreach ($existingFks as $fk) {
            try {
                Schema::table($tableName, function (Blueprint $table) use ($fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                });
            } catch (\Exception $e) {
                // Ignore
            }
        }
    }
};
