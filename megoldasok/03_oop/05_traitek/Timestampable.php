<?php

trait Timestampable
{
    private ?DateTime $createdAt = null;
    private ?DateTime $updatedAt = null;

    public function initTimestamps(): void
    {
        $this->createdAt = new DateTime();
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt?->format("Y-m-d H:i:s");
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt?->format("Y-m-d H:i:s");
    }
}
