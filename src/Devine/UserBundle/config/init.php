<?php

// module.php -
// By Anton Van Eechaute

// set user
$response->setData(array('user' => $request->get('user')));

// remember me
if (null === $request->get('user') && array_key_exists('remember_me', $_COOKIE)) {
    $key = $_COOKIE['remember_me'];

    if (64 === strlen($key)) {
        $rep = new Devine\UserBundle\Repository\UsersRepository;
        $user = $rep->getUserByRememberMe($key);
        if (false !== $user) {
            $request->set('user', $user);
            header('Location: ' . $request->getFullUrl());
        }
    }
}

// slots
$response->addSlot('userpanel', 'userpanel_slot');

$request->set('loggedInEvent', false);
$request->set('loggedOutEvent', false);
