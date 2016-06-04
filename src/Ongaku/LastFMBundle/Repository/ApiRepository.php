<?php

// UsersRepository.php -
// By Anton Van Eechaute

namespace Ongaku\LastFMBundle\Repository;

use Devine\Framework\SingletonPDO;
use Ongaku\LastFMBundle\Model\ApiCache;

class ApiRepository
{
    /**
     * @var PDO ¬†
     */
    private $dbh;

    /**
     * Initializes a products repository ¬†
     */
    public function __construct()
    {
        $this->dbh = SingletonPDO::getInstance();
    }

    /**
     * @param $key
     * @return \Ongaku\LastFMBundle\Model\ApiCache
     * @throws \Exception
     */
    public function getRow($key)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM api_cache WHERE `key` = :key");
        $stmt->execute(array('key' => $key));
        $data = $stmt->fetch();

        if (1 === $stmt->rowCount()) {
            return new ApiCache($data['key'], $data['data'], $data['created']);
        }

        throw new \Exception('Row with key \'' . $key . '\' doesn\'t exist in cache (yet).');
    }

    /**
     * @param $key
     * @return bool
     */
    public function deleteIfOld($key)
    {
        $stmt = $this->dbh->prepare("DELETE FROM api_cache WHERE `key` = :key AND DATEDIFF(NOW(), created) > 0");
        $stmt->execute(array('key' => $key));

        if (1 === $stmt->rowCount()) {
            return true;
        }

        return false;
    }

    /**
     * @param \Ongaku\LastFMBundle\Model\ApiCache $row
     * @return bool
     * @throws \Exception
     */
    public function saveRow(ApiCache $row)
    {
        $this->deleteIfOld($row->getKey());

        $stmt = $this->dbh->prepare("INSERT INTO api_cache (`key`,`data`,created)
                                     VALUES (:key, :data, NOW())");

        $data = array('key' => $row->getKey(),
                      'data' => $row->getData());

        $stmt->execute($data);

        if (1 === $stmt->rowCount()) {
            return true;
        } else {
            throw new \Exception('Couldn\'t save ApiCache row to database');
        }
    }
}
