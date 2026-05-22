<?php

class Student
{
    private array $courses = [];

    public function __construct(
        private string $id,
        private string $name
    ) {}

    public function enroll(string $course): void
    {
        $this->courses[] = $course;
    }

    public function getInfo(): string
    {
        $courseList = empty($this->courses)
            ? "nincs felvett kurzus"
            : implode(", ", $this->courses);

        return "[$this->id] $this->name – kurzusok: $courseList";
    }
}
