<?php

namespace Parallel\Compliance\Frameworks;

enum OwaspRequirement: string implements FrameworkRequirement
{
    case AsvsArchitecture = 'OWASP_ASVS:V1';
    case AsvsAuthentication = 'OWASP_ASVS:V2';
    case AsvsSessionManagement = 'OWASP_ASVS:V3';
    case AsvsAccessControl = 'OWASP_ASVS:V4';
    case AsvsInputValidation = 'OWASP_ASVS:V5';
    case AsvsCryptography = 'OWASP_ASVS:V6';
    case AsvsErrorLogging = 'OWASP_ASVS:V7';
    case AsvsDataProtection = 'OWASP_ASVS:V8';
    case AsvsCommunications = 'OWASP_ASVS:V9';
    case AsvsMaliciousCode = 'OWASP_ASVS:V10';
    case AsvsBusinessLogic = 'OWASP_ASVS:V11';
    case AsvsFilesResources = 'OWASP_ASVS:V12';
    case AsvsApiWebService = 'OWASP_ASVS:V13';
    case AsvsConfiguration = 'OWASP_ASVS:V14';
    case WstgConfiguration = 'OWASP_WSTG:WSTG-CONF';
    case WstgIdentityManagement = 'OWASP_WSTG:WSTG-IDNT';
    case WstgAuthentication = 'OWASP_WSTG:WSTG-ATHN';
    case WstgAuthorization = 'OWASP_WSTG:WSTG-ATHZ';
    case WstgSessionManagement = 'OWASP_WSTG:WSTG-SESS';
    case WstgInputValidation = 'OWASP_WSTG:WSTG-INPV';
    case WstgErrorHandling = 'OWASP_WSTG:WSTG-ERRH';
    case WstgCryptography = 'OWASP_WSTG:WSTG-CRYP';
    case WstgBusinessLogic = 'OWASP_WSTG:WSTG-BUSL';
    case WstgClientSide = 'OWASP_WSTG:WSTG-CLNT';
    case WstgApi = 'OWASP_WSTG:WSTG-APIT';

    public function id(): string
    {
        return $this->value;
    }

    public function source(): string
    {
        return match ($this) {
            self::AsvsArchitecture => 'OWASP ASVS',
            self::AsvsAuthentication => 'OWASP ASVS',
            self::AsvsSessionManagement => 'OWASP ASVS',
            self::AsvsAccessControl => 'OWASP ASVS',
            self::AsvsInputValidation => 'OWASP ASVS',
            self::AsvsCryptography => 'OWASP ASVS',
            self::AsvsErrorLogging => 'OWASP ASVS',
            self::AsvsDataProtection => 'OWASP ASVS',
            self::AsvsCommunications => 'OWASP ASVS',
            self::AsvsMaliciousCode => 'OWASP ASVS',
            self::AsvsBusinessLogic => 'OWASP ASVS',
            self::AsvsFilesResources => 'OWASP ASVS',
            self::AsvsApiWebService => 'OWASP ASVS',
            self::AsvsConfiguration => 'OWASP ASVS',
            self::WstgConfiguration => 'OWASP WSTG',
            self::WstgIdentityManagement => 'OWASP WSTG',
            self::WstgAuthentication => 'OWASP WSTG',
            self::WstgAuthorization => 'OWASP WSTG',
            self::WstgSessionManagement => 'OWASP WSTG',
            self::WstgInputValidation => 'OWASP WSTG',
            self::WstgErrorHandling => 'OWASP WSTG',
            self::WstgCryptography => 'OWASP WSTG',
            self::WstgBusinessLogic => 'OWASP WSTG',
            self::WstgClientSide => 'OWASP WSTG',
            self::WstgApi => 'OWASP WSTG',
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::AsvsArchitecture => 'Architecture, Design and Threat Modeling',
            self::AsvsAuthentication => 'Authentication',
            self::AsvsSessionManagement => 'Session Management',
            self::AsvsAccessControl => 'Access Control',
            self::AsvsInputValidation => 'Input Validation',
            self::AsvsCryptography => 'Cryptography',
            self::AsvsErrorLogging => 'Error Handling and Logging',
            self::AsvsDataProtection => 'Data Protection',
            self::AsvsCommunications => 'Communications',
            self::AsvsMaliciousCode => 'Malicious Code',
            self::AsvsBusinessLogic => 'Business Logic',
            self::AsvsFilesResources => 'Files and Resources',
            self::AsvsApiWebService => 'API and Web Service',
            self::AsvsConfiguration => 'Configuration',
            self::WstgConfiguration => 'Configuration and Deployment Management Testing',
            self::WstgIdentityManagement => 'Identity Management Testing',
            self::WstgAuthentication => 'Authentication Testing',
            self::WstgAuthorization => 'Authorization Testing',
            self::WstgSessionManagement => 'Session Management Testing',
            self::WstgInputValidation => 'Input Validation Testing',
            self::WstgErrorHandling => 'Error Handling Testing',
            self::WstgCryptography => 'Cryptography Testing',
            self::WstgBusinessLogic => 'Business Logic Testing',
            self::WstgClientSide => 'Client-side Testing',
            self::WstgApi => 'API Testing',
        };
    }

    public function description(): ?string
    {
        return null;
    }

    public function domain(): string
    {
        return 'Application security';
    }
}
