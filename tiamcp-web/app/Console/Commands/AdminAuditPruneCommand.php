<?php

namespace App\Console\Commands;

use App\Models\AdminAuditLog;
use Illuminate\Console\Command;

class AdminAuditPruneCommand extends Command
{
    protected $signature = 'tiamcp:prune-admin-audit {--days=180 : Retention window in days} {--dry-run : Count without deleting}';

    protected $description = 'Prune admin audit logs older than the retention window.';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days < 1) {
            $this->error('The --days option must be greater than zero.');

            return self::FAILURE;
        }

        $cutoff = now()->subDays($days);
        $count = AdminAuditLog::query()->where('created_at', '<', $cutoff)->count();

        if ($this->option('dry-run')) {
            $this->line('dry-run admin_audit_logs prunable='.$count);

            return self::SUCCESS;
        }

        AdminAuditLog::query()->where('created_at', '<', $cutoff)->delete();
        $this->line('pruned admin_audit_logs count='.$count);

        return self::SUCCESS;
    }
}
