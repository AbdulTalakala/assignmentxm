<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HistoryRequest;
use App\Interfaces\Company;

class CompanyController extends Controller
{
    
    private $companyService;

    public function __construct(Company $companyService)
    {
        $this->companyService = $companyService;
    }

    public function companyDetails(){
        return view('company_details');
    }  

    public function historyData(Historyrequest $request){
        return $this->companyService->getHistoryData($request->companySymbol,$request->startDate,$request->endDate,$request->email);
    }

}
