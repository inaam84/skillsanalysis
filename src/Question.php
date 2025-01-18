<?php
declare(strict_types = 1);

namespace src;

use InvalidArgumentException;

class Question
{
    private int $id;
    private string $text;
    private int $score;
    private float $deliveryHours;

    public function __construct(int $id, string $text, float $deliveryHours, int $score = 0)
    {
        $this->id = $id;
        $this->text = $text;
        $this->deliveryHours = $deliveryHours;
        $this->setScore($score);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        if($score < 1 || $score > 5)
        {
            throw new InvalidArgumentException('Score must be between 1 and 5');
        }

        $this->score = $score;
    }

    public function getFullDeliveryHours(): float
    {
        return $this->deliveryHours;
    }

    public function setDeliveryHours(int $deliveryHours): void
    {
        $this->deliveryHours = $deliveryHours;
    }
}