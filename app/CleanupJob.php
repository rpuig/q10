
<?php

namespace App; // Adjust the namespace based on your application structure

class CleanupJob extends ScheduledJob // Change to ScheduledJob if using Scheduler approach
{
    public function execute()
    {
        $cleanupPeriod = 5184000; // 60 days in seconds

        // Use CI4's Time object for period calculations
        $cleanupThreshold = time() - $cleanupPeriod;

        // Access database through dependency injection (replace with your model)
        $userModel = service('UserModel');

        $builder = $userModel->builder();

        // Build query using builder with where conditions and parameter binding
        $builder->where('deleted_at IS NOT NULL')
               ->where('deleted_at <', $cleanupThreshold);

        $deleted = $builder->delete();

        echo "Cleanup completed. Deleted rows: " . $deleted->getResultCount() . PHP_EOL;
    }
}