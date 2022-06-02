<?php

namespace MyApp\Transfer;

interface TransferInterface
{
    public function fromArray(array $param): TransferInterface;
}
