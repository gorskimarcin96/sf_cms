<?php

namespace App\Tools\Integration\Dropbox;

use App\Tools\File\Connector\ConnectorInterface;
use App\Tools\Integration\IntegrationInterface;
use Exception;
use Spatie\Dropbox\Client as DropboxClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class Client implements ConnectorInterface, IntegrationInterface
{
    public function __construct(private DropboxClient $dropboxClient)
    {
    }

    public function getName(): string
    {
        return 'Dropbox';
    }

    public function isActive(): bool
    {
        return (new FilesystemAdapter())->get('integration_dropbox_is_active', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            try {
                $this->dropboxClient->getAccountInfo();

                return true;
            } catch (Exception $exception) {
                return false;
            }
        });
    }

    public function read(string $path): string
    {
        return stream_get_contents($this->dropboxClient->download($path));
    }

    public function save(string $path, string $contents): void
    {
        $this->dropboxClient->upload($path, $contents);
    }

    public function delete(string $path): void
    {
        $this->dropboxClient->delete($path);
    }
}
