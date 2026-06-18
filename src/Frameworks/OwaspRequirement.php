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
}
