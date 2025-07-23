<?php use CodeIgniter\Database\Seeder;

class MultiCsvSeeder extends Seeder
{
    public function run()
    {
        $this->seedFromCsv('users', 'users.csv');
        $this->seedFromCsv('userBirth', 'usersBirthInfo.csv');
				$this->seedFromCsv('userInterests', 'usersInterests.csv');
				$this->seedFromCsv('userProfession', 'usersProfiession.csv');
    }

    private function seedFromCsv(string $tableName, string $fileName)
    {
        $filePath = WRITEPATH . "seed-data/{$fileName}";

        if (($handle = fopen($filePath, 'r')) !== false) {
            $columns = fgetcsv($handle, 1000, ','); // Read headers

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $row = array_combine($columns, $data);
                $this->db->table($tableName)->insert($row);
            }

            fclose($handle);
            echo "Seeded {$tableName} from {$fileName}.\n";
        } else {
            echo "Error: Could not open {$fileName}.\n";
        }
    }
}
