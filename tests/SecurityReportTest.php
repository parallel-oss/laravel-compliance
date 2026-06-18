<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::delete(dirname(__DIR__).'/workbench/app/ReportedEvidence.php');
    File::delete(storage_path('framework/testing/security-evidence-report.md'));
});

it('reports capability mappings from enum-backed evidence', function () {
    $fixture = dirname(__DIR__).'/workbench/app/ReportedEvidence.php';
    $output = storage_path('framework/testing/security-evidence-report.md');

    File::ensureDirectoryExists(dirname($fixture));
    File::put($fixture, <<<'PHP'
<?php

namespace Workbench\App;

use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Evidence;

class ReportedEvidence
{
    #[Evidence(
        capabilities: CommonCapability::UserDataErasure,
        summary: 'Deletes user profile data and related records.'
    )]
    public function deleteUserData(): void
    {
        //
    }
}
PHP);

    config()->set('compliance.scan_paths', [$fixture]);
    config()->set('compliance.report.output', $output);
    config()->set('compliance.report.include_code', false);

    $this->artisan('security:generate-report')->assertSuccessful();

    expect($output)->toBeFile()
        ->and(file_get_contents($output))->toContain('Capability: User Data Erasure')
        ->and(file_get_contents($output))->toContain('`data_lifecycle.user_data_erasure`')
        ->and(file_get_contents($output))->toContain('`GDPR:Article 17`')
        ->and(file_get_contents($output))->toContain('`SOC2:P4.3`')
        ->and(file_get_contents($output))->toContain('Secure disposal of personal information')
        ->and(file_get_contents($output))->toContain('`VANTA:DCH-1` - Customer data deleted upon leaving')
        ->and(file_get_contents($output))->toContain('Vanta slug: `customer-data-deleted-upon-leave`')
        ->and(file_get_contents($output))->toContain('Deletes user profile data and related records.');
});
