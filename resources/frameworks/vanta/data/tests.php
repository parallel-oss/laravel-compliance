<?php

return [
    [
        'vanta_test_id' => 'aws-account-access-removed-on-termination',
        'key' => 'aws-account-access-removed-on-termination',
        'title' => 'AWS accounts deprovisioned when personnel leave',
        'description' => 'This test verifies AWS accounts are promptly deprovisioned once the associated user has been removed or terminated from your organization.',
        'failure_description' => 'Some AWS accounts associated with terminated personnel have not been deactivated.',
        'remediation_instructions' => 'Remove all accounts listed from AWS.',
        'category' => 'Account security',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-dynamodb-encryption',
        'key' => 'aws-dynamodb-encryption',
        'title' => 'DynamoDB Tables encrypted (AWS)',
        'description' => 'This test verifies that DynamoDB tables have encryption enabled. AWS DynamoDB guarantees encryption by default for all tables—both encryption at rest and encryption in transit are automatically provided by AWS without requiring customer configuration.',
        'failure_description' => 'Some DynamoDB Tables are not encrypted.',
        'remediation_instructions' => 'AWS provides encryption at rest and in transit by default. See https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/EncryptionAtRest.html and https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/network-isolation.html

#### Remediation for Terraform
Ensure the `server_side_encryption` on your `aws_dynamodb_table` resources is set to true.

```hcl

resource "aws_dynamodb_table" "example" {
  name                   = "example"
  billing_mode           = "PROVISIONED"
  read_capacity          = 20 # Insert your desired  number of read units for this table
  write_capacity         = 20 # Insert your desired number of write units for this table
  hash_key               = "UserId" # Insert your desired set of nested attribute definitions for this table

  attribute {
    name = "UserId"
    type = "S" # Insert attribute type. Valid values are S (string), N (number), B (binary).
  }

  server_side_encryption {
    enabled = true
  }

}

```',
        'category' => 'Data storage',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-dynamodb-pitr-backups',
        'key' => 'aws-dynamodb-pitr-backups',
        'title' => 'Point-in-time recovery on DynamoDB enabled (AWS)',
        'description' => 'This test verifies that all active Amazon DynamoDB tables within your AWS account have point-in-time recovery (PITR) enabled.',
        'failure_description' => 'Some DynamoDB tables do not have point-in-time recovery enabled.',
        'remediation_instructions' => 'Enable point-in-time recovery on each DynamoDB table. This lets you recover your tables from a backup at any point over the past 35 days.

1. Log in to [AWS DynamoDB console](https://console.aws.amazon.com/dynamodb/).
2. Click the "Backups" tab for the table.
3. Enable "Point-in-time Recovery."

Enabling point-in-time recovery may increase your costs.

If you use a different mechanism to back up your DynamoDB data (such as on-demand backups), deactivate monitoring and provide a short description of your backup system.

#### Remediation for Terraform
Ensure the "point_in_time_recovery" on your "aws_dynamodb_table" resources is set to true.

```hcl

resource "aws_dynamodb_table" "example" {
  name                   = "example"
  billing_mode           = "PROVISIONED"
  read_capacity          = 20 # Insert your desired  number of read units for this table
  write_capacity         = 20 # Insert your desired number of write units for this table
  hash_key               = "UserId" # Insert your desired set of nested attribute definitions for this table

  attribute {
    name = "UserId"
    type = "S" # Insert attribute type. Valid values are S (string), N (number), B (binary).
  }

  point_in_time_recovery {
    enabled = true
  }

}

```',
        'category' => 'Data storage',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-ec2instances-ports-restricted',
        'key' => 'aws-ec2instances-ports-restricted',
        'title' => 'EC2 instance public ports restricted (AWS)',
        'description' => 'This test verifies that AWS EC2 instances do not have any unapproved TCP/UDP ports exposed publicly through their security groups. Instances should only expose explicitly permitted ports defined in your configuration.',
        'failure_description' => 'Ports other than 80 and 443 are publicly accessible on some EC2 instances via security groups.',
        'remediation_instructions' => 'Configure your security groups in AWS to deny public traffic on other ports.

1. [Log in to the AWS Management Console](https://console.aws.amazon.com/).
2. [Navigate to EC2 dashboard](https://console.aws.amazon.com/ec2/).
3. In the **NETWORK & SECURITY** section, **click Security Groups**.
4. Select one of the EC2 security groups.
5. Select the **Inbound** tab.
6. Verify that the protocol is not "All traffic" and that the port or port range is explicitly specified in each of your rules. The ICMP protocol is not considered public.
7. Check for values in the **Source** column that are set to `0.0.0.0/0` or `::/0` (Anywhere) with corresponding **Port range** column values that are not 80 and 443. If these two settings are true, the selected security group allows unrestricted traffic on this port range.
8. For the rows seen in step 7, change the **Port range** values to 80 and 443 or change the **Source** values to not be `0.0.0.0/0` or `::/0`.
9. Repeat steps 5 through 8 to verify the rest of your EC2 security groups.
10. Change the AWS region from the navigation bar, and repeat the audit process for other regions.

#### Remediation for Terraform
Create a "aws_security_group" resource to associate with your "aws_instance" resource. Ensure that your "aws_security_group" resource has no inbound rules set to 0.0.0.0/0 or ::/0 (Anywhere).

```hcl
resource "aws_security_group" "example" {
  name   = "example"
  vpc_id = aws_vpc.example.id

  ingress {
    from_port = 443
    to_port   = 443
    protocol  = "tcp"
  }
}

resource "aws_instance" "example" {
  ami                    = "ami-033fabdd332044f06" #Select your own Amazon Machine Image (AMI)
  instance_type          = "t2.micro" #Select your instance type
  vpc_security_group_ids = [aws_security_group.example.id]

}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/instance) for more information.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-guardduty-enabled',
        'key' => 'aws-guardduty-enabled',
        'title' => 'Intrusion detection system enabled (AWS)',
        'description' => 'This test verifies whether AWS GuardDuty is correctly enabled in every AWS account and region connected to your environment.',
        'failure_description' => 'Some accounts and regions don\'t have AWS GuardDuty enabled.',
        'remediation_instructions' => 'Enable AWS GuardDuty. For each region:

1. [Log into the AWS GuardDuty console](https://console.aws.amazon.com/guardduty).
2. Click "Get Started".
3. Click "Enable GuardDuty".
4. Ensure all data sources are enabled in the settings. See the "Usage" tab to view which data sources are enabled.

If you are using a different Intrusion Detection System, deactivate this test.

#### Remediation for Terraform
Ensure "aws_guardduty_detector" resource has an enable argument set to true.

```hcl

resource "aws_guardduty_detector" "example" {
  enable = true
}

```hcl

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/guardduty_detector) for more information.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-guardduty-notifications-enabled',
        'key' => 'aws-guardduty-notifications-enabled',
        'title' => 'Intrusion detection system notifications configured (AWS)',
        'description' => 'This test verifies that notifications for AWS GuardDuty threat detections are configured correctly, ensuring each AWS account and region is receiving GuardDuty notifications.',
        'failure_description' => 'Some accounts and regions don\'t have AWS GuardDuty threat detection notifications configured.',
        'remediation_instructions' => 'Configure notifications for AWS GuardDuty threat detections.

Follow the instructions [here](https://docs.aws.amazon.com/guardduty/latest/ug/guardduty_findings_cloudwatch.html) under the "Creating a CloudWatch Events rule to notify you of GuardDuty findings" section. For common issues, please see our help article [here](https://help.vanta.com/hc/en-us/articles/13043351354260-How-to-enable-AWS-GuardDuty-notifications-for-Vanta)

#### Remediation for Terraform
Create an `aws_sns_topic` resource, `aws_sns_topic_subscription` resource, and `aws_cloudwatch_event_rule` resource with the event pattern that consists of the "aws.guardduty" source. Add a `aws_cloudwatch_event_target` and associate it with your `aws_sns_topic` resource.


```hcl

resource "aws_sns_topic" "example" {
  name = "example"
}

resource "aws_sns_topic_subscription" "example" {
  topic_arn = aws_sns_topic.example.arn
  protocol  = "email" # Select the protocol to use. Valid values are: sqs, sms, lambda, firehose, and application. Protocols email, email-json, http and https are also valid but partially supported.
  endpoint  = "example@gmail.com" # Select the endpoint to send data to. The input varies with the protocol.
}
resource "aws_cloudwatch_event_rule" "example" {
  name = "example"

  event_pattern = <<EOF
{
  "source": ["aws.guardduty"],
  "region": ["us-east-1"], # Choose your AWS region
  "detail-type": ["GuardDuty Finding"],
  "detail": {
    "severity": [6, 6.0, 6.1, 6.2, 6.3, 6.4, 6.5, 6.6, 6.7, 6.8, 6.9, 7, 7.0, 7.1, 7.2, 7.3, 7.4, 7.5, 7.6, 7.7, 7.8, 7.9, 8, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5, 8.6, 8.7, 8.8, 8.9]
  }
}
EOF
}

resource "aws_cloudwatch_event_target" "example" {
  rule      = "example"
  arn       = aws_sns_topic.example.arn
  target_id = "example"
}

```',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-iam-expired-certificates-removed',
        'key' => 'aws-iam-expired-certificates-removed',
        'title' => 'Expired SSL/TLS certificates are removed (AWS)',
        'description' => 'This test verifies that all expired SSL/TLS certificates stored in AWS IAM have been removed. Expired certificates left in IAM can cause confusion, potential misconfigurations, and may indicate poor certificate lifecycle management.',
        'failure_description' => 'Some SSL/TLS certificates stored in AWS IAM have expired.',
        'remediation_instructions' => 'To remove expired SSL/TLS certificates stored in AWS IAM, use the AWS CLI, as the AWS Management Console does not currently support this action.

"**From Console:**

Removing expired certificates via AWS Management Console is not currently supported. To delete SSL/TLS certificates stored in IAM via the AWS API use the Command Line Interface (CLI).

**From Command Line:**

To delete Expired Certificate run following command by replacing <CERTIFICATE_NAME> with the name of the certificate to delete:

```
aws iam delete-server-certificate --server-certificate-name <CERTIFICATE_NAME>
```

When the preceding command is successful, it does not return any output."',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-rds-multi-az-redundancy',
        'key' => 'aws-rds-multi-az-redundancy',
        'title' => 'RDS Multi-AZ deployment configured (AWS)',
        'description' => 'This test verifies that AWS RDS database instances are configured for high availability using Multi-AZ deployment to ensure disaster recovery readiness.',
        'failure_description' => 'Some RDS database instances are not configured for high availability. Non-Aurora instances do not have Multi-AZ enabled, or Aurora clusters have insufficient redundancy across Availability Zones.',
        'remediation_instructions' => '**For Non-Aurora RDS Instances - From Console:**

1. Log in to the AWS Management Console and navigate to the RDS dashboard at https://console.aws.amazon.com/rds/.
2. Under the navigation panel, click `Databases`.
3. Select the RDS instance that needs Multi-AZ configuration.
4. Click `Modify` from the dashboard top menu.
5. On the Modify DB Instance panel, under the `Availability & durability` section, set `Multi-AZ deployment` to `Create a standby instance (recommended for production usage)`.
6. Click `Continue` and choose when to apply the modifications:
   - Select `Apply during the next scheduled maintenance window` to minimize downtime during off-peak hours.
   - Select `Apply immediately` to apply changes right away (may cause downtime).
7. Review the changes and click `Modify DB Instance`.
8. Repeat for each non-Aurora RDS instance in all regions.

**For Aurora Clusters - From Console:**

1. Log in to the AWS Management Console and navigate to the RDS dashboard.
2. Click on the Aurora cluster that needs additional redundancy.
3. In the cluster details, click `Add reader` to create additional Aurora replicas.
4. When adding readers, ensure they are placed in different Availability Zones than existing instances.
5. Configure at least 2 instances total across at least 2 different Availability Zones.
6. Repeat for each Aurora cluster that lacks sufficient redundancy.

**From Command Line:**

For Non-Aurora RDS Instances:
```bash
# List all RDS instances
aws rds describe-db-instances --region <region-name> --query \'DBInstances[*].{DBInstanceIdentifier:DBInstanceIdentifier,MultiAZ:MultiAZ,Engine:Engine}\'

# Enable Multi-AZ for a specific instance
aws rds modify-db-instance \\
    --region <region-name> \\
    --db-instance-identifier <db-instance-id> \\
    --multi-az \\
    --apply-immediately
```

For Aurora Clusters:
```bash
# List Aurora clusters and their instances
aws rds describe-db-clusters --region <region-name> --query \'DBClusters[*].{DBClusterIdentifier:DBClusterIdentifier,DBClusterMembers:DBClusterMembers}\'

# Add a new Aurora replica in a different AZ
aws rds create-db-instance \\
    --region <region-name> \\
    --db-instance-identifier <new-replica-id> \\
    --db-instance-class <instance-class> \\
    --engine aurora-mysql \\
    --db-cluster-identifier <cluster-id> \\
    --availability-zone <different-az>
```

**Note:** Multi-AZ deployment will increase costs but significantly improves availability and data durability. Plan the maintenance window carefully to minimize impact on production workloads.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-s3-cross-region-replication-enabled',
        'key' => 'aws-s3-cross-region-replication-enabled',
        'title' => 'S3 backup configured for redundancy across regions (AWS)',
        'description' => 'This test verifies that AWS S3 buckets are configured with enabled cross-region replication rules to ensure data redundancy and disaster recovery readiness across different AWS regions.',
        'failure_description' => 'Some AWS S3 buckets lack enabled cross-region replication configuration, potentially affecting data redundancy and disaster recovery readiness.',
        'remediation_instructions' => '## Choose Your Remediation Approach

**Not all S3 buckets require cross-region replication.** Before configuring replication, determine if each failing bucket actually needs disaster recovery protection.

### Option 1: Deactivate Entity (Recommended for Non-Critical Buckets)

If a bucket doesn\'t require disaster recovery protection, you can deactivate it from this test:

**Common bucket types that typically don\'t need replication:**
- Access logging buckets (e.g., `*-access-logs`, `*-logging`)
- CloudTrail log buckets (AWS already provides high durability)
- Temporary or scratch data buckets
- Configuration buckets with non-critical data
- Destination buckets that are themselves replicas from other buckets

**To deactivate an entity in Vanta:**
1. Navigate to the failing test in your Vanta dashboard
2. Click on the specific bucket entity that\'s failing
3. Select "Deactivate Entity" to exclude it from this test
4. Provide a brief justification (e.g., "Access logging bucket - replication not required")

### Option 2: Configure Cross-Region Replication (For Critical Data)

For buckets containing important data that requires disaster recovery protection:

  1. Sign in to the AWS Management Console.
  2. Navigate to the S3 service.
  3. Select the S3 bucket you want to enable replication for.
  4. Go to the Management tab and click Replication.
  5. Click Create replication rule.
  6. Enter a rule name and select Enable rule.
  7. Under Source, specify the objects or prefix to replicate, or select to replicate the entire bucket.
  8. Under Destination, choose a bucket in a different AWS region (not the same as the source region).
  9. Ensure the destination bucket exists and has the correct permissions.
  10. Optionally, enable additional options such as replication of delete markers or replica ownership.
  11. Review the IAM role permissions for replication and allow S3 to use the role, or create a new role as prompted.
  12. Click Save or Create rule to enable cross-region replication.

**Note:** Avoid creating "replication chains" where every destination bucket also needs its own replication. Focus replication on your critical data buckets only.',
        'category' => 'Data storage',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'aws-s3-public-access-blocked',
        'key' => 'aws-s3-public-access-blocked',
        'title' => 'S3 Block Public Access feature enabled (AWS)',
        'description' => 'This test checks whether your AWS S3 buckets have the "Block Public Access" setting enabled, ensuring buckets are secure from accidental public exposure.',
        'failure_description' => 'You haven\'t enabled AWS\'s Block Public Access feature on S3 buckets.',
        'remediation_instructions' => 'Enable [AWS\'s Block Public Access](https://docs.aws.amazon.com/AmazonS3/latest/userguide/access-control-block-public-access.html) feature on your S3 buckets. This ensures that S3 buckets are not public by default, reducing the chance of data being accidentally exposed.

Vanta recommends enabling this feature at the account level to automatically apply it to all buckets.

1. Navigate to the [S3 AWS Console](https://s3.console.aws.amazon.com/s3/).
2. Select Block Public Access settings for this account.
3. Click **Edit.**
4. Select **Block all public access.**
5. Click **Save changes.**
6. Enter **confirm** in the text field.
7. Click **confirm.**

Alternatively, you can enable this feature only on certain buckets, and disable Vanta\'s monitoring of the others.

1. Navigate to the [S3 AWS Console](https://s3.console.aws.amazon.com/s3/).
2. Select the relevant bucket(s).
3. Navigate to **Permissions.**
4. Under the **Block Public Access** section, click **Edit.**
5. Select **Block all public access.**
6. Click **Save Changes.**
7. Enter **confirm** in the text field.
8. Click **confirm.**

If you use a different mechanism to ensure S3 buckets are not public, deactivate monitoring and provide a short description of your system.

#### Remediation for Terraform
Edit your aws_s3_bucket_public_access_block resources to have block_public_acls, block_public_policy, ignore_public_acls, and restrict_public_buckets set to \'true\'

```hcl
resource "aws_s3_bucket" "example" {
  bucket = "test-bucket"
}

resource "aws_s3_bucket_public_access_block" "example" {
  bucket = aws_s3_bucket.example.id

  block_public_acls       = true
  block_public_policy     = true
  ignore_public_acls      = true
  restrict_public_buckets = true
}
```',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-account-linked-in-vanta',
        'key' => 'cloudflare-account-linked-in-vanta',
        'title' => 'Cloudflare accounts associated with users',
        'description' => 'This test verifies that all Cloudflare user accounts are associated with users in Vanta\'s system. Linking accounts to users enables proper access tracking, accountability, and ensures that only authorized personnel have access to your Cloudflare infrastructure.',
        'failure_description' => 'Vanta detected some Cloudflare accounts that are not associated with users within Vanta.',
        'remediation_instructions' => 'Visit the [Access page](/access?credentialKey=cloudflare) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.',
        'category' => 'IT',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-account-mfa-enabled',
        'key' => 'cloudflare-account-mfa-enabled',
        'title' => 'MFA on Cloudflare',
        'description' => 'This test verifies that multi-factor authentication (MFA) is enabled on all Cloudflare user accounts that are not marked as external or non-human. MFA adds a critical second layer of authentication, protecting Cloudflare accounts from unauthorized access even if passwords are compromised.',
        'failure_description' => 'Multi-factor authentication isn\'t enabled for your Cloudflare accounts',
        'remediation_instructions' => 'Enforce multi-factor authentication on all of your organization\'s Cloudflare accounts.

Follow the [instructions](https://support.cloudflare.com/hc/en-us/articles/200167906-Securing-user-access-with-two-factor-authentication-2FA-#12345679) that Cloudflare provides to turn on MFA on each account.

Monitoring can be disabled for any Cloudflare accounts that use SSO. If SSO is used for all accounts across your Cloudflare account, monitoring for this test can be deactivated.',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-http-https-redirection-enabled',
        'key' => 'cloudflare-http-https-redirection-enabled',
        'title' => 'HTTP to HTTPS redirection enabled (Cloudflare)',
        'description' => 'This test verifies that HTTP traffic is automatically redirected to HTTPS using Cloudflare\'s Always Use HTTPS feature. This ensures all clients receive encryption, even if they initially connect over HTTP.',
        'failure_description' => 'Some Cloudflare zones do not have Always Use HTTPS enabled, which means HTTP traffic is not automatically redirected to HTTPS.',
        'remediation_instructions' => 'Enable Cloudflare\'s Always Use HTTPS feature to automatically redirect HTTP traffic to HTTPS. This ensures all clients receive encryption, even if they initially connect over HTTP.

1. Log in to your [Cloudflare dashboard](https://dash.cloudflare.com/).
2. Select the zone where you want to enable HTTPS redirection.
3. In the left-hand menu, click "SSL/TLS".
4. Click the "Edge Certificates" tab.
5. Scroll down to the "Always Use HTTPS" section.
6. Toggle the switch to "On" to enable Always Use HTTPS.
7. Wait a few minutes for the setting to propagate across Cloudflare\'s network.
8. Test your domain by visiting the HTTP version (e.g., http://yourdomain.com) and confirm it redirects to HTTPS (https://yourdomain.com).

**Verify the Configuration:**

After enabling Always Use HTTPS:

1. Open a web browser and navigate to your domain using HTTP (e.g., http://yourdomain.com).
2. Verify that the browser automatically redirects to the HTTPS version.
3. Check the address bar to confirm the URL shows "https://" and a padlock icon.

**Important Notes:**

- **Proxied DNS required:** Always Use HTTPS only works when your DNS records are proxied through Cloudflare (orange cloud icon in DNS settings).
- **SSL/TLS mode:** Ensure your SSL/TLS encryption mode is set to "Full" or "Full (strict)" for proper HTTPS configuration.
- **Certificate status:** Verify that your domain has an active SSL/TLS certificate in the "Edge Certificates" tab.

Learn more about [Always Use HTTPS](https://developers.cloudflare.com/ssl/edge-certificates/additional-options/always-use-https/).',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-notifications-enabled',
        'key' => 'cloudflare-notifications-enabled',
        'title' => 'Cloudflare notifications enabled',
        'description' => 'This test verifies that four critical Cloudflare notification policies are enabled in your account: HTTP DDoS Attack Alert (or Advanced HTTP DDoS Attack Alert for Enterprise customers), Health Checks status notification, Passive Origin Monitoring, and Route Leak Detection Alert. These notifications ensure your team is promptly alerted to security threats like DDoS attacks, origin server issues, and BGP route leaks.',
        'failure_description' => 'Your Cloudflare account does not have all the required notifications enabled',
        'remediation_instructions' => 'Enable the notifications \'HTTP DDoS Attack Alert\', \'Health Checks status notification\'
\'Passive Origin Monitoring\' and \'Route Leak Detection Alert\' using
[these instructions](https://developers.cloudflare.com/fundamentals/notifications/create-notifications/)',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-ssl-mode-validation',
        'key' => 'cloudflare-ssl-mode-validation',
        'title' => 'SSL/TLS encryption enforced (Cloudflare)',
        'description' => 'This test verifies that your Cloudflare zones are configured with proper SSL/TLS encryption mode to ensure end-to-end encryption. It checks that each zone uses either "Full" or "Full (Strict)" SSL mode, which encrypts traffic both between the client and Cloudflare, and between Cloudflare and your origin server.',
        'failure_description' => 'Some Cloudflare zones are not configured to use "Full" or "Full (Strict)" SSL mode, potentially leaving communications between Cloudflare and origin servers unencrypted.',
        'remediation_instructions' => 'Configure your Cloudflare zones to use "Full" or "Full (Strict)" SSL/TLS encryption mode to ensure end-to-end encryption.

1. Log in to the [Cloudflare dashboard](https://dash.cloudflare.com/).
2. Select the appropriate domain (zone) from your list of sites.
3. In the left-hand navigation menu, click "SSL/TLS".
4. Under the "Overview" tab, locate the "SSL/TLS encryption mode" section.
5. If the mode is not set to "Full" or "Full (Strict)", click the dropdown menu.
6. Select "Full" or "Full (Strict)" as required for your security policy.
7. Wait for the setting to be applied (this may take a few minutes).
8. Verify that the SSL/TLS encryption mode now displays as "Full" or "Full (Strict)".

If you selected "Full (Strict)", confirm that your origin server has a valid SSL certificate installed.

Learn more about [Cloudflare SSL modes](https://developers.cloudflare.com/ssl/edge-certificates/ssl-modes/) in the Cloudflare documentation.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'cloudflare-worker-kv-encryption',
        'key' => 'cloudflare-worker-kv-encryption',
        'title' => 'Verifies that Cloudflare provides encryption at rest of all data stored within Cloudflare Workers KV by default.',
        'description' => 'This test verifies that all data stored in Cloudflare Workers KV namespaces is encrypted at rest. Cloudflare automatically encrypts all Workers KV data at rest by default as part of their platform security architecture, so this test always passes without requiring any customer configuration.',
        'failure_description' => 'Some Cloudflare Workers KV does not have encryption enabled.',
        'remediation_instructions' => 'For each Cloudflare Worker KV listed enable encryption.',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'code-review-application-config',
        'key' => 'code-review-application-config',
        'title' => 'Application changes reviewed',
        'description' => 'This test verifies the branch protection settings to ensure that at least one approval is required to merge code changes into the default or specified production branch of all linked version control repositories.',
        'failure_description' => 'Your version control system is not set up to require code reviews.',
        'remediation_instructions' => 'Set up protected branches in your version control tool account to make sure that changes are reviewed and approved.

1. Protect the default branch (or production branch, if it was explicitly specified during linking) in each [GitHub](https://help.github.com/articles/configuring-protected-branches/), [Bitbucket](https://confluence.atlassian.com/bitbucket/branch-permissions-385912271.html), [GitLab](https://docs.gitlab.com/ee/user/project/protected_branches.html), or [Azure DevOps](https://docs.microsoft.com/en-us/azure/devops/repos/git/branch-policies) repository, or [AWS CodeCommit](https://docs.aws.amazon.com/codecommit/latest/userguide/how-to-create-pull-request-approval-rule.html) repository. In most cases, the default branch is the `main` branch.
2. Set up required reviews
   - In GitHub, set up either a [protection rule](https://help.github.com/articles/enabling-required-reviews-for-pull-requests/) or a [ruleset](https://docs.github.com/en/repositories/configuring-branches-and-merges-in-your-repository/managing-rulesets/creating-rulesets-for-a-repository).
   - In Bitbucket, set up a [merge check for at least one approval](https://confluence.atlassian.com/bitbucket/suggest-or-require-checks-before-a-merge-856691474.html).
   - In GitLab, set up [merge request approvals](https://docs.gitlab.com/ee/user/project/merge_requests/merge_request_approvals.html) or [required approval by codeowners](https://docs.gitlab.com/ee/user/project/protected_branches.html#protected-branches-approval-by-code-owners-premium). If requiring approval by codeowners, be sure to create [a CODEOWNERS file for the repository.](https://gitlab.com/help/user/project/code_owners.md)
   - In Azure DevOps, set the [minimum number of reviewers](https://docs.microsoft.com/en-us/azure/devops/repos/git/branch-policies?view=azure-devops#require-a-minimum-number-of-reviewers) to be greater than 0, or greater than 1 if "Allow requesters to approve their own changes" is selected. You can also set up a policy to [automatically include code reviewers](https://docs.microsoft.com/en-us/azure/devops/repos/git/branch-policies?view=azure-devops#automatically-include-code-reviewers) on all pull requests with a group as a required reviewer and set the minimum number of reviewers to be a greater than 0, or greater than 1 if "Allow requesters to approve their own changes" is selected.
   - In AWS CodeCommit, create an approval rule that includes the default branch and set the [number of approvals needed](https://docs.aws.amazon.com/codecommit/latest/userguide/how-to-create-pull-request-approval-rule.html#how-to-create-pull-request-approval-rule-console) to be at least 1.

#### Remediation for Terraform
For AWS CodeCommit, create an aws_codecommit_approval_rule_template that sets the NumberOfApprovalsNeeded to 1 or greater on your default branch and associate it to the repository.

```hcl
# rule template
resource "aws_codecommit_approval_rule_template" "ruletemplate" {
  name        = "TestApprovalRuleTemplate"
  description = "This is a rule template"

  content = jsonencode({
    Version               = "2018-11-08"
    DestinationReferences = ["main"] # set this to your default branch
    Statements = [{
      Type                    = "Approvers"
      NumberOfApprovalsNeeded = 1 # this value must be 1 or greater
    }]
  })
}

# associate the rule template to the repository
resource "aws_codecommit_approval_rule_template_association" "testassociation" {
  approval_rule_template_name = "TestApprovalRuleTemplate" # your rule template name
  repository_name             = "Test-Repo" # your repository name
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/codecommit_approval_rule_template) for additional information.',
        'category' => 'Software development',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
            'azuredevops',
            'bitbucket',
            'github',
            'gitlab',
        ],
    ],
    [
        'vanta_test_id' => 'docusign-account-linked-in-vanta',
        'key' => 'docusign-account-linked-in-vanta',
        'title' => 'Docusign accounts associated with users',
        'description' => 'This test verifies that all DocuSign accounts in your organization are associated with users in Vanta. Linking accounts to users is essential for maintaining accurate access visibility, enabling proper access reviews, and ensuring accountability for document signing activities.',
        'failure_description' => 'Vanta detected some Docusign accounts that are not associated with users within Vanta.',
        'remediation_instructions' => 'Visit the [Access page](/access?credentialKey=docusign) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.',
        'category' => 'Account setup',
        'status' => 'OK',
        'integrations' => [
            'docusign',
        ],
    ],
    [
        'vanta_test_id' => 'firewall-config-acl',
        'key' => 'firewall-config-acl',
        'title' => 'Unwanted traffic filtered',
        'description' => 'This test verifies that all AWS EC2 instances have either a Network ACL associated with their subnet or a security group directly attached. Without these network filtering mechanisms, instances lack basic firewall protection, leaving them exposed to unwanted inbound and outbound traffic.',
        'failure_description' => 'Your corporate network doesn\'t filter unwanted traffic.',
        'remediation_instructions' => 'Set up a corporate VPN to control access to your corporate network. Vanta recommends [OpenVPN](https://openvpn.net/access-server/?utm_source=vanta&utm_medium=referral).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'firewall-config-cloudflare',
        'key' => 'firewall-config-cloudflare',
        'title' => 'Unwanted traffic filtered (Cloudflare)',
        'description' => 'This test verifies that your Cloudflare account has active firewall protections in place—either through enabled custom firewall rules or managed rulesets. These firewalls help block unwanted or malicious traffic from reaching your infrastructure.',
        'failure_description' => 'Your Cloudflare domain doesn\'t filter unwanted traffic.',
        'remediation_instructions' => 'Create WAF rules for each of your domains in the "Security tab".',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'firewall-config-default-deny',
        'key' => 'firewall-config-default-deny',
        'title' => 'Firewall default disallows traffic',
        'description' => 'This test verifies that AWS firewall configurations (Security Groups and Network ACLs) default to denying inbound traffic, a behavior inherent to AWS infrastructure. It ensures that unless traffic is explicitly permitted, it will be blocked by default.',
        'failure_description' => 'N/A',
        'remediation_instructions' => 'N/A',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'firewall-config-server',
        'key' => 'firewall-config-server',
        'title' => 'Public SSH denied (AWS)',
        'description' => 'This test verifies whether AWS EC2 instances have security groups configured to restrict inbound SSH (TCP port 22) traffic from the public internet (0.0.0.0/0).',
        'failure_description' => 'Your EC2 instances are not configured to deny public SSH traffic.',
        'remediation_instructions' => 'Configure your security groups in AWS to deny public SSH traffic.

1. [Log in to the AWS Management Console](https://console.aws.amazon.com/).
2. [Navigate to EC2 dashboard](https://console.aws.amazon.com/ec2/).
3. In the **NETWORK & SECURITY** section, **click Security Groups**.
4. Click inside the search field, and select the following options from the dropdown list:
   - Choose **Protocol** and select **TCP** from the protocols list.
   - Choose **Port Range** and select **SSH** as filter input.
5. Select one of the EC2 security groups.
6. Select the **Inbound** tab.
7. Verify the value available in the **Source** column for any inbound or ingress rules with the Port Range set to `22`. If one or more rules have the source set to `0.0.0.0/0` or `::/0` (Anywhere), the selected security group allows unrestricted traffic on port 22. As a result, the SSH access to the associated EC2 instances isn\'t secured.
8. Repeat steps 5 through 7 to verify the rest of your EC2 security groups.
9. Change the AWS region from the navigation bar, and repeat the audit process for other regions.

If accessing to the instances through SSH is intended, we suggest allowlisting specific IPs using allow rules and using a tool or technique that provides a static IP (or an address within a specific range) for you to connect successfully to your EC2 instances.

#### Remediation for Terraform
Create a "aws_security_group" resource to associate with your "aws_instance" resource. Ensure that your "aws_security_group" resource is configured to deny public SSH traffic.

```hcl
resource "aws_security_group" "example" {
  name   = "example"
  vpc_id = aws_vpc.example.id

  ingress {
    from_port = 443
    to_port   = 443
    protocol  = "tcp"
  }
}

resource "aws_instance" "example" {
  ami                    = "ami-033fabdd332044f06" #Select your own Amazon Machine Image (AMI)
  instance_type          = "t2.micro" #Select your instance type
  vpc_security_group_ids = [aws_security_group.example.id]

}

```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/security_group) for more information.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'flow-logs-on-config',
        'key' => 'flow-logs-on-config',
        'title' => 'VPC Flow Logs enabled',
        'description' => 'This test checks whether your AWS Virtual Private Clouds (VPCs) have VPC Flow Logs enabled for network traffic monitoring.',
        'failure_description' => 'You aren\'t using VPC flow logs to capture information about your network\'s IP traffic.',
        'remediation_instructions' => 'Enable VPC flow logs for your virtual private cloud or subnet.

1. [Log in to the VPC Console](https://console.aws.amazon.com/vpc/).
2. In the navigation pane, select **Your VPCs**.
3. Select the VPC where you want to enable VPC flow logs.
4. Click **Flow logs | Create flow Log**.
5. Select whether the flow log should capture rejected traffic, accepted traffic, or all traffic.
6. Enter the name of a CloudWatch log group where the flow logs will be published.
7. Specify the name of [the IAM role that has permission to publish logs](https://docs.aws.amazon.com/vpc/latest/userguide/flow-logs-cwl.html#flow-logs-iam-role) to CloudWatch Logs.
8. Click **Create flow log**.

For more information, see [VPC Flow Logs](https://docs.aws.amazon.com/vpc/latest/userguide/flow-logs.html) in the AWS help.

#### Remediation for Terraform
Create a `aws_flow_log` resource to associate with your desired vpc_id. Choose a log_destination for your `aws_flow_log` resource and include the relevant `aws_iam_role` that includes the policies shown.

```hcl

resource "aws_flow_log" "example" {
  iam_role_arn    = aws_iam_role.flow_log_role.arn
  log_destination = aws_cloudwatch_log_group.example.arn
  traffic_type    = "ALL"
  vpc_id          = aws_vpc.example.id
}

resource "aws_cloudwatch_log_group" "example" {
  name = "example"
}

resource "aws_iam_role" "flow_log_role" {
  name               = "flow_log_role"
  assume_role_policy = data.aws_iam_policy_document.assume_role.json
}

data "aws_iam_policy_document" "assume_role" {
  statement {
    effect = "Allow"

    principals {
      type = "Service"
      identifiers = ["vpc-flow-logs.amazonaws.com",
      "streams.metrics.cloudwatch.amazonaws.com"]
    }

    actions = ["sts:AssumeRole"]
  }
}

resource "aws_iam_policy" "policy" {
  name        = "policy"
  path        = "/"
  description = "My test policy"

  # Terraform\'s "jsonencode" function converts a
  # Terraform expression result to valid JSON syntax.
  policy = jsonencode({
   Version = "2012-10-17",
   Statement = [
    {
      Effect = "Allow"
      Action = [
        "logs:CreateLogGroup",
        "logs:CreateLogStream",
        "logs:PutLogEvents",
        "logs:DescribeLogGroups",
        "logs:DescribeLogStreams",
      ]
        Resource = "*"
    },
  ]
  })
}

resource "aws_iam_policy_attachment" "test-attach" {
  name       = "test-attach"
  roles      = [aws_iam_role.flow_log_role.name]
  policy_arn = aws_iam_policy.policy.arn
}

```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/flow_log) for more information.',
        'category' => 'Logging',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'github-account-access-removed-on-termination',
        'key' => 'github-account-access-removed-on-termination',
        'title' => 'GitHub accounts deprovisioned when personnel leave',
        'description' => 'This test verifies that GitHub accounts associated with terminated or inactive users have been promptly deprovisioned.',
        'failure_description' => 'Some GitHub accounts associated with terminated personnel have not been deactivated.',
        'remediation_instructions' => 'For each GitHub account listed, remove or deactivate the account.',
        'category' => 'Account security',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-account-linked-in-vanta',
        'key' => 'github-account-linked-in-vanta',
        'title' => 'GitHub accounts associated with users',
        'description' => 'This test verifies that all GitHub accounts have been linked to users within Vanta.',
        'failure_description' => 'Vanta detected some GitHub accounts that are not associated with users within Vanta.',
        'remediation_instructions' => 'Visit the [Access page](/access?credentialKey=github) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting `Add a person` or mark it as external by selecting `Assign to external person`.

If the account is not a human account, select `Mark as service account`.',
        'category' => 'Account setup',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-account-mfa-enabled',
        'key' => 'github-account-mfa-enabled',
        'title' => 'MFA on GitHub',
        'description' => 'This test verifies that multi-factor authentication (MFA) is enabled on all GitHub accounts that are not marked as external or non-human.',
        'failure_description' => 'Multi-factor authentication is not enabled for your GitHub accounts',
        'remediation_instructions' => 'Enforce multi-factor authentication on all of your organization\'s GitHub accounts.

Follow GitHub\'s [instructions](https://docs.github.com/en/github/authenticating-to-github/securing-your-account-with-two-factor-authentication-2fa/configuring-two-factor-authentication) to turn on MFA on each account.',
        'category' => 'Account security',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-author-is-different-from-reviewer',
        'key' => 'github-author-is-different-from-reviewer',
        'title' => 'Author is not the reviewer of pull requests',
        'description' => 'This test ensures that pull requests in GitHub are not self-approved by their authors. GitHub enforces this automatically—authors cannot approve their own pull requests.',
        'failure_description' => 'NA',
        'remediation_instructions' => 'NA',
        'category' => 'Software development',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-ensure-branch-protection-enforced',
        'key' => 'github-ensure-branch-protection-enforced',
        'title' => 'Ensure branch protection rules are enforced for administrators (GitHub)',
        'description' => 'This test verifies that all GitHub repositories linked to Vanta have branch protection rules enforced for administrators on the default branch or the explicitly specified production branch.',
        'failure_description' => 'Some repositories do not have branch protection rules enforced for administrators',
        'remediation_instructions' => '**Note** If your organization uses GitHub Rulesets, we recommend deactivating this test. While Rulesets also allow you to set branch protection rules, they do not allow Vanta to pull information about protection bypasses without escalated write permissions. If you do not use Rulesets, the following steps apply.

For every code repository in use, enforce branch protection rules for administrators by performing the following steps:

1. Check if you have specified a production branch using the the **vanta_production_branch_name** custom property in GitHub by following [this guide](https://help.vanta.com/hc/en-us/articles/23938692981524-What-branch-does-Vanta-look-at-for-GitHub-tests). Vanta will evaluate the production branch for this test. If you have not specified a production branch, this test will check the default branch.
2. In GitHub, navigate to the main page of the repository.
3. Under your repository name, click **Settings**.
4. In the "Code and automation" section of the sidebar, click **Branches**.
5. Next to "Branch protection rules," verify that there is at least one rule for your branch. If there is at least one rule, click **Edit**. If there are no rules, click **Add rule**.
6. If adding a new rule, under "Branch name pattern," type the branch name or pattern you want to protect.
7. If adding or editing, select **Do not allow bypassing the above settings**.
8. Click **Create** if adding a new rule or **Save changes** if editing an existing rule.

If you want to retain the ability for administrators to bypass branch protection rules in emergencies, Vanta recommends disabling this test. Additionally, you will need to provide manual evidence of a process that ensures that emergency changes are reviewed.',
        'category' => 'Software development',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-repos-are-private',
        'key' => 'github-repos-are-private',
        'title' => 'GitHub repository visibility has been set to private',
        'description' => 'This test verifies that all GitHub repositories in your organization, excluding those explicitly forked from external repositories, have their visibility set to private.',
        'failure_description' => 'Some repositories are not set to private.',
        'remediation_instructions' => 'It is a best practice to set repository visibility to private for all of your repositories. If you have repositories that are intentionally set to public, often to host open source code or examples, deactivate the test indefinitely for that repository and provide an explanation of why the repository must be public.

If a repository is inappropriately set to public, please follow GitHub\'s [instructions](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/managing-repository-settings/setting-repository-visibility#changing-a-repositorys-visibility) to make a repository private.',
        'category' => 'Software development',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'github-scanning-configuration',
        'key' => 'github-scanning-configuration',
        'title' => 'Vulnerability scanning is enabled (GitHub)',
        'description' => 'This test verifies that vulnerability scanning (via Dependabot) is enabled for your GitHub repositories, allowing you to identify and manage software vulnerabilities effectively.',
        'failure_description' => 'Vulnerability scanning is not enabled.',
        'remediation_instructions' => 'Vanta requests permission to read Dependabot alerts when connecting the GitHub integration by default.

To confirm Dependabot is enabled for vulnerability scanning in your monitored repositories, see GitHub\'s Dependabot [Quick Start Guide](https://docs.github.com/en/code-security/getting-started/dependabot-quickstart-guide).',
        'category' => 'Vulnerability management',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [],
    ],
    [
        'vanta_test_id' => 'high-severity-vendor-compliance-reports',
        'key' => 'high-severity-vendor-compliance-reports',
        'title' => 'Company completes security assessments for relevant vendors',
        'description' => 'This test verifies whether vendors requiring security assessments have current and up-to-date assessments according to their risk levels.',
        'failure_description' => 'Some vendors do not have an up-to-date security assessment.',
        'remediation_instructions' => 'Visit the [Vendors page](/vendors) and complete security assessments. To complete an assessment, open the assessments tab on each vendor. Upload the latest security documentation, document any notable findings, and mark the assessment as complete.',
        'category' => 'Vendors',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [],
    ],
    [
        'vanta_test_id' => 'infra-access-keys-rotated',
        'key' => 'infra-access-keys-rotated',
        'title' => 'Enabled IAM User Access Keys must not be older than 90 days',
        'description' => 'This test verifies that active AWS IAM access keys have been rotated within 90 days.',
        'failure_description' => 'Some IAM Access Keys are more than 90 days old and have not been rotated within SLA.',
        'remediation_instructions' => 'Set up automatic key rotation or rotate your old IAM Access Keys via the AWS console. To manually rotate keys:

1. Sign in to the AWS Management Console and open the [IAM console](https://console.aws.amazon.com/iam/).
2. In the navigation pane, choose “Users."
3. Choose the name of the intended user, and then choose the “Security credentials” tab.
4. Choose “Create access key” and then choose “Download .csv file” to save the access key to a .csv file on your computer. Next, store the file in a secure location such as a password manager as you will not later be able to view the secret access key in the IAM console. After you have downloaded the .csv file, choose “Close" in the IAM console.
5. Update all applications that use the original access key to use this new access key instead. The specific applications in use will depend on your unique AWS environment.
6. Determine whether the original access key is still in use by reviewing the “Last used” column for the original access key. Regularly review this list to ensure that the original access key is no longer in use.
7. Once you have confirmed that no other applications are using the original access key, choose the “Make inactive” option next to the key in "Security credentials." This will deactivate but not delete the original access key. If there are applications that still rely on this key, you can re-enable it via the “Make active” option, and repeat steps 5-7.

For more information, view [this guide](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_access-keys.html#Using_RotateAccessKey) for rotating access keys, [this guide](https://docs.aws.amazon.com/prescriptive-guidance/latest/patterns/automatically-rotate-iam-user-access-keys-at-scale-with-aws-organizations-and-aws-secrets-manager.html) for automatically rotating access keys, and this list of [access keys best practices](https://docs.aws.amazon.com/general/latest/gr/aws-access-keys-best-practices.html).',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-access-requires-approval-config',
        'key' => 'infra-access-requires-approval-config',
        'title' => 'AWS accounts reviewed',
        'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
        'failure_description' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
        'remediation_instructions' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
2. Create a task in your task tracker for each new account you need to create.
3. Tag the task with an `access-change` tag to track these changes in Vanta.

#### Remediation for Terraform
Add the "VantaOwner" tag to your aws_iam_user resource and set the value to an email address for a currently active Vanta user. This information will reflect on the [access page](https://app.vanta.com/access/accounts).

```hcl
resource "aws_iam_user" "test-iam-user" {
  name = "test-user"

  tags = {
    VantaOwner = "email@domain.com"
  }
}
```
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).',
        'category' => 'Account setup',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-activity-tracked-config',
        'key' => 'infra-activity-tracked-config',
        'title' => 'CloudTrail enabled',
        'description' => 'This test verifies that CloudTrail is enabled on all AWS accounts within your organization.',
        'failure_description' => 'You aren\'t using CloudTrail to monitor AWS user activity and API usage.',
        'remediation_instructions' => 'Enable CloudTrail in each of your AWS accounts.

1. [Log in to the CloudTrail dashboard in the AWS Management Console](https://console.aws.amazon.com/cloudtrail/).
2. In the navigation pane, click **Trails**.
3. Select "Create trail".
4. Create a trail. By default, when you create a trail in a region in the CloudTrail console, the trail applies to all regions. A multi-region trail is a recommended best practice, because it helps you to keep your AWS environment more secure, by logging activity in all regions.
5. Create an Amazon S3 bucket or specify an existing bucket where you want the log files delivered. By default, log files from all regions in your account are delivered to the bucket that you specify.
6. Configure your trail to log read-only, write-only, or all management events, all Insights events, and all or a subset of data events. By default, trails log all management events and no data or Insights events.

For more information, see [Working with CloudTrail](https://docs.aws.amazon.com/awscloudtrail/latest/userguide/cloudtrail-getting-started.html) in the AWS help.

#### Remediation for Terraform
Ensure that the \'include_global_service_events\' as well as the \'is_multi_region_trail\' arguments are set to true on at least one aws_cloudtrail resource in each AWS account.

```hcl
resource "aws_cloudtrail" "example" {
  depends_on = [aws_s3_bucket_policy.example]

  name                          = "example"
  s3_bucket_name                = aws_s3_bucket.example.id
  s3_key_prefix                 = "prefix"
  include_global_service_events = true
  is_multi_region_trail         = true

# event_selector is optional

  event_selector {
    read_write_type           = "WriteOnly"
    include_management_events = true

    data_resource {
      type   = "AWS::S3::Object"
      values = ["arn:aws:s3"]
    }
  }
}
...........
```

See a full example of the aws_cloudtrail resource including the required bucket policy in the [Terraform documentation here](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudtrail#example-usage).',
        'category' => 'Logging',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-ec2instances-imdsv1-disabled',
        'key' => 'infra-ec2instances-imdsv1-disabled',
        'title' => 'IMDSv1 is disabled on EC2 Instances',
        'description' => 'This test checks whether AWS EC2 instances have Instance Metadata Service Version 1 (IMDSv1) disabled to ensure secure metadata access through IMDSv2 or no metadata service at all.',
        'failure_description' => 'Some EC2 instances still have IMDSv1 enabled.',
        'remediation_instructions' => 'Disable IMDSv1 for your EC2 instances via the AWS CLI or AWS Console.

Review [this guide](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/configuring-IMDS-existing-instances.html) for more information about modifying existing instances and [this guide](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/configuring-IMDS-new-instances.html) to learn more about disabling IMDSv1 for new instances. You should verify that your CLI/SDK is up-to-date for use with IMDSv2 to prevent application errors.

Run the following command if you still need access to the metadata service (replace the instance-id value with your actual instance ID):

```
aws ec2 modify-instance-metadata-options \\
    --instance-id i-1234567898abcdef0 \\
    --http-tokens required \\
    --http-endpoint enabled
```

If you do not need access to the metadata service, you can alternatively run the following command:

```
aws ec2 modify-instance-metadata-options \\
    --instance-id i-1234567898abcdef0 \\
    --http-endpoint disabled
```
#### Remediation for Terraform
Ensure that the `http_tokens` metadata option is set to "required" for EC2 instances where access to the metadata service is required. You will need to replace the `ami` and `instance_type` with your actual configuration details.

```hcl
resource "aws_instance" "example_instance" {
  ami           = "ami-123456789abcdef0"
  instance_type = "t2.micro"

  # Disable IMDSv1
  metadata_options {
    http_tokens = "required"
  }
}

```

Alternatively, if access to the metadata service is not required you can use the `http_endpoint` option to disable it.

```hcl
resource "aws_instance" "example_instance" {
  ami           = "ami-123456789abcdef0"
  instance_type = "t2.micro"

  # Disable access to the metadata service
  metadata_options {
    http_endpoint = "disabled"
  }
}

```

See [Terraform metadata options documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/instance#metadata-options) for more information.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-linked-to-vanta',
        'key' => 'infra-linked-to-vanta',
        'title' => 'Cloud infrastructure linked to Vanta',
        'description' => 'This test verifies that at least one of the supported cloud infrastructure providers (AWS, GCP, Heroku, Azure, or DigitalOcean) is properly linked to Vanta.',
        'failure_description' => 'You don\'t have a cloud infrastructure service provider linked to Vanta.',
        'remediation_instructions' => 'Link your cloud infrastructure provider to Vanta on the [Integrations page](/integrations).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'akamai',
            'aws',
            'azure',
            'azure_for_government',
            'cloudflare',
            'cloudflare_for_government',
            'digitalocean',
            'digitaloceanspaces',
            'gcp',
            'heroku',
            'netlify',
            'oracle_cloud',
            'ovh_cloud',
            'scaleway',
            'supabase',
            'vercel',
        ],
    ],
    [
        'vanta_test_id' => 'infra-unique-accounts-roles',
        'key' => 'infra-unique-accounts-roles',
        'title' => 'Service accounts used',
        'description' => 'This test verifies that every AWS account connected to Vanta has at least one IAM role assigned. IAM roles are essential for securely delegating permissions to AWS services and users without sharing long-term credentials.',
        'failure_description' => 'You aren\'t using IAM roles to manage users\' access to services for every AWS account.',
        'remediation_instructions' => 'Many AWS services require that you use roles to allow the service to access resources in other services on your behalf.

1. [Create roles to delegate permissions to relevant AWS services](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_roles_create_for-service.html).
2. Assign these roles to users who need to access specific services.

#### Remediation for Terraform
Create an "aws_iam_role" resource that grants permission to assume a role. Add an "aws_iam_role_policy_attachment" resource to attach the permissions the role has once assumed.

```hcl
resource "aws_iam_role" "example" {
  name = "example"

  assume_role_policy = <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Action": "sts:AssumeRole",
      "Principal": {
        "Service": "ecs-tasks.amazonaws.com", # Replace with the AWS service that can assume the role
        "AWS": "arn:aws:iam::[account-id]:user/johndoe"
      },
      "Effect": "Allow",
      "Sid": ""
    }
  ]
}
EOF
}

resource "aws_iam_role_policy_attachment" "example-policy" {
  policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy" # Replace with the AWS IAM policy that includes the permissions of the service once the role is assumed.
  role       = aws_iam_role.example.name
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_role) for more information.',
        'category' => 'Account security',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-unique-accounts-root',
        'key' => 'infra-unique-accounts-root',
        'title' => 'Root infrastructure account unused',
        'description' => 'This test checks whether AWS root accounts have been used within the past 30 days.',
        'failure_description' => 'Your root infrastructure user has been used to make infrastructure changes recently. Root users should not be used for infrastructure changes and should only be used in emergencies.',
        'remediation_instructions' => 'The first user that is created for any new AWS account is known as the root user. As a best practice, the root user should only be used to create an administrative IAM user and should not be used after that except in emergency situations.

In AWS:

1. [Create IAM users and IAM roles](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users.html) to perform infrastructure tasks going forward and avoid making changes as the root user wherever possible.

In Vanta:

1. In the items to remediate for this test, click the "Acknowledge" button next to each instance and provide a reason why the root user was used instead of an IAM user or role.
2. Optionally: Click the "Apply this reason to all other incidents where this occurred" checkbox in the modal to acknowledge all instances at once.',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-unique-accounts-unused',
        'key' => 'infra-unique-accounts-unused',
        'title' => 'Old infrastructure accounts disabled (AWS)',
        'description' => 'This test checks for AWS IAM users (non-root) that have been inactive for more than 90 days and should be considered for removal.',
        'failure_description' => 'You have IAM user accounts that haven\'t been active in the last 90 days.',
        'remediation_instructions' => '1. Identify the IAM accounts that are no longer in use in your company.
2. [Delete IAM accounts](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_manage.html) that have been inactive for 90 days or more.

#### Remediation for Terraform
Set force_destroy to true for your "aws_iam_user" resource.

```hcl
resource "aws_iam_user" "test-iam-user" {
  name = "test-user"
  force_destroy = true

}
```
See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_user) for more information.',
        'category' => 'Account security',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'infra-unique-accounts-user',
        'key' => 'infra-unique-accounts-user',
        'title' => 'No user account has a policy attached directly',
        'description' => 'This test verifies that no AWS IAM users have policies attached directly to their user accounts, checking that policies are instead applied through user groups.',
        'failure_description' => 'Some of your AWS IAM policies are attached directly to users.',
        'remediation_instructions' => 'Amazon allows policies to be defined and applied at the group, role, or user level; as much as possible, only assign policies to groups or roles – not to individual users. Doing so will streamline making changes to users and help enforce a least-privileged policy.

#### Remediation for Terraform
Create a "aws_iam_user" resource and a "aws_iam_group" resource. Ensure the "aws_iam_user" resource is associated with the "aws_iam_group" resource using an "aws_iam_user_group_membership" resource. Verify that the "aws_iam_user" does not have any policies attached directly to the account, but rather has an aws_iam_group_policy" attached to its "aws_iam_group" resource.

```hcl
resource "aws_iam_user" "example" {
  name = "example"
}

resource "aws_iam_group" "group1" {
  name = "group1"
}

resource "aws_iam_user_group_membership" "example1" {
  user = aws_iam_user.example.name

  groups = [
    aws_iam_group.group1.name
  ]
}

resource "aws_iam_group_policy" "example_policy" {
  name  = "example_policy"
  group = aws_iam_group.group1.name

  # Terraform\'s "jsonencode" function converts a
  # Terraform expression result to valid JSON syntax.
  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action = [
          "ec2:Describe*",
        ]
        Effect   = "Allow"
        Resource = "*"
      },
    ]
  })
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_group_policy) for more information.',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'internal-password-policy-config',
        'key' => 'internal-password-policy-config',
        'title' => 'Password policy configured for infrastructure',
        'description' => 'This test verifies that all AWS accounts in your organization have an active and properly configured password policy defined.',
        'failure_description' => 'You aren\'t enforcing a password policy on your infrastructure accounts yet.',
        'remediation_instructions' => 'Set up a password policy in AWS that enforces password standards for your users.

1. Sign in to the AWS Management Console and open the [IAM console](https://console.aws.amazon.com/iam/).
2. In the navigation pane, click **Account Settings**.
3. In the Password Policy section, select **Edit**.
4. Select **Custom** and choose the options you want to apply to your password policy.
5. Click **Save Changes**.

For more information about password policy options, see [Setting an Account Password Policy for IAM Users](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_passwords_account-policy.html) in the AWS help.

#### Remediation for Terraform
Ensure that a "aws_iam_account_password_policy" resource is configured according to your organization\'s password requirements.

```hcl
resource "aws_iam_account_password_policy" "strict" {
  minimum_password_length        = 12
  require_lowercase_characters   = true
  require_numbers                = true
  require_uppercase_characters   = true
  require_symbols                = true
  allow_users_to_change_password = true
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_account_password_policy) for more information.',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'inventory-list-descriptions',
        'key' => 'inventory-list-descriptions',
        'title' => 'Inventory items have descriptions',
        'description' => 'This test verifies that every item on your Vanta Inventory page has a description. Maintaining descriptions for all inventory assets ensures proper asset management, accountability, and auditability—key requirements across security frameworks.',
        'failure_description' => 'Some inventory items don\'t have descriptions.',
        'remediation_instructions' => '1. Go to the [Inventory list](/inventory).
2. Ensure that each item in the list has a description.

Recommended: For your cloud resources, we offer a bulk tag option to help manage these resources. Click [here](/inventory?bulk-tags=open) for further instructions on how to use tags to populate inventory metadata.

#### Remediation for Terraform
Add the "VantaDescription" tag to your resources and set the value to a description of the resource. This information will reflect on the [inventory page](https://app.vanta.com/inventory).

```hcl
resource "aws_s3_bucket" "data" {
  bucket = "data-bucket"

  tags = {
    VantaDescription = "This bucket stores access logs"
  }
}
```

*Note that the tag key may be different from "VantaDescription" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'addigy',
            'aws',
            'azure',
            'azuredevops',
            'bitbucket',
            'cloudflare',
            'cloudflare_for_government',
            'datto',
            'digitalocean',
            'digitaloceanspaces',
            'gcp',
            'github',
            'gitlab',
            'heroku',
            'jamf',
            'jumpcloud',
            'kandji',
            'kolide',
            'manage_engine',
            'microsoft_endpoint_manager',
            'microsoft_endpoint_manager_gcc_high',
            'miradore',
            'mongoatlas',
            'mongoatlas_for_government',
            'netlify',
            'ninjaone',
            'oracle_cloud',
            'ovh_cloud',
            'rippling_mdm',
            'simplemdm',
            'snowflake',
            'supabase',
            'vercel',
            'workspace_one',
        ],
    ],
    [
        'vanta_test_id' => 'inventory-list-user-data',
        'key' => 'inventory-list-user-data',
        'title' => 'Inventory list tracks resources that contain user data',
        'description' => 'This test verifies whether certain resources—such as storage buckets, databases, PaaS apps, queues, data warehouses, or custom items—are marked as containing user data in Vanta.',
        'failure_description' => 'None of these resource types - storage buckets, databases, PaaS apps, queues, data warehouses, or custom items -  are marked as containing user data in Vanta.',
        'remediation_instructions' => 'Not all resource types can be marked as containing user data. Only Storage buckets, Databases, Platform-as-a-service (PaaS apps), Queues, Data warehouses, or Custom items apply.

1. Go to the [Inventory list](/inventory).
2. At least one resource containing user data must have its "Contains user data" option set to Yes under the ENCRYPTION / USER DATA column to activate this test.
3. To review/confirm that a resource contains user data, find the pencil icon in the User Data column for each resource and click it. You can also optionally provide a description of the user data stored.

[See this help article for more detail](https://help.vanta.com/hc/en-us/articles/15211770837524-Resolve-Inventory-list-tracks-resources-that-contain-user-data-test).

Recommended: For your cloud resources, we offer a bulk tag option to help manage these resources. Click [here](/inventory?bulk-tags=open) for further instructions on how to use tags to flag resources that contain user data.


#### Remediation for Terraform
Add the "VantaContainsUserData" tag to your resources and set the value to "true" for resources that contain user data. Describe the data stored in the resource using the "VantaUserDataStored" tag. This information will reflect on the [inventory page](https://app.vanta.com/inventory).

```hcl
resource "aws_s3_bucket" "data" {
  bucket = "data-bucket"

  tags = {
    VantaContainsUserData = "true"
    VantaUserDataStored = "This bucket stores user names and emails"
  }
}
```

*Note that the tag keys may be different from "VantaContainsUserData" and "VantaUserDataStored" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'addigy',
            'aws',
            'azure',
            'azuredevops',
            'bitbucket',
            'cloudflare',
            'cloudflare_for_government',
            'datto',
            'digitalocean',
            'digitaloceanspaces',
            'gcp',
            'github',
            'gitlab',
            'heroku',
            'jamf',
            'jumpcloud',
            'kandji',
            'kolide',
            'manage_engine',
            'microsoft_endpoint_manager',
            'microsoft_endpoint_manager_gcc_high',
            'miradore',
            'mongoatlas',
            'mongoatlas_for_government',
            'netlify',
            'ninjaone',
            'oracle_cloud',
            'ovh_cloud',
            'rippling_mdm',
            'simplemdm',
            'snowflake',
            'supabase',
            'vercel',
            'workspace_one',
        ],
    ],
    [
        'vanta_test_id' => 'ip-access-rules-cloudflare',
        'key' => 'ip-access-rules-cloudflare',
        'title' => 'Cloudflare IP access rules enabled',
        'description' => 'This test verifies that at least one active (unpaused) IP access rule is configured in your Cloudflare account or zone. IP access rules allow you to explicitly allow, block, or challenge traffic from specific IP addresses, IP ranges, or countries, providing a fundamental layer of network-level access control for your web properties.',
        'failure_description' => 'Your Cloudflare domains do not filter unwanted traffic.',
        'remediation_instructions' => 'Create [IP access rules](https://developers.cloudflare.com/waf/tools/ip-access-rules/) for each domain.

1. Go to your [Cloudflare Dashboard](https://dash.cloudflare.com/)
2. Select your account and then select the website/zone you want to manage.
3. In the left sidebar, go to Security > WAF (Web Application Firewall), or in some accounts, directly to Firewall.
4. Under the Tools or Firewall Rules section, look for IP Access Rules. Here you can create rules that explicitly allow, block, or challenge IP addresses, IP ranges, or countries.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'cloudflare',
        ],
    ],
    [
        'vanta_test_id' => 'load-balancer-config',
        'key' => 'load-balancer-config',
        'title' => 'Load balancer used (AWS)',
        'description' => 'This test validates that each AWS account in your organization has at least one Application Load Balancer (ALB) configured.',
        'failure_description' => 'You aren\'t using a load balancer to distribute traffic yet.',
        'remediation_instructions' => '[Determine the type of load balancer your application requires](https://docs.aws.amazon.com/elasticloadbalancing/latest/userguide/load-balancer-getting-started.html), and follow the steps to implement it.

#### Remediation for Terraform
Create an aws_lb resource for your network

```hcl
resource "aws_lb" "test-lb" {
  name               = "test-load-balancer-tf"
  internal           = true
  load_balancer_type = "application"
  security_groups    = [aws_security_group.lb_sg.id]
  subnets            = [for subnet in aws_subnet.public : subnet.id]
  enable_deletion_protection = true
}
```

See more in the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/lb).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'load-balancer-http-to-https',
        'key' => 'load-balancer-http-to-https',
        'title' => 'Load balancers redirect HTTP to HTTPS (AWS)',
        'description' => 'This test verifies that all internet-facing AWS Application Load Balancers (ALBs) listening on HTTP are configured to redirect that HTTP traffic to HTTPS.',
        'failure_description' => 'You have an Application Load Balancer that:
- Has an "internet-facing" **scheme**.
- Has a **listener** with an "HTTP" **protocol**.
- Does not have a **listener** with a **default action** that has a "redirect" **action type** and an "HTTPS" **redirect protocol**.',
        'remediation_instructions' => 'Configure the load balancers to redirect HTTP traffic to HTTPS.

For detailed instructions, see [our help article](https://help.vanta.com/hc/en-us/articles/10465036804500-How-to-Pass-the-Load-balancers-redirect-HTTP-to-HTTPS-AWS-Test).

#### Remediation for Terraform
Ensure that you create an aws_lb_listener resource for your aws_lb on port 80 that has a default_action to redirect to port 443.

```hcl
resource "aws_lb_listener" "example_listener" {
  load_balancer_arn = aws_lb.example_lb.arn
  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "redirect"
    redirect {
      protocol       = "HTTPS"
      port           = "443"
      status_code    = "HTTP_301"
    }
  }
}
```

See more in the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/data-sources/lb_listener).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'load-balancers-monitored-and-alarmed-config-healthy',
        'key' => 'load-balancers-monitored-and-alarmed-config-healthy',
        'title' => 'Load balancer unhealthy host count monitored (AWS)',
        'description' => 'This test verifies that all AWS Application Load Balancers (ALBs) have AWS CloudWatch alarms configured to monitor their host health statuses using specific AWS-provided metrics.',
        'failure_description' => 'Your load balancers don\'t have healthy host count alerts set up.',
        'remediation_instructions' => 'Set up healthy host count alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

- `UnHealthyHostCount`
- `HealthyHostCount`
- `EnvironmentHealth`

Note that these metrics are **only** available if a load balancer can make health checks over its instances. If not, you will not see these metrics until health checks are enabled.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on the appropriate metric for each of your load balancers. If you notice that some metrics do not appear to be emitted by Cloudwatch, double check that the load balancer has at least one target group configured.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Application Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/application/load-balancer-monitoring.html)
* [Available CloudWatch metrics for Classic Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-cloudwatch-metrics.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon ELB metric for your load balancers.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource using the UnHealthyHostCount, HealthyHostCount, or EnvironmentHealth metric.
evaluation_periods, period, statistic, and threshold can be set to values that make sense for your load balancers. Additionally ensure that you configure alarm_actions for notifications.

```hcl
resource "aws_cloudwatch_metric_alarm" "elb_unhealthy_hostcount_alarm" {
  alarm_name          = "elb-unhealthy-hostcount-alarm"
  comparison_operator = "GreaterThanThreshold"
  evaluation_periods  = 2
  metric_name         = "UnHealthyHostCount"
  namespace           = "AWS/ELB"
  period              = 60 # 1 minute
  statistic           = "Sum"
  threshold           = 1 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when UnHealthyHostCount exceeds 1 for 2 consecutive periods"

  dimensions = {
    LoadBalancerName = "your-load-balancer-name" # Replace with the name of your load balancer
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:my-sns-topic"] # Replace with your SNS topic ARN
}
```',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'load-balancers-monitored-and-alarmed-config-latency',
        'key' => 'load-balancers-monitored-and-alarmed-config-latency',
        'title' => 'Load balancer latency monitored',
        'description' => 'This test verifies that all AWS Application and Classic Load Balancers have CloudWatch alarms configured to monitor latency using accepted latency-related metrics.',
        'failure_description' => 'You haven\'t set up latency alerts for your load balancer yet.',
        'remediation_instructions' => 'Set up latency alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

- `Latency`
- `EnvironmentHealth`
- `ApplicationLatencyP99`
- `ApplicationLatencyP95`
- `TargetResponseTime`

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on the appropriate metric for each of your load balancers. If you notice that some metrics do not appear to be emitted by Cloudwatch, double check that the load balancer has at least one target group configured.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Application Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/application/load-balancer-monitoring.html)
* [Available CloudWatch metrics for Classic Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-cloudwatch-metrics.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon ELB metric for your load balancers.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource using the Latency, EnvironmentHealth, ApplicationLatencyP99, ApplicationLatencyP95, or TargetResponseTime metric.
evaluation_periods, period, statistic, and threshold can be set to values that make sense for your load balancers. Additionally ensure that you configure alarm_actions for notifications.

```hcl
resource "aws_cloudwatch_metric_alarm" "elb_latency_alarm" {
  alarm_name          = "elb-latency-alarm"
  comparison_operator = "GreaterThanThreshold"
  evaluation_periods  = 2
  metric_name         = "Latency"
  namespace           = "AWS/ELB"
  period              = 60 # 1 minute
  statistic           = "Average"
  threshold           = 0.1 # Adjust threshold based on your requirement (in seconds)
  alarm_description   = "Alarm when Latency exceeds 0.1 seconds for 2 consecutive periods"

  dimensions = {
    LoadBalancerName = "your-load-balancer-name" # Replace with the name of your load balancer
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:my-sns-topic"] # Replace with your SNS topic ARN
}
```',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'load-balancers-monitored-and-alarmed-config-servererrors',
        'key' => 'load-balancers-monitored-and-alarmed-config-servererrors',
        'title' => 'Load balancer server errors monitored (AWS)',
        'description' => 'This test checks whether AWS Application and Classic Load Balancers have CloudWatch alarms configured to notify you when server-side errors (5XX HTTP response codes) occur.',
        'failure_description' => 'Your load balancers don\'t have error count monitors set up.',
        'remediation_instructions' => 'Set up server error alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

- `HTTPCode_ELB_5XX`
- `HTTPCode_ELB_5XX_Count`
- `HTTPCode_Backend_5XX`
- `HTTPCode_Target_5XX_Count`
- `ApplicationRequests5xx`

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on the appropriate metric for each of your load balancers. If you notice that some metrics do not appear to be emitted by Cloudwatch, double check that the load balancer has at least one target group configured.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Application Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/application/load-balancer-monitoring.html)
* [Available CloudWatch metrics for Classic Load Balancers](https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-cloudwatch-metrics.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon ELB metric for your load balancers.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource using the HTTPCode_ELB_5XX, HTTPCode_ELB_5XX_Count, HTTPCode_Backend_5XX, HTTPCode_Target_5XX_Count, or ApplicationRequests5xx metric.
evaluation_periods, period, statistic, and threshold can be set to values that make sense for your load balancers. Additionally ensure that you configure alarm_actions for notifications.

```hcl
resource "aws_cloudwatch_metric_alarm" "elb_alarm" {
  alarm_name          = "elb-5xx-alarm"
  comparison_operator = "GreaterThanThreshold"
  evaluation_periods  = 2
  metric_name         = "HTTPCode_ELB_5XX" # Can be set to any of the supported metrics listed above
  namespace           = "AWS/ELB"
  period              = 60 # 1 minute
  statistic           = "Sum"
  threshold           = 10 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when the number of 5xx errors on the ELB exceeds 10 for 2 consecutive periods"

  dimensions = {
    LoadBalancerName = "example-lb" # Replace with the name of your load balancer
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:topic"] # Replace with your SNS topic ARN
}
```',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'logs-centrally-stored-config',
        'key' => 'logs-centrally-stored-config',
        'title' => 'S3 server access logs enabled',
        'description' => 'This test verifies that there is at least one AWS S3 bucket configured as a central storage destination for CloudTrail event logging or S3 server access logging.',
        'failure_description' => 'You aren\'t logging accesses to your S3 buckets.',
        'remediation_instructions' => '[Enable server access logging](https://docs.aws.amazon.com/AmazonS3/latest/userguide/enable-server-access-logging.html) or [enable CloudTrail data event logging](https://docs.aws.amazon.com/AmazonS3/latest/user-guide/enable-cloudtrail-events.html) for important S3 buckets

Please ensure that the bucket you select for logging is in an account that is in scope and monitored by Vanta. Otherwise, Vanta will not be able to validate that the logging bucket exists.',
        'category' => 'Logging',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'logs-retained-for-twelve-months-config',
        'key' => 'logs-retained-for-twelve-months-config',
        'title' => 'Server logs retained for 365 days (AWS)',
        'description' => 'This test verifies that AWS CloudWatch Log Groups are configured to retain logs for at least 365 days or are set to unlimited retention.',
        'failure_description' => 'You aren\'t retaining server logs for at least 365 days.',
        'remediation_instructions' => 'Change your log retention settings in CloudWatch to store your server logs for at least 365 days.

1. [Log in to the CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. In the navigation pane, click **Logs**.
3. Find the log group that contains your server logs.
4. In the **Expire Events After** column for that log group, click the current retention setting, such as **Never Expire**.
5. In the **Edit Retention** dialog box, for **Retention**, choose a log retention value.
6. Click **Ok**.

#### Remediation for Terraform
Edit your `aws_cloudwatch_log_group` resources to have the `retention_in_days` attribute set to a value greater than 365.

```hcl
resource "aws_cloudwatch_log_group" "your_log_group_name" {
  name              = "/aws/your-log-group/custom-log-group"
  retention_in_days = 365
}
```

*Note*: Only some retention in days values are supported. Refer to [the AWS documentation](https://docs.aws.amazon.com/AmazonCloudWatchLogs/latest/APIReference/API_PutRetentionPolicy.html#API_PutRetentionPolicy_RequestSyntax) for more information.',
        'category' => 'Logging',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mfa-on-accounts-gsuite',
        'key' => 'mfa-on-accounts-gsuite',
        'title' => 'MFA on Google Workspace',
        'description' => 'This test verifies that all members of a Google Workspace organization have multi-factor authentication (MFA) enabled, except for users who were recently added within the configured SLA.',
        'failure_description' => 'Multifactor authentication isn\'t enabled for your Google accounts.',
        'remediation_instructions' => 'Enforce multifactor authentication on all your organization\'s Google accounts.

1. Log in to the [Google admin console](https://admin.google.com).
2. Click **Security | Authentication | 2-step-verification** to enforce 2-step verification.
3. Select Turn on enforcement from date.
4. Enter a date by which all of your users are required to use multifactor authentication to access their Google accounts. We recommend selecting a date two to four weeks in the future, as employees without multi-factor authentication will be unable to sign in to their accounts once enforcement is in effect. ([More information from Google Workspace](https://support.google.com/a/answer/184711?hl=en))',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'gsuiteadmin',
        ],
    ],
    [
        'vanta_test_id' => 'mfa-on-accounts-infra',
        'key' => 'mfa-on-accounts-infra',
        'title' => 'MFA on infrastructure provider',
        'description' => 'This test checks whether all AWS accounts with a password have multi-factor authentication (MFA) enabled.',
        'failure_description' => 'Multifactor authentication isn\'t enabled for some of your infrastructure accounts.',
        'remediation_instructions' => 'Add multifactor authentication to your AWS account.

1. Log in to the [AWS IAM console](https://console.aws.amazon.com/iam/).
2. In the navigation panel, click **Users**.
3. Click the name of the user accounts where multifactor authentication isn\'t enabled.
4. On the Security Credentials tab, click **Manage** next to **Assigned MFA device**.
5. Choose a virtual multifactor authentication device, and follow the steps to configure it.',
        'category' => 'Account security',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mysql-database-monitored-and-alarmed-config-cpu',
        'key' => 'mysql-database-monitored-and-alarmed-config-cpu',
        'title' => 'SQL database CPU monitored',
        'description' => 'Checks that all Amazon RDS database instances have CloudWatch alarms configured to monitor CPU utilization.',
        'failure_description' => 'Your RDS databases don\'t have CPU usage alerts set up.',
        'remediation_instructions' => 'Set up CPU usage alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on `CPUUtilization` for each of your RDS instances. Ensure to add a dimension to your alarm to target your instance, either via `DBClusterIdentifier` or `DBInstanceIdentifier`.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Amazon RDS](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/MonitoringOverview.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon RDS `CPUUtilization` metric.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your RDS instances using the CPUUtilization metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your database.

```hcl
resource "aws_cloudwatch_metric_alarm" "sql-database-cpu-alarm" {
  alarm_name          = "rds-cpu-utilization-alarm"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods  = 2
  metric_name         = "CPUUtilization"
  namespace           = "AWS/RDS"
  period              = 300
  statistic           = "Average"
  threshold           = 80
  alarm_description   = "Alarm when CPU utilization exceeds 80% for 2 consecutive periods"

  dimensions = {
    DBInstanceIdentifier = "postgresql-database-1" # Replace with your RDS instance identifier
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789123:notify_admins"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mysql-database-monitored-and-alarmed-config-free-memory',
        'key' => 'mysql-database-monitored-and-alarmed-config-free-memory',
        'title' => 'SQL database freeable memory monitored (AWS)',
        'description' => 'Verifies that all Amazon RDS instances have associated AWS CloudWatch alarms configured to monitor the `FreeableMemory` metric.',
        'failure_description' => 'Your SQL databases don\'t have free memory alerts set up.',
        'remediation_instructions' => 'Set up free memory alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on `FreeableMemory` for each of your RDS instances. Ensure to add a dimension to your alarm to target your instance, either via `DBClusterIdentifier` or `DBInstanceIdentifier`.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Amazon RDS](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/MonitoringOverview.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon RDS `FreeableMemory` metric.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your AWS mysql instances using the FreeableMemory metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances.
Additionally ensure that you set alarm_actions to be notified when the threshold is reached.

```hcl
resource "aws_cloudwatch_metric_alarm" "freeable_memory_alarm" {
  alarm_name          = "mysql-freeable-memory-alarm"
  comparison_operator = "LessThanThreshold"
  evaluation_periods  = 2
  metric_name         = "FreeableMemory"
  namespace           = "AWS/RDS"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 1000000000 # 1GB in bytes, adjust based on your requirement
  alarm_description   = "Alarm when Freeable Memory is less than 1GB for 2 consecutive periods"

  dimensions = {
    DBInstanceIdentifier = "mysql-db-instance"
  }

  alarm_actions = ["arn:aws:sns:us-west-2:123456789012:topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mysql-database-monitored-and-alarmed-config-io',
        'key' => 'mysql-database-monitored-and-alarmed-config-io',
        'title' => 'Database IO monitored (AWS)',
        'description' => 'This test verifies that Amazon RDS databases have CloudWatch alarms configured for at least one key Input/Output (IO) performance metrics (such as `DiskQueueDepth`, `WriteIOPS`, `ReadIOPS`, `VolumeWriteIOPs`, `VolumeReadIOPs`).',
        'failure_description' => 'Your RDS databases don\'t have input and output alerts set up.',
        'remediation_instructions' => 'Set up read/write request alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

This can be done by setting alarm(s) for the entire database cluster or by setting alarm(s) on each individual database instance/node.

Define alerts for one or more of the following metrics:

- `DiskQueueDepth`
- `ReadIOPS`
- `WriteIOPS`
- `VolumeReadIOPs` (available for clusters only)
- `VolumeWriteIOPS` (available for clusters only)

**If you use AWS CloudWatch for monitoring and alerting**

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on the appropriate metric for each of your RDS instances. Ensure to add a dimension to your alarm to target your instance, either via DBClusterIdentifier or DBInstanceIdentifier.

**If you use a 3rd party monitoring product**

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon RDS metric for your databases.

See [Available CloudWatch metrics for Amazon RDS](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/MonitoringOverview.html) and [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html) for more information.

#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your AWS mysql instances using the DiskQueueDepth, ReadIOPS, WriteIOPS, VolumeReadIOPs (available for clusters only), or VolumeWriteIOPS (available for clusters only).
evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances. Additionally ensure that you set alarm_actions to be notified when the threshold is reached.

```hcl
resource "aws_cloudwatch_metric_alarm" "read_iops_alarm" {
  alarm_name          = "mysql-read-iops-alarm"
  comparison_operator = "GreaterThanThreshold"
  evaluation_periods  = 2
  metric_name         = "ReadIOPS"
  namespace           = "AWS/RDS"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 100 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when Read IOPS exceeds 100 for 2 consecutive periods"
    dimensions = {
    DBClusterIdentifier = "mysqldb-example"
  }
  alarm_actions = ["arn:aws:sns:us-west-2:123456789012:topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mysql-database-monitored-and-alarmed-config-storage-space',
        'key' => 'mysql-database-monitored-and-alarmed-config-storage-space',
        'title' => 'SQL database free storage space monitored (AWS)',
        'description' => 'This test verifies that all Amazon RDS instances have CloudWatch alarms configured to monitor database storage space usage for at least one of the following metrics:
  - `FreeStorageSpace` on MySQL and PostgreSQL databases
  - `FreeLocalStorage` on Aurora MySQL and Aurora PostgreSQL databases
  - `AuroraVolumeBytesLeftTotal` on Aurora MySQL Databases',
        'failure_description' => 'Your RDS instances don\'t have free storage space alerts set up.',
        'remediation_instructions' => 'Set up free storage space alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances. Define alerts for at least one of the following metrics (depending on your database type):

- `FreeStorageSpace` on MySQL and PostgreSQL databases
- `FreeLocalStorage` on Aurora MySQL and Aurora PostgreSQL databases
- `AuroraVolumeBytesLeftTotal` on Aurora MySQL Databases

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on the appropriate metric for each of your RDS instances. Ensure to add a dimension to your alarm to target your instance, either via `DBClusterIdentifier` or `DBInstanceIdentifier`.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Amazon RDS](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/MonitoringOverview.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon RDS metric for your databases.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your AWS mysql instances using the FreeStorageSpace, FreeLocalStorage, or AuroraVolumeBytesLeftTotal metric.
evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances. Additionally ensure that you set alarm_actions to be notified when the threshold is reached.

```hcl
resource "aws_cloudwatch_metric_alarm" "free_storage_space_alarm" {
  alarm_name          = "mysql-free-storage-space-alarm"
  comparison_operator = "LessThanThreshold"
  evaluation_periods  = 2
  metric_name         = "FreeStorageSpace"
  namespace           = "AWS/RDS"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 1 # Adjust threshold based on your requirement (in GB)
  alarm_description   = "Alarm when Free Storage Space is less than 1GB for 2 consecutive periods"

    dimensions = {
    DBClusterIdentifier = "mysqldb-example"
  }

  alarm_actions = ["arn:aws:sns:us-west-2:123456789012:topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'mysql-database-ports-restricted',
        'key' => 'mysql-database-ports-restricted',
        'title' => 'RDS instance IP restricted (AWS)',
        'description' => 'This test verifies that your AWS RDS (MySQL-compatible) instances are not publicly accessible. Specifically, it ensures that the security groups attached to each RDS instance do not allow unrestricted inbound access from any IP address (e.g., `0.0.0.0/0` or `::/0`).',
        'failure_description' => 'RDS instances are accessible by any IP address via security groups or RDS instances are on EC2-Classic platform.',
        'remediation_instructions' => 'If you are on the **EC2-Classic platform**, this test will fail. [The EC2-Classic Networking will be deprecated by August
15, 2022](https://aws.amazon.com/blogs/aws/ec2-classic-is-retiring-heres-how-to-prepare/)

1. [Log in to the AWS Management Console](https://console.aws.amazon.com/).
2. Navigate to the [VPC dashboard](https://console.aws.amazon.com/vpc/).
3. Click **SECURITY** in the navigation panel.
4. In the **SECURITY** section, **click Security Groups**.
5. Select one of the VPC security groups.
6. Click **Edit inbound rules**.
7. Verify the value for the **Source** column for any inbound rules are not set to `0.0.0.0/0` or `::/0` (Anywhere).
8. Repeat steps 5 through 7 to verify the rest of your VPC security groups.
9. Change the AWS region from the navigation bar, and repeat the audit process for other regions.

#### Remediation for Terraform
Create a `aws_security_group` resource and `aws_db_subnet_group` resource to associate with your `aws_db_instance`. Ensure that your `aws_security_group` resource has no inbound rules set to 0.0.0.0/0 or ::/0 (Anywhere).


```hcl

resource "aws_security_group" "example" {
  name   = "example"
  vpc_id = aws_vpc.example.id

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
  }

}

resource "aws_db_subnet_group" "example" {
  name = "example"

  subnet_ids = [
    aws_subnet.example.id,
    aws_subnet.example-2.id
  ]

}

resource "aws_db_instance" "example" {
  allocated_storage       = 10
  db_name                 = "mydb"
  engine                  = "mysql"
  engine_version          = "5.7"
  instance_class          = "db.t3.micro" # Choose the instance type of the RDS instance.
  username                = "user@example.com"
  password                = "************"
  db_subnet_group_name    = aws_db_subnet_group.example.name
  vpc_security_group_ids  = [aws_security_group.example.id]
}

```hcl

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/db_instance) for more information.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'nosql-database-monitored-and-alarmed-config-read',
        'key' => 'nosql-database-monitored-and-alarmed-config-read',
        'title' => 'NoSQL database read capacity monitored (AWS)',
        'description' => 'This test verifies whether each AWS DynamoDB table has a configured CloudWatch alarm for monitoring the `ConsumedReadCapacityUnits` metric.',
        'failure_description' => 'Your AWS DynamoDB databases do not have read capacity alerts set up.',
        'remediation_instructions' => 'Set up read capacity alerts through Amazon CloudWatch or a 3rd party monitoring provider for your NoSQL instances.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on `ConsumedReadCapacityUnits` for each of your NoSQL databases.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CouldWatch metrics for Amazon DynamoDB](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/monitoring-cloudwatch.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon DynamoDB `ConsumedReadCapacityUnits` metric.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your DynamoDB instances using the ConsumedReadCapacityUnits metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances.

```hcl
resource "aws_cloudwatch_metric_alarm" "nosql-database-read-alarm" {
  alarm_name          = "nosql-database-read-alarm"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods  = 2
  metric_name         = "ConsumedReadCapacityUnits"
  namespace           = "AWS/DynamoDB"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 100 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when database reads exceed 100 for 2 consecutive periods"

  dimensions = {
    TableName = "your-table-name" # Replace with your Dynamo DB table name
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:my-sns-topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'nosql-database-monitored-and-alarmed-config-write',
        'key' => 'nosql-database-monitored-and-alarmed-config-write',
        'title' => 'NoSQL database write capacity monitored (AWS)',
        'description' => 'This test verifies whether each AWS DynamoDB table has a configured CloudWatch alarm for monitoring the `ConsumedWriteCapacityUnits` metric.',
        'failure_description' => 'Your NoSQL databases do not have write capacity alerts set up.',
        'remediation_instructions' => 'Set up write capacity alerts through Amazon CloudWatch or a 3rd party monitoring provider for your NoSQL instances.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on `ConsumedWriteCapacityUnits` for each of your NoSQL databases.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CouldWatch metrics for Amazon DynamoDB](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/monitoring-cloudwatch.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon DynamoDB `ConsumedWriteCapacityUnits` metric.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your DynamoDB instances using the ConsumedWriteCapacityUnits metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances.

```hcl
resource "aws_cloudwatch_metric_alarm" "nosql-database-write-alarm" {
  alarm_name          = "nosql-database-write-alarm"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods  = 2
  metric_name         = "ConsumedWriteCapacityUnits"
  namespace           = "AWS/DynamoDB"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 100 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when database writes exceed 100 for 2 consecutive periods"

  dimensions = {
    TableName = "your-table-name" # Replace with your Dynamo DB table name
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:my-sns-topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'openai-account-linked-in-vanta',
        'key' => 'openai-account-linked-in-vanta',
        'title' => 'OpenAI accounts associated with users',
        'description' => 'This test verifies that all OpenAI accounts in your organization are associated with users in Vanta. Linking accounts to users is essential for access governance, accountability, and audit trails.',
        'failure_description' => 'Vanta detected some OpenAI accounts that are not associated with users within Vanta.',
        'remediation_instructions' => 'Visit the [Access page](/access?credentialKey=openai) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.',
        'category' => 'Account setup',
        'status' => 'OK',
        'integrations' => [
            'openai',
        ],
    ],
    [
        'vanta_test_id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
        'key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
        'title' => 'Critical vulnerabilities identified in packages are addressed (GitHub Repo)',
        'description' => 'This test ensures that all critical severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
        'failure_description' => 'You have open critical severity vulnerabilities.',
        'remediation_instructions' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=CRITICAL) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).',
        'category' => 'Vulnerability management',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
        'key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
        'title' => 'High vulnerabilities identified in packages are addressed (GitHub Repo)',
        'description' => 'This test ensures that all high severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
        'failure_description' => 'You have open high severity vulnerabilities.',
        'remediation_instructions' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=HIGH) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).',
        'category' => 'Vulnerability management',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
        'key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
        'title' => 'Low vulnerabilities identified in packages are addressed (GitHub Repo)',
        'description' => 'This test ensures that all low severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
        'failure_description' => 'You have open low severity vulnerabilities.',
        'remediation_instructions' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=LOW) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).',
        'category' => 'Vulnerability management',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
        'key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
        'title' => 'Medium vulnerabilities identified in packages are addressed (GitHub Repo)',
        'description' => 'This test ensures that all medium severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
        'failure_description' => 'You have open medium severity vulnerabilities.',
        'remediation_instructions' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=MEDIUM) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).',
        'category' => 'Vulnerability management',
        'status' => 'OK',
        'integrations' => [
            'github',
        ],
    ],
    [
        'vanta_test_id' => 'require-admin-encrypted-iaas',
        'key' => 'require-admin-encrypted-iaas',
        'title' => 'SSL/TLS on admin page of infrastructure console',
        'description' => 'This test confirms that all AWS service API endpoints enforce encryption via TLS (Transport Layer Security) by default. This ensures secure communication between your administrators and AWS infrastructure services.',
        'failure_description' => 'N/A',
        'remediation_instructions' => 'N/A',
        'category' => 'Monitoring alerts',
        'status' => 'OK',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'serverless-function-error-rate-monitored-aws',
        'key' => 'serverless-function-error-rate-monitored-aws',
        'title' => 'Serverless function error rate monitored (AWS)',
        'description' => 'This test verifies that all AWS Lambda functions have CloudWatch alarms configured to monitor their Errors metric—either individually per function or globally for all functions.',
        'failure_description' => 'An alarm has not been created for Lambda function error metrics.',
        'remediation_instructions' => 'Set up Error alerts through Amazon CloudWatch or a 3rd party monitoring provider for your Lambda Functions.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on Errors for your Lambda Functions

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Working with Lambda function metrics](https://docs.aws.amazon.com/lambda/latest/dg/monitoring-metrics.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click Deactivate monitoring.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon Lambda Error metric.
#### Remediation for Terraform
Create an `aws_cloudwatch_metric_alarm` resource for your AWS Lambdas using Errors metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances.

```hcl

resource "aws_cloudwatch_metric_alarm" "serverless-function-errors-alarm" {
  alarm_name          = "serverless-function-errors-alarm"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods  = 2
  metric_name         = "Errors"
  namespace           = "AWS/Lambda"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 3 # Adjust threshold based on your requirement
  alarm_description   = "Alarm when serverless function errors exceed 3 for 2 consecutive periods"
  alarm_actions = ["arn:aws:sns:us-west-2:123456789012:topic"] # Replace with your SNS topic ARN
}

```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'servers-monitored-and-alarmed-config-cpu',
        'key' => 'servers-monitored-and-alarmed-config-cpu',
        'title' => 'Server CPU monitored (AWS)',
        'description' => 'This test verifies whether all AWS EC2 instances have a CloudWatch alarm set specifically for the `CPUUtilization` metric to ensure proper monitoring and alerts in case of high CPU usage.',
        'failure_description' => 'Your servers do not have CPU usage alerts set up.',
        'remediation_instructions' => 'Set up CPU usage alerts through Amazon CloudWatch or a 3rd party monitoring provider for your EC2 instances.

### If you use AWS CloudWatch for monitoring and alerting

1. Log in to [AWS CloudWatch console](https://console.aws.amazon.com/cloudwatch/).
2. Create and configure alarms on `CPUUtilization` for each of your EC2 instances.

Additional information:
* [Vanta\'s help article on CloudWatch Alarms](https://help.vanta.com/hc/en-us/articles/12264595240724-How-to-create-AWS-Cloud-Watch-alarms-to-pass-Vanta-Tests)
* [Available CloudWatch metrics for Amazon EC2](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/viewing_metrics_with_cloudwatch.html)
* [Using Amazon CloudWatch Alarms](https://docs.aws.amazon.com/AmazonCloudWatch/latest/monitoring/AlarmThatSendsEmail.html)

### If you use a 3rd party monitoring product

1. Click **Deactivate monitoring**.
2. In the pop-up, write a short description identifying the tool used for monitoring and alerting.
3. Upload a screenshot of the alert configuration in your tool, making sure it monitors the equivalent of the Amazon EC2 `CPUUtilization` metric.
#### Remediation for Terraform
Create an aws_cloudwatch_metric_alarm resource for your EC2 instances using the CPUUtilization metric. evaluation_periods, period, statistic, and threshold can be set to values that make sense for your instances.

```hcl
resource "aws_cloudwatch_metric_alarm" "cpu_alarm" {
  alarm_name          = "cpu-utilization-alarm"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods  = 2
  metric_name         = "CPUUtilization"
  namespace           = "AWS/EC2"
  period              = 300 # 5 minutes
  statistic           = "Average"
  threshold           = 80
  alarm_description   = "Alarm when CPU utilization exceeds 80% for 2 consecutive periods"

  dimensions = {
    InstanceId = "your-instance-id" # Replace with your EC2 instance ID
  }

  alarm_actions = ["arn:aws:sns:us-east-1:123456789012:my-sns-topic"] # Replace with your SNS topic ARN
}
```

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.',
        'category' => 'Monitoring alerts',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'ssl-good-ciphers',
        'key' => 'ssl-good-ciphers',
        'title' => 'Strong SSL/TLS ciphers used',
        'description' => 'This test verifies that your SSL/TLS configurations only permit secure cipher suites (those with a cipher grade of "A") for encrypted web connections.',
        'failure_description' => 'Your SSL/TLS configuration uses an invalid or expired certificate, or is not using an up-to-date cipher suite.',
        'remediation_instructions' => 'Reconfigure your SSL/TLS policies to exclude the vulnerable ciphers. Vulnerable ciphers are any cipher that has a grade of less than `A`. Export the test data to view the cipher grades used in the test. See the [nmap documentation](https://nmap.org/nsedoc/scripts/ssl-enum-ciphers.html) for more information on how the cipher grade is calculated.',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'ssl',
        ],
    ],
    [
        'vanta_test_id' => 'ssl-no-warnings',
        'key' => 'ssl-no-warnings',
        'title' => 'SSL configuration has no known issues',
        'description' => 'This test verifies that your website\'s SSL configuration does not produce any security-related TLS warnings that could compromise secure communication.',
        'failure_description' => 'Your company isn\'t encrypting data in transit correctly.',
        'remediation_instructions' => '[Implement SSL for all your company\'s data in transit](https://github.com/ssllabs/research/wiki/SSL-and-TLS-Deployment-Best-Practices).',
        'category' => 'Infrastructure',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'ssl',
        ],
    ],
    [
        'vanta_test_id' => 'ssl-used-expiry',
        'key' => 'ssl-used-expiry',
        'title' => 'SSL/TLS certificate has not expired',
        'description' => 'This test verifies that the SSL/TLS certificate for your company’s primary website has not expired. An expired certificate can lead to browser warnings, disrupt customer trust, and leave your site vulnerable to man-in-the-middle attacks.',
        'failure_description' => 'The SSL/TLS certificate for the website specified on the Business Info page has expired.',
        'remediation_instructions' => 'Ensure that the SSL/TLS certificate for your company\'s website is up-to-date. Learn more about best practices [here.](https://github.com/ssllabs/research/wiki/SSL-and-TLS-Deployment-Best-Practices)',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'ssl',
        ],
    ],
    [
        'vanta_test_id' => 'ssl-used-unittest',
        'key' => 'ssl-used-unittest',
        'title' => 'SSL/TLS enforced on company website',
        'description' => 'This test checks that your company\'s website automatically redirects from HTTP to HTTPS using a 3XX status code. Enforcing HTTPS ensures encrypted communication, protecting users from data interception or tampering.',
        'failure_description' => 'Your company isn\'t using HTTPS on its website and applications.',
        'remediation_instructions' => 'Enable HTTPS on the company websites specified on the [Business Info page](/business-information), and configure HTTP to redirect to HTTPS. Vanta recommends using [Let\'s Encrypt](https://letsencrypt.org/getting-started/).',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'ssl',
        ],
    ],
    [
        'vanta_test_id' => 'vendor-management-records',
        'key' => 'vendor-management-records',
        'title' => 'Vendors list maintained',
        'description' => 'This test verifies that you have manually added at least one vendor (other than automatically integrated accounts) on the [Vendors page](/vendors) that is visible to auditors. If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.',
        'failure_description' => 'You haven\'t manually added any vendors on the Vendors page.',
        'remediation_instructions' => 'On the [Vendors page](/vendors), ensure you\'ve added all vendors that your company uses. Vanta will auto-populate any vendor we integrate with, but you should manually add any other vendors to ensure they\'re tracked in one place.

If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.',
        'category' => 'Vendors',
        'status' => 'OK',
        'integrations' => [],
    ],
    [
        'vanta_test_id' => 'vendor-risk-levels-assigned',
        'key' => 'vendor-risk-levels-assigned',
        'title' => 'Vendors assigned risk levels',
        'description' => 'This test verifies that every vendor listed on your [Vendors page](/vendors) has been assigned a risk level. Assigning risk levels to vendors is a foundational part of vendor risk management, enabling organizations to prioritize security reviews and due diligence based on the level of risk each vendor poses.',
        'failure_description' => 'Some of your vendors don\'t have a risk level specified on the Vendors page.',
        'remediation_instructions' => 'Go to the [Vendors page](/vendors) and assign a risk level for each vendor.',
        'category' => 'Vendors',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [],
    ],
    [
        'vanta_test_id' => 'vendors-have-authentication-method-specified',
        'key' => 'vendors-have-authentication-method-specified',
        'title' => 'Vendors have authentication method specified',
        'description' => 'This test ensures that all vendors managed by Vanta have a specified authentication method. Authentication methods may be either automatically fetched via integrations or manually specified on the [Vendors page](/vendors).',
        'failure_description' => 'Some of your vendors don\'t have an authentication method specified on the Vendors page.',
        'remediation_instructions' => 'Specify an authentication method for every vendor on the [Vendors page](/vendors/managed). To do this, click each vendor needing attention on the left, click View in Vanta, click the About tab, and then select an _Auth Method_ in the General section on the page. The vendor will be removed from the list once the test reruns.',
        'category' => 'Vendors',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
        ],
    ],
    [
        'vanta_test_id' => 'version-control-tool-records',
        'key' => 'version-control-tool-records',
        'title' => 'Company has a version control system',
        'description' => 'This test checks whether any repository in your connected version control system has been updated within the past 30 days.',
        'failure_description' => 'Your version control system hasn\'t been updated in at least 30 days.',
        'remediation_instructions' => '[Link version control](/integrations) to Vanta. Vanta runs periodic tests to determine if your repositories have been updated within the past 30 days.',
        'category' => 'Software development',
        'status' => 'NEEDS_ATTENTION',
        'integrations' => [
            'aws',
            'azuredevops',
            'bitbucket',
            'github',
            'gitlab',
        ],
    ],
    [
        'vanta_test_id' => 'zone-level-rules-cloudflare',
        'key' => 'zone-level-rules-cloudflare',
        'title' => 'Cloudflare zone-level rules configured',
        'description' => 'This test verifies that at least one zone-level rule is configured across your Cloudflare zones. Zone-level rules include WAF rules, rate limiting rules, and other security/traffic rules applied at the zone level.',
        'failure_description' => 'Your Cloudflare domain does not have traffic and security rules configured',
        'remediation_instructions' => 'Create traffic and security rules in the Security tab within the account or in Security -> WAF within each zone.',
        'category' => 'Infrastructure',
        'status' => 'OK',
        'integrations' => [
            'cloudflare',
        ],
    ],
];
