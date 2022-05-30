<?php

namespace MyApp\Repository;

use MyApp\model\Car;
use PDO;

class CarRepository
{
    private Car $car;
    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
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

    public function createCar($id, $brand, $price, $description, $date)
    {
        $statement = $this->connection->prepare("INSERT INTO cars (id, brand, price, description, date) VALUES ?");
        $statement->execute([$id, $brand, $price, $description, $date]);
        if ($this->connection->query($statement) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $statement . "<br>" . $this->connection->error;
        }

        $this->connection->close();
    }

    private function setCar($row):Car
    {
        $car = new Car();
        $car->setId($row['id']);
        $car->setPrice($row['price']);
        $car->setBrand($row['brand']);
        $car->setDescription($row['description']);
        $car->setDate($row['date']);
        return $car;
    }
}
