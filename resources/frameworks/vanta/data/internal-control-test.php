<?php

return [
    [
        'internal_control_vanta_id' => 'access-application-restricted',
        'test_key' => 'infra-unique-accounts-roles',
        'test' => [
            'id' => 'infra-unique-accounts-roles',
            'name' => 'Service accounts used',
            'lastTestRunDate' => '2026-06-18T01:52:56.055Z',
            'latestFlipDate' => '2024-09-24T16:00:11.802Z',
            'description' => 'This test verifies that every AWS account connected to Vanta has at least one IAM role assigned. IAM roles are essential for securely delegating permissions to AWS services and users without sharing long-term credentials.',
            'failureDescription' => 'You aren\'t using IAM roles to manage users\' access to services for every AWS account.',
            'remediationDescription' => 'Many AWS services require that you use roles to allow the service to access resources in other services on your behalf.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_role) for more information.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-application-restricted',
        'test_key' => 'infra-unique-accounts-root',
        'test' => [
            'id' => 'infra-unique-accounts-root',
            'name' => 'Root infrastructure account unused',
            'lastTestRunDate' => '2026-06-17T23:41:40.324Z',
            'latestFlipDate' => '2026-05-27T01:44:34.089Z',
            'description' => 'This test checks whether AWS root accounts have been used within the past 30 days.',
            'failureDescription' => 'Your root infrastructure user has been used to make infrastructure changes recently. Root users should not be used for infrastructure changes and should only be used in emergencies.',
            'remediationDescription' => 'The first user that is created for any new AWS account is known as the root user. As a best practice, the root user should only be used to create an administrative IAM user and should not be used after that except in emergency situations.

In AWS:

1. [Create IAM users and IAM roles](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users.html) to perform infrastructure tasks going forward and avoid making changes as the root user wherever possible.

In Vanta:

1. In the items to remediate for this test, click the "Acknowledge" button next to each instance and provide a reason why the root user was used instead of an IAM user or role.
2. Optionally: Click the "Apply this reason to all other incidents where this occurred" checkbox in the modal to acknowledge all instances at once.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-06-09T23:46:51.437Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-application-restricted',
        'test_key' => 'infra-unique-accounts-unused',
        'test' => [
            'id' => 'infra-unique-accounts-unused',
            'name' => 'Old infrastructure accounts disabled (AWS)',
            'lastTestRunDate' => '2026-06-17T23:41:40.709Z',
            'latestFlipDate' => '2024-09-24T16:02:49.534Z',
            'description' => 'This test checks for AWS IAM users (non-root) that have been inactive for more than 90 days and should be considered for removal.',
            'failureDescription' => 'You have IAM user accounts that haven\'t been active in the last 90 days.',
            'remediationDescription' => '1. Identify the IAM accounts that are no longer in use in your company.
2. [Delete IAM accounts](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_manage.html) that have been inactive for 90 days or more.

#### Remediation for Terraform
Set force_destroy to true for your "aws_iam_user" resource.

```hcl
resource "aws_iam_user" "test-iam-user" {
  name = "test-user"
  force_destroy = true

}
```
See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_user) for more information.

',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-application-restricted',
        'test_key' => 'infra-unique-accounts-user',
        'test' => [
            'id' => 'infra-unique-accounts-user',
            'name' => 'No user account has a policy attached directly',
            'lastTestRunDate' => '2026-06-18T01:52:56.239Z',
            'latestFlipDate' => '2026-03-03T20:42:05.536Z',
            'description' => 'This test verifies that no AWS IAM users have policies attached directly to their user accounts, checking that policies are instead applied through user groups.',
            'failureDescription' => 'Some of your AWS IAM policies are attached directly to users.',
            'remediationDescription' => 'Amazon allows policies to be defined and applied at the group, role, or user level; as much as possible, only assign policies to groups or roles – not to individual users. Doing so will streamline making changes to users and help enforce a least-privileged policy.

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-03-17T20:42:05.501Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-database-restricted-users',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-datastores-ssh',
        'test_key' => 'github-account-mfa-enabled',
        'test' => [
            'id' => 'github-account-mfa-enabled',
            'name' => 'MFA on GitHub',
            'lastTestRunDate' => '2026-06-18T01:52:56.597Z',
            'latestFlipDate' => '2025-10-10T16:49:42.231Z',
            'description' => 'This test verifies that multi-factor authentication (MFA) is enabled on all GitHub accounts that are not marked as external or non-human.',
            'failureDescription' => 'Multi-factor authentication is not enabled for your GitHub accounts',
            'remediationDescription' => 'Enforce multi-factor authentication on all of your organization\'s GitHub accounts.

Follow GitHub\'s [instructions](https://docs.github.com/en/github/authenticating-to-github/securing-your-account-with-two-factor-authentication-2fa/configuring-two-factor-authentication) to turn on MFA on each account.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-datastores-ssh',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-datastores-ssh',
        'test_key' => 'mfa-on-accounts-infra',
        'test' => [
            'id' => 'mfa-on-accounts-infra',
            'name' => 'MFA on infrastructure provider',
            'lastTestRunDate' => '2026-06-18T01:52:56.084Z',
            'latestFlipDate' => '2026-03-03T20:42:05.717Z',
            'description' => 'This test checks whether all AWS accounts with a password have multi-factor authentication (MFA) enabled.',
            'failureDescription' => 'Multifactor authentication isn\'t enabled for some of your infrastructure accounts.',
            'remediationDescription' => 'Add multifactor authentication to your AWS account.

1. Log in to the [AWS IAM console](https://console.aws.amazon.com/iam/).
2. In the navigation panel, click **Users**.
3. Click the name of the user accounts where multifactor authentication isn\'t enabled.
4. On the Security Credentials tab, click **Manage** next to **Assigned MFA device**.
5. Choose a virtual multifactor authentication device, and follow the steps to configure it.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-03-10T20:42:05.681Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-firewalls',
        'test_key' => 'cloudflare-notifications-enabled',
        'test' => [
            'id' => 'cloudflare-notifications-enabled',
            'name' => 'Cloudflare notifications enabled',
            'lastTestRunDate' => '2026-06-18T01:52:56.651Z',
            'latestFlipDate' => '2026-05-21T03:43:51.740Z',
            'description' => 'This test verifies that four critical Cloudflare notification policies are enabled in your account: HTTP DDoS Attack Alert (or Advanced HTTP DDoS Attack Alert for Enterprise customers), Health Checks status notification, Passive Origin Monitoring, and Route Leak Detection Alert. These notifications ensure your team is promptly alerted to security threats like DDoS attacks, origin server issues, and BGP route leaks.',
            'failureDescription' => 'Your Cloudflare account does not have all the required notifications enabled',
            'remediationDescription' => 'Enable the notifications \'HTTP DDoS Attack Alert\', \'Health Checks status notification\'
\'Passive Origin Monitoring\' and \'Route Leak Detection Alert\' using
[these instructions](https://developers.cloudflare.com/fundamentals/notifications/create-notifications/)
',
            'version' => [
                'major' => 1,
                'minor' => 3,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-firewalls',
        'test_key' => 'firewall-config-acl',
        'test' => [
            'id' => 'firewall-config-acl',
            'name' => 'Unwanted traffic filtered',
            'lastTestRunDate' => '2026-06-18T01:52:57.197Z',
            'latestFlipDate' => '2024-09-24T16:01:47.462Z',
            'description' => 'This test verifies that all AWS EC2 instances have either a Network ACL associated with their subnet or a security group directly attached. Without these network filtering mechanisms, instances lack basic firewall protection, leaving them exposed to unwanted inbound and outbound traffic.',
            'failureDescription' => 'Your corporate network doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Set up a corporate VPN to control access to your corporate network. Vanta recommends [OpenVPN](https://openvpn.net/access-server/?utm_source=vanta&utm_medium=referral).
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-firewalls',
        'test_key' => 'firewall-config-cloudflare',
        'test' => [
            'id' => 'firewall-config-cloudflare',
            'name' => 'Unwanted traffic filtered (Cloudflare)',
            'lastTestRunDate' => '2026-06-18T01:52:56.429Z',
            'latestFlipDate' => '2025-10-10T15:56:12.950Z',
            'description' => 'This test verifies that your Cloudflare account has active firewall protections in place—either through enabled custom firewall rules or managed rulesets. These firewalls help block unwanted or malicious traffic from reaching your infrastructure.',
            'failureDescription' => 'Your Cloudflare domain doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Create WAF rules for each of your domains in the "Security tab".
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-firewalls',
        'test_key' => 'firewall-config-default-deny',
        'test' => [
            'id' => 'firewall-config-default-deny',
            'name' => 'Firewall default disallows traffic',
            'lastTestRunDate' => '2026-06-18T01:52:56.059Z',
            'latestFlipDate' => '2024-09-24T17:11:26.516Z',
            'description' => 'This test verifies that AWS firewall configurations (Security Groups and Network ACLs) default to denying inbound traffic, a behavior inherent to AWS infrastructure. It ensures that unless traffic is explicitly permitted, it will be blocked by default.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-firewalls',
        'test_key' => 'zone-level-rules-cloudflare',
        'test' => [
            'id' => 'zone-level-rules-cloudflare',
            'name' => 'Cloudflare zone-level rules configured',
            'lastTestRunDate' => '2026-06-18T01:52:56.686Z',
            'latestFlipDate' => '2025-10-10T15:56:13.399Z',
            'description' => 'This test verifies that at least one zone-level rule is configured across your Cloudflare zones. Zone-level rules include WAF rules, rate limiting rules, and other security/traffic rules applied at the zone level.',
            'failureDescription' => 'Your Cloudflare domain does not have traffic and security rules configured',
            'remediationDescription' => 'Create traffic and security rules in the Security tab within the account or in Security -> WAF within each zone.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-operating-system-restricted',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-production-network-restricted',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'cloudflare-account-linked-in-vanta',
        'test' => [
            'id' => 'cloudflare-account-linked-in-vanta',
            'name' => 'Cloudflare accounts associated with users',
            'lastTestRunDate' => '2026-06-18T01:52:56.088Z',
            'latestFlipDate' => '2026-01-21T19:38:39.296Z',
            'description' => 'This test verifies that all Cloudflare user accounts are associated with users in Vanta\'s system. Linking accounts to users enables proper access tracking, accountability, and ensures that only authorized personnel have access to your Cloudflare infrastructure.',
            'failureDescription' => 'Vanta detected some Cloudflare accounts that are not associated with users within Vanta.',
            'remediationDescription' => 'Visit the [Access page](/access?credentialKey=cloudflare) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'IT',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-01-28T19:38:39.270Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'docusign-account-linked-in-vanta',
        'test' => [
            'id' => 'docusign-account-linked-in-vanta',
            'name' => 'Docusign accounts associated with users',
            'lastTestRunDate' => '2026-06-18T01:52:56.087Z',
            'latestFlipDate' => '2025-05-22T03:32:33.470Z',
            'description' => 'This test verifies that all DocuSign accounts in your organization are associated with users in Vanta. Linking accounts to users is essential for maintaining accurate access visibility, enabling proper access reviews, and ensuring accountability for document signing activities.',
            'failureDescription' => 'Vanta detected some Docusign accounts that are not associated with users within Vanta.',
            'remediationDescription' => 'Visit the [Access page](/access?credentialKey=docusign) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'docusign',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'github-account-linked-in-vanta',
        'test' => [
            'id' => 'github-account-linked-in-vanta',
            'name' => 'GitHub accounts associated with users',
            'lastTestRunDate' => '2026-06-18T01:52:56.965Z',
            'latestFlipDate' => '2025-10-10T16:49:41.845Z',
            'description' => 'This test verifies that all GitHub accounts have been linked to users within Vanta.',
            'failureDescription' => 'Vanta detected some GitHub accounts that are not associated with users within Vanta.',
            'remediationDescription' => 'Visit the [Access page](/access?credentialKey=github) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting `Add a person` or mark it as external by selecting `Assign to external person`.

If the account is not a human account, select `Mark as service account`.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'infra-linked-to-vanta',
        'test' => [
            'id' => 'infra-linked-to-vanta',
            'name' => 'Cloud infrastructure linked to Vanta',
            'lastTestRunDate' => '2026-06-18T01:52:56.947Z',
            'latestFlipDate' => '2024-09-25T17:11:50.775Z',
            'description' => 'This test verifies that at least one of the supported cloud infrastructure providers (AWS, GCP, Heroku, Azure, or DigitalOcean) is properly linked to Vanta.',
            'failureDescription' => 'You don\'t have a cloud infrastructure service provider linked to Vanta.',
            'remediationDescription' => 'Link your cloud infrastructure provider to Vanta on the [Integrations page](/integrations).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
                'azure',
                'azure_for_government',
                'gcp',
                'oracle_cloud',
                'ovh_cloud',
                'akamai',
                'cloudflare',
                'cloudflare_for_government',
                'digitalocean',
                'digitaloceanspaces',
                'heroku',
                'netlify',
                'scaleway',
                'supabase',
                'vercel',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-reviews',
        'test_key' => 'openai-account-linked-in-vanta',
        'test' => [
            'id' => 'openai-account-linked-in-vanta',
            'name' => 'OpenAI accounts associated with users',
            'lastTestRunDate' => '2026-06-18T01:52:56.674Z',
            'latestFlipDate' => '2024-09-24T22:24:10.239Z',
            'description' => 'This test verifies that all OpenAI accounts in your organization are associated with users in Vanta. Linking accounts to users is essential for access governance, accountability, and audit trails.',
            'failureDescription' => 'Vanta detected some OpenAI accounts that are not associated with users within Vanta.',
            'remediationDescription' => 'Visit the [Access page](/access?credentialKey=openai) to review and update the owners for each of your accounts.

If the account does not correspond to a user in Vanta, create the user manually by selecting \'Add a person,\' or mark it as external by selecting \'Assign to external person.\'

If the account is not a human account, select \'Mark as service account\'.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'openai',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-revoked-termination',
        'test_key' => 'aws-account-access-removed-on-termination',
        'test' => [
            'id' => 'aws-account-access-removed-on-termination',
            'name' => 'AWS accounts deprovisioned when personnel leave',
            'lastTestRunDate' => '2026-06-18T01:52:56.460Z',
            'latestFlipDate' => '2024-09-24T16:01:05.604Z',
            'description' => 'This test verifies AWS accounts are promptly deprovisioned once the associated user has been removed or terminated from your organization.',
            'failureDescription' => 'Some AWS accounts associated with terminated personnel have not been deactivated.',
            'remediationDescription' => 'Remove all accounts listed from AWS.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-revoked-termination',
        'test_key' => 'github-account-access-removed-on-termination',
        'test' => [
            'id' => 'github-account-access-removed-on-termination',
            'name' => 'GitHub accounts deprovisioned when personnel leave',
            'lastTestRunDate' => '2026-06-18T01:52:56.983Z',
            'latestFlipDate' => '2025-10-10T16:49:42.037Z',
            'description' => 'This test verifies that GitHub accounts associated with terminated or inactive users have been promptly deprovisioned.',
            'failureDescription' => 'Some GitHub accounts associated with terminated personnel have not been deactivated.',
            'remediationDescription' => 'For each GitHub account listed, remove or deactivate the account.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-ssh-required',
        'test_key' => 'internal-password-policy-config',
        'test' => [
            'id' => 'internal-password-policy-config',
            'name' => 'Password policy configured for infrastructure',
            'lastTestRunDate' => '2026-06-18T01:52:56.048Z',
            'latestFlipDate' => '2024-09-24T17:11:27.835Z',
            'description' => 'This test verifies that all AWS accounts in your organization have an active and properly configured password policy defined.',
            'failureDescription' => 'You aren\'t enforcing a password policy on your infrastructure accounts yet.',
            'remediationDescription' => 'Set up a password policy in AWS that enforces password standards for your users.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T17:11:27.682Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'access-ssh-required',
        'test_key' => 'require-admin-encrypted-iaas',
        'test' => [
            'id' => 'require-admin-encrypted-iaas',
            'name' => 'SSL/TLS on admin page of infrastructure console',
            'lastTestRunDate' => '2026-06-18T01:52:56.074Z',
            'latestFlipDate' => '2024-09-24T17:11:28.290Z',
            'description' => 'This test confirms that all AWS service API endpoints enforce encryption via TLS (Transport Layer Security) by default. This ensures secure communication between your administrators and AWS infrastructure services.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'change-management-procedures',
        'test_key' => 'code-review-application-config',
        'test' => [
            'id' => 'code-review-application-config',
            'name' => 'Application changes reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:57.225Z',
            'latestFlipDate' => '2025-10-10T16:49:57.356Z',
            'description' => 'This test verifies the branch protection settings to ensure that at least one approval is required to merge code changes into the default or specified production branch of all linked version control repositories.',
            'failureDescription' => 'Your version control system is not set up to require code reviews.',
            'remediationDescription' => 'Set up protected branches in your version control tool account to make sure that changes are reviewed and approved.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'aws',
                'azuredevops',
                'bitbucket',
                'github',
                'gitlab',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2025-10-13T16:49:57.322Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'change-management-procedures',
        'test_key' => 'github-author-is-different-from-reviewer',
        'test' => [
            'id' => 'github-author-is-different-from-reviewer',
            'name' => 'Author is not the reviewer of pull requests',
            'lastTestRunDate' => '2026-06-18T01:52:56.633Z',
            'latestFlipDate' => '2025-10-10T19:44:12.676Z',
            'description' => 'This test ensures that pull requests in GitHub are not self-approved by their authors. GitHub enforces this automatically—authors cannot approve their own pull requests.',
            'failureDescription' => 'NA',
            'remediationDescription' => 'NA
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'change-management-procedures',
        'test_key' => 'github-ensure-branch-protection-enforced',
        'test' => [
            'id' => 'github-ensure-branch-protection-enforced',
            'name' => 'Ensure branch protection rules are enforced for administrators (GitHub)',
            'lastTestRunDate' => '2026-06-18T01:52:56.849Z',
            'latestFlipDate' => '2025-10-10T16:49:48.891Z',
            'description' => 'This test verifies that all GitHub repositories linked to Vanta have branch protection rules enforced for administrators on the default branch or the explicitly specified production branch.',
            'failureDescription' => 'Some repositories do not have branch protection rules enforced for administrators',
            'remediationDescription' => '**Note** If your organization uses GitHub Rulesets, we recommend deactivating this test. While Rulesets also allow you to set branch protection rules, they do not allow Vanta to pull information about protection bypasses without escalated write permissions. If you do not use Rulesets, the following steps apply.

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2025-10-13T16:49:48.843Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'change-management-procedures',
        'test_key' => 'github-repos-are-private',
        'test' => [
            'id' => 'github-repos-are-private',
            'name' => 'GitHub repository visibility has been set to private',
            'lastTestRunDate' => '2026-06-18T01:52:56.479Z',
            'latestFlipDate' => '2025-10-10T16:49:49.273Z',
            'description' => 'This test verifies that all GitHub repositories in your organization, excluding those explicitly forked from external repositories, have their visibility set to private.',
            'failureDescription' => 'Some repositories are not set to private.',
            'remediationDescription' => 'It is a best practice to set repository visibility to private for all of your repositories. If you have repositories that are intentionally set to public, often to host open source code or examples, deactivate the test indefinitely for that repository and provide an explanation of why the repository must be public.

If a repository is inappropriately set to public, please follow GitHub\'s [instructions](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/managing-repository-settings/setting-repository-visibility#changing-a-repositorys-visibility) to make a repository private.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'change-management-procedures',
        'test_key' => 'version-control-tool-records',
        'test' => [
            'id' => 'version-control-tool-records',
            'name' => 'Company has a version control system',
            'lastTestRunDate' => '2026-06-18T01:52:59.232Z',
            'latestFlipDate' => '2025-11-09T19:23:02.961Z',
            'description' => 'This test checks whether any repository in your connected version control system has been updated within the past 30 days.',
            'failureDescription' => 'Your version control system hasn\'t been updated in at least 30 days.
',
            'remediationDescription' => '[Link version control](/integrations) to Vanta. Vanta runs periodic tests to determine if your repositories have been updated within the past 30 days.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'aws',
                'azuredevops',
                'bitbucket',
                'github',
                'gitlab',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'changes-approval-required',
        'test_key' => 'code-review-application-config',
        'test' => [
            'id' => 'code-review-application-config',
            'name' => 'Application changes reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:57.225Z',
            'latestFlipDate' => '2025-10-10T16:49:57.356Z',
            'description' => 'This test verifies the branch protection settings to ensure that at least one approval is required to merge code changes into the default or specified production branch of all linked version control repositories.',
            'failureDescription' => 'Your version control system is not set up to require code reviews.',
            'remediationDescription' => 'Set up protected branches in your version control tool account to make sure that changes are reviewed and approved.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'aws',
                'azuredevops',
                'bitbucket',
                'github',
                'gitlab',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2025-10-13T16:49:57.322Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'changes-approval-required',
        'test_key' => 'github-author-is-different-from-reviewer',
        'test' => [
            'id' => 'github-author-is-different-from-reviewer',
            'name' => 'Author is not the reviewer of pull requests',
            'lastTestRunDate' => '2026-06-18T01:52:56.633Z',
            'latestFlipDate' => '2025-10-10T19:44:12.676Z',
            'description' => 'This test ensures that pull requests in GitHub are not self-approved by their authors. GitHub enforces this automatically—authors cannot approve their own pull requests.',
            'failureDescription' => 'NA',
            'remediationDescription' => 'NA
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'changes-approval-required',
        'test_key' => 'github-ensure-branch-protection-enforced',
        'test' => [
            'id' => 'github-ensure-branch-protection-enforced',
            'name' => 'Ensure branch protection rules are enforced for administrators (GitHub)',
            'lastTestRunDate' => '2026-06-18T01:52:56.849Z',
            'latestFlipDate' => '2025-10-10T16:49:48.891Z',
            'description' => 'This test verifies that all GitHub repositories linked to Vanta have branch protection rules enforced for administrators on the default branch or the explicitly specified production branch.',
            'failureDescription' => 'Some repositories do not have branch protection rules enforced for administrators',
            'remediationDescription' => '**Note** If your organization uses GitHub Rulesets, we recommend deactivating this test. While Rulesets also allow you to set branch protection rules, they do not allow Vanta to pull information about protection bypasses without escalated write permissions. If you do not use Rulesets, the following steps apply.

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2025-10-13T16:49:48.843Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'changes-approval-required',
        'test_key' => 'github-repos-are-private',
        'test' => [
            'id' => 'github-repos-are-private',
            'name' => 'GitHub repository visibility has been set to private',
            'lastTestRunDate' => '2026-06-18T01:52:56.479Z',
            'latestFlipDate' => '2025-10-10T16:49:49.273Z',
            'description' => 'This test verifies that all GitHub repositories in your organization, excluding those explicitly forked from external repositories, have their visibility set to private.',
            'failureDescription' => 'Some repositories are not set to private.',
            'remediationDescription' => 'It is a best practice to set repository visibility to private for all of your repositories. If you have repositories that are intentionally set to public, often to host open source code or examples, deactivate the test indefinitely for that repository and provide an explanation of why the repository must be public.

If a repository is inappropriately set to public, please follow GitHub\'s [instructions](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/managing-repository-settings/setting-repository-visibility#changing-a-repositorys-visibility) to make a repository private.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Software development',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'changes-approval-required',
        'test_key' => 'version-control-tool-records',
        'test' => [
            'id' => 'version-control-tool-records',
            'name' => 'Company has a version control system',
            'lastTestRunDate' => '2026-06-18T01:52:59.232Z',
            'latestFlipDate' => '2025-11-09T19:23:02.961Z',
            'description' => 'This test checks whether any repository in your connected version control system has been updated within the past 30 days.',
            'failureDescription' => 'Your version control system hasn\'t been updated in at least 30 days.
',
            'remediationDescription' => '[Link version control](/integrations) to Vanta. Vanta runs periodic tests to determine if your repositories have been updated within the past 30 days.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Software development',
            'integrations' => [
                'aws',
                'azuredevops',
                'bitbucket',
                'github',
                'gitlab',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'configuration-management-system-established',
        'test_key' => 'aws-iam-expired-certificates-removed',
        'test' => [
            'id' => 'aws-iam-expired-certificates-removed',
            'name' => 'Expired SSL/TLS certificates are removed (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.049Z',
            'latestFlipDate' => '2025-12-19T07:12:26.323Z',
            'description' => 'This test verifies that all expired SSL/TLS certificates stored in AWS IAM have been removed. Expired certificates left in IAM can cause confusion, potential misconfigurations, and may indicate poor certificate lifecycle management.',
            'failureDescription' => 'Some SSL/TLS certificates stored in AWS IAM have expired.',
            'remediationDescription' => 'To remove expired SSL/TLS certificates stored in AWS IAM, use the AWS CLI, as the AWS Management Console does not currently support this action.

"**From Console:**

Removing expired certificates via AWS Management Console is not currently supported. To delete SSL/TLS certificates stored in IAM via the AWS API use the Command Line Interface (CLI).

**From Command Line:**

To delete Expired Certificate run following command by replacing <CERTIFICATE_NAME> with the name of the certificate to delete:

```
aws iam delete-server-certificate --server-certificate-name <CERTIFICATE_NAME>
```

When the preceding command is successful, it does not return any output."',
            'version' => [
                'major' => 0,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted',
        'test_key' => 'aws-dynamodb-encryption',
        'test' => [
            'id' => 'aws-dynamodb-encryption',
            'name' => 'DynamoDB Tables encrypted (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.504Z',
            'latestFlipDate' => '2024-09-24T16:02:55.249Z',
            'description' => 'This test verifies that DynamoDB tables have encryption enabled. AWS DynamoDB guarantees encryption by default for all tables—both encryption at rest and encryption in transit are automatically provided by AWS without requiring customer configuration.',
            'failureDescription' => 'Some DynamoDB Tables are not encrypted.',
            'remediationDescription' => 'AWS provides encryption at rest and in transit by default. See https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/EncryptionAtRest.html and https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/network-isolation.html

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

```
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Data storage',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted',
        'test_key' => 'cloudflare-worker-kv-encryption',
        'test' => [
            'id' => 'cloudflare-worker-kv-encryption',
            'name' => 'Verifies that Cloudflare provides encryption at rest of all data stored within Cloudflare Workers KV by default.',
            'lastTestRunDate' => '2026-06-18T01:52:56.468Z',
            'latestFlipDate' => '2025-10-10T19:44:07.785Z',
            'description' => 'This test verifies that all data stored in Cloudflare Workers KV namespaces is encrypted at rest. Cloudflare automatically encrypts all Workers KV data at rest by default as part of their platform security architecture, so this test always passes without requiring any customer configuration.',
            'failureDescription' => 'Some Cloudflare Workers KV does not have encryption enabled.',
            'remediationDescription' => 'For each Cloudflare Worker KV listed enable encryption.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'load-balancer-http-to-https',
        'test' => [
            'id' => 'load-balancer-http-to-https',
            'name' => 'Load balancers redirect HTTP to HTTPS (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.982Z',
            'latestFlipDate' => '2024-09-24T15:59:58.349Z',
            'description' => 'This test verifies that all internet-facing AWS Application Load Balancers (ALBs) listening on HTTP are configured to redirect that HTTP traffic to HTTPS.',
            'failureDescription' => 'You have an Application Load Balancer that:
- Has an "internet-facing" **scheme**.
- Has a **listener** with an "HTTP" **protocol**.
- Does not have a **listener** with a **default action** that has a "redirect" **action type** and an "HTTPS" **redirect protocol**.
',
            'remediationDescription' => 'Configure the load balancers to redirect HTTP traffic to HTTPS.

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

See more in the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/data-sources/lb_listener).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'require-admin-encrypted-iaas',
        'test' => [
            'id' => 'require-admin-encrypted-iaas',
            'name' => 'SSL/TLS on admin page of infrastructure console',
            'lastTestRunDate' => '2026-06-18T01:52:56.074Z',
            'latestFlipDate' => '2024-09-24T17:11:28.290Z',
            'description' => 'This test confirms that all AWS service API endpoints enforce encryption via TLS (Transport Layer Security) by default. This ensures secure communication between your administrators and AWS infrastructure services.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'ssl-good-ciphers',
        'test' => [
            'id' => 'ssl-good-ciphers',
            'name' => 'Strong SSL/TLS ciphers used',
            'lastTestRunDate' => '2026-06-18T01:52:56.265Z',
            'latestFlipDate' => '2025-12-24T13:16:25.411Z',
            'description' => 'This test verifies that your SSL/TLS configurations only permit secure cipher suites (those with a cipher grade of "A") for encrypted web connections.',
            'failureDescription' => 'Your SSL/TLS configuration uses an invalid or expired certificate, or is not using an up-to-date cipher suite.',
            'remediationDescription' => 'Reconfigure your SSL/TLS policies to exclude the vulnerable ciphers. Vulnerable ciphers are any cipher that has a grade of less than `A`. Export the test data to view the cipher grades used in the test. See the [nmap documentation](https://nmap.org/nsedoc/scripts/ssl-enum-ciphers.html) for more information on how the cipher grade is calculated.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'ssl',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-01-07T13:16:25.389Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'ssl-no-warnings',
        'test' => [
            'id' => 'ssl-no-warnings',
            'name' => 'SSL configuration has no known issues',
            'lastTestRunDate' => '2026-06-18T01:52:56.970Z',
            'latestFlipDate' => '2025-12-24T13:16:25.634Z',
            'description' => 'This test verifies that your website\'s SSL configuration does not produce any security-related TLS warnings that could compromise secure communication.',
            'failureDescription' => 'Your company isn\'t encrypting data in transit correctly.',
            'remediationDescription' => '[Implement SSL for all your company\'s data in transit](https://github.com/ssllabs/research/wiki/SSL-and-TLS-Deployment-Best-Practices).
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'ssl',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-01-07T13:16:25.602Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'ssl-used-expiry',
        'test' => [
            'id' => 'ssl-used-expiry',
            'name' => 'SSL/TLS certificate has not expired',
            'lastTestRunDate' => '2026-06-18T01:52:56.896Z',
            'latestFlipDate' => '2025-06-19T18:17:53.726Z',
            'description' => 'This test verifies that the SSL/TLS certificate for your company’s primary website has not expired. An expired certificate can lead to browser warnings, disrupt customer trust, and leave your site vulnerable to man-in-the-middle attacks.',
            'failureDescription' => 'The SSL/TLS certificate for the website specified on the Business Info page has expired.',
            'remediationDescription' => 'Ensure that the SSL/TLS certificate for your company\'s website is up-to-date. Learn more about best practices [here.](https://github.com/ssllabs/research/wiki/SSL-and-TLS-Deployment-Best-Practices)
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'ssl',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'data-encrypted-in-transit',
        'test_key' => 'ssl-used-unittest',
        'test' => [
            'id' => 'ssl-used-unittest',
            'name' => 'SSL/TLS enforced on company website',
            'lastTestRunDate' => '2026-06-18T01:52:56.083Z',
            'latestFlipDate' => '2026-06-01T16:23:55.606Z',
            'description' => 'This test checks that your company\'s website automatically redirects from HTTP to HTTPS using a 3XX status code. Enforcing HTTPS ensures encrypted communication, protecting users from data interception or tampering.',
            'failureDescription' => 'Your company isn\'t using HTTPS on its website and applications.',
            'remediationDescription' => 'Enable HTTPS on the company websites specified on the [Business Info page](/business-information), and configure HTTP to redirect to HTTPS. Vanta recommends using [Let\'s Encrypt](https://letsencrypt.org/getting-started/).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'ssl',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'intrusion-detection-system',
        'test_key' => 'aws-guardduty-enabled',
        'test' => [
            'id' => 'aws-guardduty-enabled',
            'name' => 'Intrusion detection system enabled (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:57.428Z',
            'latestFlipDate' => '2024-09-24T15:58:02.448Z',
            'description' => 'This test verifies whether AWS GuardDuty is correctly enabled in every AWS account and region connected to your environment.',
            'failureDescription' => 'Some accounts and regions don\'t have AWS GuardDuty enabled.',
            'remediationDescription' => 'Enable AWS GuardDuty. For each region:

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T15:58:02.413Z',
                'itemCount' => 4,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'intrusion-detection-system',
        'test_key' => 'aws-guardduty-notifications-enabled',
        'test' => [
            'id' => 'aws-guardduty-notifications-enabled',
            'name' => 'Intrusion detection system notifications configured (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.608Z',
            'latestFlipDate' => '2024-09-24T15:58:02.589Z',
            'description' => 'This test verifies that notifications for AWS GuardDuty threat detections are configured correctly, ensuring each AWS account and region is receiving GuardDuty notifications.',
            'failureDescription' => 'Some accounts and regions don\'t have AWS GuardDuty threat detection notifications configured.',
            'remediationDescription' => 'Configure notifications for AWS GuardDuty threat detections.

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

```
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T15:58:02.561Z',
                'itemCount' => 4,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'log-management-utilized',
        'test_key' => 'flow-logs-on-config',
        'test' => [
            'id' => 'flow-logs-on-config',
            'name' => 'VPC Flow Logs enabled',
            'lastTestRunDate' => '2026-06-18T01:52:56.853Z',
            'latestFlipDate' => '2024-09-24T16:00:52.690Z',
            'description' => 'This test checks whether your AWS Virtual Private Clouds (VPCs) have VPC Flow Logs enabled for network traffic monitoring.',
            'failureDescription' => 'You aren\'t using VPC flow logs to capture information about your network\'s IP traffic.',
            'remediationDescription' => 'Enable VPC flow logs for your virtual private cloud or subnet.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/flow_log) for more information.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Logging',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:00:52.623Z',
                'itemCount' => 10,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'log-management-utilized',
        'test_key' => 'infra-linked-to-vanta',
        'test' => [
            'id' => 'infra-linked-to-vanta',
            'name' => 'Cloud infrastructure linked to Vanta',
            'lastTestRunDate' => '2026-06-18T01:52:56.947Z',
            'latestFlipDate' => '2024-09-25T17:11:50.775Z',
            'description' => 'This test verifies that at least one of the supported cloud infrastructure providers (AWS, GCP, Heroku, Azure, or DigitalOcean) is properly linked to Vanta.',
            'failureDescription' => 'You don\'t have a cloud infrastructure service provider linked to Vanta.',
            'remediationDescription' => 'Link your cloud infrastructure provider to Vanta on the [Integrations page](/integrations).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
                'azure',
                'azure_for_government',
                'gcp',
                'oracle_cloud',
                'ovh_cloud',
                'akamai',
                'cloudflare',
                'cloudflare_for_government',
                'digitalocean',
                'digitaloceanspaces',
                'heroku',
                'netlify',
                'scaleway',
                'supabase',
                'vercel',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'log-management-utilized',
        'test_key' => 'logs-centrally-stored-config',
        'test' => [
            'id' => 'logs-centrally-stored-config',
            'name' => 'S3 server access logs enabled',
            'lastTestRunDate' => '2026-06-18T01:52:59.115Z',
            'latestFlipDate' => '2024-09-24T16:02:44.643Z',
            'description' => 'This test verifies that there is at least one AWS S3 bucket configured as a central storage destination for CloudTrail event logging or S3 server access logging.',
            'failureDescription' => 'You aren\'t logging accesses to your S3 buckets.',
            'remediationDescription' => '[Enable server access logging](https://docs.aws.amazon.com/AmazonS3/latest/userguide/enable-server-access-logging.html) or [enable CloudTrail data event logging](https://docs.aws.amazon.com/AmazonS3/latest/user-guide/enable-cloudtrail-events.html) for important S3 buckets

Please ensure that the bucket you select for logging is in an account that is in scope and monitored by Vanta. Otherwise, Vanta will not be able to validate that the logging bucket exists.',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Logging',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:02:44.582Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'log-management-utilized',
        'test_key' => 'logs-retained-for-twelve-months-config',
        'test' => [
            'id' => 'logs-retained-for-twelve-months-config',
            'name' => 'Server logs retained for 365 days (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.950Z',
            'latestFlipDate' => '2024-09-24T15:59:23.111Z',
            'description' => 'This test verifies that AWS CloudWatch Log Groups are configured to retain logs for at least 365 days or are set to unlimited retention.',
            'failureDescription' => 'You aren\'t retaining server logs for at least 365 days.',
            'remediationDescription' => 'Change your log retention settings in CloudWatch to store your server logs for at least 365 days.

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Logging',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T15:59:23.071Z',
                'itemCount' => 4,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-reviewed',
        'test_key' => 'cloudflare-notifications-enabled',
        'test' => [
            'id' => 'cloudflare-notifications-enabled',
            'name' => 'Cloudflare notifications enabled',
            'lastTestRunDate' => '2026-06-18T01:52:56.651Z',
            'latestFlipDate' => '2026-05-21T03:43:51.740Z',
            'description' => 'This test verifies that four critical Cloudflare notification policies are enabled in your account: HTTP DDoS Attack Alert (or Advanced HTTP DDoS Attack Alert for Enterprise customers), Health Checks status notification, Passive Origin Monitoring, and Route Leak Detection Alert. These notifications ensure your team is promptly alerted to security threats like DDoS attacks, origin server issues, and BGP route leaks.',
            'failureDescription' => 'Your Cloudflare account does not have all the required notifications enabled',
            'remediationDescription' => 'Enable the notifications \'HTTP DDoS Attack Alert\', \'Health Checks status notification\'
\'Passive Origin Monitoring\' and \'Route Leak Detection Alert\' using
[these instructions](https://developers.cloudflare.com/fundamentals/notifications/create-notifications/)
',
            'version' => [
                'major' => 1,
                'minor' => 3,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-reviewed',
        'test_key' => 'firewall-config-acl',
        'test' => [
            'id' => 'firewall-config-acl',
            'name' => 'Unwanted traffic filtered',
            'lastTestRunDate' => '2026-06-18T01:52:57.197Z',
            'latestFlipDate' => '2024-09-24T16:01:47.462Z',
            'description' => 'This test verifies that all AWS EC2 instances have either a Network ACL associated with their subnet or a security group directly attached. Without these network filtering mechanisms, instances lack basic firewall protection, leaving them exposed to unwanted inbound and outbound traffic.',
            'failureDescription' => 'Your corporate network doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Set up a corporate VPN to control access to your corporate network. Vanta recommends [OpenVPN](https://openvpn.net/access-server/?utm_source=vanta&utm_medium=referral).
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-reviewed',
        'test_key' => 'firewall-config-cloudflare',
        'test' => [
            'id' => 'firewall-config-cloudflare',
            'name' => 'Unwanted traffic filtered (Cloudflare)',
            'lastTestRunDate' => '2026-06-18T01:52:56.429Z',
            'latestFlipDate' => '2025-10-10T15:56:12.950Z',
            'description' => 'This test verifies that your Cloudflare account has active firewall protections in place—either through enabled custom firewall rules or managed rulesets. These firewalls help block unwanted or malicious traffic from reaching your infrastructure.',
            'failureDescription' => 'Your Cloudflare domain doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Create WAF rules for each of your domains in the "Security tab".
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-reviewed',
        'test_key' => 'firewall-config-default-deny',
        'test' => [
            'id' => 'firewall-config-default-deny',
            'name' => 'Firewall default disallows traffic',
            'lastTestRunDate' => '2026-06-18T01:52:56.059Z',
            'latestFlipDate' => '2024-09-24T17:11:26.516Z',
            'description' => 'This test verifies that AWS firewall configurations (Security Groups and Network ACLs) default to denying inbound traffic, a behavior inherent to AWS infrastructure. It ensures that unless traffic is explicitly permitted, it will be blocked by default.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-reviewed',
        'test_key' => 'zone-level-rules-cloudflare',
        'test' => [
            'id' => 'zone-level-rules-cloudflare',
            'name' => 'Cloudflare zone-level rules configured',
            'lastTestRunDate' => '2026-06-18T01:52:56.686Z',
            'latestFlipDate' => '2025-10-10T15:56:13.399Z',
            'description' => 'This test verifies that at least one zone-level rule is configured across your Cloudflare zones. Zone-level rules include WAF rules, rate limiting rules, and other security/traffic rules applied at the zone level.',
            'failureDescription' => 'Your Cloudflare domain does not have traffic and security rules configured',
            'remediationDescription' => 'Create traffic and security rules in the Security tab within the account or in Security -> WAF within each zone.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-utilized',
        'test_key' => 'cloudflare-notifications-enabled',
        'test' => [
            'id' => 'cloudflare-notifications-enabled',
            'name' => 'Cloudflare notifications enabled',
            'lastTestRunDate' => '2026-06-18T01:52:56.651Z',
            'latestFlipDate' => '2026-05-21T03:43:51.740Z',
            'description' => 'This test verifies that four critical Cloudflare notification policies are enabled in your account: HTTP DDoS Attack Alert (or Advanced HTTP DDoS Attack Alert for Enterprise customers), Health Checks status notification, Passive Origin Monitoring, and Route Leak Detection Alert. These notifications ensure your team is promptly alerted to security threats like DDoS attacks, origin server issues, and BGP route leaks.',
            'failureDescription' => 'Your Cloudflare account does not have all the required notifications enabled',
            'remediationDescription' => 'Enable the notifications \'HTTP DDoS Attack Alert\', \'Health Checks status notification\'
\'Passive Origin Monitoring\' and \'Route Leak Detection Alert\' using
[these instructions](https://developers.cloudflare.com/fundamentals/notifications/create-notifications/)
',
            'version' => [
                'major' => 1,
                'minor' => 3,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-utilized',
        'test_key' => 'firewall-config-acl',
        'test' => [
            'id' => 'firewall-config-acl',
            'name' => 'Unwanted traffic filtered',
            'lastTestRunDate' => '2026-06-18T01:52:57.197Z',
            'latestFlipDate' => '2024-09-24T16:01:47.462Z',
            'description' => 'This test verifies that all AWS EC2 instances have either a Network ACL associated with their subnet or a security group directly attached. Without these network filtering mechanisms, instances lack basic firewall protection, leaving them exposed to unwanted inbound and outbound traffic.',
            'failureDescription' => 'Your corporate network doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Set up a corporate VPN to control access to your corporate network. Vanta recommends [OpenVPN](https://openvpn.net/access-server/?utm_source=vanta&utm_medium=referral).
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-utilized',
        'test_key' => 'firewall-config-cloudflare',
        'test' => [
            'id' => 'firewall-config-cloudflare',
            'name' => 'Unwanted traffic filtered (Cloudflare)',
            'lastTestRunDate' => '2026-06-18T01:52:56.429Z',
            'latestFlipDate' => '2025-10-10T15:56:12.950Z',
            'description' => 'This test verifies that your Cloudflare account has active firewall protections in place—either through enabled custom firewall rules or managed rulesets. These firewalls help block unwanted or malicious traffic from reaching your infrastructure.',
            'failureDescription' => 'Your Cloudflare domain doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Create WAF rules for each of your domains in the "Security tab".
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-utilized',
        'test_key' => 'firewall-config-default-deny',
        'test' => [
            'id' => 'firewall-config-default-deny',
            'name' => 'Firewall default disallows traffic',
            'lastTestRunDate' => '2026-06-18T01:52:56.059Z',
            'latestFlipDate' => '2024-09-24T17:11:26.516Z',
            'description' => 'This test verifies that AWS firewall configurations (Security Groups and Network ACLs) default to denying inbound traffic, a behavior inherent to AWS infrastructure. It ensures that unless traffic is explicitly permitted, it will be blocked by default.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'network-firewalls-utilized',
        'test_key' => 'zone-level-rules-cloudflare',
        'test' => [
            'id' => 'zone-level-rules-cloudflare',
            'name' => 'Cloudflare zone-level rules configured',
            'lastTestRunDate' => '2026-06-18T01:52:56.686Z',
            'latestFlipDate' => '2025-10-10T15:56:13.399Z',
            'description' => 'This test verifies that at least one zone-level rule is configured across your Cloudflare zones. Zone-level rules include WAF rules, rate limiting rules, and other security/traffic rules applied at the zone level.',
            'failureDescription' => 'Your Cloudflare domain does not have traffic and security rules configured',
            'remediationDescription' => 'Create traffic and security rules in the Security tab within the account or in Security -> WAF within each zone.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'policies-password-complexity',
        'test_key' => 'internal-password-policy-config',
        'test' => [
            'id' => 'internal-password-policy-config',
            'name' => 'Password policy configured for infrastructure',
            'lastTestRunDate' => '2026-06-18T01:52:56.048Z',
            'latestFlipDate' => '2024-09-24T17:11:27.835Z',
            'description' => 'This test verifies that all AWS accounts in your organization have an active and properly configured password policy defined.',
            'failureDescription' => 'You aren\'t enforcing a password policy on your infrastructure accounts yet.',
            'remediationDescription' => 'Set up a password policy in AWS that enforces password standards for your users.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T17:11:27.682Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'production-inventory-maintained',
        'test_key' => 'inventory-list-descriptions',
        'test' => [
            'id' => 'inventory-list-descriptions',
            'name' => 'Inventory items have descriptions',
            'lastTestRunDate' => '2026-06-18T01:52:57.214Z',
            'latestFlipDate' => '2024-09-24T15:58:00.008Z',
            'description' => 'This test verifies that every item on your Vanta Inventory page has a description. Maintaining descriptions for all inventory assets ensures proper asset management, accountability, and auditability—key requirements across security frameworks.',
            'failureDescription' => 'Some inventory items don\'t have descriptions.',
            'remediationDescription' => '1. Go to the [Inventory list](/inventory).
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
            'version' => [
                'major' => 5,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
                'azure',
                'azuredevops',
                'gcp',
                'oracle_cloud',
                'ovh_cloud',
                'addigy',
                'bitbucket',
                'cloudflare',
                'cloudflare_for_government',
                'datto',
                'digitalocean',
                'digitaloceanspaces',
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
                'rippling_mdm',
                'simplemdm',
                'snowflake',
                'supabase',
                'vercel',
                'workspace_one',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'production-inventory-maintained',
        'test_key' => 'inventory-list-user-data',
        'test' => [
            'id' => 'inventory-list-user-data',
            'name' => 'Inventory list tracks resources that contain user data',
            'lastTestRunDate' => '2026-06-18T01:52:56.760Z',
            'latestFlipDate' => '2024-09-24T15:58:02.289Z',
            'description' => 'This test verifies whether certain resources—such as storage buckets, databases, PaaS apps, queues, data warehouses, or custom items—are marked as containing user data in Vanta.',
            'failureDescription' => 'None of these resource types - storage buckets, databases, PaaS apps, queues, data warehouses, or custom items -  are marked as containing user data in Vanta.',
            'remediationDescription' => 'Not all resource types can be marked as containing user data. Only Storage buckets, Databases, Platform-as-a-service (PaaS apps), Queues, Data warehouses, or Custom items apply.

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
            'version' => [
                'major' => 4,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
                'azure',
                'azuredevops',
                'gcp',
                'oracle_cloud',
                'ovh_cloud',
                'addigy',
                'bitbucket',
                'cloudflare',
                'cloudflare_for_government',
                'datto',
                'digitalocean',
                'digitaloceanspaces',
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
                'rippling_mdm',
                'simplemdm',
                'snowflake',
                'supabase',
                'vercel',
                'workspace_one',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T15:58:02.254Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'remote-access-mfa-enforced',
        'test_key' => 'mfa-on-accounts-infra',
        'test' => [
            'id' => 'mfa-on-accounts-infra',
            'name' => 'MFA on infrastructure provider',
            'lastTestRunDate' => '2026-06-18T01:52:56.084Z',
            'latestFlipDate' => '2026-03-03T20:42:05.717Z',
            'description' => 'This test checks whether all AWS accounts with a password have multi-factor authentication (MFA) enabled.',
            'failureDescription' => 'Multifactor authentication isn\'t enabled for some of your infrastructure accounts.',
            'remediationDescription' => 'Add multifactor authentication to your AWS account.

1. Log in to the [AWS IAM console](https://console.aws.amazon.com/iam/).
2. In the navigation panel, click **Users**.
3. Click the name of the user accounts where multifactor authentication isn\'t enabled.
4. On the Security Credentials tab, click **Manage** next to **Assigned MFA device**.
5. Choose a virtual multifactor authentication device, and follow the steps to configure it.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-03-10T20:42:05.681Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'remote-access-vpn-enforced',
        'test_key' => 'require-admin-encrypted-iaas',
        'test' => [
            'id' => 'require-admin-encrypted-iaas',
            'name' => 'SSL/TLS on admin page of infrastructure console',
            'lastTestRunDate' => '2026-06-18T01:52:56.074Z',
            'latestFlipDate' => '2024-09-24T17:11:28.290Z',
            'description' => 'This test confirms that all AWS service API endpoints enforce encryption via TLS (Transport Layer Security) by default. This ensures secure communication between your administrators and AWS infrastructure services.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'support-infra-patched',
        'test_key' => 'github-scanning-configuration',
        'test' => [
            'id' => 'github-scanning-configuration',
            'name' => 'Vulnerability scanning is enabled (GitHub)',
            'lastTestRunDate' => '2026-06-18T01:52:56.704Z',
            'latestFlipDate' => '2025-10-10T19:43:18.405Z',
            'description' => 'This test verifies that vulnerability scanning (via Dependabot) is enabled for your GitHub repositories, allowing you to identify and manage software vulnerabilities effectively.',
            'failureDescription' => 'Vulnerability scanning is not enabled.',
            'remediationDescription' => 'Vanta requests permission to read Dependabot alerts when connecting the GitHub integration by default.

To confirm Dependabot is enabled for vulnerability scanning in your monitored repositories, see GitHub\'s Dependabot [Quick Start Guide](https://docs.github.com/en/code-security/getting-started/dependabot-quickstart-guide).',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'support-infra-patched',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
            'name' => 'Critical vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.915Z',
            'latestFlipDate' => '2025-10-10T16:49:57.866Z',
            'description' => 'This test ensures that all critical severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open critical severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=CRITICAL) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'support-infra-patched',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
            'name' => 'High vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.331Z',
            'latestFlipDate' => '2025-10-10T16:49:58.113Z',
            'description' => 'This test ensures that all high severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open high severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=HIGH) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'support-infra-patched',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
            'name' => 'Low vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.255Z',
            'latestFlipDate' => '2025-10-10T16:49:58.646Z',
            'description' => 'This test ensures that all low severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open low severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=LOW) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'support-infra-patched',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
            'name' => 'Medium vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.687Z',
            'latestFlipDate' => '2025-10-10T16:49:58.400Z',
            'description' => 'This test ensures that all medium severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open medium severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=MEDIUM) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'cloudflare-notifications-enabled',
        'test' => [
            'id' => 'cloudflare-notifications-enabled',
            'name' => 'Cloudflare notifications enabled',
            'lastTestRunDate' => '2026-06-18T01:52:56.651Z',
            'latestFlipDate' => '2026-05-21T03:43:51.740Z',
            'description' => 'This test verifies that four critical Cloudflare notification policies are enabled in your account: HTTP DDoS Attack Alert (or Advanced HTTP DDoS Attack Alert for Enterprise customers), Health Checks status notification, Passive Origin Monitoring, and Route Leak Detection Alert. These notifications ensure your team is promptly alerted to security threats like DDoS attacks, origin server issues, and BGP route leaks.',
            'failureDescription' => 'Your Cloudflare account does not have all the required notifications enabled',
            'remediationDescription' => 'Enable the notifications \'HTTP DDoS Attack Alert\', \'Health Checks status notification\'
\'Passive Origin Monitoring\' and \'Route Leak Detection Alert\' using
[these instructions](https://developers.cloudflare.com/fundamentals/notifications/create-notifications/)
',
            'version' => [
                'major' => 1,
                'minor' => 3,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'firewall-config-acl',
        'test' => [
            'id' => 'firewall-config-acl',
            'name' => 'Unwanted traffic filtered',
            'lastTestRunDate' => '2026-06-18T01:52:57.197Z',
            'latestFlipDate' => '2024-09-24T16:01:47.462Z',
            'description' => 'This test verifies that all AWS EC2 instances have either a Network ACL associated with their subnet or a security group directly attached. Without these network filtering mechanisms, instances lack basic firewall protection, leaving them exposed to unwanted inbound and outbound traffic.',
            'failureDescription' => 'Your corporate network doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Set up a corporate VPN to control access to your corporate network. Vanta recommends [OpenVPN](https://openvpn.net/access-server/?utm_source=vanta&utm_medium=referral).
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'firewall-config-cloudflare',
        'test' => [
            'id' => 'firewall-config-cloudflare',
            'name' => 'Unwanted traffic filtered (Cloudflare)',
            'lastTestRunDate' => '2026-06-18T01:52:56.429Z',
            'latestFlipDate' => '2025-10-10T15:56:12.950Z',
            'description' => 'This test verifies that your Cloudflare account has active firewall protections in place—either through enabled custom firewall rules or managed rulesets. These firewalls help block unwanted or malicious traffic from reaching your infrastructure.',
            'failureDescription' => 'Your Cloudflare domain doesn\'t filter unwanted traffic.',
            'remediationDescription' => 'Create WAF rules for each of your domains in the "Security tab".
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'firewall-config-default-deny',
        'test' => [
            'id' => 'firewall-config-default-deny',
            'name' => 'Firewall default disallows traffic',
            'lastTestRunDate' => '2026-06-18T01:52:56.059Z',
            'latestFlipDate' => '2024-09-24T17:11:26.516Z',
            'description' => 'This test verifies that AWS firewall configurations (Security Groups and Network ACLs) default to denying inbound traffic, a behavior inherent to AWS infrastructure. It ensures that unless traffic is explicitly permitted, it will be blocked by default.',
            'failureDescription' => 'N/A',
            'remediationDescription' => 'N/A
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'infra-access-requires-approval-config',
        'test' => [
            'id' => 'infra-access-requires-approval-config',
            'name' => 'AWS accounts reviewed',
            'lastTestRunDate' => '2026-06-18T01:52:56.275Z',
            'latestFlipDate' => '2024-09-24T16:01:06.103Z',
            'description' => 'This test verifies that all AWS accounts have been linked to users within Vanta. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.',
            'failureDescription' => 'Some of your AWS accounts have not been linked to Vanta users, so Vanta can\'t confirm you\'re limiting AWS access.',
            'remediationDescription' => '1. Use our [Access page](/access) to review any open access requests to your infrastructure. Accounts that have open access requests or have not been linked to a Vanta user may cause this test to fail.
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
*Note that the tag key may be different from "VantaOwner" if you are utilizing [custom tags](https://app.vanta.com/inventory?bulk-tags=open#compute).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account setup',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-01T16:01:05.770Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-network-hardening',
        'test_key' => 'zone-level-rules-cloudflare',
        'test' => [
            'id' => 'zone-level-rules-cloudflare',
            'name' => 'Cloudflare zone-level rules configured',
            'lastTestRunDate' => '2026-06-18T01:52:56.686Z',
            'latestFlipDate' => '2025-10-10T15:56:13.399Z',
            'description' => 'This test verifies that at least one zone-level rule is configured across your Cloudflare zones. Zone-level rules include WAF rules, rate limiting rules, and other security/traffic rules applied at the zone level.',
            'failureDescription' => 'Your Cloudflare domain does not have traffic and security rules configured',
            'remediationDescription' => 'Create traffic and security rules in the Security tab within the account or in Security -> WAF within each zone.
',
            'version' => [
                'major' => 1,
                'minor' => 1,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'cloudflare',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'load-balancer-config',
        'test' => [
            'id' => 'load-balancer-config',
            'name' => 'Load balancer used (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:57.139Z',
            'latestFlipDate' => '2024-09-24T15:59:58.103Z',
            'description' => 'This test validates that each AWS account in your organization has at least one Application Load Balancer (ALB) configured.',
            'failureDescription' => 'You aren\'t using a load balancer to distribute traffic yet.',
            'remediationDescription' => '[Determine the type of load balancer your application requires](https://docs.aws.amazon.com/elasticloadbalancing/latest/userguide/load-balancer-getting-started.html), and follow the steps to implement it.

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

See more in the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/lb).
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'load-balancer-http-to-https',
        'test' => [
            'id' => 'load-balancer-http-to-https',
            'name' => 'Load balancers redirect HTTP to HTTPS (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.982Z',
            'latestFlipDate' => '2024-09-24T15:59:58.349Z',
            'description' => 'This test verifies that all internet-facing AWS Application Load Balancers (ALBs) listening on HTTP are configured to redirect that HTTP traffic to HTTPS.',
            'failureDescription' => 'You have an Application Load Balancer that:
- Has an "internet-facing" **scheme**.
- Has a **listener** with an "HTTP" **protocol**.
- Does not have a **listener** with a **default action** that has a "redirect" **action type** and an "HTTPS" **redirect protocol**.
',
            'remediationDescription' => 'Configure the load balancers to redirect HTTP traffic to HTTPS.

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

See more in the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/data-sources/lb_listener).
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Infrastructure',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'load-balancers-monitored-and-alarmed-config-healthy',
        'test' => [
            'id' => 'load-balancers-monitored-and-alarmed-config-healthy',
            'name' => 'Load balancer unhealthy host count monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.058Z',
            'latestFlipDate' => '2024-09-24T15:59:58.542Z',
            'description' => 'This test verifies that all AWS Application Load Balancers (ALBs) have AWS CloudWatch alarms configured to monitor their host health statuses using specific AWS-provided metrics.',
            'failureDescription' => 'Your load balancers don\'t have healthy host count alerts set up.',
            'remediationDescription' => 'Set up healthy host count alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

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
```
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T15:59:58.515Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'load-balancers-monitored-and-alarmed-config-latency',
        'test' => [
            'id' => 'load-balancers-monitored-and-alarmed-config-latency',
            'name' => 'Load balancer latency monitored',
            'lastTestRunDate' => '2026-06-18T01:52:56.270Z',
            'latestFlipDate' => '2024-09-24T15:59:58.724Z',
            'description' => 'This test verifies that all AWS Application and Classic Load Balancers have CloudWatch alarms configured to monitor latency using accepted latency-related metrics.',
            'failureDescription' => 'You haven\'t set up latency alerts for your load balancer yet.',
            'remediationDescription' => 'Set up latency alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

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
```
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T15:59:58.679Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'load-balancers-monitored-and-alarmed-config-servererrors',
        'test' => [
            'id' => 'load-balancers-monitored-and-alarmed-config-servererrors',
            'name' => 'Load balancer server errors monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.064Z',
            'latestFlipDate' => '2024-09-24T15:59:58.878Z',
            'description' => 'This test checks whether AWS Application and Classic Load Balancers have CloudWatch alarms configured to notify you when server-side errors (5XX HTTP response codes) occur.',
            'failureDescription' => 'Your load balancers don\'t have error count monitors set up.',
            'remediationDescription' => 'Set up server error alerts in Amazon Cloudwatch or a 3rd party monitoring provider for your application and classic load balancers. Define alerts for at least one of the following metric categories:

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
```
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T15:59:58.851Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'mysql-database-monitored-and-alarmed-config-cpu',
        'test' => [
            'id' => 'mysql-database-monitored-and-alarmed-config-cpu',
            'name' => 'SQL database CPU monitored',
            'lastTestRunDate' => '2026-06-18T01:52:56.739Z',
            'latestFlipDate' => '2024-09-24T16:00:06.824Z',
            'description' => 'Checks that all Amazon RDS database instances have CloudWatch alarms configured to monitor CPU utilization.',
            'failureDescription' => 'Your RDS databases don\'t have CPU usage alerts set up.',
            'remediationDescription' => 'Set up CPU usage alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:00:06.794Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'mysql-database-monitored-and-alarmed-config-free-memory',
        'test' => [
            'id' => 'mysql-database-monitored-and-alarmed-config-free-memory',
            'name' => 'SQL database freeable memory monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.508Z',
            'latestFlipDate' => '2024-09-24T16:00:07.056Z',
            'description' => 'Verifies that all Amazon RDS instances have associated AWS CloudWatch alarms configured to monitor the `FreeableMemory` metric.',
            'failureDescription' => 'Your SQL databases don\'t have free memory alerts set up.',
            'remediationDescription' => 'Set up free memory alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:00:06.993Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'mysql-database-monitored-and-alarmed-config-io',
        'test' => [
            'id' => 'mysql-database-monitored-and-alarmed-config-io',
            'name' => 'Database IO monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.517Z',
            'latestFlipDate' => '2024-09-24T16:00:07.280Z',
            'description' => 'This test verifies that Amazon RDS databases have CloudWatch alarms configured for at least one key Input/Output (IO) performance metrics (such as `DiskQueueDepth`, `WriteIOPS`, `ReadIOPS`, `VolumeWriteIOPs`, `VolumeReadIOPs`).',
            'failureDescription' => 'Your RDS databases don\'t have input and output alerts set up.',
            'remediationDescription' => 'Set up read/write request alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:00:07.245Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'mysql-database-monitored-and-alarmed-config-storage-space',
        'test' => [
            'id' => 'mysql-database-monitored-and-alarmed-config-storage-space',
            'name' => 'SQL database free storage space monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:58.253Z',
            'latestFlipDate' => '2024-09-24T16:00:07.485Z',
            'description' => 'This test verifies that all Amazon RDS instances have CloudWatch alarms configured to monitor database storage space usage for at least one of the following metrics:
  - `FreeStorageSpace` on MySQL and PostgreSQL databases
  - `FreeLocalStorage` on Aurora MySQL and Aurora PostgreSQL databases
  - `AuroraVolumeBytesLeftTotal` on Aurora MySQL Databases',
            'failureDescription' => 'Your RDS instances don\'t have free storage space alerts set up.',
            'remediationDescription' => 'Set up free storage space alerts through Amazon CloudWatch or a 3rd party monitoring provider for your RDS Database instances. Define alerts for at least one of the following metrics (depending on your database type):

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:00:07.454Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'nosql-database-monitored-and-alarmed-config-read',
        'test' => [
            'id' => 'nosql-database-monitored-and-alarmed-config-read',
            'name' => 'NoSQL database read capacity monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.075Z',
            'latestFlipDate' => '2024-09-24T16:02:54.612Z',
            'description' => 'This test verifies whether each AWS DynamoDB table has a configured CloudWatch alarm for monitoring the `ConsumedReadCapacityUnits` metric.',
            'failureDescription' => 'Your AWS DynamoDB databases do not have read capacity alerts set up.',
            'remediationDescription' => 'Set up read capacity alerts through Amazon CloudWatch or a 3rd party monitoring provider for your NoSQL instances.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:02:54.577Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'nosql-database-monitored-and-alarmed-config-write',
        'test' => [
            'id' => 'nosql-database-monitored-and-alarmed-config-write',
            'name' => 'NoSQL database write capacity monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.329Z',
            'latestFlipDate' => '2024-09-24T16:02:54.769Z',
            'description' => 'This test verifies whether each AWS DynamoDB table has a configured CloudWatch alarm for monitoring the `ConsumedWriteCapacityUnits` metric.',
            'failureDescription' => 'Your NoSQL databases do not have write capacity alerts set up.',
            'remediationDescription' => 'Set up write capacity alerts through Amazon CloudWatch or a 3rd party monitoring provider for your NoSQL instances.

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
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:02:54.740Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'serverless-function-error-rate-monitored-aws',
        'test' => [
            'id' => 'serverless-function-error-rate-monitored-aws',
            'name' => 'Serverless function error rate monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.902Z',
            'latestFlipDate' => '2024-09-24T16:02:35.209Z',
            'description' => 'This test verifies that all AWS Lambda functions have CloudWatch alarms configured to monitor their Errors metric—either individually per function or globally for all functions.',
            'failureDescription' => 'An alarm has not been created for Lambda function error metrics.',
            'remediationDescription' => 'Set up Error alerts through Amazon CloudWatch or a 3rd party monitoring provider for your Lambda Functions.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/cloudwatch_metric_alarm) for more information.
',
            'version' => [
                'major' => 1,
                'minor' => 2,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-08T16:02:35.073Z',
                'itemCount' => 21,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'system-threshold-monitoring',
        'test_key' => 'servers-monitored-and-alarmed-config-cpu',
        'test' => [
            'id' => 'servers-monitored-and-alarmed-config-cpu',
            'name' => 'Server CPU monitored (AWS)',
            'lastTestRunDate' => '2026-06-18T01:52:56.254Z',
            'latestFlipDate' => '2024-09-25T17:11:48.807Z',
            'description' => 'This test verifies whether all AWS EC2 instances have a CloudWatch alarm set specifically for the `CPUUtilization` metric to ensure proper monitoring and alerts in case of high CPU usage.',
            'failureDescription' => 'Your servers do not have CPU usage alerts set up.',
            'remediationDescription' => 'Set up CPU usage alerts through Amazon CloudWatch or a 3rd party monitoring provider for your EC2 instances.

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
            'version' => [
                'major' => 2,
                'minor' => 1,
            ],
            'category' => 'Monitoring alerts',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2024-10-09T17:11:48.768Z',
                'itemCount' => 7,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'third-party-agreements',
        'test_key' => 'vendor-management-records',
        'test' => [
            'id' => 'vendor-management-records',
            'name' => 'Vendors list maintained',
            'lastTestRunDate' => '2026-06-17T22:48:52.954Z',
            'latestFlipDate' => '2024-09-26T12:31:50.674Z',
            'description' => 'This test verifies that you have manually added at least one vendor (other than automatically integrated accounts) on the [Vendors page](/vendors) that is visible to auditors. If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.',
            'failureDescription' => 'You haven\'t manually added any vendors on the Vendors page.',
            'remediationDescription' => 'On the [Vendors page](/vendors), ensure you\'ve added all vendors that your company uses. Vanta will auto-populate any vendor we integrate with, but you should manually add any other vendors to ensure they\'re tracked in one place.

If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vendors',
            'integrations' => [],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'third-party-agreements',
        'test_key' => 'vendor-risk-levels-assigned',
        'test' => [
            'id' => 'vendor-risk-levels-assigned',
            'name' => 'Vendors assigned risk levels',
            'lastTestRunDate' => '2026-06-17T22:48:53.223Z',
            'latestFlipDate' => '2024-09-23T08:02:34.728Z',
            'description' => 'This test verifies that every vendor listed on your [Vendors page](/vendors) has been assigned a risk level. Assigning risk levels to vendors is a foundational part of vendor risk management, enabling organizations to prioritize security reviews and due diligence based on the level of risk each vendor poses.',
            'failureDescription' => 'Some of your vendors don\'t have a risk level specified on the Vendors page.',
            'remediationDescription' => 'Go to the [Vendors page](/vendors) and assign a risk level for each vendor.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vendors',
            'integrations' => [],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 16,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'unique-account-authentication-enforced',
        'test_key' => 'infra-unique-accounts-roles',
        'test' => [
            'id' => 'infra-unique-accounts-roles',
            'name' => 'Service accounts used',
            'lastTestRunDate' => '2026-06-18T01:52:56.055Z',
            'latestFlipDate' => '2024-09-24T16:00:11.802Z',
            'description' => 'This test verifies that every AWS account connected to Vanta has at least one IAM role assigned. IAM roles are essential for securely delegating permissions to AWS services and users without sharing long-term credentials.',
            'failureDescription' => 'You aren\'t using IAM roles to manage users\' access to services for every AWS account.',
            'remediationDescription' => 'Many AWS services require that you use roles to allow the service to access resources in other services on your behalf.

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

See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_role) for more information.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'unique-account-authentication-enforced',
        'test_key' => 'infra-unique-accounts-root',
        'test' => [
            'id' => 'infra-unique-accounts-root',
            'name' => 'Root infrastructure account unused',
            'lastTestRunDate' => '2026-06-17T23:41:40.324Z',
            'latestFlipDate' => '2026-05-27T01:44:34.089Z',
            'description' => 'This test checks whether AWS root accounts have been used within the past 30 days.',
            'failureDescription' => 'Your root infrastructure user has been used to make infrastructure changes recently. Root users should not be used for infrastructure changes and should only be used in emergencies.',
            'remediationDescription' => 'The first user that is created for any new AWS account is known as the root user. As a best practice, the root user should only be used to create an administrative IAM user and should not be used after that except in emergency situations.

In AWS:

1. [Create IAM users and IAM roles](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users.html) to perform infrastructure tasks going forward and avoid making changes as the root user wherever possible.

In Vanta:

1. In the items to remediate for this test, click the "Acknowledge" button next to each instance and provide a reason why the root user was used instead of an IAM user or role.
2. Optionally: Click the "Apply this reason to all other incidents where this occurred" checkbox in the modal to acknowledge all instances at once.
',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-06-09T23:46:51.437Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'unique-account-authentication-enforced',
        'test_key' => 'infra-unique-accounts-unused',
        'test' => [
            'id' => 'infra-unique-accounts-unused',
            'name' => 'Old infrastructure accounts disabled (AWS)',
            'lastTestRunDate' => '2026-06-17T23:41:40.709Z',
            'latestFlipDate' => '2024-09-24T16:02:49.534Z',
            'description' => 'This test checks for AWS IAM users (non-root) that have been inactive for more than 90 days and should be considered for removal.',
            'failureDescription' => 'You have IAM user accounts that haven\'t been active in the last 90 days.',
            'remediationDescription' => '1. Identify the IAM accounts that are no longer in use in your company.
2. [Delete IAM accounts](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_manage.html) that have been inactive for 90 days or more.

#### Remediation for Terraform
Set force_destroy to true for your "aws_iam_user" resource.

```hcl
resource "aws_iam_user" "test-iam-user" {
  name = "test-user"
  force_destroy = true

}
```
See the [Terraform documentation](https://registry.terraform.io/providers/hashicorp/aws/latest/docs/resources/iam_user) for more information.

',
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'unique-account-authentication-enforced',
        'test_key' => 'infra-unique-accounts-user',
        'test' => [
            'id' => 'infra-unique-accounts-user',
            'name' => 'No user account has a policy attached directly',
            'lastTestRunDate' => '2026-06-18T01:52:56.239Z',
            'latestFlipDate' => '2026-03-03T20:42:05.536Z',
            'description' => 'This test verifies that no AWS IAM users have policies attached directly to their user accounts, checking that policies are instead applied through user groups.',
            'failureDescription' => 'Some of your AWS IAM policies are attached directly to users.',
            'remediationDescription' => 'Amazon allows policies to be defined and applied at the group, role, or user level; as much as possible, only assign policies to groups or roles – not to individual users. Doing so will streamline making changes to users and help enforce a least-privileged policy.

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
            'version' => [
                'major' => 1,
                'minor' => 0,
            ],
            'category' => 'Account security',
            'integrations' => [
                'aws',
            ],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'OVERDUE',
                'soonestRemediateByDate' => '2026-03-17T20:42:05.501Z',
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vendor-management-program-established',
        'test_key' => 'high-severity-vendor-compliance-reports',
        'test' => [
            'id' => 'high-severity-vendor-compliance-reports',
            'name' => 'Company completes security assessments for relevant vendors',
            'lastTestRunDate' => '2026-06-17T22:48:52.960Z',
            'latestFlipDate' => '2024-09-23T08:02:27.323Z',
            'description' => 'This test verifies whether vendors requiring security assessments have current and up-to-date assessments according to their risk levels.',
            'failureDescription' => 'Some vendors do not have an up-to-date security assessment.',
            'remediationDescription' => 'Visit the [Vendors page](/vendors) and complete security assessments. To complete an assessment, open the assessments tab on each vendor. Upload the latest security documentation, document any notable findings, and mark the assessment as complete.
',
            'version' => [
                'major' => 2,
                'minor' => 0,
            ],
            'category' => 'Vendors',
            'integrations' => [],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 20,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vendor-management-program-established',
        'test_key' => 'vendor-management-records',
        'test' => [
            'id' => 'vendor-management-records',
            'name' => 'Vendors list maintained',
            'lastTestRunDate' => '2026-06-17T22:48:52.954Z',
            'latestFlipDate' => '2024-09-26T12:31:50.674Z',
            'description' => 'This test verifies that you have manually added at least one vendor (other than automatically integrated accounts) on the [Vendors page](/vendors) that is visible to auditors. If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.',
            'failureDescription' => 'You haven\'t manually added any vendors on the Vendors page.',
            'remediationDescription' => 'On the [Vendors page](/vendors), ensure you\'ve added all vendors that your company uses. Vanta will auto-populate any vendor we integrate with, but you should manually add any other vendors to ensure they\'re tracked in one place.

If you do not have any vendors beyond what Vanta integrates with, you can deactivate this test.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vendors',
            'integrations' => [],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vendor-management-program-established',
        'test_key' => 'vendor-risk-levels-assigned',
        'test' => [
            'id' => 'vendor-risk-levels-assigned',
            'name' => 'Vendors assigned risk levels',
            'lastTestRunDate' => '2026-06-17T22:48:53.223Z',
            'latestFlipDate' => '2024-09-23T08:02:34.728Z',
            'description' => 'This test verifies that every vendor listed on your [Vendors page](/vendors) has been assigned a risk level. Assigning risk levels to vendors is a foundational part of vendor risk management, enabling organizations to prioritize security reviews and due diligence based on the level of risk each vendor poses.',
            'failureDescription' => 'Some of your vendors don\'t have a risk level specified on the Vendors page.',
            'remediationDescription' => 'Go to the [Vendors page](/vendors) and assign a risk level for each vendor.
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vendors',
            'integrations' => [],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 16,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vulnerability-scans-conducted',
        'test_key' => 'github-scanning-configuration',
        'test' => [
            'id' => 'github-scanning-configuration',
            'name' => 'Vulnerability scanning is enabled (GitHub)',
            'lastTestRunDate' => '2026-06-18T01:52:56.704Z',
            'latestFlipDate' => '2025-10-10T19:43:18.405Z',
            'description' => 'This test verifies that vulnerability scanning (via Dependabot) is enabled for your GitHub repositories, allowing you to identify and manage software vulnerabilities effectively.',
            'failureDescription' => 'Vulnerability scanning is not enabled.',
            'remediationDescription' => 'Vanta requests permission to read Dependabot alerts when connecting the GitHub integration by default.

To confirm Dependabot is enabled for vulnerability scanning in your monitored repositories, see GitHub\'s Dependabot [Quick Start Guide](https://docs.github.com/en/code-security/getting-started/dependabot-quickstart-guide).',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [],
            'status' => 'NEEDS_ATTENTION',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'NEEDS_WORK',
                'soonestRemediateByDate' => null,
                'itemCount' => 1,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vulnerability-scans-conducted',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-critical',
            'name' => 'Critical vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.915Z',
            'latestFlipDate' => '2025-10-10T16:49:57.866Z',
            'description' => 'This test ensures that all critical severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open critical severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=CRITICAL) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vulnerability-scans-conducted',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-high',
            'name' => 'High vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.331Z',
            'latestFlipDate' => '2025-10-10T16:49:58.113Z',
            'description' => 'This test ensures that all high severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open high severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=HIGH) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vulnerability-scans-conducted',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-low',
            'name' => 'Low vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.255Z',
            'latestFlipDate' => '2025-10-10T16:49:58.646Z',
            'description' => 'This test ensures that all low severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open low severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=LOW) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
    [
        'internal_control_vanta_id' => 'vulnerability-scans-conducted',
        'test_key' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
        'test' => [
            'id' => 'packages-checked-for-vulnerabilities-v2-records-closed-github-dependabot-medium',
            'name' => 'Medium vulnerabilities identified in packages are addressed (GitHub Repo)',
            'lastTestRunDate' => '2026-06-18T01:52:56.687Z',
            'latestFlipDate' => '2025-10-10T16:49:58.400Z',
            'description' => 'This test ensures that all medium severity vulnerabilities identified by GitHub\'s Dependabot in your repositories are addressed and resolved.',
            'failureDescription' => 'You have open medium severity vulnerabilities.',
            'remediationDescription' => '1. Visit the [Vulnerabilities page](/vulnerabilities/findings-by-vulnerability?source=github&severity=MEDIUM) to learn more about the unresolved vulnerabilities.
2. Remediate or deactivate monitoring for each unresolved vulnerability.
3. [Optional] If the vulnerability was resolved outside of the SLA you’ve defined, explain the reason to your auditor on the [SLA violations page](/vulnerabilities/history?tab=sla-misses).
',
            'version' => [
                'major' => 0,
                'minor' => 0,
            ],
            'category' => 'Vulnerability management',
            'integrations' => [
                'github',
            ],
            'status' => 'OK',
            'deactivatedStatusInfo' => [
                'isDeactivated' => false,
                'deactivatedReason' => null,
                'lastUpdatedDate' => null,
            ],
            'remediationStatusInfo' => [
                'status' => 'PASS',
                'soonestRemediateByDate' => null,
                'itemCount' => 0,
            ],
            'owner' => null,
        ],
    ],
];
