<?php
declare(strict_types=1);

namespace App\Http\Action;

use App\Application\Helper\EnvironmentHelper;
use App\Application\Helper\ResponseHelper;
use Zend\Diactoros\Response\JsonResponse;

class AbstractAction
{
    private const SUCCESS = true;
    private const ERROR = false;

    /**
     * @param $isException
     * @param null $exception
     * @return int
     */
    private function getCodeException($isException, $exception = null): int
    {
        if (!$isException) {
            return 400;
        }

        return $exception->getCode() ?: 500;
    }

    /**
     * @param string $message
     * @param null $detailed
     * @return string
     */
    private function getResponseMessage(string $message, $detailed = null) : string
    {
        $isException = ($detailed instanceof \Exception || $detailed instanceof \Throwable);

        if (null !== $detailed && EnvironmentHelper::isProduction() === false) {
            $message = $isException
                ? sprintf(
                    '%s. Line %s. File %s',
                    $detailed->getMessage(),
                    $detailed->getLine(),
                    $detailed->getFile()
                )
                : $message;
        }

        return $message;
    }

    /**
     * @param string $message
     * @param null $detailed
     * @return JsonResponse
     */
    protected function methodBadRequest($message = 'Bad request', $detailed = null): JsonResponse
    {
        return $this->jsonResponse(self::ERROR, ResponseHelper::HTTP_BAD_REQUEST, $this->getResponseMessage($message, $detailed));
    }

    /**
     * @param string $message
     * @param null $detailed
     * @return JsonResponse
     */
    protected function methodNotAllowed($message = 'Method not allowed', $detailed = null): JsonResponse
    {
        return $this->jsonResponse(self::ERROR, ResponseHelper::HTTP_METHOD_NOT_ALLOWED, $this->getResponseMessage($message, $detailed));
    }

    /**
     * @param string $message
     * @param null $detailed
     * @return JsonResponse
     */
    protected function methodUnprocessableEntity($message = 'Unprocessable entity', $detailed = null): JsonResponse
    {
        return $this->jsonResponse(self::ERROR, ResponseHelper::HTTP_UNPROCESSABLE_ENTITY, $this->getResponseMessage($message, $detailed));
    }

    /**
     * @param string $message
     * @param array $result
     * @return JsonResponse
     */
    protected function methodOk($message = 'OK', $result = []): JsonResponse
    {
        return $this->jsonResponse(self::SUCCESS, ResponseHelper::HTTP_OK, $this->getResponseMessage($message), $result);
    }

    /**
     * @param bool $status
     * @param int $statusCode
     * @param string|null $message
     * @param array|null $result
     * @return JsonResponse
     */
    protected function jsonResponse(bool $status, int $statusCode, string $message = null, array $result = null): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
                'result' => $result,
            ],
            $statusCode
        );
    }
}
