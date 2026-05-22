<?php

class PasswordValidator
{
    /**
     * Ellenőrzi, hogy a jelszó megfelel-e az erősségi követelményeknek.
     *
     * Feltételek:
     *  – minimum 8 karakter
     *  – legalább egy nagybetű (A–Z)
     *  – legalább egy szám (0–9)
     *  – legalább egy speciális karakter (nem betű és nem szám)
     */
    public function validate(string $password): bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }

        return true;
    }
}
