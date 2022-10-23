@extends('layouts.header')

@section('content')

    <div class="container-fluid">
                    
        <div class="row mt-3">
            
            <form id="frmCompanyData" method="post" action="{{ route('company.history') }}">
                @csrf
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row g-3">  
                            <div class="col form-field">
                                <label for="companySymbol">Symbol</label>
                                <input type="text" class="form-control"  id="companySymbol" name="companySymbol" value="{{  old('companySymbol', isset($companySymbol) ? $companySymbol : '') }}" placeholder="Company Symbol" autocomplete="off">
                                <small></small>
                                @if ($errors->has('companySymbol'))
                                    <span class="text-danger">{{ $errors->first('companySymbol') }}</span>
                                @endif
                            </div>    
                        </div>

                        <div class="row g-3">
                            <div class="col p-1 form-field">
                                <label for="startDate">Start Date </label>
                                <input type="text" class="form-control"  id="startDate" name="startDate" value="{{ old('startDate', isset($startDate) ? $startDate : '') }}" placeholder="Start Date" autocomplete="off">
                                <small></small>
                                @if ($errors->has('startDate'))
                                    <span class="text-danger">{{ $errors->first('startDate') }}</span>
                                @endif
                            </div>
                            
                            <div class="col p-1 form-field">
                                <label for="endDate">End Date </label>
                                <input type="text" class="form-control" id="endDate" name="endDate" value="{{ old('endDate', isset($endDate) ? $endDate : '') }}" placeholder="End Date" autocomplete="off">
                                <small></small>
                                @if ($errors->has('endDate'))
                                    <span class="text-danger">{{ $errors->first('endDate') }}</span>
                                @endif
                            </div>
                            
                            <input type="hidden" name="today" value="{{ date('Y-m-d')  }}" />

                        </div>

                        <div class="row g-3">

                            <div class="col form-field">
                                <label for="email">Email</label>
                                <input type="text" class="form-control"  id="email" name="email" value="{{ old('email', isset($email) ? $email : '') }}" placeholder="email" autocomplete="off">
                                <small></small>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>        
                        </div>


                        <div class="col-md-8 p-2 form-field">
                            <button type="submit" class="btn btn-lg  btn-primary">Submit</button>
                            <a class="btn btn-primary btn-lg" href="{{  route('company.details') }}">Clear</a>
                        </div>

            

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif


                    </div>
                </div>        
            </form>

        </div>

        @if(isset($mail_sent_status))
            @if($mail_sent_status == true)
                <div class="alert alert-success">Mail Sent.</div>
            @else
                <div class="alert alert-danger">Mail Not Sent.</div>
            @endif
        @endif   

        <h4 class="p-2">Historical Data </h4>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
     
        <div class="table-responsive mt-3">

            <table class="table">

                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Open</th>
                        <th scope="col">High</th>
                        <th scope="col">Low</th>
                        <th scope="col">Close</th>
                        <th scope="col">Volume</th>
                    </tr>

                </thead>
                <tbody>
                    @if(isset($response["historicalData"]))
                        @foreach($response["historicalData"] as $data)
                            <tr scope="row" class="no-border m-2">
                                <td>{{ $data["date"] }}</td>
                                <td>{{ $data["open"] }}</td>
                                <td>{{ $data["high"] }}</td>   
                                <td>{{ $data["low"] }}</td>
                                <td>{{ $data["close"] }}</td>   
                                <td>{{ $data["volume"] }}</td>                                      
                            </tr>
                        @endforeach
                    @elseif(isset($response["dataCount"]) &&  $response["dataCount"] == 0)
                        <h4>No records found for given company.</h4>
                    @endif        
                
                </tbody>

            </table>
        </div>


        <h4 class="p-3"> Chart Section </h4>
        @if(isset($response["dataCount"]))
            <h6>Open Price </h6>
            <div id="openPriceChart"></div>

        
            <h6 class="p-3">Close Price </h6>
            <div class="p-2" id="closePriceChart"></div>
        @endif
        

    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>       
        
@endsection