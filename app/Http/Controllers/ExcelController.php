<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export() {
        $excel = Excel::create('test');
        $sheet = $excel->sheet('default', function($sheet) {
            $sheet->rows(array(
                array('data1', 'data2'),
                array('data3', 'data4')
            ));
        });
        return $excel->export('xls');
    }
}
