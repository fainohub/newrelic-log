<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

final class Geo
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function grausToDecimal()
    {
        $re = '/[a-zA-Z]/';
        preg_match($re, $this->value, $matches);
        $pontoCardeal = $this->verifyPontoCardeal(reset($matches));

        $hora = preg_replace('/[^0-9:\.]/i', '', $this->value);
        $hora = explode(':', $hora);

        return ($hora[0] + $hora[1] / 60 + $hora[2] / 3600) * $pontoCardeal;
    }

    private function verifyPontoCardeal($ponto)
    {
        $pontos = ['n' => 1, 's' => -1, 'l' => 1, 'o' => -1];
        return $pontos[strtolower($ponto)];
    }
}
