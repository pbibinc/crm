<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <title>Generate PDF Template using TCPDF</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            height:20px;
        }
        th {
            background-color: #f2f2f2;
        }
        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
        }
        .fillable-underline {
            border-bottom: 1px solid black;
            display: inline-block;
            width: 150px; /* Adjust the width as needed */
        }
    </style>
</head>
<body>

    <div id="image-placeholder"></div>

    <h1 style="text-align:center;">{!! $title !!}</h1>
    
    <div style="text-align:center;">
        <p>I, the undersigned, acknowledged that while I am working with Insuraprime Inc, I will take proper care of all company equipment and tools that I am entrusted with. I further understand that upon termination, I will return all property of Company and that the property will be returned in proper working order. I understand I may be held financially responsible for damaged property or if I lose any tools/equipment as mentioned below: </p>
    </div>

    {{-- <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>Description</th>
                <th>QTY</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
            <tr>
                <td>00222048825W21K</td>
                <td>Jabra Biz 2300</td>
                <td>1</td>
                <td>{!! $price !!}</td>
                <td>{!! $price !!}</td>
            </tr>
        </tbody>
    </table> --}}

    {{-- <div>
        <p>I understand that if damaged company property or tools is beyond three (3) years, I will not be held liable to it financially.</p>
        <p>I understand that failure to return equipment and tools will be considered theft and may lead to termination of my employment.</p>
    </div> --}}

    {{-- <div>

    </div> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>