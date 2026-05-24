<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SecurityHealthCommand extends Command
{
    protected $signature = 'tiamcp:security-health {--json : Output machine-readable JSON}';

    protected $description = 'Run security readiness checks for the web control plane.';

    public function handle(): int
    {
        $checks = [
            'app_key' => $this->checkAppKey(),
            'database' => $this->checkDatabase(),
            'admin_schema' => $this->checkAdminSchema(),
            'entitlement_signing' => $this->checkEntitlementSigning(),
        ];

        $ok = collect($checks)->every(fn (array $check): bool => $check['ok'] === true);

        if ($this->option('json')) {
            $this->line(json_encode([
                'ok' => $ok,
                'checks' => $checks,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '{}');

            return $ok ? self::SUCCESS : self::FAILURE;
        }

        foreach ($checks as $name => $check) {
            $status = $check['ok'] ? 'ok' : 'fail';
            $this->line($status.' '.$name.': '.$check['message']);
        }

        return $ok ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @return array{ok: bool, message: string}
     */
    private function checkAppKey(): array
    {
        $key = (string) config('app.key', '');

        return [
            'ok' => $key !== '',
            'message' => $key === '' ? 'APP_KEY is not configured.' : 'APP_KEY is configured.',
        ];
    }

    /**
     * @return array{ok: bool, message: string}
     */
    private function checkDatabase(): array
    {
        try {
            DB::select('select 1');
        } catch (Throwable $exception) {
            return [
                'ok' => false,
                'message' => $exception->getMessage(),
            ];
        }

        return [
            'ok' => true,
            'message' => 'Database connection responded.',
        ];
    }

    /**
     * @return array{ok: bool, message: string}
     */
    private function checkAdminSchema(): array
    {
        try {
            $ready = Schema::hasColumn('users', 'role')
                && Schema::hasTable('admin_audit_logs');
        } catch (Throwable $exception) {
            return [
                'ok' => false,
                'message' => $exception->getMessage(),
            ];
        }

        return [
            'ok' => $ready,
            'message' => $ready ? 'Admin role and audit schema are present.' : 'Admin role or audit schema is missing.',
        ];
    }

    /**
     * @return array{ok: bool, message: string}
     */
    private function checkEntitlementSigning(): array
    {
        $algorithm = (string) config('tiamcp.entitlement_signing_alg', 'HS256');

        if ($algorithm === 'RS256') {
            $privateKey = (string) config('tiamcp.entitlement_signing_private_key_path', '');
            $publicKey = (string) config('tiamcp.entitlement_signing_public_key_path', '');
            $ready = is_readable($privateKey) && is_readable($publicKey);

            return [
                'ok' => $ready,
                'message' => $ready ? 'RS256 signing keys are readable.' : 'RS256 signing key paths are not readable.',
            ];
        }

        $secret = (string) config('tiamcp.entitlement_signing_secret', '');

        return [
            'ok' => $secret !== '',
            'message' => $secret === '' ? 'HS256 signing secret is missing.' : 'HS256 signing secret is configured.',
        ];
    }
}
