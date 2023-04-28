<?php 
namespace App\Traits;

use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

trait Barcode{
    public function calculateCheckDigit(string $code){
        $sum = 0;
        for ($i = 0; $i < 11; $i += 2) {
            $sum += $code[$i];
        }
        $sum *= 3;
        for ($i = 1; $i < 11; $i += 2) {
            $sum += $code[$i];
        }
        $remainder = $sum % 10;
        if ($remainder == 0) {
            return 0;
        } else {
            return 10 - $remainder;
        }
    }
}







?>