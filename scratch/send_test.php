<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminInquiryNotification;

$inquiry = Inquiry::create([
    'name' => 'John Doe', 
    'email' => 'john.doe@example.com', 
    'phone' => '123-456-7890', 
    'journey' => 'Ultimate Thailand Adventure', 
    'message' => 'I would like to book this tour for next month.'
]);

Mail::to(config('mail.from.address'))->send(new AdminInquiryNotification($inquiry));

echo "Test email sent!";
