<?php
/**
 * AWS 部屬腳本產生器
 *
 * @anoter 小周
 */

// require_once "vendor/autoload.php";

# 產生 appspec.yaml
$templateDir = "./aws_codebuild/template/";

# 判斷是否為 CLI 環境
if (PHP_SAPI != "cli") {
    http_response_code(404);
    echo "404 Not Found";
    exit();
}

$appSpecTemplateContent = file_get_contents("{$templateDir}/appspec.yaml");

$appSpecConfig = [
    "<ECS_CONTAINER_NAME>"                      => $_SERVER['ECS_TASK_CONTAINER_NAME'],
//    "<LAMBDA_AFTER_ALLOW_TEST_TRAFFIC_ARN>"     => $_SERVER['LAMBDA_AFTER_ALLOW_TEST_TRAFFIC_ARN'],
//    "<LAMBDA_BEFORE_ALLOW_TRAFFIC_ARN>"         => $_SERVER['LAMBDA_AFTER_ALLOW_TEST_TRAFFIC_ARN'],
//    "<LAMBDA_CLOUDFRONT_INVALID_ARN>"           => $_SERVER['LAMBDA_CLOUDFRONT_INVALID_ARN']
];

$finalAppSpecContent = str_replace(array_keys($appSpecConfig),array_values($appSpecConfig),$appSpecTemplateContent);
// 檔案如果存在 刪除掉
if (file_exists("./appspec.yaml")) unlink("./appspec.yaml");
$file = fopen("./appspec.yaml","a+");
fwrite($file,$finalAppSpecContent);
fclose($file);
unset($file);
echo "appspec.yaml 產生完成\n";


# 產生 taskdef.json
$taskDefTemplateContent = file_get_contents("{$templateDir}/taskdef.json");

$taskReplaceConfig = [
    "<AWS_SECRETS_MANAGER_ARN>"                 => $_SERVER['SECRET_MANAGER_ARN'],
    "<ECS_TASK_ROLE_ARN>"                       => $_SERVER['ECS_TASK_ROLE_ARN'],
    "<ECS_EXECUTE_ROLE_ARN>"                    => $_SERVER['ECS_EXECUTE_ROLE_ARN'],
    "<ECS_TASK_DEFINITION_FAMILY>"              => $_SERVER['ECS_TASK_DEFINITION_FAMILY'],
    "<ECS_CONTAINER_NAME>"                      => $_SERVER['ECS_TASK_CONTAINER_NAME'],
    "<AWS_LOG_REGION>"                          => $_SERVER['AWS_DEFAULT_REGION'],
    "<AWS_REGION>"                              => $_SERVER['AWS_DEFAULT_REGION'],
    "<ECS_TASK_CPU>"                            => $_SERVER['ECS_TASK_CPU'],
    "<ECS_TASK_MEMORY>"                         => $_SERVER['ECS_TASK_MEMORY'],
    "<AWS_LOG_GROUP_NAME>"                      => $_SERVER['ECS_CONTAINER_LOG_GROUP_NAME'],
    "<AWS_LOG_STREAM_PREFIX>"                   => $_SERVER['ECS_TASK_CONTAINER_NAME'],
];

$finalTaskDefContent = $taskDefTemplateContent;
$replace = str_replace(array_keys($taskReplaceConfig),array_values($taskReplaceConfig),$finalTaskDefContent);
// 檔案如果存在 刪除掉
if (file_exists("./taskdef.json")) unlink("./taskdef.json");
$file = fopen("./taskdef.json","a+");
fwrite($file,$replace);
fclose($file);
unset($file);
echo "taskdef.json 產生完成\n";

