<?php

namespace App\Imports;

use App\Models\Formdata;
use Maatwebsite\Excel\Concerns\ToModel;
use \PhpOffice\PhpSpreadsheet\Shared\Date;


class FormDataImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $excelDate = $row[6];
        $properDateTime = null;
        if (is_numeric($excelDate)) {
            $properDateTime = Date::excelToDateTimeObject($excelDate)->format('Y-m-d H:i:s');
        } else {
            $properDateTime = $excelDate;
        }
        // dd($row);
        return new Formdata([
            'id' => $row[0],
            'Name' => $row[1],
            'Password' => $row[2],
            'Email' => $row[3],
            'Image' => $row[4],
            'Mobile' => $row[5],
            'Date' =>$properDateTime,
            'Role' => $row[7],
            'updated_at' => $row[8],
            'created_at' => $row[9],
        ]);
    }

}
