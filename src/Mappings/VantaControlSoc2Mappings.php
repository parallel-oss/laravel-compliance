<?php

namespace Parallel\Compliance\Mappings;

use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Frameworks\Soc2Criteria;

class VantaControlSoc2Mappings
{
    /**
     * @return array<string, array<int, Soc2Criteria>>
     */
    public static function defaults(): array
    {
        return [
            VantaControl::AST_1->value => [Soc2Criteria::C1_2, Soc2Criteria::CC6_5],
            VantaControl::AST_2->value => [Soc2Criteria::C1_1, Soc2Criteria::CC5_3, Soc2Criteria::CC6_5, Soc2Criteria::P4_2],
            VantaControl::AST_3->value => [Soc2Criteria::CC6_1],
            VantaControl::BCD_1->value => [Soc2Criteria::A1_3, Soc2Criteria::CC9_1],
            VantaControl::BCD_2->value => [Soc2Criteria::A1_2, Soc2Criteria::A1_3, Soc2Criteria::CC3_2, Soc2Criteria::CC7_5, Soc2Criteria::PI1_5],
            VantaControl::BCD_3->value => [Soc2Criteria::CC9_1],
            VantaControl::BCD_4->value => [Soc2Criteria::A1_2],
            VantaControl::BCD_5->value => [Soc2Criteria::A1_2],
            VantaControl::BCD_6->value => [Soc2Criteria::A1_2],
            VantaControl::CAP_1->value => [Soc2Criteria::A1_1],
            VantaControl::CFG_1->value => [Soc2Criteria::CC3_4, Soc2Criteria::CC7_1],
            VantaControl::CHG_1->value => [Soc2Criteria::CC5_3, Soc2Criteria::CC7_1, Soc2Criteria::CC8_1],
            VantaControl::CHG_2->value => [Soc2Criteria::CC6_1, Soc2Criteria::CC8_1],
            VantaControl::CHG_3->value => [Soc2Criteria::CC5_2, Soc2Criteria::CC5_3, Soc2Criteria::CC6_8, Soc2Criteria::CC8_1, Soc2Criteria::PI1_2, Soc2Criteria::PI1_3],
            VantaControl::CPL_1->value => [Soc2Criteria::SupportingDocumentation],
            VantaControl::CPL_2->value => [Soc2Criteria::CC2_2],
            VantaControl::CRY_1->value => [Soc2Criteria::CC6_1],
            VantaControl::CRY_2->value => [Soc2Criteria::CC6_1],
            VantaControl::CRY_3->value => [Soc2Criteria::CC6_7],
            VantaControl::CRY_4->value => [Soc2Criteria::CC6_1, Soc2Criteria::PI1_4],
            VantaControl::CRY_5->value => [Soc2Criteria::C1_1, Soc2Criteria::CC6_1],
            VantaControl::DCH_1->value => [Soc2Criteria::C1_2, Soc2Criteria::CC6_5],
            VantaControl::DCH_10->value => [Soc2Criteria::P4_3],
            VantaControl::DCH_11->value => [Soc2Criteria::C1_1],
            VantaControl::DCH_2->value => [Soc2Criteria::PI1_2, Soc2Criteria::PI1_4, Soc2Criteria::PI1_5],
            VantaControl::DCH_3->value => [Soc2Criteria::PI1_5],
            VantaControl::DCH_4->value => [Soc2Criteria::PI1_4],
            VantaControl::DCH_5->value => [Soc2Criteria::C1_1, Soc2Criteria::CC6_1],
            VantaControl::DCH_6->value => [Soc2Criteria::P4_3],
            VantaControl::DCH_7->value => [Soc2Criteria::P5_2],
            VantaControl::DCH_8->value => [Soc2Criteria::P5_1, Soc2Criteria::P6_7],
            VantaControl::DCH_9->value => [Soc2Criteria::P4_3, Soc2Criteria::P6_7],
            VantaControl::END_1->value => [Soc2Criteria::CC6_8],
            VantaControl::GOV_1->value => [Soc2Criteria::CC1_2, Soc2Criteria::P8_1],
            VantaControl::GOV_10->value => [Soc2Criteria::CC1_3, Soc2Criteria::CC1_4, Soc2Criteria::CC1_5, Soc2Criteria::CC2_2, Soc2Criteria::CC5_3],
            VantaControl::GOV_11->value => [Soc2Criteria::CC2_2, Soc2Criteria::CC5_1, Soc2Criteria::CC5_2, Soc2Criteria::CC5_3],
            VantaControl::GOV_12->value => [Soc2Criteria::CC2_3],
            VantaControl::GOV_13->value => [Soc2Criteria::CC2_2],
            VantaControl::GOV_2->value => [Soc2Criteria::CC1_2, Soc2Criteria::CC1_3],
            VantaControl::GOV_3->value => [Soc2Criteria::CC1_2],
            VantaControl::GOV_4->value => [Soc2Criteria::CC1_2],
            VantaControl::GOV_5->value => [Soc2Criteria::A1_2, Soc2Criteria::A1_3, Soc2Criteria::CC5_3],
            VantaControl::GOV_6->value => [Soc2Criteria::CC2_3],
            VantaControl::GOV_7->value => [Soc2Criteria::CC1_3, Soc2Criteria::CC2_2],
            VantaControl::GOV_8->value => [Soc2Criteria::CC1_3],
            VantaControl::GOV_9->value => [Soc2Criteria::PI1_4],
            VantaControl::HRS_1->value => [Soc2Criteria::CC1_1, Soc2Criteria::CC1_4],
            VantaControl::HRS_2->value => [Soc2Criteria::CC1_1],
            VantaControl::HRS_3->value => [Soc2Criteria::CC1_1, Soc2Criteria::CC1_5],
            VantaControl::HRS_4->value => [Soc2Criteria::CC1_1],
            VantaControl::HRS_5->value => [Soc2Criteria::CC1_1],
            VantaControl::HRS_6->value => [Soc2Criteria::CC1_1, Soc2Criteria::CC1_4, Soc2Criteria::CC1_5],
            VantaControl::IAC_1->value => [Soc2Criteria::CC6_1],
            VantaControl::IAC_10->value => [Soc2Criteria::CC6_1, Soc2Criteria::CC6_2, Soc2Criteria::CC6_3, Soc2Criteria::CC6_6],
            VantaControl::IAC_11->value => [Soc2Criteria::CC6_1],
            VantaControl::IAC_12->value => [Soc2Criteria::CC6_1, Soc2Criteria::CC6_6],
            VantaControl::IAC_13->value => [Soc2Criteria::CC6_1, Soc2Criteria::CC6_6],
            VantaControl::IAC_2->value => [Soc2Criteria::CC5_2, Soc2Criteria::CC6_1, Soc2Criteria::CC6_2, Soc2Criteria::CC6_3],
            VantaControl::IAC_3->value => [Soc2Criteria::CC6_1],
            VantaControl::IAC_4->value => [Soc2Criteria::CC6_1],
            VantaControl::IAC_5->value => [Soc2Criteria::CC6_1],
            VantaControl::IAC_6->value => [Soc2Criteria::CC6_1, Soc2Criteria::PI1_5],
            VantaControl::IAC_7->value => [Soc2Criteria::CC6_2, Soc2Criteria::CC6_3, Soc2Criteria::CC6_4],
            VantaControl::IAC_8->value => [Soc2Criteria::CC6_2, Soc2Criteria::CC6_3, Soc2Criteria::CC6_5],
            VantaControl::IAC_9->value => [Soc2Criteria::CC6_1, Soc2Criteria::CC6_2, Soc2Criteria::CC6_3],
            VantaControl::IAO_1->value => [Soc2Criteria::CC2_1, Soc2Criteria::CC4_1, Soc2Criteria::CC4_2, Soc2Criteria::P8_1],
            VantaControl::IAO_2->value => [Soc2Criteria::CC3_4, Soc2Criteria::CC4_1, Soc2Criteria::CC7_2, Soc2Criteria::CC8_1],
            VantaControl::IRO_1->value => [Soc2Criteria::CC7_4, Soc2Criteria::CC7_5],
            VantaControl::IRO_2->value => [Soc2Criteria::CC2_2, Soc2Criteria::CC5_3, Soc2Criteria::CC7_3, Soc2Criteria::CC7_4, Soc2Criteria::CC7_5, Soc2Criteria::P6_3, Soc2Criteria::P6_4, Soc2Criteria::P6_5, Soc2Criteria::P6_6],
            VantaControl::IRO_3->value => [Soc2Criteria::CC7_3, Soc2Criteria::CC7_4, Soc2Criteria::CC7_5, Soc2Criteria::P6_3, Soc2Criteria::P6_4, Soc2Criteria::P6_5, Soc2Criteria::P6_6, Soc2Criteria::P8_1],
            VantaControl::IRO_4->value => [Soc2Criteria::P6_7],
            VantaControl::MDM_1->value => [Soc2Criteria::CC6_7],
            VantaControl::MON_1->value => [Soc2Criteria::A1_3, Soc2Criteria::CC6_6, Soc2Criteria::CC7_2],
            VantaControl::MON_2->value => [Soc2Criteria::CC2_1, Soc2Criteria::CC7_2],
            VantaControl::MON_3->value => [Soc2Criteria::PI1_2, Soc2Criteria::PI1_3, Soc2Criteria::PI1_4],
            VantaControl::MON_4->value => [Soc2Criteria::A1_1, Soc2Criteria::CC7_2, Soc2Criteria::PI1_3],
            VantaControl::NET_1->value => [Soc2Criteria::CC6_6, Soc2Criteria::CC6_7],
            VantaControl::NET_2->value => [Soc2Criteria::CC6_1],
            VantaControl::NET_3->value => [Soc2Criteria::CC6_6],
            VantaControl::NET_4->value => [Soc2Criteria::CC6_6],
            VantaControl::NET_5->value => [Soc2Criteria::CC6_6, Soc2Criteria::CC8_1],
            VantaControl::OPS_1->value => [Soc2Criteria::CC7_1, Soc2Criteria::CC7_2],
            VantaControl::PES_1->value => [Soc2Criteria::CC6_4],
            VantaControl::PES_2->value => [Soc2Criteria::CC6_4],
            VantaControl::PES_3->value => [Soc2Criteria::CC6_4],
            VantaControl::PES_4->value => [Soc2Criteria::A1_2],
            VantaControl::PES_5->value => [Soc2Criteria::A1_2],
            VantaControl::PRI_1->value => [Soc2Criteria::P6_1],
            VantaControl::PRI_10->value => [Soc2Criteria::P2_1, Soc2Criteria::P6_1],
            VantaControl::PRI_11->value => [Soc2Criteria::P2_1, Soc2Criteria::P6_1],
            VantaControl::PRI_12->value => [Soc2Criteria::P2_1],
            VantaControl::PRI_13->value => [Soc2Criteria::P3_1, Soc2Criteria::P4_1],
            VantaControl::PRI_14->value => [Soc2Criteria::P1_1],
            VantaControl::PRI_15->value => [Soc2Criteria::P5_1, Soc2Criteria::P5_2, Soc2Criteria::P7_1, Soc2Criteria::P8_1],
            VantaControl::PRI_16->value => [Soc2Criteria::P1_1],
            VantaControl::PRI_17->value => [Soc2Criteria::P6_1, Soc2Criteria::P6_2, Soc2Criteria::P6_7, Soc2Criteria::P7_1, Soc2Criteria::P8_1],
            VantaControl::PRI_2->value => [Soc2Criteria::P7_1],
            VantaControl::PRI_3->value => [Soc2Criteria::P1_1, Soc2Criteria::P3_1],
            VantaControl::PRI_4->value => [Soc2Criteria::P3_1],
            VantaControl::PRI_5->value => [Soc2Criteria::P3_1],
            VantaControl::PRI_6->value => [Soc2Criteria::P1_1, Soc2Criteria::P2_1, Soc2Criteria::P5_1, Soc2Criteria::P6_1],
            VantaControl::PRI_7->value => [Soc2Criteria::P8_1],
            VantaControl::PRI_8->value => [Soc2Criteria::P4_2],
            VantaControl::PRI_9->value => [Soc2Criteria::P2_1, Soc2Criteria::P3_2],
            VantaControl::PRM_1->value => [Soc2Criteria::CC2_3, Soc2Criteria::PI1_1],
            VantaControl::PRM_2->value => [Soc2Criteria::CC2_3, Soc2Criteria::PI1_1],
            VantaControl::PRM_3->value => [Soc2Criteria::CC2_2, Soc2Criteria::CC2_3, Soc2Criteria::PI1_1],
            VantaControl::RSK_1->value => [Soc2Criteria::CC3_1, Soc2Criteria::CC5_3],
            VantaControl::RSK_2->value => [Soc2Criteria::A1_2, Soc2Criteria::CC3_2, Soc2Criteria::CC3_3, Soc2Criteria::CC3_4, Soc2Criteria::CC7_1, Soc2Criteria::CC9_1],
            VantaControl::RSK_3->value => [Soc2Criteria::A1_2, Soc2Criteria::CC3_1, Soc2Criteria::CC3_2, Soc2Criteria::CC3_3, Soc2Criteria::CC3_4, Soc2Criteria::CC5_1, Soc2Criteria::CC5_3, Soc2Criteria::CC9_1, Soc2Criteria::P8_1],
            VantaControl::SAT_1->value => [Soc2Criteria::CC1_4, Soc2Criteria::CC2_2],
            VantaControl::TDA_1->value => [Soc2Criteria::PI1_2],
            VantaControl::TDA_2->value => [Soc2Criteria::PI1_3, Soc2Criteria::PI1_4],
            VantaControl::TDA_3->value => [Soc2Criteria::PI1_2, Soc2Criteria::PI1_3],
            VantaControl::TDA_4->value => [Soc2Criteria::PI1_3],
            VantaControl::TPM_1->value => [Soc2Criteria::C1_1, Soc2Criteria::CC2_3, Soc2Criteria::CC9_2, Soc2Criteria::P6_1, Soc2Criteria::P6_4, Soc2Criteria::P6_5],
            VantaControl::TPM_2->value => [Soc2Criteria::CC3_2, Soc2Criteria::CC4_1, Soc2Criteria::CC4_2, Soc2Criteria::CC5_3, Soc2Criteria::CC9_2, Soc2Criteria::P6_1, Soc2Criteria::P6_4],
            VantaControl::VPM_1->value => [Soc2Criteria::CC6_6, Soc2Criteria::CC6_8, Soc2Criteria::CC7_2, Soc2Criteria::CC7_4, Soc2Criteria::CC8_1],
            VantaControl::VPM_2->value => [Soc2Criteria::CC2_1, Soc2Criteria::CC4_1, Soc2Criteria::CC7_1, Soc2Criteria::CC7_2, Soc2Criteria::CC7_4, Soc2Criteria::CC8_1],
        ];
    }

    /**
     * @return array<int, Soc2Criteria>
     */
    public static function sectionsFor(VantaControl|string $control): array
    {
        $id = $control instanceof VantaControl ? $control->value : $control;

        return self::defaults()[$id] ?? [];
    }

    /**
     * @return array<int, string>
     */
    public static function sectionIdsFor(VantaControl|string $control): array
    {
        return array_map(
            fn (Soc2Criteria $criteria) => str_replace('SOC2:', '', $criteria->value),
            self::sectionsFor($control),
        );
    }
}
