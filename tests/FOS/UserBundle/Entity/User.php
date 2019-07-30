<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
namespace FOS\UserBundle\Entity;

use FOS\UserBundle\Model\User as AbstractUser;

abstract class User extends AbstractUser
{
}