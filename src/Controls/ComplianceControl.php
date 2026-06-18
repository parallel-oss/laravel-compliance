<?php

namespace Parallel\Compliance\Controls;

use Parallel\Compliance\Data\ControlRecord;
use Parallel\Compliance\Data\VantaComplianceData;

/**
 * @generated from package compliance seed data
 */
enum ComplianceControl: string implements Control
{
    /**
     * Asset disposal procedures utilized
     *
     * The company has electronic media containing confidential information purged or destroyed in accordance with best practices, and certificates of destruction are issued for each device destroyed.
     */
    case AssetDisposalProceduresUtilized = 'asset-disposal-procedures-utilized';

    /**
     * Data retention procedures established
     *
     * The company has formal retention and disposal procedures in place to guide the secure retention and disposal of company and customer data.
     */
    case DataRetentionProceduresEstablished = 'data-retention-procedures-established';

    /**
     * Production inventory maintained
     *
     * The company maintains a formal inventory of production system assets.
     */
    case ProductionInventoryMaintained = 'production-inventory-maintained';

    /**
     * Continuity and Disaster Recovery plans established
     *
     * The company has Business Continuity and Disaster Recovery Plans in place that outline communication plans in order to maintain information security continuity in the event of the unavailability of key personnel.
     */
    case ContinuityAndDisasterRecoveryPlansEstablished = 'continuity-and-disaster-recovery-plans-established';

    /**
     * Continuity and Disaster Recovery plans tested
     *
     * The company has a documented Business Continuity/Disaster Recovery (BC/DR) plan and tests it at least annually.
     */
    case ContinuityAndDisasterRecoveryPlansTested = 'continuity-disaster-recovery-plans-tested';

    /**
     * Configuration management system established
     *
     * The company has a configuration management procedure in place to ensure that system configurations are deployed consistently throughout the environment.
     */
    case ConfigurationManagementSystemEstablished = 'configuration-management-system-established';

    /**
     * Change management procedures enforced
     *
     * The company requires changes to software and infrastructure components of the service to be authorized, formally documented, tested, reviewed, and approved prior to being implemented in the production environment.
     */
    case ChangeManagementProceduresEnforced = 'change-management-procedures';

    /**
     * Production deployment access restricted
     *
     * The company restricts access to migrate changes to production to authorized personnel.
     */
    case ProductionDeploymentAccessRestricted = 'changes-approval-required';

    /**
     * Development lifecycle established
     *
     * The company has a formal systems development life cycle (SDLC) methodology in place that governs the development, acquisition, implementation, changes (including emergency changes), and maintenance of information systems and related technology requirements.
     */
    case DevelopmentLifecycleEstablished = 'development-lifecycle-established';

    /**
     * Unique production database authentication enforced
     *
     * The company requires authentication to production datastores to use authorized secure authentication mechanisms, such as unique SSH key.
     */
    case UniqueProductionDatabaseAuthenticationEnforced = 'access-datastores-ssh';

    /**
     * Encryption key access restricted
     *
     * The company restricts privileged access to encryption keys to authorized users with a business need.
     */
    case EncryptionKeyAccessRestricted = 'access-encryption-keys';

    /**
     * Portable media encrypted
     *
     * The company encrypts portable and removable media devices when used.
     */
    case PortableMediaEncrypted = 'assets-portable-media-encrypted';

    /**
     * Data encryption utilized
     *
     * The company's datastores housing sensitive customer data are encrypted at rest.
     */
    case DataEncryptionUtilized = 'data-encrypted';

    /**
     * Unique account authentication enforced
     *
     * The company requires authentication to systems and applications to use unique username and password or authorized Secure Socket Shell (SSH) keys.
     */
    case UniqueAccountAuthenticationEnforced = 'unique-account-authentication-enforced';

    /**
     * Customer data deleted upon leaving
     *
     * The company purges or removes customer data containing confidential information from the application environment, in accordance with best practices, when customers leave the service.
     */
    case CustomerDataDeletedUponLeaving = 'customer-data-deleted-upon-leave';

    /**
     * Data classification policy established
     *
     * The company has a data classification policy in place to help ensure that confidential data is properly secured and restricted to authorized personnel.
     */
    case DataClassificationPolicyEstablished = 'data-classification-policy';

    /**
     * Anti-malware technology utilized
     *
     * The company deploys anti-malware technology to environments commonly susceptible to malicious attacks and configures this to be updated routinely, logged, and installed on all relevant systems.
     */
    case AntiMalwareTechnologyUtilized = 'assets-anti-malware';

    /**
     * Production application access restricted
     *
     * System access restricted to authorized access only
     */
    case ProductionApplicationAccessRestricted = 'access-application-restricted';

    /**
     * Unique network system authentication enforced
     *
     * The company requires authentication to the "production network" to use unique usernames and passwords or authorized Secure Socket Shell (SSH) keys.
     */
    case UniqueNetworkSystemAuthenticationEnforced = 'access-ssh-required';

    /**
     * Password policy enforced
     *
     * The company requires passwords for in-scope system components to be configured according to the company's policy.
     */
    case PasswordPolicyEnforced = 'policies-password-complexity';

    /**
     * Remote access MFA enforced
     *
     * The company's production systems can only be remotely accessed by authorized employees possessing a valid multi-factor authentication (MFA) method.
     */
    case RemoteAccessMfaEnforced = 'remote-access-mfa-enforced';

    /**
     * Remote access encrypted enforced
     *
     * The company's production systems can only be remotely accessed by authorized employees via an approved encrypted connection.
     */
    case RemoteAccessEncryptedEnforced = 'remote-access-vpn-enforced';

    /**
     * Access control procedures established
     *
     * The company's access control policy documents the requirements for the following access control functions:
     *
     * - adding new users;
     *
     * - modifying users; and/or
     *
     * - removing an existing user's access.
     */
    case AccessControlProceduresEstablished = 'access-control-procedures';

    /**
     * Production database access restricted
     *
     * The company restricts privileged access to databases to authorized users with a business need.
     */
    case ProductionDatabaseAccessRestricted = 'access-database-restricted-users';

    /**
     * Firewall access restricted
     *
     * The company restricts privileged access to the firewall to authorized users with a business need.
     */
    case FirewallAccessRestricted = 'access-firewalls';

    /**
     * Production OS access restricted
     *
     * The company restricts privileged access to the operating system to authorized users with a business need.
     */
    case ProductionOsAccessRestricted = 'access-operating-system-restricted';

    /**
     * Production network access restricted
     *
     * The company restricts privileged access to the production network to authorized users with a business need.
     */
    case ProductionNetworkAccessRestricted = 'access-production-network-restricted';

    /**
     * Access reviews conducted
     *
     * The company conducts access reviews at least quarterly for the in-scope system components to help ensure that access is restricted appropriately. Required changes are tracked to completion.
     */
    case AccessReviewsConducted = 'access-reviews';

    /**
     * Access revoked upon termination
     *
     * The company completes termination checklists to ensure that access is revoked for terminated employees within SLAs.
     */
    case AccessRevokedUponTermination = 'access-revoked-termination';

    /**
     * Access requests required
     *
     * The company ensures that user access to in-scope system components is based on job role and function or requires a documented access request form and manager approval prior to access being provisioned.
     */
    case AccessRequestsRequired = 'access-role-based';

    /**
     * Control self-assessments conducted
     *
     * The company performs control self-assessments at least annually to gain assurance that controls are in place and operating effectively. Corrective actions are taken based on relevant findings. If the company has committed to an SLA for a finding, the corrective action is completed within that SLA.
     */
    case ControlSelfAssessmentsConducted = 'control-self-assessments-conducted';

    /**
     * Penetration testing performed
     *
     * The company's penetration testing is performed at least annually. A remediation plan is developed and changes are implemented to remediate vulnerabilities in accordance with SLAs.
     */
    case PenetrationTestingPerformed = 'penetration-testing';

    /**
     * Incident response plan tested
     *
     * The company tests their incident response plan at least annually.
     */
    case IncidentResponsePlanTested = 'incident-response-plan-tested';

    /**
     * Incident response policies established
     *
     * The company has security and privacy incident response policies and procedures that are documented and communicated to authorized users.
     */
    case IncidentResponsePoliciesEstablished = 'incident-response-policies-established';

    /**
     * Incident management procedures followed
     *
     * The company's security and privacy incidents are logged, tracked, resolved, and communicated to affected or relevant parties by management according to the company's security incident response policy and procedures.
     */
    case IncidentManagementProceduresFollowed = 'policies-incident-management';

    /**
     * MDM system utilized
     *
     * The company has a mobile device management (MDM) system in place to centrally manage mobile devices supporting the service.
     */
    case MdmSystemUtilized = 'MDM-system-utilized';

    /**
     * Intrusion detection system utilized
     *
     * The company uses an intrusion detection system to provide continuous monitoring of the company's network and early detection of potential security breaches.
     */
    case IntrusionDetectionSystemUtilized = 'intrusion-detection-system';

    /**
     * Log management utilized
     *
     * The company utilizes a log management tool to identify events that may have a potential impact on the company's ability to achieve its security objectives.
     */
    case LogManagementUtilized = 'log-management-utilized';

    /**
     * Infrastructure performance monitored
     *
     * An infrastructure monitoring tool is utilized to monitor systems, infrastructure, and performance and generates alerts when specific predefined thresholds are met.
     */
    case InfrastructurePerformanceMonitored = 'system-threshold-monitoring';

    /**
     * Data transmission encrypted
     *
     * The company uses secure data transmission protocols to encrypt confidential and sensitive data when transmitted over public networks.
     */
    case DataTransmissionEncrypted = 'data-encrypted-in-transit';

    /**
     * Network segmentation implemented
     *
     * The company's network is segmented to prevent unauthorized access to customer data.
     */
    case NetworkSegmentationImplemented = 'infra-network-segregation';

    /**
     * Network firewalls reviewed
     *
     * The company reviews its firewall rulesets at least annually. Required changes are tracked to completion.
     */
    case NetworkFirewallsReviewed = 'network-firewalls-reviewed';

    /**
     * Network firewalls utilized
     *
     * The company uses firewalls and configures them to prevent unauthorized access.
     */
    case NetworkFirewallsUtilized = 'network-firewalls-utilized';

    /**
     * Network and system hardening standards maintained
     *
     * The company's network and system hardening standards are documented, based on industry best practices, and reviewed at least annually.
     */
    case NetworkAndSystemHardeningStandardsMaintained = 'system-network-hardening';

    /**
     * Vulnerability and system monitoring procedures established
     *
     * The company's formal policies outline the requirements for the following functions related to IT / Engineering:
     *
     * - vulnerability management;
     *
     * - system monitoring.
     */
    case VulnerabilityAndSystemMonitoringProceduresEstablished = 'policies-incident-monitoring';

    /**
     * Third-party agreements established
     *
     * The company has written agreements in place with vendors and related third-parties. These agreements include confidentiality and privacy commitments applicable to that entity.
     */
    case ThirdPartyAgreementsEstablished = 'third-party-agreements';

    /**
     * Vendor management program established
     *
     * The company has a vendor management program in place. Components of this program include:
     *
     * - critical third-party vendor inventory;
     *
     * - vendor's security and privacy requirements; and
     *
     * - review of critical third-party vendors at least annually.
     */
    case VendorManagementProgramEstablished = 'vendor-management-program-established';

    /**
     * Service infrastructure maintained
     *
     * The company has infrastructure supporting the service patched as a part of routine maintenance and as a result of identified vulnerabilities to help ensure that servers supporting the service are hardened against security threats.
     */
    case ServiceInfrastructureMaintained = 'support-infra-patched';

    /**
     * Vulnerabilities scanned and remediated
     *
     * Host-based vulnerability scans are performed at least quarterly on all external-facing systems. Critical and high vulnerabilities are tracked to remediation.
     */
    case VulnerabilitiesScannedAndRemediated = 'vulnerability-scans-conducted';

    public function id(): string
    {
        return $this->value;
    }

    public function source(): string
    {
        return 'Laravel Compliance';
    }

    public function title(): string
    {
        return $this->record()->name;
    }

    public function description(): ?string
    {
        return $this->record()->description;
    }

    public function domains(): array
    {
        return $this->record()->domains;
    }

    private function record(): ControlRecord
    {
        $record = VantaComplianceData::fromPackageResources()->control($this);

        if (! $record) {
            throw new \RuntimeException("Missing compliance control data for {$this->value}.");
        }

        return $record;
    }
}
