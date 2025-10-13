<?php

namespace App\Interface;

interface StockableInterface 
{
    public function addStock(int $stock): self;
    public function removeStock(int $stock): self;
}