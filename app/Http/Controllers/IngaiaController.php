<?php

namespace App\Http\Controllers;

use App\Helpers\GuzzleHelper;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IngaiaController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function processXML(Request $request){


        $url =   implode('&', ($request->all()));
        $parameter =  urlencode($request->p);


        $urlGuzzle = $url.'&p='.$parameter;


        $getXML = GuzzleHelper::get($urlGuzzle,20);

        if($getXML){
            $xml = (array) simplexml_load_string($getXML,"SimpleXMLElement",LIBXML_NOCDATA);
            if($xml){
                return $this->successResponse( json_encode($xml, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
            }else{
                return $this->errorResponse("Falha ao recuperar os dados do XML", Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }else{
            return $this->errorResponse("Falha ao recuperar dados da url :" . $urlGuzzle, Response::HTTP_BAD_REQUEST);
        }

    }


    //
}
