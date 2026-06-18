<?php

use Illuminate\Support\Facades\File;
use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Scanning\ComplianceGapScanner;

afterEach(function () {
    File::delete(dirname(__DIR__).'/workbench/app/ScannedComplianceGap.php');
});

it('finds compliance gap attributes on classes and methods', function () {
    $fixture = dirname(__DIR__).'/workbench/app/ScannedComplianceGap.php';

    File::ensureDirectoryExists(dirname($fixture));
    File::put($fixture, <<<'PHP'
<?php

namespace Workbench\App;

use Parallel\Compliance\ComplianceGap;
use Parallel\Compliance\Controls\ComplianceControl;

#[ComplianceGap(
    summary: 'Account export does not include deletion audit coverage yet.',
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
)]
class ScannedComplianceGap
{
    #[ComplianceGap(
        summary: 'Data export endpoint needs access logging.',
        controls: [ComplianceControl::LogManagementUtilized],
        remediation: 'Emit an audit log entry when exports are requested.'
    )]
    public function export(): void
    {
        //
    }
}
PHP);

    $findings = (new ComplianceGapScanner)->scan([$fixture]);

    expect($findings)->toHaveCount(2)
        ->and($findings[0]->target)->toBe('Workbench\\App\\ScannedComplianceGap')
        ->and($findings[0]->code)->toContain('#[ComplianceGap(')
        ->and($findings[0]->gap->controls[0])->toBe(ComplianceControl::CustomerDataDeletedUponLeaving)
        ->and($findings[0]->gap->summary)->toBe('Account export does not include deletion audit coverage yet.')
        ->and($findings[1]->target)->toBe('Workbench\\App\\ScannedComplianceGap::export()')
        ->and($findings[1]->gap->controls[0])->toBe(ComplianceControl::LogManagementUtilized)
        ->and($findings[1]->gap->remediation)->toBe('Emit an audit log entry when exports are requested.');
});
