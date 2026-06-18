<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(storage_path('framework/testing/cursor-skills'));
});

it('publishes packaged skills into a Cursor project skills directory', function () {
    $output = storage_path('framework/testing/cursor-skills');

    $this->artisan('laravel-compliance:publish-skills', [
        '--path' => $output,
    ])->assertSuccessful();

    expect($output.'/use-laravel-compliance/SKILL.md')->toBeFile()
        ->and($output.'/use-laravel-compliance/references/mapping-sources.md')->toBeFile()
        ->and($output.'/map-compliance-evidence/SKILL.md')->not->toBeFile()
        ->and(file_get_contents($output.'/use-laravel-compliance/SKILL.md'))->toContain('name: use-laravel-compliance');
});

it('does not overwrite existing project skills unless forced', function () {
    $output = storage_path('framework/testing/cursor-skills');
    $skill = $output.'/use-laravel-compliance/SKILL.md';

    File::ensureDirectoryExists(dirname($skill));
    File::put($skill, 'custom local skill');

    $this->artisan('laravel-compliance:publish-skills', [
        '--path' => $output,
    ])->assertSuccessful();

    expect(file_get_contents($skill))->toBe('custom local skill');

    $this->artisan('laravel-compliance:publish-skills', [
        '--path' => $output,
        '--force' => true,
    ])->assertSuccessful();

    expect(file_get_contents($skill))->toContain('name: use-laravel-compliance');
});
