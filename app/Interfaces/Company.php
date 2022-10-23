<?php

namespace  App\Interfaces;

interface Company
{
    public function getHistoryData(string $symbol,string $startDate,string $toDate, string $email);

    // public function getCompanyName(string $symbol);

    // public function sendEmail(array $data,string $toEmail);

}