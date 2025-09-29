<?php
namespace GPA;
use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;
class GpaProvider extends AbstractProvider {
    public const IDENTIFIER = 'GPA';
    protected $scopes = ['users'];
    protected $scopeSeparator = ' ';
    protected function getAuthUrl($state) {
        return $this->buildAuthUrlFromBase(
            'https://accounts.gridplay.ca/oauth/authorize',
            $state
        );
    }
    protected function getTokenUrl() {
        return 'https://accounts.gridplay.ca/oauth/token';
    }
    protected function getUserByToken($token) {
        $response = $this->getHttpClient()->get(
            'https://accounts.gridplay.ca/api/user',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }
    protected function mapUserToObject(array $user) {
        return (new User())->setRaw($user)->map([
            'id'   => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
