<?php


namespace App\Traits;


trait General
{
    public function uploadFile($image,$title,$path){
        $name = time() . '-' . $title . '.' . $image->extension();
        $image->move(public_path($path),$name);
        return $name;
    }

    /**
     * convert from ml to liter
     * @param $value
     * @return float|int
     */
    public function convertToLiter($value)
    {
        $result = $value / 1000;
        return $result;
    }


}
