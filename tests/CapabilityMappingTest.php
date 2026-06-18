<?php

use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Frameworks\GdprArticle;
use Parallel\Compliance\Frameworks\Soc2Criteria;
use Parallel\Compliance\Mappings\VantaControlFrameworkMappings;
use Parallel\Compliance\Mappings\VantaControlSoc2Mappings;

it('maps selected Vanta controls to additional enum-backed framework requirements', function () {
    $mappings = VantaControlFrameworkMappings::defaults();

    expect($mappings)
        ->toHaveKey(VantaControl::DCH_1->value)
        ->and($mappings[VantaControl::DCH_1->value])
        ->toContain(GdprArticle::Article17);

    foreach ($mappings as $requirements) {
        foreach ($requirements as $requirement) {
            expect($requirement)->toBeInstanceOf(FrameworkRequirement::class);
        }
    }
});

it('includes all Vanta implementation controls referenced by the purchased SOC 2 framework', function () {
    $expected = [
        'VANTA:AST-1', 'VANTA:AST-2', 'VANTA:AST-3',
        'VANTA:BCD-1', 'VANTA:BCD-2', 'VANTA:BCD-3', 'VANTA:BCD-4', 'VANTA:BCD-5', 'VANTA:BCD-6',
        'VANTA:CAP-1',
        'VANTA:CFG-1',
        'VANTA:CHG-1', 'VANTA:CHG-2', 'VANTA:CHG-3',
        'VANTA:CPL-1', 'VANTA:CPL-2',
        'VANTA:CRY-1', 'VANTA:CRY-2', 'VANTA:CRY-3', 'VANTA:CRY-4', 'VANTA:CRY-5',
        'VANTA:DCH-1', 'VANTA:DCH-2', 'VANTA:DCH-3', 'VANTA:DCH-4', 'VANTA:DCH-5', 'VANTA:DCH-6', 'VANTA:DCH-7', 'VANTA:DCH-8', 'VANTA:DCH-9', 'VANTA:DCH-10', 'VANTA:DCH-11',
        'VANTA:END-1',
        'VANTA:GOV-1', 'VANTA:GOV-2', 'VANTA:GOV-3', 'VANTA:GOV-4', 'VANTA:GOV-5', 'VANTA:GOV-6', 'VANTA:GOV-7', 'VANTA:GOV-8', 'VANTA:GOV-9', 'VANTA:GOV-10', 'VANTA:GOV-11', 'VANTA:GOV-12', 'VANTA:GOV-13',
        'VANTA:HRS-1', 'VANTA:HRS-2', 'VANTA:HRS-3', 'VANTA:HRS-4', 'VANTA:HRS-5', 'VANTA:HRS-6',
        'VANTA:IAC-1', 'VANTA:IAC-2', 'VANTA:IAC-3', 'VANTA:IAC-4', 'VANTA:IAC-5', 'VANTA:IAC-6', 'VANTA:IAC-7', 'VANTA:IAC-8', 'VANTA:IAC-9', 'VANTA:IAC-10', 'VANTA:IAC-11', 'VANTA:IAC-12', 'VANTA:IAC-13',
        'VANTA:IAO-1', 'VANTA:IAO-2',
        'VANTA:IRO-1', 'VANTA:IRO-2', 'VANTA:IRO-3', 'VANTA:IRO-4',
        'VANTA:MDM-1',
        'VANTA:MON-1', 'VANTA:MON-2', 'VANTA:MON-3', 'VANTA:MON-4',
        'VANTA:NET-1', 'VANTA:NET-2', 'VANTA:NET-3', 'VANTA:NET-4', 'VANTA:NET-5',
        'VANTA:OPS-1',
        'VANTA:PES-1', 'VANTA:PES-2', 'VANTA:PES-3', 'VANTA:PES-4', 'VANTA:PES-5',
        'VANTA:PRI-1', 'VANTA:PRI-2', 'VANTA:PRI-3', 'VANTA:PRI-4', 'VANTA:PRI-5', 'VANTA:PRI-6', 'VANTA:PRI-7', 'VANTA:PRI-8', 'VANTA:PRI-9', 'VANTA:PRI-10', 'VANTA:PRI-11', 'VANTA:PRI-12', 'VANTA:PRI-13', 'VANTA:PRI-14', 'VANTA:PRI-15', 'VANTA:PRI-16', 'VANTA:PRI-17',
        'VANTA:PRM-1', 'VANTA:PRM-2', 'VANTA:PRM-3',
        'VANTA:RSK-1', 'VANTA:RSK-2', 'VANTA:RSK-3',
        'VANTA:SAT-1',
        'VANTA:TDA-1', 'VANTA:TDA-2', 'VANTA:TDA-3', 'VANTA:TDA-4',
        'VANTA:TPM-1', 'VANTA:TPM-2',
        'VANTA:VPM-1', 'VANTA:VPM-2',
    ];

    $actual = array_map(
        fn (VantaControl $control) => $control->value,
        VantaControl::cases(),
    );

    expect($actual)->toHaveCount(119);

    foreach ($expected as $control) {
        expect($actual)->toContain($control);
    }
});

it('keeps report metadata on the relevant enums', function () {
    expect(Soc2Criteria::CC6_1->source())->toBe('SOC 2')
        ->and(Soc2Criteria::CC6_1->title())->toBe('Logical access security implementation')
        ->and(VantaControl::IAC_2->source())->toBe('Vanta')
        ->and(VantaControl::IAC_2->externalId())->toBe('IAC-2')
        ->and(VantaControl::IAC_2->slug())->toBe('access-control-procedures')
        ->and(VantaControl::IAC_2->title())->toBe('Access control procedures established')
        ->and(VantaControl::IAC_2->description())
        ->toContain('access control policy');
});

it('centralizes Vanta control to SOC 2 section mappings with enums', function () {
    expect(VantaControlSoc2Mappings::sectionsFor(VantaControl::IAC_2))
        ->toContain(Soc2Criteria::CC5_2)
        ->toContain(Soc2Criteria::CC6_1)
        ->toContain(Soc2Criteria::CC6_2)
        ->toContain(Soc2Criteria::CC6_3)
        ->and(VantaControlSoc2Mappings::sectionIdsFor(VantaControl::DCH_1))
        ->toBe(['C1.2', 'CC6.5']);
});

it('includes SOC 2 section-level criteria from the purchased SOC 2 framework', function () {
    $expected = [
        'SOC2:A1.1', 'SOC2:A1.2', 'SOC2:A1.3',
        'SOC2:C1.1', 'SOC2:C1.2',
        'SOC2:CC1.1', 'SOC2:CC1.2', 'SOC2:CC1.3', 'SOC2:CC1.4', 'SOC2:CC1.5',
        'SOC2:CC2.1', 'SOC2:CC2.2', 'SOC2:CC2.3',
        'SOC2:CC3.1', 'SOC2:CC3.2', 'SOC2:CC3.3', 'SOC2:CC3.4',
        'SOC2:CC4.1', 'SOC2:CC4.2',
        'SOC2:CC5.1', 'SOC2:CC5.2', 'SOC2:CC5.3',
        'SOC2:CC6.1', 'SOC2:CC6.2', 'SOC2:CC6.3', 'SOC2:CC6.4', 'SOC2:CC6.5', 'SOC2:CC6.6', 'SOC2:CC6.7', 'SOC2:CC6.8',
        'SOC2:CC7.1', 'SOC2:CC7.2', 'SOC2:CC7.3', 'SOC2:CC7.4', 'SOC2:CC7.5',
        'SOC2:CC8.1',
        'SOC2:CC9.1', 'SOC2:CC9.2',
        'SOC2:P1.1', 'SOC2:P2.1', 'SOC2:P3.1', 'SOC2:P3.2',
        'SOC2:P4.1', 'SOC2:P4.2', 'SOC2:P4.3',
        'SOC2:P5.1', 'SOC2:P5.2',
        'SOC2:P6.1', 'SOC2:P6.2', 'SOC2:P6.3', 'SOC2:P6.4', 'SOC2:P6.5', 'SOC2:P6.6', 'SOC2:P6.7',
        'SOC2:P7.1', 'SOC2:P8.1',
        'SOC2:PI1.1', 'SOC2:PI1.2', 'SOC2:PI1.3', 'SOC2:PI1.4', 'SOC2:PI1.5',
    ];

    $actual = array_map(
        fn (Soc2Criteria $criteria) => $criteria->value,
        Soc2Criteria::cases(),
    );

    foreach ($expected as $criteria) {
        expect($actual)->toContain($criteria);
    }
});
