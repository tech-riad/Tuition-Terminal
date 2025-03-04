<?php

return [
    "sandbox"         => env("BKASH_SANDBOX", true),
    'app_key' => env('BKASH_APP_KEY',"4f6o0cjiki2rfm34kfdadl1eqq"),
    'app_secret' => env('BKASH_APP_SECRET',"2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b"),
    'base_url' => env('BKASH_BASE_URL',"https://tokenized.sandbox.bka.sh"),
    'username' => env('BKASH_USERNAME',"sandboxTokenizedUser02"),
    'password' => env('BKASH_PASSWORD',"sandboxTokenizedUser02@12345"),

    "callbackURL"     => env("BKASH_CALLBACK_URL", "https://dev-tuitionterminal.vercel.app/api/v1/tutor/sms-recharge"),
    'timezone'        => 'Asia/Dhaka',
];
