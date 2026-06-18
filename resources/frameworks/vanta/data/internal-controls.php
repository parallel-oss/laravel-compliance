<?php

return [
    [
        'vanta_id' => 'asset-disposal-procedures-utilized',
        'external_id' => 'AST-1',
        'name' => 'Asset disposal procedures utilized',
        'description' => 'The company has electronic media containing confidential information purged or destroyed in accordance with best practices, and certificates of destruction are issued for each device destroyed.',
        'domains' => [
            'ASSET_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'data-retention-procedures-established',
        'external_id' => 'AST-2',
        'name' => 'Data retention procedures established',
        'description' => 'The company has formal retention and disposal procedures in place to guide the secure retention and disposal of company and customer data.',
        'domains' => [
            'ASSET_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'production-inventory-maintained',
        'external_id' => 'AST-3',
        'name' => 'Production inventory maintained',
        'description' => 'The company maintains a formal inventory of production system assets.',
        'domains' => [
            'ASSET_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'continuity-and-disaster-recovery-plans-established',
        'external_id' => 'BCD-1',
        'name' => 'Continuity and Disaster Recovery plans established',
        'description' => 'The company has Business Continuity and Disaster Recovery Plans in place that outline communication plans in order to maintain information security continuity in the event of the unavailability of key personnel.',
        'domains' => [
            'BUSINESS_CONTINUITY_&_DISASTER_RECOVERY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'continuity-disaster-recovery-plans-tested',
        'external_id' => 'BCD-2',
        'name' => 'Continuity and Disaster Recovery plans tested',
        'description' => 'The company has a documented Business Continuity/Disaster Recovery (BC/DR) plan and tests it at least annually.',
        'domains' => [
            'BUSINESS_CONTINUITY_&_DISASTER_RECOVERY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'configuration-management-system-established',
        'external_id' => 'CFG-1',
        'name' => 'Configuration management system established',
        'description' => 'The company has a configuration management procedure in place to ensure that system configurations are deployed consistently throughout the environment.',
        'domains' => [
            'CONFIGURATION_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'change-management-procedures',
        'external_id' => 'CHG-1',
        'name' => 'Change management procedures enforced',
        'description' => 'The company requires changes to software and infrastructure components of the service to be authorized, formally documented, tested, reviewed, and approved prior to being implemented in the production environment.',
        'domains' => [
            'CHANGE_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'changes-approval-required',
        'external_id' => 'CHG-2',
        'name' => 'Production deployment access restricted',
        'description' => 'The company restricts access to migrate changes to production to authorized personnel.',
        'domains' => [
            'CHANGE_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'development-lifecycle-established',
        'external_id' => 'CHG-3',
        'name' => 'Development lifecycle established',
        'description' => 'The company has a formal systems development life cycle (SDLC) methodology in place that governs the development, acquisition, implementation, changes (including emergency changes), and maintenance of information systems and related technology requirements.',
        'domains' => [
            'CHANGE_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-datastores-ssh',
        'external_id' => 'CRY-1',
        'name' => 'Unique production database authentication enforced',
        'description' => 'The company requires authentication to production datastores to use authorized secure authentication mechanisms, such as unique SSH key.',
        'domains' => [
            'CRYPTOGRAPHIC_PROTECTIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-encryption-keys',
        'external_id' => 'CRY-2',
        'name' => 'Encryption key access restricted',
        'description' => 'The company restricts privileged access to encryption keys to authorized users with a business need.',
        'domains' => [
            'CRYPTOGRAPHIC_PROTECTIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'assets-portable-media-encrypted',
        'external_id' => 'CRY-3',
        'name' => 'Portable media encrypted',
        'description' => 'The company encrypts portable and removable media devices when used.',
        'domains' => [
            'CRYPTOGRAPHIC_PROTECTIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'data-encrypted',
        'external_id' => 'CRY-4',
        'name' => 'Data encryption utilized',
        'description' => 'The company\'s datastores housing sensitive customer data are encrypted at rest.',
        'domains' => [
            'CRYPTOGRAPHIC_PROTECTIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'unique-account-authentication-enforced',
        'external_id' => 'CRY-5',
        'name' => 'Unique account authentication enforced',
        'description' => 'The company requires authentication to systems and applications to use unique username and password or authorized Secure Socket Shell (SSH) keys.',
        'domains' => [
            'CRYPTOGRAPHIC_PROTECTIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'customer-data-deleted-upon-leave',
        'external_id' => 'DCH-1',
        'name' => 'Customer data deleted upon leaving',
        'description' => 'The company purges or removes customer data containing confidential information from the application environment, in accordance with best practices, when customers leave the service.',
        'domains' => [
            'DATA_CLASSIFICATION_&_HANDLING',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'data-classification-policy',
        'external_id' => 'DCH-5',
        'name' => 'Data classification policy established',
        'description' => 'The company has a data classification policy in place to help ensure that confidential data is properly secured and restricted to authorized personnel.',
        'domains' => [
            'DATA_CLASSIFICATION_&_HANDLING',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'assets-anti-malware',
        'external_id' => 'END-1',
        'name' => 'Anti-malware technology utilized',
        'description' => 'The company deploys anti-malware technology to environments commonly susceptible to malicious attacks and configures this to be updated routinely, logged, and installed on all relevant systems.',
        'domains' => [
            'ENDPOINT_SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-application-restricted',
        'external_id' => 'IAC-1',
        'name' => 'Production application access restricted',
        'description' => 'System access restricted to authorized access only',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-ssh-required',
        'external_id' => 'IAC-10',
        'name' => 'Unique network system authentication enforced',
        'description' => 'The company requires authentication to the "production network" to use unique usernames and passwords or authorized Secure Socket Shell (SSH) keys.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'policies-password-complexity',
        'external_id' => 'IAC-11',
        'name' => 'Password policy enforced',
        'description' => 'The company requires passwords for in-scope system components to be configured according to the company\'s policy.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'remote-access-mfa-enforced',
        'external_id' => 'IAC-12',
        'name' => 'Remote access MFA enforced',
        'description' => 'The company\'s production systems can only be remotely accessed by authorized employees possessing a valid multi-factor authentication (MFA) method.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'remote-access-vpn-enforced',
        'external_id' => 'IAC-13',
        'name' => 'Remote access encrypted enforced',
        'description' => 'The company\'s production systems can only be remotely accessed by authorized employees via an approved encrypted connection.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-control-procedures',
        'external_id' => 'IAC-2',
        'name' => 'Access control procedures established',
        'description' => 'The company\'s access control policy documents the requirements for the following access control functions: 

- adding new users;

- modifying users; and/or 

- removing an existing user\'s access.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-database-restricted-users',
        'external_id' => 'IAC-3',
        'name' => 'Production database access restricted',
        'description' => 'The company restricts privileged access to databases to authorized users with a business need.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-firewalls',
        'external_id' => 'IAC-4',
        'name' => 'Firewall access restricted',
        'description' => 'The company restricts privileged access to the firewall to authorized users with a business need.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-operating-system-restricted',
        'external_id' => 'IAC-5',
        'name' => 'Production OS access restricted',
        'description' => 'The company restricts privileged access to the operating system to authorized users with a business need.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-production-network-restricted',
        'external_id' => 'IAC-6',
        'name' => 'Production network access restricted',
        'description' => 'The company restricts privileged access to the production network to authorized users with a business need.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-reviews',
        'external_id' => 'IAC-7',
        'name' => 'Access reviews conducted',
        'description' => 'The company conducts access reviews at least quarterly for the in-scope system components to help ensure that access is restricted appropriately. Required changes are tracked to completion.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-revoked-termination',
        'external_id' => 'IAC-8',
        'name' => 'Access revoked upon termination',
        'description' => 'The company completes termination checklists to ensure that access is revoked for terminated employees within SLAs.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'access-role-based',
        'external_id' => 'IAC-9',
        'name' => 'Access requests required',
        'description' => 'The company ensures that user access to in-scope system components is based on job role and function or requires a documented access request form and manager approval prior to access being provisioned.',
        'domains' => [
            'IDENTIFICATION_&_AUTHENTICATION',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'control-self-assessments-conducted',
        'external_id' => 'IAO-1',
        'name' => 'Control self-assessments conducted',
        'description' => 'The company performs control self-assessments at least annually to gain assurance that controls are in place and operating effectively. Corrective actions are taken based on relevant findings. If the company has committed to an SLA for a finding, the corrective action is completed within that SLA.',
        'domains' => [
            'INFORMATION_ASSURANCE',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'penetration-testing',
        'external_id' => 'IAO-2',
        'name' => 'Penetration testing performed',
        'description' => 'The company\'s penetration testing is performed at least annually. A remediation plan is developed and changes are implemented to remediate vulnerabilities in accordance with SLAs.',
        'domains' => [
            'INFORMATION_ASSURANCE',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'incident-response-plan-tested',
        'external_id' => 'IRO-1',
        'name' => 'Incident response plan tested',
        'description' => 'The company tests their incident response plan at least annually.',
        'domains' => [
            'INCIDENT_RESPONSE',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'incident-response-policies-established',
        'external_id' => 'IRO-2',
        'name' => 'Incident response policies established',
        'description' => 'The company has security and privacy incident response policies and procedures that are documented and communicated to authorized users.',
        'domains' => [
            'INCIDENT_RESPONSE',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'policies-incident-management',
        'external_id' => 'IRO-3',
        'name' => 'Incident management procedures followed',
        'description' => 'The company\'s security and privacy incidents are logged, tracked, resolved, and communicated to affected or relevant parties by management according to the company\'s security incident response policy and procedures.',
        'domains' => [
            'INCIDENT_RESPONSE',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'MDM-system-utilized',
        'external_id' => 'MDM-1',
        'name' => 'MDM system utilized',
        'description' => 'The company has a mobile device management (MDM) system in place to centrally manage mobile devices supporting the service.',
        'domains' => [
            'MOBILE_DEVICE_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'intrusion-detection-system',
        'external_id' => 'MON-1',
        'name' => 'Intrusion detection system utilized',
        'description' => 'The company uses an intrusion detection system to provide continuous monitoring of the company\'s network and early detection of potential security breaches.',
        'domains' => [
            'CONTINUOUS_MONITORING',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'log-management-utilized',
        'external_id' => 'MON-2',
        'name' => 'Log management utilized',
        'description' => 'The company utilizes a log management tool to identify events that may have a potential impact on the company\'s ability to achieve its security objectives.',
        'domains' => [
            'CONTINUOUS_MONITORING',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'system-threshold-monitoring',
        'external_id' => 'MON-4',
        'name' => 'Infrastructure performance monitored',
        'description' => 'An infrastructure monitoring tool is utilized to monitor systems, infrastructure, and performance and generates alerts when specific predefined thresholds are met.',
        'domains' => [
            'CONTINUOUS_MONITORING',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'data-encrypted-in-transit',
        'external_id' => 'NET-1',
        'name' => 'Data transmission encrypted',
        'description' => 'The company uses secure data transmission protocols to encrypt confidential and sensitive data when transmitted over public networks.',
        'domains' => [
            'NETWORK SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'infra-network-segregation',
        'external_id' => 'NET-2',
        'name' => 'Network segmentation implemented',
        'description' => 'The company\'s network is segmented to prevent unauthorized access to customer data.',
        'domains' => [
            'NETWORK SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'network-firewalls-reviewed',
        'external_id' => 'NET-3',
        'name' => 'Network firewalls reviewed',
        'description' => 'The company reviews its firewall rulesets at least annually. Required changes are tracked to completion.',
        'domains' => [
            'NETWORK SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'network-firewalls-utilized',
        'external_id' => 'NET-4',
        'name' => 'Network firewalls utilized',
        'description' => 'The company uses firewalls and configures them to prevent unauthorized access.',
        'domains' => [
            'NETWORK SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'system-network-hardening',
        'external_id' => 'NET-5',
        'name' => 'Network and system hardening standards maintained',
        'description' => 'The company\'s network and system hardening standards are documented, based on industry best practices, and reviewed at least annually.',
        'domains' => [
            'NETWORK SECURITY',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'policies-incident-monitoring',
        'external_id' => 'OPS-1',
        'name' => 'Vulnerability and system monitoring procedures established',
        'description' => 'The company\'s formal policies outline the requirements for the following functions related to IT / Engineering: 

- vulnerability management;

- system monitoring.',
        'domains' => [
            'SECURITY_OPERATIONS',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'third-party-agreements',
        'external_id' => 'TPM-1',
        'name' => 'Third-party agreements established',
        'description' => 'The company has written agreements in place with vendors and related third-parties. These agreements include confidentiality and privacy commitments applicable to that entity.',
        'domains' => [
            'THIRD-PARTY_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'vendor-management-program-established',
        'external_id' => 'TPM-2',
        'name' => 'Vendor management program established',
        'description' => 'The company has a vendor management program in place. Components of this program include:

- critical third-party vendor inventory;

- vendor\'s security and privacy requirements; and

- review of critical third-party vendors at least annually.',
        'domains' => [
            'THIRD-PARTY_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'support-infra-patched',
        'external_id' => 'VPM-1',
        'name' => 'Service infrastructure maintained',
        'description' => 'The company has infrastructure supporting the service patched as a part of routine maintenance and as a result of identified vulnerabilities to help ensure that servers supporting the service are hardened against security threats.',
        'domains' => [
            'VULNERABILITY_&_PATCH_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
    [
        'vanta_id' => 'vulnerability-scans-conducted',
        'external_id' => 'VPM-2',
        'name' => 'Vulnerabilities scanned and remediated',
        'description' => 'Host-based vulnerability scans are performed at least quarterly on all external-facing systems. Critical and high vulnerabilities are tracked to remediation.',
        'domains' => [
            'VULNERABILITY_&_PATCH_MANAGEMENT',
        ],
        'source' => 'Vanta',
    ],
];
