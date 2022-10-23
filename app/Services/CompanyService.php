<?php

namespace App\Services;
use App\Interfaces\Company;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Mail;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use  App\Mail\CompanyMail;
use App\Models\CompanyDetail;


class CompanyService implements Company { 


    public function getHistoryData(string $companySymbol,string $startDate,string $endDate, string $email){
      
        try{

            $apiUrl = config('constant.api.api_url');
            $headers = [
                'X-RapidAPI-Host' => config('constant.api.X-RapidAPI-Host'),
                'X-RapidAPI-Key' => config('constant.api.X-RapidAPI-Key')
            ];
            $params = ['symbol' => $companySymbol];
            $response =  Http::withHeaders($headers)->get($apiUrl,$params);
            $responseData = collect($response->json());
            $recordLength = count($responseData);
            if($response->successful() == 1 && $recordLength > 0){
                if(count($responseData["prices"]) > 0){

                    $records = collect($responseData["prices"])->sortBy('date')->toArray();
                    $responseData = $this->getResponseData($records,$startDate,$endDate);

                    /* Sending email   */
                    if($responseData["dataCount"] > 0){
                        $companyName = $this->getCompanyName($companySymbol);
                        $mailData = ["companyName"=>$companyName,"startDate"=>$startDate,"endDate"=>$endDate];
                        $mailResponse = $this->sendEmail($mailData,$email);
                    }

                    $data = ['historicalData'=>$responseData["historicalData"],'dataCount'=>$responseData["dataCount"],'openPrices'=>$responseData["openPrices"],'closePrices'=>$responseData["closePrices"]];
                    return view('company_details',['response'=>$data,'companySymbol'=>$companySymbol,'startDate'=>$startDate,'endDate'=>$endDate,'email'=>$email,"mail_sent_status"=>$mailResponse["mail_sent_status"]]);
                }
            }
            else{
                return back()->withError($responseData["message"])->withInput();
            }
        } 
        catch (RequestException $ex) {
            return back()->withError("Request url or parameter or api keys error")->withInput();
        }
        catch(ConnectionException $e){
           return back()->withError("Internet Connection Error")->withInput();
        }
        catch(\Exception $e){
            return back()->withError("No data found!")->withInput();
        }
    }

    public function getResponseData(array $records,string $startDate,string $endDate){
        
        $dataCount = 0;
        $historicalData = array();
        $openPrices = array();
        $closePrices = array();

        foreach ($records as $price){
            $date = Carbon::parse($price["date"])->toDateString();
            if($date >= $startDate && $date <= $endDate && $price["open"] !== null){
                $dataCount += 1;
                $price["date"] = $date;         
                array_push($historicalData,$price);
                array_push($openPrices,$price["open"]);
                array_push($closePrices,$price["close"]);
            } 
        }
        return ["historicalData"=>$historicalData,"openPrices"=>$openPrices,"closePrices"=>$closePrices,"dataCount"=>$dataCount];
    }


    public function sendEmail(array $data, string $email){
        try{
              Mail::to($email)->send(new CompanyMail($data));
              return ["mail_sent_status"=>true];
        }
        catch(\Exception $e){
            return ["mail_sent_status"=>false];
        }   
    }


    public function getCompanyName(string $symbol){
        $companyDetails =  CompanyDetail::where('symbol',$symbol)->first();
        return $companyDetails->name;
    }
}