<?php

// =============================================================
// 3.5. Öröklődés
// =============================================================


// --- 3.24. A self:: és static:: különbsége -------------------
class Model
{
    protected static string $table = 'models';

    public static function tableWithSelf(): string
    {
        return self::$table;
    }

    public static function tableWithStatic(): string
    {
        return static::$table;
    }
}

class Student extends Model
{
    protected static string $table = 'students';
}

echo Student::tableWithSelf();    // models
echo Student::tableWithStatic();  // students
