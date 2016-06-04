<?php

// Product.php -
// By Anton Van Eechaute

namespace Devine\UserBundle\Model;

class User
{
    /**
     * @var int  
     */
    private $id;

    /**
     * @var string  
     */

    private $username;

    /**
     * @var string  
     */
    private $email;

    /**
     * @var string  
     */
    private $first_name;

    /**
     * @var string  
     */
    private $last_name;

    /**
     * @var string  
     */
    private $lastfm;

    /**
     * @var DateTime  
     */
    private $date_created;

    /**
     * @var string  
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * Initializes an User object
     * @param integer $id
     * @param string $username
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @param DateTime $date_created
     * @param string $password
     * @param string $salt  
     */
    public function __construct($id, $username, $email, $first_name, $last_name, $date_created, $lastfm, $password = null, $salt = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->date_created = $date_created;
        $this->password = $password;
        $this->salt = $salt;
        $this->lastfm = $lastfm;
    }

    /**
     * @return integer  
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id  
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param type string
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email  
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string  
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name  
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string  
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name  
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string  
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param string $date_created  
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return string  
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password  
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string  
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt  
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param string $lastfm
     */
    public function setLastfm($lastfm)
    {
        $this->lastfm = $lastfm;
    }

    /**
     * @return string
     */
    public function getLastfm()
    {
        return $this->lastfm;
    }
}
