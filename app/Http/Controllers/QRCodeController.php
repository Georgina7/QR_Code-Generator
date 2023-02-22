<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PHPUnit\Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Generator;

class QRCodeController extends Controller
{
    public function qrcode($file_name){
        return response()->file(public_path()."\storage\programmes\\".$file_name);
    }

    public function index(){
        return view('qrcode');
    }

    public function generateQrcode(Request $request){
        $file = $request->file('program');
        $file_name = $request->name."_".$request->venue."_".$request->date.".pdf";
        $qrcode_name = $request->name."_".$request->venue."_".$request->date.".png";
        Storage::putFileAs('public/programmes', $file, $file_name);

        $qrcode = QrCode::format('png')
                ->merge(public_path('storage/sbs_logo.png'), 0.2, true)
                ->eyeColor(0, 52, 71, 130, 151, 126, 61)
                ->eyeColor(1, 52, 71, 130, 231, 0, 0)
                ->eyeColor(2, 231, 0, 0, 52, 71, 130)
                ->size(600)
                ->margin(3)
                ->generate(route('get_qrcode',['file_name'=>$file_name]));

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();
        $hook = $request->name;
        $description1 = $request->venue;
        $description2 = $request->date.', '.$request->start_time.' - '.$request->end_time;

        $imageStyles = array(
            'width' => 500,
            'height' => 500,
        );

        $hookStyles = array(
            'size' => 35,
            'bold' => true,
            'allCaps' => true,
            'color' => '#00205B',
            'spaceBefore' => Converter::pointToTwip(40),
        );

        $textStyles = array(
            'size' => 20,
            'bold' => true,
            'allCaps' => true,
            'spaceBefore' => Converter::pointToTwip(40)
        );

        $section->addText($hook, $hookStyles);
        $section->addImage($qrcode, $imageStyles);
        $section->addText($description1);
        $section->addText($description2);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $docName = $request->name.'_'.$request->venue.'_'.$request->date.'.docx';
        try{
            $objWriter->save(storage_path($docName));
        }catch (Exception $e){
            return response($e->getMessage());
        }

        return response()->download(storage_path($docName));


////        Storage::put('public/qrcodes/'.$qrcode_name, $qrcode);
//        Session::put('event_name', $request->name);
//        Session::put('event_venue', $request->venue);
//        Session::put('event_date', $request->date);
//        Session::put('event_start_time', $request->start_time);
//        Session::put('event_end_time', $request->end_time);
//        return view('download')->with(['qrcode_name'=> $qrcode_name]);
    }

    public function download($qrcode_name){
        $event_name = Session::get('event_name');
        $event_venue = Session::get('event_venue');
        $event_date = Session::get('event_date');
        $event_start_time = Session::get('event_start_time');
        $event_end_time = Session::get('event_end_time');

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();
        $hook = $event_name;
        $description1 = $event_venue;
        $description2 = $event_date.', '.$event_start_time.' - '.$event_end_time;

        $imageStyles = array(
            'width' => 500,
            'height' => 500,
        );

        $hookStyles = array(
            'size' => 35,
            'bold' => true,
            'allCaps' => true,
            'color' => '#00205B',
            'spaceBefore' => Converter::pointToTwip(40),
        );

        $textStyles = array(
            'size' => 20,
            'bold' => true,
            'allCaps' => true,
            'spaceBefore' => Converter::pointToTwip(40)
        );

        $section->addText($hook, $hookStyles);
        $section->addImage(public_path()."\storage\qrcodes\\".$qrcode_name, $imageStyles);
        $section->addText($description1);
        $section->addText($description2);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $docName = $event_name.'_'.$event_venue.'_'.$event_date.'.docx';
        try{
            $objWriter->save(storage_path($docName));
        }catch (Exception $e){
            return response($e->getMessage());
        }

        return response()->download(storage_path($docName));
        dd($qrcode_name);
    }
}