<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Http\Controllers\Controller;
use App\Models\Homeowner;


class ImportCSVController extends Controller
{
    private $people = [];

    private $titles = ["Mister","Mr","Mrs","Miss","Dr","Ms","Prof","Rev","Lady","Sir","Capt","Major","Lt-Col","Col","Lady","Lt-Cmdr","The Hon","Cmdr","Flt Lt","Brgdr","Judge","Lord","The Hon Mrs","Wng Cmdr","Group Capt","Rt Hon Lord","Revd Father","Revd Canon","Maj-Gen","Air Cdre","Viscount","Dame","Rear Admrl"];

    public function getImport()
    {
        return view('uploadCSV');
    }

    public function parseImport(CsvImportRequest $request)
    {

        $path = $request->file('csv_file')->getRealPath();

            $sanitisedData = $this->normalise(file_get_contents($path));

            $data = explode(",", $sanitisedData);

            //$hasHeader false if first data item is a title
            $hasHeader = !$this->isHeader($data[0]);

            if (count($data) > 0) {
                if ($hasHeader) {
                    $csv_header = $data[0];
                    $data = array_slice($data, 1, count($data));
                } else {
                    $csv_header = 'Homeowners';
                }


                foreach ($data as $line) {
                    if($this->isOnePerson($line)) {
                        $this->formatPerson($line);
                    } else {
                        $this->splitPeople($line);
                    }
                }
            } else {
                return redirect()->back();
            }
            return view('displayResults')->with(['homeowners'=> $this->people, 'title'=>$csv_header]);
    }

    private function isHeader($firstLine){
        $firstLineArray = explode(" ", $firstLine);
        return $this->isTitle($firstLineArray[0]);
    }

    //returns true is $item is a title
    private function isTitle($item)
    {
        return in_array($item, $this->titles);
    }

    private function normalise($stringToSanatise) {

        $sanatised = preg_replace('/[^A-z-&, ]/', '', $stringToSanatise);
        return $sanatised;
    }

    private function isOnePerson($line) {
        if(preg_match('[and|&]', $line)) {
           return false;
        }
        return true;
    }

    private function isInitial($word) {
        if(strlen($word) === 1){
            return true;
        }
        return false;
    }

    private function formatPerson($line) {
        $personArray = explode(" ", $line);
        if(count($personArray) >1 && count($personArray) < 5 ) {
            $person = new Homeowner();
            if($this->isTitle($personArray[0])){
                $items = count($personArray);
                switch ($items) {
                    case 2:
                        $person->title = ucwords($personArray[0]);
                        $person->first_name = null;
                        $person->initial = null;
                        $person->last_name = ucwords($personArray[1]);
                        break;
                    case 3:
                        $person->title = ucwords($personArray[0]);
                        if($this->isInitial($personArray[1]) == false) {
                            $person->first_name = ucwords($personArray[1]);
                            $person->initial = null;
                        } else {
                            $person->initial = ucwords($personArray[1]);
                            $person->first_name = null;
                        }
                        $person->last_name = ucwords($personArray[2]);
                        break;
                    case 4:
                        $person->title = ucwords($personArray[0]);
                        $person->first_name = ucwords($personArray[1]);
                        $person->initial = ucwords($personArray[2]);
                        $person->last_name = ucwords($personArray[3]);
                        break;
                    default:
                        echo('here'.$items);
                        $person->title = "Data incorrectly formatted";
                        $person->first_name = "Data incorrectly formatted";
                        $person->initial = "Data incorrectly formatted";
                        $person->last_name = "Data incorrectly formatted";
                }

            }
            array_push($this->people, $person);
        }
    }

    private function splitPeople($line) {
        $twoPeople = preg_split('/ (and|&) /', $line);
        $firstPerson = $twoPeople[0];
        $secondPerson = $twoPeople[1];
        $firstPersonArray = explode(" ", $firstPerson);
        $secondPersonArray = explode(" ", $secondPerson);
        if(count($firstPersonArray)=== 1) {
            array_push($firstPersonArray, end($secondPersonArray));
            $firstPersonString = implode(" ", $firstPersonArray);
            $this->formatPerson($firstPersonString);
            $this->formatPerson($secondPerson);
        } else {
            $this->formatPerson($firstPerson);
            $this->formatPerson($secondPerson);
        }
    }
}
