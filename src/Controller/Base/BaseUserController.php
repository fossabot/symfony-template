<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Base;

use App\Entity\Traits\UserTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class BaseUserController extends BaseFormController
{
    /**
     * @param Request $request
     * @param UserInterface $user
     */
    protected function loginUser(Request $request, UserInterface $user)
    {
        //login programmatically
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);
    }

    /**
     * @param UserTrait|UserInterface $user
     * @return bool
     */
    protected function setNewPasswordIfValid(UserInterface $user)
    {
        if ($user->getPlainPassword() !== $user->getRepeatPlainPassword()) {
            $this->displayError($this->getTranslator()->trans('error.passwords_do_not_match', [], 'trait_user'));
            return false;
        }

        if (strlen($user->getPlainPassword()) < 8) {
            $this->displayError($this->getTranslator()->trans('error.password_needs_at_least_8_chars', [], 'trait_user'));
            return false;
        }

        $user->setPassword();

        return true;
    }
}