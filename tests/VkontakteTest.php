<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Token\AccessToken;
use Max107\OAuth2\Client\Provider\User;
use Max107\OAuth2\Client\Provider\Vkontakte;
use PHPUnit\Framework\TestCase;

class VkontakteTest extends TestCase
{
    /**
     * @var array
     */
    protected $response;
    /**
     * @var Vkontakte
     */
    protected $provider;
    /**
     * @var AccessToken
     */
    protected $token;

    protected function setUp()
    {
        $this->response = [
            'uid' => 12345,
            'bdate' => '12.07.1980',
            'city' => [
                'id' => 42,
                'title' => 'mock_city_title',
            ],
            'country' => [
                'id' => 421,
                'title' => 'UK',
            ],
            'domain' => 'id12345',
            'first_name' => 'mock_first_name',
            'friend_status' => 3,
            'has_photo' => 1,
            'home_town' => 'mock_home_town',
            'is_friend' => 1,
            'last_name' => 'mock_last_name',
            'maiden_name' => 'mock_maiden_name',
            'nickname' => 'mock_nickname',
            'photo_max' => 'http::/example.com/mock/image/url.jpg?with=parameters&and=square',
            'photo_max_orig' => 'http::/example.com/mock/image/url.jpg?with=parameters&and=max',
            'screen_name' => 'mock_screen_name',
            'sex' => 2,
        ];
        $this->provider = new Vkontakte([
            'clientId' => 'mock',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);
        $this->token = new AccessToken([
            'access_token' => 'mock_token',
        ]);
    }

    public function testUrlUserDetails()
    {
        $query = parse_url($this->provider->getResourceOwnerDetailsUrl($this->token), PHP_URL_QUERY);
        parse_str($query, $param);

        $this->assertEquals($this->token->getToken(), $param['access_token']);
    }

    public function testUserDetails()
    {
        $user = new User($this->response);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($this->response['uid'], $user->getId());
        $this->assertEquals($this->response['screen_name'], $user->getScreenName());
        $this->assertEquals($this->response['first_name'], $user->getFirstName());
        $this->assertEquals($this->response['last_name'], $user->getLastName());
    }
}
