<?php
namespace App\Admin\Exporters;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporter extends AbstractExporter {
    private $titleMaps = null;
    private $keys = null;

    public function __construct(array $titleMaps = null)
    {
        $this->titleMaps  = $titleMaps;
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        // TODO: Implement export() method.
        $filename = $this->getTable();

        $titles = $this->getTitles();

        $data = $this->wantedData();
        array_unshift($data, $titles);
        info(print_r($data, true));

        $excel = Excel::create($filename);

        $excel->sheet('default', function($sheet) use ($data){
            $sheet->rows($data);
            $sheet->cells("A1:E1", function($cells) {
                $cells->setBackground('#3aafd6');
            });
        });
        $excel->export('xls');
    }

    /**
     * Remove indexed array.
     *
     * @param array $row
     *
     * @return array
     */
    protected function sanitize(array $row)
    {
        return collect($row)->reject(function ($val) {
            return is_array($val) && !Arr::isAssoc($val);
        })->toArray();
    }

    protected function wantedData() {
        $data = $this->getData();
        $keys = $this->getKeys();
        info(print_r($keys, true));
        $wantedData = [];
        foreach ($data as $row) {
            $row = array_map(function($key) use ($row) {
                return $row[$key];
            }, $keys);
            $wantedData[] = $row;
        }
        return $wantedData;
    }

    protected function getTitles() {
        $keys  = $this->getKeys();
        if ($this->titleMaps == null) {
            return $keys;
        }
        $titles = [];
        foreach($keys as $key) {
            $titles[] = $this->titleMaps[$key];
        }
        return $titles;
    }

    protected function getKeys() {
        if ($this->keys != null) {
            return $this->keys;
        }
        $data = $this->getData();
        $columns = array_dot($this->sanitize($data[0]));
        $keys = array_keys($columns);
        $this->keys = [];
        foreach($this->titleMaps as $key => $title) {
            if (in_array($key, $keys)) {
                $this->keys[] = $key;
            }
        }
        return $this->keys;
    }
}