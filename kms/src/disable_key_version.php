<?php
/*
 * Copyright 2020 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

// [START kms_disable_key_version]
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\CryptoKeyVersion\CryptoKeyVersionState;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Protobuf\FieldMask;

function disable_key_version_sample(
    string $projectId = 'my-project',
    string $locationId = 'us-east1',
    string $keyRingId = 'my-key-ring',
    string $keyId = 'my-key',
    string $versionId = '123'
) {
    // Create the Cloud KMS client.
    $client = new KeyManagementServiceClient();

    // Build the key version name.
    $keyVersionName = $client->cryptoKeyVersionName($projectId, $locationId, $keyRingId, $keyId, $versionId);

    // Create the updated version.
    $keyVersion = (new CryptoKeyVersion())
        ->setName($keyVersionName)
        ->setState(CryptoKeyVersionState::DISABLED);

    // Create the field mask.
    $updateMask = (new FieldMask())
        ->setPaths(['state']);

    // Call the API.
    $disabledVersion = $client->updateCryptoKeyVersion($keyVersion, $updateMask);
    printf('Disabled key version: %s' . PHP_EOL, $disabledVersion->getName());
    return $disabledVersion;
}
// [END kms_disable_key_version]

if (isset($argv)) {
    if (count($argv) === 0) {
        return printf("Usage: php %s PROJECT_ID LOCATION_ID KEY_RING_ID KEY_ID VERSION_ID\n", basename(__FILE__));
    }

    require_once __DIR__ . '/../vendor/autoload.php';
    list($_, $projectId, $locationId, $keyRingId, $keyId, $versionId) = $argv;
    disable_key_version_sample($projectId, $locationId, $keyRingId, $keyId, $versionId);
}
