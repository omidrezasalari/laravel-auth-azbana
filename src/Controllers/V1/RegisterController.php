<?php

namespace Authenticate\Controllers\V1;

use App\Http\Controllers\Controller;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Facades\TokenGeneratorFacade;
use Authenticate\Facades\TokenSaverFacade;
use Authenticate\Facades\TokenSenderFacade;
use Authenticate\Facades\TokenStoreFacade;
use Authenticate\Facades\UserProviderFacade;
use Authenticate\Requests\CheckCodeRequest;
use Authenticate\Requests\CheckUsernameRequest;
use Authenticate\Requests\IssueTokenRequest;
use Authenticate\Requests\UserRegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
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
            $mobile = $request->mobile;
            if (UserProviderFacade::exist($mobile)) {
                return ResponderFacade::userExist();
            }

            $token = TokenGeneratorFacade::generateToken();
            TokenStoreFacade::store($mobile, $token);
            TokenSenderFacade::send($mobile, $token);

            return ResponderFacade::tokenSend();

        } catch (Exception $exception) {

            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }

    }

    /**
     * Check the code sent to the user.
     *
     * @param CheckCodeRequest $request
     *
     * @return JsonResponse
     */
    public function checkCodeIsValid(CheckCodeRequest $request)
    {
        try {
            $code = $request->code;

            if (!TokenStoreFacade::getCodeByToken($code)) {
                return ResponderFacade::codeIsInvalid();
            }
            return ResponderFacade::codeIsValid();

        } catch (Exception $exception) {
            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }
    }

    /**
     * Check the user name when registering that has not been registered before
     *
     * @param CheckUsernameRequest $request
     *
     * @return JsonResponse
     */
    public function checkUsernameIsValid(CheckUsernameRequest $request)
    {
        try {
            $username = str_replace(" ", "_", $request['username']);
            if (UserProviderFacade::checkUsernameExist($username)) {
                return ResponderFacade::usernameIsExist();
            }

            return ResponderFacade::usernameIsValid();

        } catch (Exception $exception) {

            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }
    }

    /**
     * Register new user
     *
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $userRegistered = UserProviderFacade::create($request->all());

            return ResponderFacade::userRegistered($userRegistered);

        } catch (Exception $exception) {

            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }

    }
}
