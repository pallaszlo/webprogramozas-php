<?php

class PasswordValidator
{
    /**
     * Ellenőrzi, hogy a jelszó megfelel-e az erősségi követelményeknek.
     *
     * Feltételek:
     *  – minimum 8 karakter (karakterben, nem bájtban mérve)
     *  – legalább egy nagybetű (az ékezetesek is, pl. Á)
     *  – legalább egy számjegy
     *  – legalább egy speciális karakter (nem betű és nem szám)
     */
    public function validate(string $password): bool
    {
        // mb_strlen: karaktereket számol, nem bájtokat (ékezetes betűk)
        if (mb_strlen($password) < 8) {
            return false;
        }

        // \p{Lu}: bármely nagybetű, az ékezetesek is (Á, É, Ő ...)
        if (!preg_match('/\p{Lu}/u', $password)) {
            return false;
        }

        if (!preg_match('/\p{N}/u', $password)) {
            return false;
        }

        // speciális: se betű, se szám (az ékezetes betű nem speciális karakter)
        if (!preg_match('/[^\p{L}\p{N}]/u', $password)) {
            return false;
        }

        return true;
    }
}
