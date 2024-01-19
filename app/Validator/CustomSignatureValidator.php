<?php

namespace App\Validators;

use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class CustomSignatureValidator implements SignatureValidator
{
    public function isValid(string $signature, string $payload, WebhookConfig $config): bool
    {
        // Implement your custom validation logic here
        // Return true if the signature is valid, false otherwise
    }
}

?>
