<?php

// UserController.php - General controller
// By Anton Van Eechaute

namespace Devine\UserBundle\Controller;

use Devine\UserBundle\Repository\UsersRepository;
use Devine\Framework\BaseController;
use Devine\UserBundle\Model\User;
use Devine\Framework\Validation;

class UserController extends BaseController
{
    public function registerAction()
    {
        $request = $this->getRequest();
        $data = $request->getPOST('register');

        // redirect to profile if logged in
        if ($request->get('user')) {
            $this->redirect('/user/profile');
        }

        // pass data to the template so they don't have to type it again (if they provided it)
        $this->add('reg_username', $data['username']);
        $this->add('reg_email', $data['email']);
        $this->add('reg_lastfm', $data['lastfm']);

        // initiate attempt to register an user if the form is submitted
        if ($request->isPOST()) {
            $rep = new UsersRepository();

            if (!$this->validateUser($rep, $data)) {
                // save user to the database
                $user = new User(null, $data['username'], $data['email'], '', '', $data['lastfm'], null, $data['password'], $this->generateSalt());
                $user = $rep->saveUser($user);

                // remove password & salt from object for extra security
                $user->setPassword(null);
                $user->setSalt(null);

                // log in the user
                $request->set('user', $user);

                // redirect to home
                $this->redirect('/');
            }
        }

        $this->setTemplate('register_form');
    }

    public function loginAction()
    {
        $request = $this->getRequest();

        // redirect to profile if logged in
        if ($request->get('user')) {
            $this->redirect('/user/profile');
        }

        // process login
        if ($request->isPOST()) {
            $rep = new UsersRepository();
            $user = $rep->checkLogin($request->getPOST('email'), $request->getPOST('password'));

            // proceed if user is found otherwise show error
            if (false !== $user) {
                $request->set('user', $user);

                // process remember me
                if ($request->getPOST('remember_me')) {
                    $salt = $this->generateSalt(64);
                    $rep->addRememberMe($salt, $user->getId());
                    setcookie('remember_me', $salt, time()+4320000);
                }
                $request->set('loggedInEvent', true);
                $this->redirect('/');
            } else {
                $this->add('error_login', 'No user found with this email and password combination.');
            }
        }

        $this->setTemplate('login_form');
    }

    public function logoutAction()
    {
        $request = $this->getRequest();

        if ($request->get('user')) {
            $request->set('user', null);
            setcookie('remember_me', '', time()-4320000);
            $request->set('loggedOutEvent', true);
            $this->redirect('/');
        } else {
            $this->forward404();
        }
    }

    public function resetAction()
    {
        //TODO: finish this
        $request = $this->getRequest();

        if ($request->get('user')) {
            $this->forward404();
        }

        if ($request->isPOST()) {
            $rep = new UsersRepository();

            // proceed if user is found otherwise show error
            try {
                $secret = $rep->createNewReset($request->getPOST('email'));

                $body = <<<EOF
Hello,

Someone has requested a password reset for your account on Ongaku. (hopefully that's you). Please click <a href="http://{$_SERVER['SERVER_NAME']}/index.php/user/reset/confirm/{$secret}">this link</a> to confirm your password reset. If the link doesn't work, please copy paste the link below into your browser. <br />

<span style="background: #e55a57; color: #ffffff; padding: 3px;">http://{$_SERVER['SERVER_NAME']}/index.php/user/reset/confirm/{$secret}</span> <br />

If you didn't request this password reset, you don't have to do anything and it will expire in 24 hours.
EOF;
                $smarty = $this->getSmarty();
                $smarty->assign('subject', 'Your password reset on Ongaku');
                $smarty->assign('body', $body);

                $body = $smarty->fetch('mail.tpl');

                // @TODO: Should extract these values to a config file
                $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'tls')
                                            ->setUsername('hello@example.com')
                                            ->setPassword('example');
                $mailer = \Swift_Mailer::newInstance($transport);

                $message = \Swift_Message::newInstance()
                    ->setSubject('Your password reset on Ongaku')
                    ->setFrom(array('hello@example.com' => 'Ongaku'))
                    ->setTo(array($request->getPOST('email')))
                    ->setBody($body);

                $logger = new \Swift_Plugins_Loggers_ArrayLogger();
                $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));

                $mailer->send($message);
                trace($logger->dump());
                //$this->redirect('/user/reset/sent');
            } catch(\Exception $e) {
                $this->add('error_reset', 'No user found with this email.');
            }
        }

        $this->setTemplate('reset');
    }

    public function profileAction()
    {
        $request = $this->getRequest();
        $user = $request->get('user');
        $data = $request->getPOST('profile');

        if ($user) {

            $this->add('profile_username', $user->getUsername());
            $this->add('profile_email', $user->getEmail());
            $this->add('profile_firstname', $user->getFirstName());
            $this->add('profile_lastname', $user->getLastName());

            if ($request->isPOST()) {
                $rep = new UsersRepository();

                $this->add('profile_username', $data['username']);
                $this->add('profile_email', $data['email']);
                $this->add('profile_firstname', $data['firstname']);
                $this->add('profile_lastname', $data['lastname']);

                if (!$this->validateUser($rep, $data, true)) {

                    $user->setUsername($data['username']);
                    $user->setFirstName($data['firstname']);
                    $user->setLastName($data['lastname']);
                    $user->setEmail($data['email']);

                    if ('' != $data['password']) {
                        $user->setPassword($data['password']);
                        $user->setSalt($this->generateSalt());
                    }

                    // save user to the database
                    $user = $rep->saveUser($user);

                    // remove password & salt from object for extra security
                    $user->setPassword(null);
                    $user->setSalt(null);

                    // log in the user
                    $request->set('user', $user);

                    // redirect to home
                    $this->redirect('/user/profile');
                }
            }

            $this->setTemplate('profile_form');

        } else {
            $this->forward404();
        }
    }

    private function validateUser($rep, $data, $check_old_pw = false)
    {
        $lfm = $this->sget('lastfm');
        $error = false;

        // validate user
        if ((!Validation::isMin($data['username'], 3)) || (!Validation::isMax($data['username'], 15)) || (!Validation::isAlpha($data['username']))) {
            $error = true;
            $this->add('error_username', 'Must be at least 3, and at most 15 characters long and be alphanumeric.');
        } elseif((null === $this->getRequest()->get('user') || $data['username'] !== $this->getRequest()->get('user')->getUsername()) && !$rep->isUsernameAvailable($data['username'])) {
            $error = true;
            $this->add('error_username', 'Username already used.');
        }
        if (!Validation::isEmail($data['email'])) {
            $error = true;
            $this->add('error_email', 'Must be a valid email.');
        }
        if (($check_old_pw && ('' != $data['password'] && !Validation::isMin($data['password'], 6))) || (!$check_old_pw && !Validation::isMin($data['password'], 6))) {
            $error = true;
            $this->add('error_password', 'Must be at least 6 characters long.');
        }
        if ('' != $data['password'] && $data['password'] !== $data['password2']) {
            $error = true;
            $this->add('error_password2', 'The passwords are not the same.');
        }
        if ($check_old_pw && !$rep->checkPassword($this->getRequest()->get('user')->getUsername(), $data['old_password'])) {
            $error = true;
            $this->add('error_old_password', 'Old password is incorrect.');
        }
        if (!$lfm->isUsernameValid($data['lastfm'])) {
            $error = true;
            $this->add('error_lastfm', 'There is no Last.FM account with this username');
        }

        return $error;
    }

    /**
     * Generates a salt of the given length
     * @param integer $len
     * @return string ¬†
     */
    private function generateSalt($len = 15)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+';
        $return = '';
        $totalChars = strlen($chars) - 1;

        if ($len <= 0) {
            for ($i = 0; $i < $len; ++$i) {
                $return .= $chars[rand(0, $totalChars)];
            }
        }

        return $return;
    }
}
