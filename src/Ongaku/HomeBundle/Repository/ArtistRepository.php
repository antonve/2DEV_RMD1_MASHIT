<?php

// UsersRepository.php -
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Repository;

use Devine\Framework\SingletonPDO;
use Ongaku\HomeBundle\Model\Artist;

class ArtistRepository
{
    /**
     * @var PDO ¬†
     */
    private $dbh;

    public function __construct()
    {
        $this->dbh = SingletonPDO::getInstance();
    }

    public function getArtist($name)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM artists WHERE name = :name");
        $stmt->execute(array('name' => $name));
        $data = $stmt->fetch();

        if (1 === $stmt->rowCount()) {
            return new Artist($data['id'], $data['name'], $data['summary'], $data['bio'], $data['listeners'], $data['yearformed'], $data['placeformed']);
        }

        throw new \Exception('Artist with name \'' . $name . '\' wasn\'t found.');
    }

    public function getImagesByArtist($id)
    {
        $stmt = $this->dbh->prepare("SELECT filename FROM artist_images WHERE artist_id = :id");
        $stmt->execute(array('id' => $id));
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function saveArtistImages($images, $artist_id)
    {
        $stmt = $this->dbh->prepare("INSERT INTO artist_images (artist_id, filename)
                                     VALUES (:artist_id, :filename)");

        foreach ($images as $image) {
            $stmt->execute(array('artist_id' => $artist_id, 'filename' => $image['filename']));
        }
    }

    public function saveArtist(Artist $artist)
    {
        $stmt = $this->dbh->prepare("INSERT INTO artists (`name`,summary,bio,listeners,placeformed,yearformed,date_created,date_updated)
                                     VALUES (:name,:summary,:bio,:listeners,:placeformed,:yearformed,NOW(),NOW())");

        $data = array('name' => $artist->getName(),
                      'summary' => $artist->getSummary(),
                      'bio' => $artist->getBio(),
                      'listeners' => $artist->getListeners(),
                      'placeformed' => $artist->getPlaceformed(),
                      'yearformed' => $artist->getYearformed());

        $stmt->execute($data);

        if (1 === $stmt->rowCount()) {
            $artist->setId($this->dbh->lastInsertId());
            return $artist;
        } else {
            throw new \Exception('Couldn\'t save Artist to database');
        }
    }
}
