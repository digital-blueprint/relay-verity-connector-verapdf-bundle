<?php

declare(strict_types=1);

/**
 * PDF/A validation service.
 */

namespace Dbp\Relay\VerityConnectorVerapdfBundle\Service;

use Dbp\Relay\VerityBundle\Helpers\VerityResult;
use Dbp\Relay\VerityBundle\Service\VerityProviderInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PDFAValidationAPI implements VerityProviderInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ConfigurationService $configurationService)
    {
    }

    public function validate($fileContent, $fileName, $fileSize, $sha1sum, $config, $mimetype): VerityResult
    {
        $bundleConfig = $this->configurationService->getConfig();
        $serverUrl = $bundleConfig['url'];
        $maxsize = $bundleConfig['maxsize'];

        if ($fileSize > $maxsize) {
            throw new \Exception("File size exceeded maxsize: {$fileSize} > {$maxsize}");
        }

        $checkConfig = json_decode($config, true);
        if (!isset($checkConfig['flavour']) || $checkConfig['flavour'] === '') {
            throw new \Exception("Required config key 'flavour' is missing.");
        }
        $flavour = $checkConfig['flavour'];
        $url = "$serverUrl/api/validate/$flavour/";

        $fileHandle = fopen('data://text/plain,'.urlencode($fileContent), 'rb');
        stream_context_set_option($fileHandle, 'http', 'filename', $fileName);
        stream_context_set_option($fileHandle, 'http', 'content_type', $mimetype);

        $response = null;
        try {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-File-Size: '.$fileSize,
                    'Content-Type: multipart/form-data',
                ],
                'body' => [
                    'sha1Hex' => $sha1sum,
                    'file' => $fileHandle,
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $content = $response->getContent(false);
        } catch (TransportExceptionInterface $e) {
            if ($response instanceof \Symfony\Contracts\HttpClient\ResponseInterface) {
                $statusCode = $response->getStatusCode();
                $content = $response->getContent(false);
            } else {
                $statusCode = 500;
                $content = 'Internal Server Error';
            }
        }

        $result = new VerityResult();
        $result->profileNameRequested = $flavour;

        // Check if the request was successful
        if ($statusCode !== 200) {
            $result->validity = false;
            $result->message = 'Network Error';
            $result->errors[] = $statusCode.' '.$content;

            return $result;
        }

        $res = json_decode($content, true);
        $validationResult = $res['report']['jobs'][0]['validationResult'][0];
        $result->validity = $validationResult['compliant'];
        $result->message = $validationResult['statement'];
        $result->profileNameUsed = $validationResult['profileName'];
        if ($validationResult['details']['failedRules'] > 0) {
            foreach ($validationResult['details']['ruleSummaries'] as $summary) {
                if ($summary['ruleStatus'] === 'FAILED') {
                    $result->errors[] = $summary['description'];
                }
            }
        }

        return $result;
    }
}
