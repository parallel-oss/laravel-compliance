<?php

namespace Parallel\Compliance\Capabilities;

enum CommonCapability: string implements Capability
{
    case UserDataErasure = 'data_lifecycle.user_data_erasure';
    case UserDataExport = 'data_lifecycle.user_data_export';
    case UserDataAccess = 'data_lifecycle.user_data_access';
    case UserDataRectification = 'data_lifecycle.user_data_rectification';
    case UserDataRestriction = 'data_lifecycle.user_data_restriction';
    case UserDataObjection = 'data_lifecycle.user_data_objection';
    case DataRetention = 'data_lifecycle.data_retention';
    case DataMinimization = 'privacy.data_minimization';
    case PurposeLimitation = 'privacy.purpose_limitation';
    case ConsentCapture = 'privacy.consent_capture';
    case ConsentWithdrawal = 'privacy.consent_withdrawal';
    case PrivacyNotice = 'privacy.notice';
    case ProcessingRecords = 'privacy.processing_records';
    case ProcessorManagement = 'privacy.processor_management';
    case PrivacyImpactAssessment = 'privacy.impact_assessment';
    case BreachNotification = 'privacy.breach_notification';
    case AccessLogging = 'security.access_logging';
    case Authentication = 'security.authentication';
    case Authorization = 'security.authorization';
    case SessionManagement = 'security.session_management';
    case InputValidation = 'security.input_validation';
    case OutputEncoding = 'security.output_encoding';
    case SecureConfiguration = 'security.secure_configuration';
    case SecretsManagement = 'security.secrets_management';
    case DependencyManagement = 'security.dependency_management';
    case SecurityMonitoring = 'security.security_monitoring';
    case IncidentResponse = 'security.incident_response';
    case ChangeManagement = 'governance.change_management';
    case EncryptionAtRest = 'security.encryption_at_rest';
    case EncryptionInTransit = 'security.encryption_in_transit';
}
