<?php

use Carbon\Carbon;

function generateInvoiceNumber() {
    $text = "INV-";
    $time = Carbon::now()->format('YmdHis');
    $invoiceNumber = $text . $time;
    return $invoiceNumber;
}

  function getCurrentDate() {
    $date = Carbon::now()->format('Y-m-d');
    return $date;
  }

function isConnected($site = "www.google.com"): bool
{
    return (bool) @fsockopen($site, 80, $errno, $errstr, 5);
}