<?php

namespace Parallel\Compliance\Capabilities;

enum CommonCapability: string implements Capability
{
    case UserDataErasure = 'data_lifecycle.user_data_erasure';
    case UserDataExport = 'data_lifecycle.user_data_export';
    case ConsentCapture = 'privacy.consent_capture';
    case ConsentWithdrawal = 'privacy.consent_withdrawal';
    case AccessLogging = 'security.access_logging';
    case Authentication = 'security.authentication';
    case Authorization = 'security.authorization';
    case EncryptionAtRest = 'security.encryption_at_rest';
    case EncryptionInTransit = 'security.encryption_in_transit';
}
