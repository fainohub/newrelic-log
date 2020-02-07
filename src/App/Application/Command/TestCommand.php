<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Infrastructure\Container\Application\Utils\Command\CommandInterface;
use App\Infrastructure\Container\Application\Utils\Validate\ValidateRoot;


class TestCommand extends ValidateRoot implements CommandInterface
{
    /** @var string */
    private $name;

    /**
     * TestCommand constructor.
     * @param $name
     */
    public function __construct(
        $name
    ) {
        $this->name = $name;
    }

    /**
     * @param array $data
     * @return TestCommand
     * @throws \Exception
     */
    public static function fromArray($data)
    {
        $validateSchema = [
            'type' => 'object',
            'properties' => [
                'name' => [
                    'type' => 'string',
                    "minLength" => 15
                ]
            ]
        ];

        parent::validate($data, $validateSchema);

        return new self(
            $data->name
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function toArray(): array
    {
        return [
            'name'  => $this->name
        ];
    }
}
