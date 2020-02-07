<?php
/**
 * @file
 * Contains App\Twig\Extensions\ElementError.
 */

namespace App\Infrastructure\Container\Application\Twig\Extensions;

use App\Infrastructure\Container\Application\Utils\Auth\SystemAcl;

/**
 * Class IsAllowed
 * @package App\Infrastructure\Container\Application\Twig\Extensions
 */
class IsAllowed extends \Twig_Extension
{
    /** @var array */
    private $roles;

    /** @var SystemAcl */
    private $acl;

    public function __construct(array $roles, SystemAcl $acl)
    {
        $this->roles = $roles;
        $this->acl = $acl;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('isAllowed', [$this, 'isAllowed']),
        ];
    }

    /**
     * @param $resource
     * @return bool
     */
    public function isAllowed($resource)
    {
        foreach ($this->roles as $role) {
            if ($this->acl->isAllowed($role, $resource)) {
                return true;
            }
        }

        return false;
    }
}
