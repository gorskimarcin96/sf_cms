<?php

namespace App\Factory;

use App\Repository\ConstantRepository;
use App\Tools\Integration\Dropbox\RefreshToken;
use Exception;
use Spatie\Dropbox\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class DropboxClient
{
    public static function create(ConstantRepository $constantRepository, RefreshToken $refreshToken): Client
    {
        return (new FilesystemAdapter())->get(
            'dropboxClient',
            function (ItemInterface $item) use ($constantRepository, $refreshToken) {
                $item->expiresAfter(3600);
                $client = new Client($constantRepository->findDropboxAccessToken()->getDescription());

                try {
                    $client->getAccountInfo();

                    return $client;
                } catch (Exception $exception) {
                    $refreshToken->refresh();

                    return new Client($constantRepository->findDropboxAccessToken()->getDescription());
                }
            }
        );
    }
}
