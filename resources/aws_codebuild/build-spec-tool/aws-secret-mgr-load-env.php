<?php

require_once 'vendor/autoload.php';

if (!class_exists(\Aws\SecretsManager\SecretsManagerClient::class)) {
    echo <<<EOL
class not found \Aws\SecretsManager\SecretsManagerClient，please use 'composer require aws/aws-sdk-php-laravel'
EOL;
    exit(1);
}


if (PHP_SAPI != 'cli') { exit(1); }

$awsRegion = $argv[1];
$secretId  = $argv[2];

if (empty($awsRegion) || empty($secretId)) {
    echo '缺少必要參數';
    exit(1);
}

$taskDefPath = __DIR__ . '/aws_codebuild/template/taskdef.json';
if (!file_exists($taskDefPath)) {
    echo 'file not found';
    exit(1);
}

$fileSourceContent = file_get_contents($taskDefPath);

$taskDefJson = json_decode($fileSourceContent);

$awsApi = new \Aws\SecretsManager\SecretsManagerClient([
    'version' => '2017-10-17',
    'region' => $awsRegion
]);

try {
    $result = $awsApi->getSecretValue([
        'SecretId' => $secretId,
    ]);

    $jsonSecrets = json_decode($result['SecretString'], true);

    $taskDefJson->containerDefinitions[0]->secrets = [];
    foreach (array_keys($jsonSecrets) as $keyName) {
        // @see https://docs.aws.amazon.com/zh_tw/AmazonECS/latest/developerguide/specifying-sensitive-data-tutorial.html
        $taskDefJson->containerDefinitions[0]->secrets[] = (object) [
            'name' => $keyName,
            'valueFrom' => "<AWS_SECRETS_MANAGER_ARN>:{$keyName}::"
        ];
    }

    # see https://codebeautify.org/blog/json-encode-pretty-print-using-php/
    $newTaskDefJsonString = json_encode($taskDefJson, JSON_PRETTY_PRINT);
    file_put_contents($taskDefPath, $newTaskDefJsonString);
    echo "done!\ncontent:\n{$newTaskDefJsonString}";
} catch (\Aws\Exception\AwsException $e) {
    echo "aws error: {$e->getMessage()}";
    exit(1);
}

