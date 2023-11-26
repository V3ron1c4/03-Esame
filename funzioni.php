<?php
namespace Classi;

class Functions
{
    /**
     * Funzione per estrarre dal $_POST o dal $_GET la proprietà richiesta
     */
    public static function richiestaHTTP($str)
    {
        $rit = null;
        if ($str !== null) {
            if (isset($_POST[$str])) {
                $rit = $_POST[$str];
            } elseif (isset($_GET[$str])) {
                $rit = $_GET[$str];
            }
        }
        return $rit;
    }
    //---------------------------------------------------------------------

    /**
     * Funzione per controllare se una stringa sta all'interno di un range
     */
    public static function controllaRangeStringa($stringa, $min = null, $max = null)
    {
        $rit = 0;
        $n = strlen($stringa);
        if ($min != null && $n < $min) {
            $rit++;
        }
        if ($max != null && $n > $max) {
            $rit++;
        }
        return ($rit == 0);
    }
    //---------------------------------------------------------------------

    /**
     * Funzione per scrivere del testo in un file
     */
    public static function scriviTesto($file, $str, $commenta = false)
    {
        $rit = false;
        if (file_exists($file)) {
            if (is_file($file)) {
                if (file_put_contents($file, $str, FILE_APPEND)) {
                    if ($commenta) echo "<br><h3>Modulo inviato correttamente.</h3>";
                    $rit = true;
                } else {
                    echo "<br><h3>Qualcosa è andato storto.</h3><br>";
                }
            } else {
                echo "<br>Questo path '$file' non è un file.<br>";
            }
        } else {
            echo "<br>Questo path'$file' non esiste.<br>";
        }
        return $rit;
    }
    //---------------------------------------------------------------------
}
