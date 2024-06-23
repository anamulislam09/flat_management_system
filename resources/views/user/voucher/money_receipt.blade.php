<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <style>
        .container {
            width: 90%;
            margin: auto;
        }

        .header-section {
            width: 100%;
            height: 100px;
            margin-top: -30px;
        }

        .header-text {
            width: 100%;
            float: left;
            text-align: center;
            margin-top: -15px
        }

        .header-text h1 {
            font-family: arial;
            margin-bottom: -6Px;
        }


        .header-text p {
            margin: 0px 10px;
        }

        .status p {
            width: 100%;
        }

        .body p {
            line-height: 30px;
            /* margin-top: 0px; */
        }

        /* table style ends here  */

        .Prepared {
            width: 70%;
            float: left;
        }

        .Prepared h4 {
            border-top: 2px solid black;
            width: 40%;
            text-align: center;
        }

        .Recipient {
            width: 30%;
            float: left;
            text-align: -webkit-right;
        }

        .Recipient h4 {
            border-top: 2px solid black;
            width: 90%;
            text-align: center;
        }

        /* body text start here  */
        .bodyInfo {
            display: flex;
            justify-content: space-between;
            display: block;
            /* padding: 15px 0px; */
            padding-bottom: 8px;
            width: 100%;
            height: 50px;
            /* background: #fb5200; */
        }

        .left-text {
            width: 25%;
            float: left;
            /* line-height: 10px; */
        }

        .middle-text {
            width: 55%;
            float: left;
            padding-left: 10%;
            margin-top: -12px;
            /* text-align: center; */
            /* line-height: 10px; */
        }

        .middle-text p {
            width: 50%;
            text-align: center;
            padding: 10px 5px;
            background: #000;
            border-radius: 20px;
            font-weight: 800;
            font-size: 20PX;
            color: white;
            font-family: cursive;
            /* line-height: 10px; */
        }

        .right-text {
            width: 20%;
            float: right;
            margin-bottom: -15px;
            line-height: 0px;
        }

        /* body text ends here  */
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section">
            {{-- <div class="logo"> --}}
            {{-- <h3>{{ $customer->name }}</h3> --}}
            {{-- <img src="" alt="$customer->name "> --}}
            {{-- </div> --}}

            <div class="header-text">
                <h1>{{ $client->name }}</h1>
                <p>{{ $client->address }}</p>
                <p>{{ $client->phone }}</p>
                <p>{{ $client->email }}</p>
            </div>

            {{-- <div class="status" style="text-align: center"> --}}
            {{-- <h3>Money Receipt</h3> --}}
            {{-- <p>{{ $custDetails->address }}</p> --}}
            {{-- </div> --}}
        </div>

        <div class="bodyInfo">
            <div class="left-text">
                <p>MR No : {{ $inv->invoice_id }}</p>

            </div>
            <div class="middle-text">
                <p>Money Receipt</p>
            </div>

            <div class="right-text">
                <p style="margin-top: 0px">{!! DNS1D::getBarcodeHTML("$inv->invoice_id", 'C128') !!}</p>
                <p>Date :{{ date('m/d/y') }}</p>
            </div>
        </div>
        @php
            // Function which returns number to words
            function numberToWord($num = '')
            {
                $num = (string) ((int) $num);

                if ((int) $num && ctype_digit($num)) {
                    $words = [];

                    $num = str_replace([',', ' '], '', trim($num));

                    $list1 = [
                        '',
                        'one',
                        'two',
                        'three',
                        'four',
                        'five',
                        'six',
                        'seven',
                        'eight',
                        'nine',
                        'ten',
                        'eleven',
                        'twelve',
                        'thirteen',
                        'fourteen',
                        'fifteen',
                        'sixteen',
                        'seventeen',
                        'eighteen',
                        'nineteen',
                    ];

                    $list2 = [
                        '',
                        'ten',
                        'twenty',
                        'thirty',
                        'forty',
                        'fifty',
                        'sixty',
                        'seventy',
                        'eighty',
                        'ninety',
                        'hundred',
                    ];

                    $list3 = [
                        '',
                        'thousand',
                        'million',
                        'billion',
                        'trillion',
                        'quadrillion',
                        'quintillion',
                        'sextillion',
                        'septillion',
                        'octillion',
                        'nonillion',
                        'decillion',
                        'undecillion',
                        'duodecillion',
                        'tredecillion',
                        'quattuordecillion',
                        'quindecillion',
                        'sexdecillion',
                        'septendecillion',
                        'octodecillion',
                        'novemdecillion',
                        'vigintillion',
                    ];

                    $num_length = strlen($num);
                    $levels = (int) (($num_length + 2) / 3);
                    $max_length = $levels * 3;
                    $num = substr('00' . $num, -$max_length);
                    $num_levels = str_split($num, 3);

                    foreach ($num_levels as $num_part) {
                        $levels--;
                        $hundreds = (int) ($num_part / 100);
                        $hundreds = $hundreds
                            ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' '
                            : '';
                        $tens = (int) ($num_part % 100);
                        $singles = '';

                        if ($tens < 20) {
                            $tens = $tens ? ' ' . $list1[$tens] . ' ' : '';
                        } else {
                            $tens = (int) ($tens / 10);
                            $tens = ' ' . $list2[$tens] . ' ';
                            $singles = (int) ($num_part % 10);
                            $singles = ' ' . $list1[$singles] . ' ';
                        }
                        $words[] =
                            $hundreds .
                            $tens .
                            $singles .
                            ($levels && (int) $num_part ? ' ' . $list3[$levels] . ' ' : '');
                    }
                    $commas = count($words);
                    if ($commas > 1) {
                        $commas = $commas - 1;
                    }

                    $words = implode(', ', $words);

                    $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
                    if ($commas) {
                        $words = str_replace(',', ' and', $words);
                    }

                    return $words;
                } elseif (!((int) $num)) {
                    return 'Zero';
                }
                return '';
            }

            $word = numberToWord($inv->paid);
        @endphp

        <div class="body">
            <p>Received with thanks from Mr./Ms <strong><span style="border-bottom: 2px dotted #000; padding:0px 70px">
                        @if (isset($user->name) && !empty($user->name))
                            {{ $user->name }}@else{{ $inv->flat_name }}
                        @endif
                    </span></strong> The
                sum of tk. (in words)
                <strong><span
                        style="border-bottom: 2px dotted #000; padding:0px 70px">{{ $word }}</span></strong>
                Month of <strong><span style="border-bottom: 2px dotted #000; padding:0px 70px">
                        @if ($inv->month == 1)
                            January
                        @elseif ($inv->month == 2)
                            February
                        @elseif ($inv->month == 3)
                            March
                        @elseif ($inv->month == 4)
                            April
                        @elseif ($inv->month == 5)
                            May
                        @elseif ($inv->month == 6)
                            June
                        @elseif ($inv->month == 7)
                            July
                        @elseif ($inv->month == 8)
                            August
                        @elseif ($inv->month == 9)
                            September
                        @elseif ($inv->month == 10)
                            October
                        @elseif ($inv->month == 11)
                            November
                        @elseif ($inv->month == 12)
                            December
                        @endif {{ $inv->year }}
                    </span> </strong>. In Cash <strong><span style="border-bottom: 2px dotted #000; padding:0px 30px">
                        {{ $inv->paid }}</span></strong>.
                Service Charge of Flat No <strong><span
                        style="border-bottom: 2px dotted #000; padding:0px 30px; width:50%">{{ $inv->flat_name }}</span></strong>.
            </p>

        </div>
        <div class="footer">
            <div class="Prepared">
                @php
                    $client = App\Models\Client::where('id', $inv->auth_id)->first();
                    $user = App\Models\User::where('user_id', $inv->auth_id)->first();
                @endphp
                @if ($inv->auth_id == Auth::user()->user_id)
                    <p style="padding-bottom: -10px; margin-bottom:-20px; text-align:center; width:40%">
                        {{ $user->name }}</p>
                @else
                    <p style="padding-bottom: -10px; margin-bottom:-20px; text-align:center; width:40%">
                        {{ $client->name }}</p>
                @endif

                <h4>Prepared by</h4>
            </div>
            <div class="Recipient">
                <p></p>
                <h4>Recipient Signature</h4>
            </div>
        </div>
    </div>
</body>

</html>
