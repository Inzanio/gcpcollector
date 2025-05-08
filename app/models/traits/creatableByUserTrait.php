<?php
namespace App\Models\Traits;

trait CreatableByUserTrait
{
    protected string $idCreator;

    public function getIdCreator(): string
    {
        return $this->idCreator;
    }

    public function setIdCreator(string $idCreator): self
    {
        $this->idCreator = $idCreator;
        return $this;
    }

}
