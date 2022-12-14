<!DOCTYPE html>
<html>
<head>
    <title>Invoice № {{ $invoice['invoice_number'] }}</title>
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <link rel="apple-touch-icon" sizes="180x180" href="/img/meta/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/meta/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/meta/favicon-16x16.png">
    <link rel="manifest" href="/img/meta/site.webmanifest">
    <link rel="mask-icon" href="/img/meta/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/img/meta/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/img/meta/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        color: #020102;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        background-color: #201020;
    }
    .pdf-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 60px 70px;
        border: 1px solid #201020;
        background-color: #ffffff;
    }
    h1 {
        color: #201020;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.4em;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
    }
    h2 {
        color: #201020;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.2em;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5em;
    }
    p:not(:last-child) {
        margin-bottom: 0;
    }
    .pdf-header-block .date {
        margin-left: 0.5em;
    }
    .pdf-seller-block {
        margin-bottom: 30px;
    }
    .pdf-seller-block .left-column {
        width: 70%;
        float: left;
    }
    .pdf-seller-block .right-column {
        float: right;
        width: 30%;
        position: relative;
    }
    .clear-fix {
        clear: both;
    }
    .pdf-seller-block .image-wrapper {
        width: 9em;
        height: 3.4em;
        position: absolute;
        top: -0.5em;
        right: 0em;
    }
    .pdf-seller-block img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center center;
    }
    .pdf-customer-block {
        margin-bottom: 30px;
    }
    .pdf-customer-block .block-title {
        text-align: right;
    }
    .pdf-customer-block p {
        text-align: right;
    }
    .pdf-details-block {
        margin-bottom: 30px;
    }
    .pdf-details-block table {
        width: 100%;
    }
    .pdf-details-block th {
        color: #ffffff;
        text-align: right;
        background-color: #5182bb;
        padding: 0.6em 1em 0.5em;
    }
    .pdf-details-block td {
        color: #201020;
        font-size: 1.3em;
        font-weight: 500;
        text-align: right;
        background-color: #ced7e6;
        padding: 0.6em 1em 0.5em;
    }
    .pdf-details-block th:nth-child(1) {
        width: 7%;
    }
    .pdf-details-block th:nth-child(2) {
        text-align: left;
        width: 60%;
    }
    .pdf-details-block th:nth-child(3) {
        width: 12%;
    }
    .pdf-details-block th:nth-child(4) {
        width: 21%;
    }
    .pdf-details-block td:nth-child(1) {
        width: 7%;
    }
    .pdf-details-block td:nth-child(2) {
        text-align: left;
        width: 60%;
    }
    .pdf-details-block td:nth-child(3) {
        width: 12%;
    }
    .pdf-details-block td:nth-child(4) {
        width: 21%;
    }
    .pdf-total-block {
        padding: 0 2px;
    }
    .pdf-total-block table {
        border-collapse: collapse;
        margin-left: auto;
    }
    .pdf-total-block td {
        font-weight: 600;
        line-height: 1.5;
        border: 1px solid #676767;
        width: 125px;
        padding: 0.6em 1em 0.5em;
    }
    .pdf-total-block td:nth-child(2) {
        text-align: center;
    }
</style>    
<body>
    <div class="pdf-wrapper">
        <div class="pdf-header-block">
            <h1><span class="number">Invoice № {{ $invoice['invoice_number'] }}</span> <span class="date">{{ $invoice['invoice_date'] }}</span></h1>
        </div>
        <div class="pdf-seller-block">
            <div class="left-column">
                <div class="text-wrapper">
                    <h2 class="block-title">Seller</h2>
                    <p>Private entrepreneur Denys Kabychenko</p>
                    <p>Legal address: 42, Kovtuna street, Kharkov, 61036, Ukraine</p>
                    <p>Phone: +33 970 464 932</p>
                    <p>E-mail: <a href="mailto:contact@bato-webdesign.net">contact@bato-webdesign.net</a></p>
                    <p>IBAN: LT233500010008937005</p>
                    <p>Swift code: EVIULT2VXXX</p>
                    <p>Bank code: 35000</p>
                    <p>Bank Name: "Paysera LT", UAB</p>
                    <p>Bank address: Pilaités pr. 16, LT-04352, Vilnius, Lituanie</p>
                </div>
            </div>
            <div class="right-column">
                <div class="image-wrapper">
                    <img src="{{ asset('img/logo-shadow.png') }}" alt="Bato">
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <div class="pdf-customer-block">
            <h2 class="block-title">Customer</h2>
            @if (!empty($invoice['name']))
                <p>{{ $invoice['name'] }}</p>
            @endif
            @if (!empty($invoice['company_name']))
                <p>{{ $invoice['company_name'] }}</p>
            @endif
            @if (!empty($invoice['address']) || !empty($invoice['post_code']) || !empty($invoice['city']))
                <p>{{ $invoice['address'] }}<br> {{ $invoice['post_code'] }} {{ $invoice['city'] }}</p>
            @endif
            @if (!empty($invoice['phone']))
                <p>{{ $invoice['phone'] }}</p>
            @endif
            @if (!empty($invoice['siret']))
                <p>Siret: {{ $invoice['siret'] }}</p>
            @endif
            @if (!empty($invoice['rcs']))
                <p>RCS: {{ $invoice['rcs'] }}</p>
            @endif
            @if (!empty($invoice['tva']))
                <p>TVA: {{ $invoice['tva'] }}</p>
            @endif
            @if (!empty($invoice['note']))
                <p>{{ $invoice['note'] }}</p>
            @endif
        </div>
        <div class="pdf-details-block">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice['details'] as $item)
                        <tr>
                            <td>{{ $item['order'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pdf-total-block">
            <table>
                <tr>
                    <td>Total, €</td>
                    <td>{{ $invoice['total'] }} €</td>
                </tr>
                <tr>
                    <td>VAT
                        @if (!empty($invoice['vat']) && $invoice['vat'] != 0)
                            , ({{$invoice['vat']}}%)
                        @endif
                    </td>
                    <td>{{ $invoice['vat_qty'] }} €</td>
                </tr>
                <tr>
                    <td>Total, €<br> (all taxes incl.)</td>
                    <td>{{ $invoice['total_tax'] }} €</td>
                </tr>
            </table>
        </div>
        <div class="pdf-footnote" style="font-size: 14px; font-weight: 600;text-align: center; margin-top: 50px;">Thank you for your business!</div>
    </div>
</body>
</html>