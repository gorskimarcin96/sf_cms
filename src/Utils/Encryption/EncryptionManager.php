<?php

namespace App\Utils\Encryption;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class EncryptionManager
{
    private string $method;
    private string $iv;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->method = $parameterBag->get('encryption_manager.method');
        $this->iv = $parameterBag->get('encryption_manager.iv');
    }

    public function encrypt(string $string): string
    {
        return base64_encode(openssl_encrypt($string, $this->method, $this->iv, OPENSSL_RAW_DATA, $this->iv));
    }

    public function decrypt(string $string): string
    {
        return openssl_decrypt(base64_decode($string), $this->method, $this->iv, OPENSSL_RAW_DATA, $this->iv);
    }
}
