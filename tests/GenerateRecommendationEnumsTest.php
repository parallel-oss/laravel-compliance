<?php

use Illuminate\Support\Facades\File;

it('generates typed requirement enums with docblocks', function () {
    $input = storage_path('framework/testing/requirements.json');
    $output = storage_path('framework/testing/enums');

    File::ensureDirectoryExists(dirname($input));
    File::deleteDirectory($output);

    file_put_contents($input, json_encode([
        [
            'id' => 'OWASP_ASVS:5.0.0:V2.1.1',
            'source' => 'OWASP_ASVS',
            'source_version' => '5.0.0',
            'source_id' => 'V2.1.1',
            'title' => 'Verify secure password handling.',
            'description' => 'Passwords are handled using accepted controls.',
        ],
    ]));

    $this->artisan('security:generate-enums', [
        'input' => [$input],
        '--output' => $output,
        '--namespace' => 'Workbench\\App\\Enums\\Compliance',
    ])->assertSuccessful();

    $generated = $output.'/OwaspAsvs500Requirements.php';

    expect($generated)->toBeFile()
        ->and(file_get_contents($generated))->toContain('namespace Workbench\\App\\Enums\\Compliance;')
        ->and(file_get_contents($generated))->toContain('enum OwaspAsvs500Requirements: string implements Recommendation')
        ->and(file_get_contents($generated))->toContain('case V2_1_1 = \'OWASP_ASVS:5.0.0:V2.1.1\';')
        ->and(file_get_contents($generated))->toContain('Verify secure password handling.');
});
