<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\Database;
use Faker\Factory;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $db    = Database::connect();
        $faker = Factory::create('en_US');

        // 🔐 Password conocida SOLO para los nuevos dummy users
        $sharedPasswordPlain = 'DummyPass123!';
        $sharedHash          = password_hash($sharedPasswordPlain, PASSWORD_BCRYPT);

        // ¿Cuántos intentos de creación de usuarios dummy?
        $targetNewUsers = 12;
        $created        = 0;

        // No tocamos: match_scores_*, userastroinfo, usermatches, userchatmessages
        // Tampoco truncamos nada.

        while ($created < $targetNewUsers) {
            // Generar datos con fijaciones
            $rawUsername = $faker->unique()->userName();
            $username    = substr($rawUsername, 0, 20); // clamp 20
            $email       = $faker->unique()->safeEmail();

            // Respetar existentes: si ya hay usuario con mismo email o username, saltar
            $exists = $db->table('xgroups.users')
                ->groupStart()
                    ->where('email', $email)
                    ->orWhere('username', $username)
                ->groupEnd()
                ->countAllResults();

            if ($exists > 0) {
                // Evitar bucle infinito si Faker repite; seguimos intentando otro
                continue;
            }

            // Insertar NUEVO usuario (no se tocan los existentes)
            $db->table('xgroups.users')->insert([
                'username'        => $username,
                'email'           => $email,
                'password'        => $sharedHash,  // misma password para los nuevos
                'name'            => $faker->firstName(),
                'surname'         => $faker->lastName(),
                'sex'             => $faker->randomElement(['M','F','O']),
                'looking'         => $faker->randomElement(['friends','dating','networking']),
                'aboutme'         => $faker->sentence(8),
                'data_visibility' => '{}',
                'active'          => $faker->boolean(70),
                'is_active'       => $faker->boolean(70),
                'language'        => $faker->randomElement(['en','es','ca']),
                'created_at'      => time(), // bigint en tu esquema
                // updated_at usa DEFAULT CURRENT_TIMESTAMP
            ]);

            $uid = $db->insertID();
            $created++;

            // ─────────────────────────────────────────────────────────
            // RELACIONADAS (respetando existentes)
            // ─────────────────────────────────────────────────────────

            // userinterests: solo setear si fila existe (trigger) y está “vacía” (interests='{}' y lookingfor='Not set')
            $interestsRow = $db->table('xgroups.userinterests')->where('userid', $uid)->get()->getRowArray();
            if ($interestsRow) {
                $needsUpdate = ($interestsRow['interests'] === '{}' || $interestsRow['interests'] === null)
                            || ($interestsRow['lookingfor'] === 'Not set' || $interestsRow['lookingfor'] === null);
                if ($needsUpdate) {
                    $db->table('xgroups.userinterests')->where('userid', $uid)->update([
                        'interests'  => json_encode(['music','books','coding','sports']),
                        'lookingfor' => 'Chat',
                    ]);
                }
            } else {
                // Si por cualquier razón no existiera, crearla
                $db->table('xgroups.userinterests')->insert([
                    'userid'     => $uid,
                    'interests'  => json_encode(['music','books','coding','sports']),
                    'lookingfor' => 'Chat',
                ]);
            }

            // userprofinfo: respetar si ya tiene datos; si está NULL, completar con clamp(20)
            $profRow = $db->table('xgroups.userprofinfo')->where('userid', $uid)->get()->getRowArray();
            if ($profRow) {
                $updates = [];
                if (empty($profRow['profession'])) {
                    $updates['profession'] = substr($faker->randomElement(['Engineer','Designer','Teacher','Driver','Chef']), 0, 20);
                }
                if (empty($profRow['position'])) {
                    $updates['position'] = substr($faker->randomElement(['Junior','Senior','Lead','Manager']), 0, 20);
                }
                if (empty($profRow['sector'])) {
                    $updates['sector'] = substr($faker->randomElement(['IT','Health','Education','Logistics','Food']), 0, 20);
                }
                if (!empty($updates)) {
                    $db->table('xgroups.userprofinfo')->where('userid', $uid)->update($updates);
                }
            } else {
                // Crear con valores acotados
                $db->table('xgroups.userprofinfo')->insert([
                    'userid'     => $uid,
                    'profession' => substr($faker->randomElement(['Engineer','Designer','Teacher','Driver','Chef']), 0, 20),
                    'position'   => substr($faker->randomElement(['Junior','Senior','Lead','Manager']), 0, 20),
                    'sector'     => substr($faker->randomElement(['IT','Health','Education','Logistics','Food']), 0, 20),
                    'username'   => $username, // columna existe y es varchar(20) en tu tabla
                ]);
            }

            // userbirthinfo: si trigger no la creó, insertamos; si existe, NO pisamos (respetar)
            $birthExists = $db->table('xgroups.userbirthinfo')->where('userid', $uid)->countAllResults();
            if ($birthExists == 0) {
                $db->table('xgroups.userbirthinfo')->insert([
                    'userid'       => $uid,
                    'sex'          => $faker->randomElement(['M','F','O']),
                    'birthdate'    => $faker->date('d/m/Y'),
                    'birthtime'    => $faker->time('H:i'),
                    'timezone'     => '1',
                    'timezone_txt' => 'UTC+1',
                    'city'         => $faker->city(),
                    'birthcountry' => $faker->countryCode(),
                    'lon'          => (string)$faker->longitude(),
                    'lat'          => (string)$faker->latitude(),
                ]);
            }

            // users_backup: crear solo si no hay fila con ese userid
            $backupExists = $db->table('xgroups.users_backup')->where('userid', $uid)->countAllResults();
            if ($backupExists == 0) {
                $db->table('xgroups.users_backup')->insert([
                    'userid'         => $uid,
                    'created_at'     => time(),
                    'username'       => $username,
                    'email'          => $email,
                    'password'       => $sharedHash, // misma password que users
                    'name'           => $faker->firstName(),
                    'surname'        => $faker->lastName(),
                    'sex'            => $faker->randomElement(['M','F','O']),
                    'looking'        => $faker->randomElement(['friends','dating','networking']),
                    'aboutme'        => $faker->sentence(8),
                    'data_visibility'=> '{}',
                ]);
            }
        }

        echo "Seeding finalizado. Se añadieron {$created} usuarios nuevos sin modificar los existentes.\n";
        echo "Password de los nuevos dummy users: {$sharedPasswordPlain}\n";
    }
}
