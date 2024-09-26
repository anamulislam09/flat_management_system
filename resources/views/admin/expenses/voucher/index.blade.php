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
            height: 80px;
            margin-top: -30px;
        }

        .logo {
            width: 20%;
            float: left;
        }

        .header-text {
            width: 55%;
            float: left;
            text-align: center;
            /* float:right; */
            margin-top: -10px;
        }

        .status {
            width: 25%;
            float: right;
            text-align: end;

        }

        .header-text h2 {
            font-family: arial;
            margin-bottom: 0Px;
        }


        .header-text p {
            margin: 0px 10px;
            font-size: 15px;
            /* font-family: Arial, Helvetica, sans-serif */
        }

        .status h3 {
            padding: 8px 0px;
            background: #ddd;
            text-align: center;
            width: 100%;
        }

        /* table style start here  */
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* table style ends here  */

        .Prepared {
            width: 33.33%;
            float: left;
        }

        .Prepared h4 {
            border-top: 2px solid black;
            width: 60%;
            text-align: center;
        }

        .Approved {
            width: 33.33%;
            float: left;
            text-align: -webkit-center;
        }

        .Approved h4 {
            border-top: 2px solid black;
            width: 45%;
            text-align: center;
        }

        .Recipient {
            width: 33.33%;
            float: left;
            text-align: -webkit-right;
        }

        .Recipient h4 {
            border-top: 2px solid black;
            width: 70%;
            text-align: center;
        }

        /* body text start here  */
        .bodyInfo {
            display: flex;
            justify-content: space-between;
            display: block;
            padding: 15px 0px;
            padding-bottom: 5px;
            width: 100%;
            list-style: 10px;
            font-size: 15px;
        }

        .left-text {
            width: 70%;
            float: left;
            line-height: 5px;
        }

        .right-text {
            padding-top: 10px;
            line-height: 5px;
            text-align: right;
        }

        .textAmount h3 {
            margin-top: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px 
        }

        /* body text ends here  */
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <div class="header-text 9">
                <h2>{{ $client->name }}</h2>
                <p>{{ $client->address }}</p>
                <p>{{ $client->phone }}, {{ $client->email }}</p>
            </div>

            <div class="status">
                <h3>Payment Voucher</h3>
            </div>
        </div>

        <div class="bodyInfo">
            <div class="left-text">
                <p>Name : {{ $vendor->name }}</p>
                <p>Phone : {{ $vendor->phone }}</p>
                <p>Address : {{ $vendor->address }}</p>
            </div>
            <div class="right-text">
                <p>Voucher No : {{ $inv->voucher_id }}</p>
                <p>Date :{{ $inv->date }}</p>
            </div>
        </div>
        <div class="body">
            <table>
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th colspan="2">Payment Info</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">1</td>
                        <td colspan="2">{{ $exp_name->name }}</td>
                        <td style="text-align: center">{{ number_format($inv->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 15px;">Payment Method :</td>
                        <td style="text-align: center" style="font-size: 15px;">Total Amount</td>
                        <td style="text-align: center; font-size: 15px;">{{ number_format($inv->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
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

                $word = numberToWord($inv->amount);
            @endphp

            <div class="textAmount">
                <h3>In Word: {{ $word }} taka (only)</h3>
            </div>
        </div>
        <div class="footer">
            <div class="Prepared">
                <p style="padding-bottom: -10px; margin-bottom:-20px;text-align:center; width:60%">
                    {{ Auth::guard('admin')->user()->name }}</p>
                <h4>Prepared by</h4>
            </div>
            <div class="Approved">
                <p></p>
                <h4>Approved by</h4>
            </div>
            <div class="Recipient">
                <p></p>
                <h4>Recipient Signature</h4>
            </div>
        </div>
    </div>
</body>

</html>
