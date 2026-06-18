<?php

namespace Parallel\Compliance\Mappings;

use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Frameworks\GdprArticle;
use Parallel\Compliance\Frameworks\OwaspRequirement;

class VantaControlFrameworkMappings
{
    /**
     * @return array<string, array<int, FrameworkRequirement>>
     */
    public static function defaults(): array
    {
        return [
            VantaControl::AST_1->value => [GdprArticle::Article17, GdprArticle::Article19, OwaspRequirement::AsvsDataProtection],
            VantaControl::AST_2->value => [GdprArticle::Article17, GdprArticle::Article19, OwaspRequirement::AsvsDataProtection, GdprArticle::Article18, GdprArticle::Article5, GdprArticle::Article25, GdprArticle::Article30],
            VantaControl::CFG_1->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsConfiguration, OwaspRequirement::WstgConfiguration],
            VantaControl::CHG_1->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsConfiguration, OwaspRequirement::WstgConfiguration, GdprArticle::Article24, OwaspRequirement::AsvsArchitecture],
            VantaControl::CHG_2->value => [GdprArticle::Article24, GdprArticle::Article25, OwaspRequirement::AsvsArchitecture],
            VantaControl::CHG_3->value => [OwaspRequirement::AsvsMaliciousCode, OwaspRequirement::AsvsConfiguration, GdprArticle::Article24, GdprArticle::Article25, OwaspRequirement::AsvsArchitecture],
            VantaControl::CRY_2->value => [GdprArticle::Article32, OwaspRequirement::AsvsCryptography, OwaspRequirement::AsvsConfiguration],
            VantaControl::CRY_3->value => [GdprArticle::Article32, OwaspRequirement::AsvsCommunications, OwaspRequirement::WstgCryptography],
            VantaControl::CRY_4->value => [GdprArticle::Article32, OwaspRequirement::AsvsCryptography, OwaspRequirement::AsvsConfiguration, OwaspRequirement::AsvsDataProtection, OwaspRequirement::WstgCryptography],
            VantaControl::CRY_5->value => [GdprArticle::Article32, OwaspRequirement::AsvsAuthentication, OwaspRequirement::WstgAuthentication, OwaspRequirement::AsvsSessionManagement, OwaspRequirement::WstgSessionManagement],
            VantaControl::DCH_1->value => [GdprArticle::Article17, GdprArticle::Article19, OwaspRequirement::AsvsDataProtection, GdprArticle::Article5, GdprArticle::Article25, GdprArticle::Article30],
            VantaControl::DCH_10->value => [GdprArticle::Article17, GdprArticle::Article19, OwaspRequirement::AsvsDataProtection],
            VantaControl::DCH_5->value => [GdprArticle::Article18, GdprArticle::Article19],
            VantaControl::DCH_6->value => [GdprArticle::Article17, GdprArticle::Article19, OwaspRequirement::AsvsDataProtection],
            VantaControl::DCH_7->value => [GdprArticle::Article16, GdprArticle::Article19],
            VantaControl::DCH_8->value => [GdprArticle::Article15, GdprArticle::Article20, OwaspRequirement::AsvsDataProtection, GdprArticle::Article12],
            VantaControl::DCH_9->value => [GdprArticle::Article15, GdprArticle::Article20, OwaspRequirement::AsvsDataProtection, GdprArticle::Article12],
            VantaControl::IAC_1->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsAccessControl, OwaspRequirement::WstgAuthorization],
            VantaControl::IAC_11->value => [GdprArticle::Article32, OwaspRequirement::AsvsAuthentication, OwaspRequirement::WstgAuthentication],
            VantaControl::IAC_12->value => [GdprArticle::Article32, OwaspRequirement::AsvsAuthentication, OwaspRequirement::WstgAuthentication, OwaspRequirement::AsvsSessionManagement, OwaspRequirement::WstgSessionManagement],
            VantaControl::IAC_2->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsAccessControl, OwaspRequirement::WstgAuthorization],
            VantaControl::IAC_7->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsAccessControl, OwaspRequirement::WstgAuthorization],
            VantaControl::IAC_9->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsAccessControl, OwaspRequirement::WstgAuthorization],
            VantaControl::IAO_1->value => [GdprArticle::Article24, GdprArticle::Article25, GdprArticle::Article35],
            VantaControl::IRO_1->value => [GdprArticle::Article33, GdprArticle::Article34],
            VantaControl::IRO_2->value => [GdprArticle::Article33, GdprArticle::Article34],
            VantaControl::IRO_3->value => [GdprArticle::Article33, GdprArticle::Article34],
            VantaControl::IRO_4->value => [GdprArticle::Article15, GdprArticle::Article20, OwaspRequirement::AsvsDataProtection, GdprArticle::Article30],
            VantaControl::MON_1->value => [GdprArticle::Article32, OwaspRequirement::AsvsErrorLogging, OwaspRequirement::WstgErrorHandling],
            VantaControl::MON_2->value => [GdprArticle::Article30, GdprArticle::Article32, OwaspRequirement::AsvsErrorLogging, OwaspRequirement::WstgErrorHandling],
            VantaControl::MON_3->value => [OwaspRequirement::AsvsInputValidation, OwaspRequirement::WstgInputValidation],
            VantaControl::MON_4->value => [GdprArticle::Article32, OwaspRequirement::AsvsErrorLogging, OwaspRequirement::WstgErrorHandling],
            VantaControl::NET_1->value => [GdprArticle::Article32, OwaspRequirement::AsvsCommunications, OwaspRequirement::WstgCryptography],
            VantaControl::NET_5->value => [GdprArticle::Article25, GdprArticle::Article32, OwaspRequirement::AsvsConfiguration, OwaspRequirement::WstgConfiguration],
            VantaControl::OPS_1->value => [GdprArticle::Article32, OwaspRequirement::AsvsErrorLogging, OwaspRequirement::WstgErrorHandling],
            VantaControl::PRI_1->value => [GdprArticle::Article30],
            VantaControl::PRI_10->value => [GdprArticle::Article6, GdprArticle::Article7, GdprArticle::Article25],
            VantaControl::PRI_11->value => [GdprArticle::Article6, GdprArticle::Article7, GdprArticle::Article25],
            VantaControl::PRI_12->value => [GdprArticle::Article21, GdprArticle::Article7, GdprArticle::Article17],
            VantaControl::PRI_13->value => [GdprArticle::Article18, GdprArticle::Article19, GdprArticle::Article21, GdprArticle::Article5, GdprArticle::Article25, OwaspRequirement::AsvsDataProtection, GdprArticle::Article6, GdprArticle::Article13, GdprArticle::Article14],
            VantaControl::PRI_14->value => [GdprArticle::Article12, GdprArticle::Article13, GdprArticle::Article14],
            VantaControl::PRI_15->value => [GdprArticle::Article12, GdprArticle::Article15, OwaspRequirement::AsvsDataProtection, GdprArticle::Article16, GdprArticle::Article19],
            VantaControl::PRI_16->value => [GdprArticle::Article12, GdprArticle::Article13, GdprArticle::Article14],
            VantaControl::PRI_17->value => [GdprArticle::Article30, GdprArticle::Article28, GdprArticle::Article32],
            VantaControl::PRI_2->value => [GdprArticle::Article16, GdprArticle::Article19],
            VantaControl::PRI_3->value => [GdprArticle::Article12, GdprArticle::Article13, GdprArticle::Article14],
            VantaControl::PRI_4->value => [GdprArticle::Article5, GdprArticle::Article25, OwaspRequirement::AsvsDataProtection],
            VantaControl::PRI_6->value => [GdprArticle::Article5, GdprArticle::Article6, GdprArticle::Article13, GdprArticle::Article14, GdprArticle::Article12],
            VantaControl::PRI_8->value => [GdprArticle::Article5, GdprArticle::Article25, GdprArticle::Article30, OwaspRequirement::AsvsDataProtection],
            VantaControl::PRI_9->value => [GdprArticle::Article6, GdprArticle::Article7, GdprArticle::Article25],
            VantaControl::RSK_2->value => [GdprArticle::Article24, GdprArticle::Article25, GdprArticle::Article35],
            VantaControl::RSK_3->value => [GdprArticle::Article24, GdprArticle::Article25, GdprArticle::Article35],
            VantaControl::TDA_2->value => [OwaspRequirement::AsvsInputValidation, OwaspRequirement::WstgClientSide],
            VantaControl::TDA_3->value => [GdprArticle::Article30, GdprArticle::Article32, OwaspRequirement::AsvsErrorLogging, OwaspRequirement::WstgErrorHandling],
            VantaControl::TDA_4->value => [OwaspRequirement::AsvsInputValidation, OwaspRequirement::WstgInputValidation],
            VantaControl::TPM_1->value => [GdprArticle::Article28, GdprArticle::Article32],
            VantaControl::TPM_2->value => [GdprArticle::Article28, GdprArticle::Article32],
            VantaControl::VPM_1->value => [OwaspRequirement::AsvsMaliciousCode, OwaspRequirement::AsvsConfiguration],
            VantaControl::VPM_2->value => [OwaspRequirement::AsvsMaliciousCode, OwaspRequirement::AsvsConfiguration],
        ];
    }

    /**
     * @return array<int, FrameworkRequirement>
     */
    public static function requirementsFor(VantaControl|string $control): array
    {
        $id = $control instanceof VantaControl ? $control->value : $control;

        return self::defaults()[$id] ?? [];
    }
}
