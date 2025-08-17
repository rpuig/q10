<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class SeedDummyData extends Migration
{
    public function up()
    {
        // Llamar al seeder para poblar datos dummy
        $seeder = Database::seeder();
        $seeder->call('App\Database\Seeds\DummyDataSeeder');
    }

    public function down()
    {
        // Limpiar datos (orden seguro + CASCADE)
        $db = Database::connect();

        // Tablas sin FK a users primero
        $db->query('TRUNCATE TABLE xgroups.userchatmessages RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.usermatches RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_eb_eb_full_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_hs_hs_full_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_eb_eb_scores RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_eb_eb_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_hs_hs_scores RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_hs_hs_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_na_na_scores RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_zd_zd_scores RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_zd_zd_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_my_scores RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.match_scores_my_weights RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.users_backup RESTART IDENTITY CASCADE');

        // Dependientes de users
        $db->query('TRUNCATE TABLE xgroups.userinterests RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.userastroinfo RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.userbirthinfo RESTART IDENTITY CASCADE');
        $db->query('TRUNCATE TABLE xgroups.userprofinfo RESTART IDENTITY CASCADE');

        // Al final users
        $db->query('TRUNCATE TABLE xgroups.users RESTART IDENTITY CASCADE');
    }
}
