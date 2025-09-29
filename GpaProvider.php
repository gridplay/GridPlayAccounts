<?php

namespace GPA;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class GpaProvider extends AbstractProvider
{
    public const IDENTIFIER = 'GPA';

    protected $scopes = [
        'users',
    ];
    protected $consent = true;

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

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://accounts.gridplay.ca/api/users',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'       => $user['id'],
            'name'     => $user['name'],
            'email'    => $user['email'] ?? null,
        ]);
    }
}
