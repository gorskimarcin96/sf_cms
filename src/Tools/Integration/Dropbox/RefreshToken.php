<?php

namespace App\Tools\Integration\Dropbox;

use App\Repository\ConstantRepository;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RefreshToken
{
    public function __construct(
        private ConstantRepository $constantRepository,
        private HttpClientInterface $httpClient,
        private ParameterBagInterface $parameterBag
    ) {
    }

    public function refresh(): void
    {
        try {
            $this->refreshTokenByRefreshToken();
        } catch (ClientException $exception) {
            $this->refreshTokenByAuthorizationCode();
        }
    }

    private function refreshTokenByRefreshToken(): void
    {
        $dropboxAccessTokenConstant = $this->constantRepository->findDropboxAccessToken();
        $dropboxRefreshTokenConstant = $this->constantRepository->findDropBoxRefreshToken();

        $response = $this->httpClient->request('POST', 'https://api.dropbox.com/oauth2/token', [
            'body' => [
                'refresh_token' => $dropboxRefreshTokenConstant->getDescription(),
                'grant_type' => 'refresh_token',
                'client_id' => $this->parameterBag->get('dropbox.key'),
                'client_secret' => $this->parameterBag->get('dropbox.secret'),
            ],
        ])->toArray();

        $dropboxAccessTokenConstant->setDescription($response['access_token']);
        $this->constantRepository->add($dropboxAccessTokenConstant);
    }

    private function refreshTokenByAuthorizationCode(): void
    {
        $dropboxAuthorizationCodeConstant = $this->constantRepository->findDropboxAuthorizationCode();
        $dropboxAccessTokenConstant = $this->constantRepository->findDropboxAccessToken();
        $dropboxRefreshTokenConstant = $this->constantRepository->findDropBoxRefreshToken();

        $response = $this->httpClient->request('POST', 'https://api.dropbox.com/oauth2/token', [
            'auth_basic' => [$this->parameterBag->get('dropbox.key'), $this->parameterBag->get('dropbox.secret')],
            'body' => [
                'code' => $dropboxAuthorizationCodeConstant->getDescription(),
                'grant_type' => 'authorization_code',
            ],
        ])->toArray();

        $dropboxAccessTokenConstant->setDescription($response['access_token']);
        $this->constantRepository->add($dropboxAccessTokenConstant, false);
        $dropboxRefreshTokenConstant->setDescription($response['refresh_token']);
        $this->constantRepository->add($dropboxRefreshTokenConstant);
    }
}
