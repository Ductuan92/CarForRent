<?php

namespace MyApp\Transfer;

use MyApp\model\Car;

class CarTransfer implements TransferInterface
{
    private int $id;
    private string $brand;
    private string $price;
    private string $description;
    private string $image;

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return void
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @param array $param
     * @return TransferInterface
     */
    public function fromArray(array $param): TransferInterface
    {
        $this->brand = $param['brand'] ?? null;
        $this->price = $param['price'] ?? null;
        $this->description = $param['description'] ?? null;
        $this->image = $param['image'] ?? null;

        return $this;
    }

    /**
     * @param Car $car
     * @param $dir
     * @return array
     */
    public function toArray(Car $car, $dir): array
    {
        return [
            'id' => $car->getId(),
            'brand' => $car->getBrand(),
            'price' => $car->getPrice(),
            'description' => $car->getDescription(),
            'image' => $dir . $car->getImage(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

}
