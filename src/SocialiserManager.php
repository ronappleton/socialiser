<?php
namespace RonAppleton\Socialiser;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Manager;
use RonAppleton\Socialiser\Two\GithubProvider;
use RonAppleton\Socialiser\Two\GoogleProvider;
use RonAppleton\Socialiser\One\TwitterProvider;
use RonAppleton\Socialiser\Two\FacebookProvider;
use RonAppleton\Socialiser\Two\LinkedInProvider;
use RonAppleton\Socialiser\Two\BitbucketProvider;
use RonAppleton\Socialiser\Two\YoutubeProvider;
use RonAppleton\Socialiser\Two\InstagramProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use RonAppleton\Socialiser\Contracts\Factory;

class SocialiserManager extends Manager implements Factory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createGithubDriver()
    {
        $config = config('socialiser.github');

        return $this->buildProvider(
            GithubProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createFacebookDriver()
    {
        $config = config('socialiser.facebook');

        return $this->buildProvider(
            FacebookProvider::class, $config
        );
    }
    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createInstagramDriver()
    {
        $config = config('socialiser.instagram');

        return $this->buildProvider(
            InstagramProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createGoogleDriver()
    {
        $config = config('socialiser.google');

        return $this->buildProvider(
            GoogleProvider::class, $config
        );
    }
    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createYoutubeDriver()
    {
        $config = config('socialiser.youtube');

        return $this->buildProvider(
            YoutubeProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createLinkedinDriver()
    {
        $config = config('socialiser.linkedin');

        return $this->buildProvider(
            LinkedInProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    protected function createBitbucketDriver()
    {
        $config = config('socialiser.bitbucket');

        return $this->buildProvider(
            BitbucketProvider::class, $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \RonAppleton\Socialiser\Two\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'], $config['client_id'],
            $config['client_secret'], $this->formatRedirectUrl($config),
            Arr::get($config, 'guzzle', [])
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \RonAppleton\Socialiser\One\AbstractProvider
     */
    protected function createTwitterDriver()
    {
        $config = config('socialiser.twitter');

        return new TwitterProvider(
            $this->app['request'], new TwitterServer($this->formatConfig($config))
        );
    }

    /**
     * Format the server configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function formatConfig(array $config)
    {
        return array_merge([
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => $this->formatRedirectUrl($config),
        ], $config);
    }

    /**
     * Format the callback URL, resolving a relative URI if needed.
     *
     * @param  array  $config
     * @return string
     */
    protected function formatRedirectUrl(array $config)
    {
        $redirect = value($config['redirect_url']);

        return Str::startsWith($redirect, '/')
            ? $this->app['url']->to($redirect)
            : $redirect;
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Socialiser driver was specified.');
    }
}