<?php

namespace Authenticate\Facades;

use Authenticate\User;
use Illuminate\Http\JsonResponse;

class VueResponder
{
    const HTTP_SUCCESS_CODE = 200;
    const HTTP_CLIENT_ERROR_CODE = 400;
    const HTTP_SERVER_ERROR_CODE = 500;

    const ERROR_KEYS = ['status', 'developerMessage', 'userMessage', 'errorCode', 'moreInfo'];

    /**
     * Create message For send error
     *
     * @param string $developerMessage Message for developers to use for debugging.
     * @param string $userMessage message for presentation layer.
     * @param integer $status request status
     * @param integer $erroCode contract code between front and backend to write error document.
     *
     * @return array
     */
    private function createErrorMessage(
        $developerMessage,
        $userMessage,
        $status = self::HTTP_CLIENT_ERROR_CODE,
        $erroCode = self::HTTP_CLIENT_ERROR_CODE
    ): array {

        return array_combine(
            Self::ERROR_KEYS,
            [$status, $developerMessage, $userMessage, $erroCode, null]
        );
    }

    /**
     * Send a response that user does  exist
     *
     * @return JsonResponse
     */
    public function userExist(): JsonResponse
    {

        $message = $this->createErrorMessage(
            __('authService::server-error.user-exist'),
            __('authService::client-error.user-exist')
        );
        return response()->json($message);
    }

    /**
     * Send a response that user does not exist
     *
     * @return JsonResponse
     */
    public function userNotExist(): JsonResponse
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.user-not-exist'),
            __('authService::client-error.user-not-exist')
        );
        return response()->json($message);
    }

    /**
     * Send user registerd information
     *
     * @param User $data user mobile number.
     *
     * @return JsonResponse
     */
    public function userRegistered(User $data): JsonResponse
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => $data
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    /**
     * Send user information
     *
     * @param array|User $data user mobile number.
     *
     * @return JsonResponse
     */
    public function user(User $data): JsonResponse
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => $data
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function userIsBanned()
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.user-is-banned'),
            __('authService::client-error.user-is-banned')
        );
        return response()->json($message);
    }

    public function codeIsInvalid()
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.code-is-invalid'),
            __('authService::client-error.code-is-invalid')
        );
        return response()->json($message);
    }

    public function usernameIsExist()
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.username-is-exist'),
            __('authService::client-error.username-is-exist')
        );
        return response()->json($message);
    }


    /**
     * send token to user
     */
    public function tokenSend()
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => __('authService::message.token-send')
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function logout()
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => __('authService::message.logout')
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function codeIsValid()
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => __('authService::message.code-is-valid'), 'is-valid' => true
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function usernameIsValid()
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'message' => __('authService::message.username-is-valid'), 'is-valid' => true
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function youShouldBeGuest()
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.user-loggedIn'),
            __('authService::client-error.user-should-be-guest')
        );
        return response()->json($message);
    }

    /**
     * User logged in response
     *
     *
     * @param string $token
     * @return JsonResponse
     */
    public function loggedIn(string $token, string $role)
    {

        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE, 'api_token' => $token, 'role' => $role,
                'message' => __('authService::message.user-logged-in')
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    /**
     * Send an error when a server error  occurs
     *
     * @param string $errorMessage the error message that sends to the developer
     *
     * @return JsonResponse
     */
    public function sendServerError($errorMessage)
    {
        $message = $this->createErrorMessage(
            $errorMessage,
            __('authService::client-error.error-occurred'),
            self::HTTP_SERVER_ERROR_CODE,
            self::HTTP_SERVER_ERROR_CODE
        );
        return response()->json($message);
    }
}
