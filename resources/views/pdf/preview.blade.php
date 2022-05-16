<!DOCTYPE html>
<html>
<head>
    <title>Generate PDF Laravel 8 - phpcodingstuff.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>    
<body>
    @php
        // dd($invoice);
    @endphp
    <div class="invoice">
        Invoice №
    </div>
    <div class="container">
        <div class="col-md-8 section offset-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2>Invoice № {{ $invoice['invoice_number'] }} {{ $invoice['invoice_date'] }}</h2>
                </div>
                <div class="panel-body">
                    <h3>Customer</h3>
                    <div class="main-div">{{ $invoice['name'] }}</div>
                    <div class="main-div">{{ $invoice['company_name'] }}</div>
                    <div class="main-div">{{ $invoice['address'] }}</div>
                    <div class="main-div">{{ $invoice['post_code'] }} {{ $invoice['city'] }}</div>
                    <div class="main-div">Telephone: {{ $invoice['phone'] }}</div>
                    <div class="main-div">Siret: {{ $invoice['siret'] }}</div>
                    <div class="main-div">RCS: {{ $invoice['rcs'] }}</div>
                    <div class="main-div">TVA: {{ $invoice['tva'] }}</div>
                    <table>
                        @foreach ($invoice['details'] as $item)
                            <tr>
                                <td>{{ $item['order'] }}</td>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ $item['price'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="main-div">TVA: {{ $invoice['total_tax'] }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>