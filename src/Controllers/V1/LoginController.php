<?php

namespace Authenticate\Controllers\V1;

use App\Http\Controllers\Controller;
use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Facades\TokenGeneratorFacade;
use Authenticate\Facades\TokenSaverFacade;
use Authenticate\Facades\TokenSenderFacade;
use Authenticate\Facades\TokenStoreFacade;
use Authenticate\Facades\UserProviderFacade;
use Authenticate\Requests\CheckCodeRequest;
use Authenticate\Requests\IssueTokenRequest;
use Authenticate\Requests\UserLoginRequest;
use Illuminate\Http\JsonResponse;
use Exception;

class LoginController extends Controller
{

    /**
     * Create and send issue token.
     *
     * @param IssueTokenRequest $request
     *
     * @return JsonResponse
     */
    public function issueToken(IssueTokenRequest $request)
    {
        try {
            if (AuthFacade::check()) {
                return ResponderFacade::youShouldBeGuest();
            }

            $mobile = $request->mobile;


            if (!UserProviderFacade::exist($mobile)) {
                return ResponderFacade::userNotExist();
            }

            if (UserProviderFacade::isBanned($mobile)) {
                return ResponderFacade::userIsBanned();
            }

            $token = TokenGeneratorFacade::generateToken();


            TokenStoreFacade::store($mobile, $token);


            TokenSenderFacade::send($mobile, $token);

            return ResponderFacade::tokenSend();
        } catch (Exception $exception) {

            ResponderFacade::sendServerError($$exception->message)->throwResponse();
        }
    }

    /**
     * login user
     *
     * @param UserLoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        try {
            $code = $request->code;

            if (!$token = TokenStoreFacade::getCodeByToken($code)) {
                return ResponderFacade::codeIsInvalid();
            }
            $user = UserProviderFacade::getUserWithMobile($token);

            AuthFacade::loginUsingId($user->id);

            $token = UserProviderFacade::UpdateApiToken($user);

            return ResponderFacade::loggedIn($token, $user->role);
        } catch (Exception $exception) {

            ResponderFacade::sendServerError($$exception->message)->throwResponse();
        }
    }
}
