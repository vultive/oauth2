<?php

namespace Vultive\OAuth2\Client\Provider;

use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class VultiveProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public $myVultiveDomain = 'https://my.vultive.com';

    public function getBaseAuthorizationUrl()
    {
        return $this->myVultiveDomain . '/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->myVultiveDomain . '/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->myVultiveDomain . '/api/v1/me';
    }

    protected function fetchResourceOwnerDetails(AccessToken $token)
    {
        return parent::fetchResourceOwnerDetails($token);
    }

    protected function getDefaultScopes()
    {
        return [
            'profile',
            'email'
        ];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        return $response->getStatusCode();
    }

    /**
     * Generate a user object from a successful user details request.
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new VultiveResourceOwner($response);
    }
}