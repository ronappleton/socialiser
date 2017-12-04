<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 12/2/17
 * Time: 3:22 PM
 */

namespace RonAppleton\Socialiser\Two;

use Illuminate\Support\Arr;

class InstagramProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['basic'];

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://api.instagram.com/oauth/authorize', $state
        );
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return 'https://api.instagram.com/oauth/access_token';
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param  string $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $endpoint = '/users/self';
        $query = [
            'access_token' => $token,
        ];
        $signature = $this->generateSignature($endpoint, $query);

        $query['sig'] = $signature;
        $response = $this->getHttpClient()->get(
            'https://api.instagram.com/v1/users/self', [
            'query' => $query,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['data'];
    }

    /**
     * Map the raw user array to a Socialiser User instance.
     *
     * @param  array $user
     * @return \RonAppleton\Socialiser\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['username'],
            'name' => $user['full_name'],
            'email' => null,
            'avatar' => $user['profile_picture'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'form_params' => $this->getTokenFields($code),
        ]);

        $this->credentialsResponseBody = json_decode($response->getBody(), true);

        return $this->parseAccessToken($response->getBody());
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * Allows compatibility for signed API requests.
     */
    protected function generateSignature($endpoint, array $params)
    {
        $sig = $endpoint;
        ksort($params);
        foreach ($params as $key => $val) {
            $sig .= "|$key=$val";
        }
        $signing_key = $this->clientSecret;

        return hash_hmac('sha256', $sig, $signing_key, false);
    }

    /**
     * Get the access token from the token response body.
     *
     * @param string $body
     *
     * @return string
     */
    protected function parseAccessToken($body)
    {
        return Arr::get($body, 'access_token');
    }
}