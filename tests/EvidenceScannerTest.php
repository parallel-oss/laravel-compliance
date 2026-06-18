<?php

use Illuminate\Support\Facades\File;
use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Scanning\EvidenceScanner;

afterEach(function () {
    File::delete(dirname(__DIR__).'/workbench/app/ScannedEvidence.php');
});

it('finds evidence attributes on classes and methods', function () {
    $fixture = dirname(__DIR__).'/workbench/app/ScannedEvidence.php';

    File::ensureDirectoryExists(dirname($fixture));
    File::put($fixture, <<<'PHP'
<?php

namespace Workbench\App;

use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Evidence;
use Parallel\Compliance\Tests\Fixtures\TestRequirement;

#[Evidence(
    controls: TestRequirement::Example,
    capabilities: CommonCapability::UserDataErasure,
    summary: 'Class-level evidence.'
)]
class ScannedEvidence
{
    #[Evidence(
        controls: [TestRequirement::Example],
        capabilities: [CommonCapability::AccessLogging],
        summary: 'Method-level evidence.'
    )]
    public function handle(): void
    {
        //
    }
}
PHP);

    $findings = (new EvidenceScanner)->scan([$fixture]);

    expect($findings)->toHaveCount(2)
        ->and($findings[0]->target)->toBe('Workbench\\App\\ScannedEvidence')
        ->and($findings[0]->code)->toContain('#[Evidence(')
        ->and($findings[0]->evidence->capabilities[0])->toBe(CommonCapability::UserDataErasure)
        ->and($findings[0]->evidence->summary)->toBe('Class-level evidence.')
        ->and($findings[1]->target)->toBe('Workbench\\App\\ScannedEvidence::handle()')
        ->and($findings[1]->evidence->capabilities[0])->toBe(CommonCapability::AccessLogging)
        ->and($findings[1]->evidence->summary)->toBe('Method-level evidence.');
});
