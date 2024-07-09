<?php

namespace App\Utils;

abstract class CNPJUtils
{
    public static function mask(string $cnpj)
    {
        return vsprintf("%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s", str_split($cnpj));
    }

    public static function removeNonAlphaNumericFromString($cnpj)
    {
        return preg_replace('/[^\da-zA-Z]/', '', $cnpj);
    }
    public static function validateCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $soma = 0;
        for ($i = 0, $j = 5; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        $dv1 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[12] != $dv1) {
            return false;
        }

        $soma = 0;
        for ($i = 0, $j = 6; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        $dv2 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[13] != $dv2) {
            return false;
        }

        return true;
    }
}
