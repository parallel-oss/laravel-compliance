<?php

namespace Parallel\Compliance\Frameworks;

enum Soc2Criteria: string implements FrameworkRequirement
{
    case A1_1 = 'SOC2:A1.1';
    case A1_2 = 'SOC2:A1.2';
    case A1_3 = 'SOC2:A1.3';
    case C1_1 = 'SOC2:C1.1';
    case C1_2 = 'SOC2:C1.2';
    case CC1_1 = 'SOC2:CC1.1';
    case CC1_2 = 'SOC2:CC1.2';
    case CC1_3 = 'SOC2:CC1.3';
    case CC1_4 = 'SOC2:CC1.4';
    case CC1_5 = 'SOC2:CC1.5';
    case CC2_1 = 'SOC2:CC2.1';
    case CC2_2 = 'SOC2:CC2.2';
    case CC2_3 = 'SOC2:CC2.3';
    case CC3_1 = 'SOC2:CC3.1';
    case CC3_2 = 'SOC2:CC3.2';
    case CC3_3 = 'SOC2:CC3.3';
    case CC3_4 = 'SOC2:CC3.4';
    case CC4_1 = 'SOC2:CC4.1';
    case CC4_2 = 'SOC2:CC4.2';
    case CC5_1 = 'SOC2:CC5.1';
    case CC5_2 = 'SOC2:CC5.2';
    case CC5_3 = 'SOC2:CC5.3';
    case CC6_1 = 'SOC2:CC6.1';
    case CC6_2 = 'SOC2:CC6.2';
    case CC6_3 = 'SOC2:CC6.3';
    case CC6_4 = 'SOC2:CC6.4';
    case CC6_5 = 'SOC2:CC6.5';
    case CC6_6 = 'SOC2:CC6.6';
    case CC6_7 = 'SOC2:CC6.7';
    case CC6_8 = 'SOC2:CC6.8';
    case CC7_1 = 'SOC2:CC7.1';
    case CC7_2 = 'SOC2:CC7.2';
    case CC7_3 = 'SOC2:CC7.3';
    case CC7_4 = 'SOC2:CC7.4';
    case CC7_5 = 'SOC2:CC7.5';
    case CC8_1 = 'SOC2:CC8.1';
    case CC9_1 = 'SOC2:CC9.1';
    case CC9_2 = 'SOC2:CC9.2';
    case P1_1 = 'SOC2:P1.1';
    case P2_1 = 'SOC2:P2.1';
    case P3_1 = 'SOC2:P3.1';
    case P3_2 = 'SOC2:P3.2';
    case P4_1 = 'SOC2:P4.1';
    case P4_2 = 'SOC2:P4.2';
    case P4_3 = 'SOC2:P4.3';
    case P5_1 = 'SOC2:P5.1';
    case P5_2 = 'SOC2:P5.2';
    case P6_1 = 'SOC2:P6.1';
    case P6_2 = 'SOC2:P6.2';
    case P6_3 = 'SOC2:P6.3';
    case P6_4 = 'SOC2:P6.4';
    case P6_5 = 'SOC2:P6.5';
    case P6_6 = 'SOC2:P6.6';
    case P6_7 = 'SOC2:P6.7';
    case P7_1 = 'SOC2:P7.1';
    case P8_1 = 'SOC2:P8.1';
    case PI1_1 = 'SOC2:PI1.1';
    case PI1_2 = 'SOC2:PI1.2';
    case PI1_3 = 'SOC2:PI1.3';
    case PI1_4 = 'SOC2:PI1.4';
    case PI1_5 = 'SOC2:PI1.5';
    case SupportingDocumentation = 'SOC2:SD';

    public function id(): string
    {
        return $this->value;
    }

    public function source(): string
    {
        return 'SOC 2';
    }

    public function title(): string
    {
        return match ($this) {
            self::A1_1 => 'Capacity management',
            self::A1_2 => 'Environmental and recovery infrastructure',
            self::A1_3 => 'Recovery plan testing',
            self::C1_1 => 'Confidential information identification',
            self::C1_2 => 'Confidential information disposal',
            self::CC1_1 => 'COSO Principle 1: Integrity and ethical values',
            self::CC1_2 => 'COSO Principle 2: Board independence and oversight',
            self::CC1_3 => 'COSO Principle 3: Structures, reporting lines, and authorities',
            self::CC1_4 => 'COSO Principle 4: Attracting and retaining competent individuals',
            self::CC1_5 => 'COSO Principle 5: Accountability for internal control',
            self::CC2_1 => 'COSO Principle 13: Quality information for internal control',
            self::CC2_2 => 'COSO Principle 14: Internal communication of control information',
            self::CC2_3 => 'COSO Principle 15: External communication on control matters',
            self::CC3_1 => 'COSO Principle 6: Clarity in objectives for risk identification',
            self::CC3_2 => 'COSO Principle 7: Risk identification and management',
            self::CC3_3 => 'COSO Principle 8: Fraud risk assessment',
            self::CC3_4 => 'COSO Principle 9: Assessment of impactful changes',
            self::CC4_1 => 'COSO Principle 16: Evaluation of internal control',
            self::CC4_2 => 'COSO Principle 17: Communication of control deficiencies',
            self::CC5_1 => 'COSO Principle 10: Development of control activities',
            self::CC5_2 => 'COSO Principle 11: Technology control activities',
            self::CC5_3 => 'COSO Principle 12: Deployment of control activities',
            self::CC6_1 => 'Logical access security implementation',
            self::CC6_2 => 'User registration and access control',
            self::CC6_3 => 'Role-based access management',
            self::CC6_4 => 'Physical access restrictions',
            self::CC6_5 => 'Decommissioning of logical and physical assets',
            self::CC6_6 => 'External threat protection',
            self::CC6_7 => 'Information transmission security',
            self::CC6_8 => 'Malware prevention and detection',
            self::CC7_1 => 'Vulnerability detection and monitoring',
            self::CC7_2 => 'System anomaly monitoring',
            self::CC7_3 => 'Security event evaluation',
            self::CC7_4 => 'Incident response program',
            self::CC7_5 => 'Security incident recovery',
            self::CC8_1 => 'Change management process',
            self::CC9_1 => 'Business disruption risk mitigation',
            self::CC9_2 => 'Vendor and partner risk management',
            self::P1_1 => 'Privacy notice to data subjects',
            self::P2_1 => 'Privacy choices and consent',
            self::P3_1 => 'Personal information collection',
            self::P3_2 => 'Consent communication and collection',
            self::P4_1 => 'Limited use of personal information',
            self::P4_2 => 'Personal information retention',
            self::P4_3 => 'Secure disposal of personal information',
            self::P5_1 => 'Data subject access to personal information',
            self::P5_2 => 'Personal information correction and amendment',
            self::P6_1 => 'Personal information disclosure',
            self::P6_2 => 'Record of authorized disclosures',
            self::P6_3 => 'Record of unauthorized disclosures',
            self::P6_4 => 'Privacy commitments from vendors and third parties',
            self::P6_5 => 'Third-party breach notification commitment',
            self::P6_6 => 'Breach and incident notification',
            self::P6_7 => 'Personal information accounting',
            self::P7_1 => 'Accurate and complete personal information',
            self::P8_1 => 'Privacy inquiry and dispute resolution',
            self::PI1_1 => 'Quality information for processing objectives',
            self::PI1_2 => 'Input controls policies and procedures',
            self::PI1_3 => 'Processing controls policies and procedures',
            self::PI1_4 => 'Output delivery controls',
            self::PI1_5 => 'Storage policies for inputs, processing, and outputs',
            self::SupportingDocumentation => 'System and commitments description for audit',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::A1_1 => 'The entity maintains, monitors, and evaluates current processing capacity and use of system components (infrastructure, data, and software) to manage capacity demand and to enable the implementation of additional capacity to help meet its objectives.',
            self::A1_2 => 'The entity authorizes, designs, develops or acquires, implements, operates, approves, maintains, and monitors environmental protections, software, data back-up processes, and recovery infrastructure to meet its objectives.',
            self::A1_3 => 'The entity tests recovery plan procedures supporting system recovery to meet its objectives.',
            self::C1_1 => 'The entity identifies and maintains confidential information to meet the entity’s objectives related to confidentiality.',
            self::C1_2 => 'The entity disposes of confidential information to meet the entity’s objectives related to confidentiality.',
            self::CC1_1 => 'COSO Principle 1: The entity demonstrates a commitment to integrity and ethical values.',
            self::CC1_2 => 'COSO Principle 2: The board of directors demonstrates independence from management and exercises oversight of the development and performance of internal control.',
            self::CC1_3 => 'COSO Principle 3: Management establishes, with board oversight, structures, reporting lines, and appropriate authorities and responsibilities in the pursuit of objectives.',
            self::CC1_4 => 'COSO Principle 4: The entity demonstrates a commitment to attract, develop, and retain competent individuals in alignment with objectives.',
            self::CC1_5 => 'COSO Principle 5: The entity holds individuals accountable for their internal control responsibilities in the pursuit of objectives.',
            self::CC2_1 => 'COSO Principle 13: The entity obtains or generates and uses relevant, quality information to support the functioning of internal control.',
            self::CC2_2 => 'COSO Principle 14: The entity internally communicates information, including objectives and responsibilities for internal control, necessary to support the functioning of internal control.',
            self::CC2_3 => 'COSO Principle 15: The entity communicates with external parties regarding matters affecting the functioning of internal control.',
            self::CC3_1 => 'COSO Principle 6: The entity specifies objectives with sufficient clarity to enable the identification and assessment of risks relating to objectives.',
            self::CC3_2 => 'COSO Principle 7: The entity identifies risks to the achievement of its objectives across the entity and analyzes risks as a basis for determining how the risks should be managed.',
            self::CC3_3 => 'COSO Principle 8: The entity considers the potential for fraud in assessing risks to the achievement of objectives.',
            self::CC3_4 => 'COSO Principle 9: The entity identifies and assesses changes that could significantly impact the system of internal control.',
            self::CC4_1 => 'COSO Principle 16: The entity selects, develops, and performs ongoing and/or separate evaluations to ascertain whether the components of internal control are present and functioning.',
            self::CC4_2 => 'COSO Principle 17: The entity evaluates and communicates internal control deficiencies in a timely manner to those parties responsible for taking corrective action, including senior management and the board of directors, as appropriate.',
            self::CC5_1 => 'COSO Principle 10: The entity selects and develops control activities that contribute to the mitigation of risks to the achievement of objectives to acceptable levels.',
            self::CC5_2 => 'COSO Principle 11: The entity also selects and develops general control activities over technology to support the achievement of objectives.',
            self::CC5_3 => 'COSO Principle 12: The entity deploys control activities through policies that establish what is expected and in procedures that put policies into action.',
            self::CC6_1 => 'The entity implements logical access security software, infrastructure, and architectures over protected information assets to protect them from security events to meet the entity\'s objectives.',
            self::CC6_2 => 'Prior to issuing system credentials and granting system access, the entity registers and authorizes new internal and external users whose access is administered by the entity. For those users whose access is administered by the entity, user system credentials are removed when user access is no longer authorized.',
            self::CC6_3 => 'The entity authorizes, modifies, or removes access to data, software, functions, and other protected information assets based on roles, responsibilities, or the system design and changes, giving consideration to the concepts of least privilege and segregation of duties, to meet the entity’s objectives.',
            self::CC6_4 => 'The entity restricts physical access to facilities and protected information assets (for example, data center facilities,  back-up media storage, and other sensitive locations) to authorized personnel to meet the entity’s objectives.',
            self::CC6_5 => 'The entity discontinues logical and physical protections over physical assets only after the ability to read or recover data and software from those assets has been diminished and is no longer required to meet the entity’s objectives.',
            self::CC6_6 => 'The entity implements logical access security measures to protect against threats from sources outside its system boundaries.',
            self::CC6_7 => 'The entity restricts the transmission, movement, and removal of information to authorized internal and external users and processes, and protects it during transmission, movement, or removal to meet the entity’s objectives.',
            self::CC6_8 => 'The entity implements controls to prevent or detect and act upon the introduction of unauthorized or malicious software to meet the entity’s objectives.',
            self::CC7_1 => 'To meet its objectives, the entity uses detection and monitoring procedures to identify (1) changes to configurations that result in the introduction of new vulnerabilities, and (2) susceptibilities to newly discovered vulnerabilities.',
            self::CC7_2 => 'The entity monitors system components and the operation of those components for anomalies that are indicative of malicious acts, natural disasters, and errors affecting the entity\'s ability to meet its objectives; anomalies are analyzed to determine whether they represent security events.',
            self::CC7_3 => 'The entity evaluates security events to determine whether they could or have resulted in a failure of the entity to meet its objectives (security incidents) and, if so, takes actions to prevent or address such failures.',
            self::CC7_4 => 'The entity responds to identified security incidents by executing a defined incident response program to understand, contain, remediate, and communicate security incidents, as appropriate.',
            self::CC7_5 => 'The entity identifies, develops, and implements activities to recover from identified security incidents.',
            self::CC8_1 => 'The entity authorizes, designs, develops or acquires, configures, documents, tests, approves, and implements changes to infrastructure, data, software, and procedures to meet its objectives.',
            self::CC9_1 => 'The entity identifies, selects, and develops risk mitigation activities for risks arising from potential business disruptions.',
            self::CC9_2 => 'The entity assesses and manages risks associated with vendors and business partners.',
            self::P1_1 => 'The entity provides notice to data subjects about its privacy practices to meet the entity’s objectives related to privacy. The notice is updated and communicated to data subjects in a timely manner for changes to the entity’s privacy practices, including changes in the use of personal information, to meet the entity’s objectives related to privacy.',
            self::P2_1 => 'The entity communicates choices available regarding the collection, use, retention, disclosure, and disposal of personal information to the data subjects and the consequences, if any, of each choice. Explicit consent for the collection, use, retention, disclosure, and disposal of personal information is obtained from data subjects or other authorized persons, if required. Such consent is obtained only for the intended purpose of the information to meet the entity’s objectives related to privacy. The entity’s basis for determining implicit consent for the collection, use, retention, disclosure, and disposal of personal information is documented.',
            self::P3_1 => 'Personal information is collected consistent with the entity’s objectives related to privacy.',
            self::P3_2 => 'For information requiring explicit consent, the entity communicates the need for such consent, as well as the consequences of a failure to provide consent for the request for personal information, and obtains the consent prior to the collection of the information to meet the entity’s objectives related to privacy.',
            self::P4_1 => 'The entity limits the use of personal information to the purposes identified in the entity’s objectives related to privacy.',
            self::P4_2 => 'The entity retains personal information consistent with the entity’s objectives related to privacy.',
            self::P4_3 => 'The entity securely disposes of personal information to meet the entity’s objectives related to privacy.',
            self::P5_1 => 'The entity grants identified and authenticated data subjects the ability to access their stored personal information for review and, upon request, provides physical or electronic copies of that information to data subjects to meet the entity’s objectives related to privacy. If access is denied, data subjects are informed of the denial and reason for such denial, as required, to meet the entity’s objectives related to privacy.',
            self::P5_2 => 'The entity corrects, amends, or appends personal information based on information provided by data subjects and communicates such information to third parties, as committed or required, to meet the entity’s objectives related to privacy. If a request for correction is denied, data subjects are informed of the denial and reason for such denial to meet the entity’s objectives related to privacy.',
            self::P6_1 => 'The entity discloses personal information to third parties with the explicit consent of data subjects, and such consent is obtained prior to disclosure to meet the entity’s objectives related to privacy.',
            self::P6_2 => 'The entity creates and retains a complete, accurate, and timely record of authorized disclosures of personal information to meet the entity’s objectives related to privacy.',
            self::P6_3 => 'The entity creates and retains a complete, accurate, and timely record of detected or reported unauthorized disclosures (including breaches) of personal information to meet the entity’s objectives related to privacy.',
            self::P6_4 => 'The entity obtains privacy commitments from vendors and other third parties who have access to personal information to meet the entity’s objectives related to privacy. The entity assesses those parties’ compliance on a periodic and as-needed basis and takes corrective action, if necessary.',
            self::P6_5 => 'The entity obtains commitments from vendors and other third parties with access to personal information to notify the entity in the event of actual or suspected unauthorized disclosures of personal information. Such notifications are reported to appropriate personnel and acted on in accordance with established incident response procedures to meet the entity’s objectives related to privacy.',
            self::P6_6 => 'The entity provides notification of breaches and incidents to affected data subjects, regulators, and others to meet the entity’s objectives related to privacy.',
            self::P6_7 => 'The entity provides data subjects with an accounting of the personal information held and disclosure of the data subjects’ personal information, upon the data subjects’ request, to meet the entity’s objectives related to privacy.',
            self::P7_1 => 'The entity collects and maintains accurate, up-to-date, complete, and relevant personal information to meet the entity’s objectives related to privacy.',
            self::P8_1 => 'The entity implements a process for receiving, addressing, resolving, and communicating the resolution of inquiries, complaints, and disputes from data subjects and others and periodically monitors compliance to meet the entity’s objectives related to privacy. Corrections and other necessary actions related to identified deficiencies are made or taken in a timely manner.',
            self::PI1_1 => 'The entity obtains or generates, uses, and communicates relevant, quality information regarding the objectives related to processing, including definitions of data processed and product and service specifications, to support the use of products and services.',
            self::PI1_2 => 'The entity implements policies and procedures over system inputs, including controls over completeness and accuracy, to result in products, services, and reporting to meet the entity’s objectives.',
            self::PI1_3 => 'The entity implements policies and procedures over system processing to result in products, services, and reporting to meet the entity’s objectives.',
            self::PI1_4 => 'The entity implements policies and procedures to make available or deliver output completely, accurately, and timely in accordance with specifications to meet the entity’s objectives.',
            self::PI1_5 => 'The entity implements policies and procedures to store inputs, items in processing, and outputs completely, accurately, and timely in accordance with system specifications to meet the entity’s objectives.',
            self::SupportingDocumentation => 'Description of the organization‘s system and commitments for Section III of the audit report',
        };
    }

    public function domain(): string
    {
        return match ($this) {
            self::A1_1 => 'Additional Criteria for Availability',
            self::A1_2 => 'Additional Criteria for Availability',
            self::A1_3 => 'Additional Criteria for Availability',
            self::C1_1 => 'Additional Criteria for Confidentiality',
            self::C1_2 => 'Additional Criteria for Confidentiality',
            self::CC1_1 => 'Control Environment',
            self::CC1_2 => 'Control Environment',
            self::CC1_3 => 'Control Environment',
            self::CC1_4 => 'Control Environment',
            self::CC1_5 => 'Control Environment',
            self::CC2_1 => 'Communication and Information',
            self::CC2_2 => 'Communication and Information',
            self::CC2_3 => 'Communication and Information',
            self::CC3_1 => 'Risk Assessment',
            self::CC3_2 => 'Risk Assessment',
            self::CC3_3 => 'Risk Assessment',
            self::CC3_4 => 'Risk Assessment',
            self::CC4_1 => 'Monitoring Activities',
            self::CC4_2 => 'Monitoring Activities',
            self::CC5_1 => 'Control Activities',
            self::CC5_2 => 'Control Activities',
            self::CC5_3 => 'Control Activities',
            self::CC6_1 => 'Logical and Physical Access Controls',
            self::CC6_2 => 'Logical and Physical Access Controls',
            self::CC6_3 => 'Logical and Physical Access Controls',
            self::CC6_4 => 'Logical and Physical Access Controls',
            self::CC6_5 => 'Logical and Physical Access Controls',
            self::CC6_6 => 'Logical and Physical Access Controls',
            self::CC6_7 => 'Logical and Physical Access Controls',
            self::CC6_8 => 'Logical and Physical Access Controls',
            self::CC7_1 => 'System Operations',
            self::CC7_2 => 'System Operations',
            self::CC7_3 => 'System Operations',
            self::CC7_4 => 'System Operations',
            self::CC7_5 => 'System Operations',
            self::CC8_1 => 'Change Management',
            self::CC9_1 => 'Risk Mitigation',
            self::CC9_2 => 'Risk Mitigation',
            self::P1_1 => 'Privacy Criteria Related to Notice and Communication of Objectives Related to Privacy',
            self::P2_1 => 'Privacy Criteria Related to Choice and Consent',
            self::P3_1 => 'Privacy Criteria Related to Collection',
            self::P3_2 => 'Privacy Criteria Related to Collection',
            self::P4_1 => 'Privacy Criteria Related to Use, Retention, and Disposal',
            self::P4_2 => 'Privacy Criteria Related to Use, Retention, and Disposal',
            self::P4_3 => 'Privacy Criteria Related to Use, Retention, and Disposal',
            self::P5_1 => 'Privacy Criteria Related to Access',
            self::P5_2 => 'Privacy Criteria Related to Access',
            self::P6_1 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_2 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_3 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_4 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_5 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_6 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P6_7 => 'Privacy Criteria Related to Disclosure and Notification',
            self::P7_1 => 'Privacy Criteria Related to Quality',
            self::P8_1 => 'Privacy Criteria Related to Monitoring and Enforcement',
            self::PI1_1 => 'Additional Criteria for Processing Integrity',
            self::PI1_2 => 'Additional Criteria for Processing Integrity',
            self::PI1_3 => 'Additional Criteria for Processing Integrity',
            self::PI1_4 => 'Additional Criteria for Processing Integrity',
            self::PI1_5 => 'Additional Criteria for Processing Integrity',
            self::SupportingDocumentation => 'Supporting Compliance Documentation',
        };
    }

    public function variants(): array
    {
        return match ($this) {
            self::A1_1 => ['SOC2_AVAILABILITY', 'SOC2_SECURITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::A1_2 => ['SOC2_AVAILABILITY', 'SOC2_SECURITY', 'SOC2_PRIVACY', 'SOC2_PROCESSING_INTEGRITY'],
            self::A1_3 => ['SOC2_AVAILABILITY', 'SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY'],
            self::C1_1 => ['SOC2_CONFIDENTIALITY', 'SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::C1_2 => ['SOC2_CONFIDENTIALITY', 'SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC1_1 => ['SOC2_SECURITY'],
            self::CC1_2 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC1_3 => ['SOC2_SECURITY'],
            self::CC1_4 => ['SOC2_SECURITY'],
            self::CC1_5 => ['SOC2_SECURITY'],
            self::CC2_1 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC2_2 => ['SOC2_SECURITY', 'SOC2_PRIVACY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC2_3 => ['SOC2_SECURITY', 'SOC2_CONFIDENTIALITY', 'SOC2_PRIVACY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC3_1 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY'],
            self::CC3_2 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC3_3 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY'],
            self::CC3_4 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY'],
            self::CC4_1 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC4_2 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC5_1 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY'],
            self::CC5_2 => ['SOC2_SECURITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC5_3 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY', 'SOC2_CONFIDENTIALITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC6_1 => ['SOC2_SECURITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC6_2 => ['SOC2_SECURITY'],
            self::CC6_3 => ['SOC2_SECURITY'],
            self::CC6_4 => ['SOC2_SECURITY'],
            self::CC6_5 => ['SOC2_SECURITY', 'SOC2_CONFIDENTIALITY', 'SOC2_PRIVACY'],
            self::CC6_6 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY'],
            self::CC6_7 => ['SOC2_SECURITY'],
            self::CC6_8 => ['SOC2_SECURITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC7_1 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY'],
            self::CC7_2 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC7_3 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC7_4 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC7_5 => ['SOC2_SECURITY', 'SOC2_PRIVACY'],
            self::CC8_1 => ['SOC2_SECURITY', 'SOC2_PROCESSING_INTEGRITY'],
            self::CC9_1 => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_PRIVACY'],
            self::CC9_2 => ['SOC2_SECURITY', 'SOC2_CONFIDENTIALITY', 'SOC2_PRIVACY'],
            self::P1_1 => ['SOC2_PRIVACY'],
            self::P2_1 => ['SOC2_PRIVACY'],
            self::P3_1 => ['SOC2_PRIVACY'],
            self::P3_2 => ['SOC2_PRIVACY'],
            self::P4_1 => ['SOC2_PRIVACY'],
            self::P4_2 => ['SOC2_PRIVACY', 'SOC2_CONFIDENTIALITY', 'SOC2_SECURITY'],
            self::P4_3 => ['SOC2_PRIVACY'],
            self::P5_1 => ['SOC2_PRIVACY'],
            self::P5_2 => ['SOC2_PRIVACY'],
            self::P6_1 => ['SOC2_PRIVACY', 'SOC2_SECURITY', 'SOC2_CONFIDENTIALITY'],
            self::P6_2 => ['SOC2_PRIVACY'],
            self::P6_3 => ['SOC2_PRIVACY', 'SOC2_SECURITY'],
            self::P6_4 => ['SOC2_PRIVACY', 'SOC2_SECURITY'],
            self::P6_5 => ['SOC2_PRIVACY', 'SOC2_SECURITY', 'SOC2_CONFIDENTIALITY'],
            self::P6_6 => ['SOC2_PRIVACY', 'SOC2_SECURITY'],
            self::P6_7 => ['SOC2_PRIVACY'],
            self::P7_1 => ['SOC2_PRIVACY'],
            self::P8_1 => ['SOC2_PRIVACY', 'SOC2_SECURITY', 'SOC2_AVAILABILITY'],
            self::PI1_1 => ['SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY'],
            self::PI1_2 => ['SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY'],
            self::PI1_3 => ['SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY', 'SOC2_AVAILABILITY'],
            self::PI1_4 => ['SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY'],
            self::PI1_5 => ['SOC2_PROCESSING_INTEGRITY', 'SOC2_SECURITY', 'SOC2_AVAILABILITY'],
            self::SupportingDocumentation => ['SOC2_SECURITY', 'SOC2_AVAILABILITY', 'SOC2_CONFIDENTIALITY', 'SOC2_PROCESSING_INTEGRITY', 'SOC2_PRIVACY'],
        };
    }
}
