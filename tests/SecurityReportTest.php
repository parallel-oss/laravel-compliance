<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::delete(dirname(__DIR__).'/workbench/app/ReportedEvidence.php');
    File::delete(storage_path('framework/testing/security-evidence-report.md'));
});

it('reports control mappings from enum-backed evidence', function () {
    $fixture = dirname(__DIR__).'/workbench/app/ReportedEvidence.php';
    $output = storage_path('framework/testing/security-evidence-report.md');

    File::ensureDirectoryExists(dirname($fixture));
    File::put($fixture, <<<'PHP'
<?php

namespace Workbench\App;

use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Evidence;

class ReportedEvidence
{
    #[Evidence(
        controls: ComplianceControl::DataEncryptionUtilized,
        summary: 'Encrypts customer data at rest.'
    )]
    public function encryptCustomerData(): void
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
        ->and(file_get_contents($output))->toContain('Control: Data encryption utilized')
        ->and(file_get_contents($output))->toContain('`data-encrypted`')
        ->and(file_get_contents($output))->toContain('`SOC2:CC6.1`')
        ->and(file_get_contents($output))->toContain('`SOC2:PI1.4`')
        ->and(file_get_contents($output))->toContain('### Related Tests')
        ->and(file_get_contents($output))->toContain('`aws-dynamodb-encryption`')
        ->and(file_get_contents($output))->not->toContain('approved-cryptography-policy-bsi-exists')
        ->and(file_get_contents($output))->toContain('Encrypts customer data at rest.');
});
