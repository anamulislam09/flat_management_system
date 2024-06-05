{{-- @php
    $user = App\Models\User::where('user_id', Auth::user()->user_id)->first();
    $pdfNo = App\Models\Income::where('client_id', $user->client_id)
        ->where('month', $month->month)
        ->where('year', $month->year)
        ->where('status', '!=', 0)
        ->count();
    // $no =1;
@endphp --}}



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .container {
            width: 90%;
            margin: auto;
            /* border: 1px solid #ddd; */
        }

        .header-text {
            width: 95%;
            text-align: center;
            margin-top: -15px height: 100px;
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
            margin-top: 10px;
            /* padding-bottom: 5px; */
            width: 95%;
            height: 50px;
        }

        .left-text {
            width: 25%;
            float: left;
        }

        .middle-text {
            width: 55%;
            float: left;
            padding-left: 10%;
        }

        .middle-text p {
            width: 50%;
            text-align: center;
            padding: 5px 5px;
            background: #000;
            border-radius: 20px;
            font-weight: 800;
            font-size: 19PX;
            color: white;
            font-family: cursive;
        }

        .right-text {
            width: 20%;
            float: right;
            margin-bottom: -15px;
        }

        .border {
            border: 1px solid #ddd;
            margin: 10px 5px;
            padding: 10px;
        }

        /* body text ends here  */
    </style>
</head>

<body>

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
                $hundreds = $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '';
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
                    $hundreds . $tens . $singles . ($levels && (int) $num_part ? ' ' . $list3[$levels] . ' ' : '');
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

    
@endphp

    @foreach ($inv as $voucher)
        @php
        $word = numberToWord($voucher->paid);
            $customer = App\Models\Customer::where('id', $voucher->client_id)->first();
            $custDetails = App\Models\CustomerDetail::where('client_id', $customer->id)->first();
        @endphp
        <div class="container">
            <div class="border">
                <div class="header-text">
                    <h1>{{ $customer->name }}</h1>
                    <p>{{ $custDetails->address }}</p>
                    <p>{{ $custDetails->phone }}, {{ $customer->email }}</p>
                </div>

                <div class="bodyInfo">
                    <div class="left-text">
                        <p>MR No : {{ $voucher->invoice_id }}</p>

                    </div>
                    <div class="middle-text">
                        <p>Money Receipt</p>
                    </div>

                    <div class="right-text">
                        <p style="margin-top: -15px; width:10px;">{!! DNS1D::getBarcodeHTML("$voucher->invoice_id", 'C128', 1.5, 23) !!}</p>
                        <p>Date :{{ date('m/d/y') }}</p>
                    </div>
                </div>

                <div class="body">
                    <p>Received with thanks from Mr./Ms <strong><span
                                style="border-bottom: 2px dotted #000; padding:0px 20px">
                                @if (isset($user->name) && !empty($user->name))
                                    {{ $user->name }}@else{{ $voucher->flat_name }}
                                @endif
                            </span></strong> The
                        sum of tk. (in words)
                        <strong><span style="border-bottom: 2px dotted #000; padding:0px 20px">{{$word}}</span></strong>
                        Month of <strong><span style="border-bottom: 2px dotted #000; padding:0px 20px">
                                @if ($voucher->month == 1)
                                    January
                                @elseif ($voucher->month == 2)
                                    February
                                @elseif ($voucher->month == 3)
                                    March
                                @elseif ($voucher->month == 4)
                                    April
                                @elseif ($voucher->month == 5)
                                    May
                                @elseif ($voucher->month == 6)
                                    June
                                @elseif ($voucher->month == 7)
                                    July
                                @elseif ($voucher->month == 8)
                                    August
                                @elseif ($voucher->month == 9)
                                    September
                                @elseif ($voucher->month == 10)
                                    October
                                @elseif ($voucher->month == 11)
                                    November
                                @elseif ($voucher->month == 12)
                                    December
                                @endif {{ $voucher->year }}
                            </span> </strong>. In Cash <strong><span
                                style="border-bottom: 2px dotted #000; padding:0px 10px">
                                {{ $voucher->paid }}</span></strong>.
                        Service Charge of Flat No <strong><span
                                style="border-bottom: 2px dotted #000; padding:0px 10px; width:50%">{{ $voucher->flat_name }}</span></strong>.
                    </p>

                </div>
                <div class="footer" style="padding-bottom:40px">
                    <div class="Prepared">
                        @php
                            $customer = App\Models\Customer::where('id', $voucher->auth_id)->first();
                            $user = App\Models\User::where('user_id', $voucher->auth_id)->first();
                        @endphp
                        @if ($voucher->auth_id == Auth::user()->user_id)
                            <p style=" margin-bottom:-0px; text-align:center; width:40%">
                                {{ $user->name }}</p>
                        @else
                            <p style="margin-bottom:-0px; text-align:center; width:40%">
                                {{ $customer->name }}</p>
                        @endif
                        <h4>Prepared by</h4>
                    </div>
                    <div class="Recipient">
                        <p></p>
                        <h4>Recipient Signature</h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
   
</body>

</html>



