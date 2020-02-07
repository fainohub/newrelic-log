<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Validate;

use JsonSchema\Validator;

abstract class ValidateRoot
{
    protected static function validate($data, $validateSchema)
    {
        $validator = self::validator($data, $validateSchema);

        if (!$validator->isValid()) {
            $errors = ['JSON does not validate. Violations'];
            foreach ($validator->getErrors() as $error) {
                $message = $validateSchema['properties'][$error['property']]['messageError'] ?? $error['message'];
                $errors[] = sprintf("[%s] %s", $error['property'], $message);
            }

            throw new \Exception(json_encode($errors));
        }

        return true;
    }

    protected static function formValidate($data, $validateSchema)
    {
        $errors = [];

        $validator = self::validator($data, $validateSchema);

        if (!$validator->isValid()) {

            foreach ($validator->getErrors() as $error) {
                $message = $validateSchema['properties'][$error['property']]['messageError'] ?? $error['message'];
                $errors[$error['property']] = $message;
            }
        }

        return $errors;
    }

    private static function validator($data, $validateSchema)
    {
        if (is_array($data)) {
            if (!count($data)) {
                $data = new \stdClass();
            } else {
                $data = json_decode(json_encode($data), false);
            }
        }

        $validator = new Validator;
        $validator->check($data, $validateSchema);

        return $validator;
    }
}