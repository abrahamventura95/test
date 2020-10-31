<?php
/*
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Formato;
class FormatExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
/*    public function collection()
    {
    	 return view('format');
        //return Formato::all();
    }
}
*/

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
	private $clase;
    private $rangeX;

	public function __construct(String $clase,int $i)
    {
        $this->clase = $clase;
        $this->rangeX = $i;
    }

    public function view(): View
    {
    	return view('formats.'.$this->clase);
    }

    public function title(): string
    {
        return strtoupper($this->clase);
    }

    public function styles(Worksheet $sheet)
    {
        $alphabet = range('A', 'Z');
        $range = "A1:".$alphabet[$this->rangeX-1]."2";
        $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
         ]);
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]

        ];
    }
}
