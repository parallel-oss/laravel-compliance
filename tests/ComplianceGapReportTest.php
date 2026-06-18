<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::delete(dirname(__DIR__).'/workbench/app/ReportedComplianceGap.php');
    File::delete(storage_path('framework/testing/compliance-gap-report.md'));
});

it('reports compliance gaps separately from implemented evidence', function () {
    $fixture = dirname(__DIR__).'/workbench/app/ReportedComplianceGap.php';
    $output = storage_path('framework/testing/compliance-gap-report.md');

    File::ensureDirectoryExists(dirname($fixture));
    File::put($fixture, <<<'PHP'
<?php

namespace Workbench\App;

use Parallel\Compliance\ComplianceGap;
use Parallel\Compliance\Controls\ComplianceControl;

class ReportedComplianceGap
{
    #[ComplianceGap(
        summary: 'Account closure does not delete billing export files.',
        controls: ComplianceControl::CustomerDataDeletedUponLeaving,
        details: 'The account closure flow deletes database records but leaves generated export files in object storage.',
        remediation: 'Delete object storage exports during account closure.',
        owner: 'platform'
    )]
    public function closeAccount(): void
    {
        //
    }
}
PHP);

    config()->set('compliance.scan_paths', [$fixture]);
    config()->set('compliance.gaps.output', $output);
    config()->set('compliance.gaps.include_code', false);

    $this->artisan('security:find-gaps')->assertSuccessful();

    expect($output)->toBeFile()
        ->and(file_get_contents($output))->toContain('# Compliance Gap Report')
        ->and(file_get_contents($output))->toContain('Gap: Account closure does not delete billing export files.')
        ->and(file_get_contents($output))->toContain('**Expected Controls:** `Customer data deleted upon leaving`')
        ->and(file_get_contents($output))->toContain('**Owner:** platform')
        ->and(file_get_contents($output))->toContain('Delete object storage exports during account closure.')
        ->and(file_get_contents($output))->not->toContain('### Code');
});
