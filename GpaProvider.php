<?php

namespace GPA;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class GpaProvider extends AbstractProvider
{
    public const IDENTIFIER = 'GRIDPLAYACCOUNTS';

    protected $scopes = [
        'users',
    ];
    protected $consent = false;

    protected $stateless = true;

    protected $scopeSeparator = ' ';

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase('https://accounts.gridplay.ca/oauth/authorize', $state);
    }

    protected function getTokenUrl(): string
    {
        return "https://accounts.gridplay.ca/oauth/token";
    }

    protected function getUserByToken($token)
    {
        try {
            $response = $this->getHttpClient()->get(
                'https://accounts.gridplay.ca/api/users',
                [
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer '.$token,
                        'Accept' => 'application/json',
                    ],
                ]
            );

            return json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch user from GridPlay Accounts: '.$e->getMessage());
        }
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'       => $user['id'],
            'name'     => $user['name'],
            'slid'     => $user['slid'] ?? null,
            'prem'     => $user['prem'] ?? 0,
        ]);
    }
}
