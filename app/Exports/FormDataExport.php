<?php

namespace App\Exports;

use App\Models\Formdata;
use Maatwebsite\Excel\Concerns\FromCollection;

class FormDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Formdata::all();
    }
}
