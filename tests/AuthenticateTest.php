<?php

namespace AuthenticateTest;


use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Facades\TokenGeneratorFacade;
use Authenticate\Facades\TokenSenderFacade;
use Authenticate\Facades\TokenStoreFacade;
use Authenticate\Facades\UserProviderFacade;
use Authenticate\User;
use Tests\TestCase;

class TwoFactorAuthTokenTest extends TestCase
{
    /**
     * @var string $mobile
     */
    private $mobile;

    public function setUp(): void
    {
        parent::setUp();
        $this->mobile = "+989354864721";
    }

    public function test_the_happy_path_for_send_token_register()
    {
        UserProviderFacade::shouldReceive('exist')->with($this->mobile)
            ->once()->andReturnNull();

        TokenGeneratorFacade::shouldReceive('generateToken')->withNoArgs()
            ->once()->andReturn("123456");

        TokenStoreFacade::shouldReceive('store')->with($this->mobile, "123456")->once();
        TokenSenderFacade::shouldReceive('send')->with($this->mobile, "123456")->once();

        ResponderFacade::shouldReceive('tokenSend')->withNoArgs()->once();

        $res = $this->postJson(route('v1.register.issue-token'), ['mobile' => $this->mobile]);


    }

    public function test_mobile_does_exist()
    {
        User::unguard();
        $user = new User(['id' => 1, 'mobile' => "+989354864721"]);

        UserProviderFacade::shouldReceive('exist')->with($this->mobile)
            ->once()->andReturn($user);

        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('store')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('tokenSend')->never();

        ResponderFacade::shouldReceive('userExist')->withNoArgs()->once();

        $res = $this->postJson(route('v1.register.issue-token'), ['mobile' => $this->mobile]);
    }

    public function test_for_send_token_in_login()
    {
        User::unguard();
        $user = new User(['id' => 1, 'mobile' => "+989354864721"]);

        AuthFacade::shouldReceive('check')->withNoArgs()->once()
            ->andReturnFalse();

        UserProviderFacade::shouldReceive('exist')->with($this->mobile)
            ->once()->andReturn($user);

        UserProviderFacade::shouldReceive('isBanned')->with($this->mobile)
            ->once()->andReturnNull();

        TokenGeneratorFacade::shouldReceive('generateToken')->withNoArgs()
            ->once()->andReturn("123456");

        TokenStoreFacade::shouldReceive('store')->with($this->mobile, "123456")->once();
        TokenSenderFacade::shouldReceive('send')->with($this->mobile, "123456")->once();

        ResponderFacade::shouldReceive('tokenSend')->withNoArgs()->once();

        $res = $this->postJson(route('v1.login.issue-token'), ['mobile' => $this->mobile]);



    }
}






