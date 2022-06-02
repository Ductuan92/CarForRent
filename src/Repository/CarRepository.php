<?php

namespace MyApp\Repository;

use MyApp\Database\Database;
use MyApp\model\Car;
use MyApp\Transfer\CarTransfer;
use PDO;

class CarRepository
{
    private Car $car;
    private ?PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct()
    {
        $this->connection = Database::databaseConnection();
    }

    public function getAllCar(): array
    {
        $statement = $this->connection->prepare("SELECT * FROM cars");
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cars = [];
        foreach ($rows as $row){
            array_push($cars, $this->setCar($row));
        }
        return $cars;
    }

    public function searchById($id): Car|null
    {
        $statement = $this->connection->prepare("SELECT * FROM cars WHERE id = ? ");
        $statement->execute([$id]);
        $row = $statement->fetch();
        $statement->closeCursor();

        if($row){
            return $this->setCar($row);
        }
        return null;
    }

    public function createCar(CarTransfer $car): array
    {
        $statement = $this->connection->prepare("INSERT INTO cars (brand, price, description, image) VALUES (?, ?, ?, ?)");
        $result = $statement->execute([$car->getBrand(), $car->getPrice(), $car->getDescription(), $car->getImage()]);
        $this->connection = null;
        if ($result != TRUE) {
            return ["error" => $statement . "<br>" . $this->connection->errorCode()];
        }
        return [];
    }

    private function setCar($row):Car
    {
        $car = new Car();
        $car->setId($row['id']);
        $car->setPrice($row['price']);
        $car->setBrand($row['brand']);
        $car->setDescription($row['description']);
        $car->setImage($row['image']);
        return $car;
    }
}
