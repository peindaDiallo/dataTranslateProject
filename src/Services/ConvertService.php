<?php

namespace App\Services;

use App\Entity\XLSXWriter;
use ErrorException;
use Shuchkin\SimpleXLSX;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ConvertService
{
    private GoogleTranslate $googleTranslate;

    public function __construct()
    {
        $this->googleTranslate = new GoogleTranslate();
    }

    /**
     * @param string $in
     * @param string $to
     * @param string $word
     * @return string|null
     * @throws ErrorException
     */
    public function translate(string $in, string $to, string $word): ?string
    {
        return  $this->googleTranslate->setSource($in)->setTarget($to)->translate($word);
    }

    /**
     * @param string $filePath
     * @param string $pathFileNew
     * @return void
     * @throws ErrorException
     */
    public function saveWord(string $filePath, string $pathFileNew )
    {
        $xlsx = SimpleXLSX::parse($filePath);
        $header_values = $rows = [];
        foreach ($xlsx->rows() as $k => $r ){
            if ( $k === 0 ) {
                $header_values = $r;
                continue;
            }
            $rows[] = array_combine( $header_values, $r );
        }
        $result = [];
        $result[]= $header_values;
        foreach ($rows as $value){
            $result[] = [
                $value["Key"],
                $value["Label_it"],
                $this->translate("it",'en',$value["Label_it"]),
                $this->translate("it",'fr',$value["Label_it"]),
                $this->translate("it",'de',$value["Label_it"]),
                $this->translate("it",'es',$value["Label_it"])
            ];
        }
        $this->generateExcelFile($pathFileNew,$result);
    }

    /**
     * Generate new excel file with translate words
     * @param string $newFileXlsx
     * @param array $data
     * @return void
     */
    public function generateExcelFile(string $newFileXlsx, array $data)
    {
        $writer = new XLSXWriter();
        $writer->writeSheet($data);
        $writer->writeToFile($newFileXlsx);
    }

    /**
     * Download file
     * @param string $file
     * @return void
     */
    public function downloadFile(string $file): void
    {

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        header_remove();

    }



    /**
     * Delete all files in directory
     * @param string $directory
     * @return void
     */
    public function cleanDirectory(string $directory)
    {
        array_map( 'unlink', array_filter((array) glob($directory) ) );
    }

}