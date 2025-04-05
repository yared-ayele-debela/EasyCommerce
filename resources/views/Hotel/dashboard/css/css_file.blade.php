<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Restaurant Dashboard</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{asset('dashboard/img/Logo.png')}}" rel="icon">
    <link href="{{asset('dashboard/img/Logo.png')}}" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{asset('dashboard/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/simple-datatables.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: white !important;
            border: 1px solid #dddddd !important;
            border-radius: 4px;
            cursor: text;
            padding-bottom: 15px !important;
            padding-right: 5px;
            position: relative;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #19403C !important;
            border: none !important;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            margin-left: 5px;
            margin-top: 5px;
            padding: 0;
            padding-left: 20px;
            position: relative;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: bottom;
            white-space: nowrap;
            color: white !important;
        }

    </style>
</head>
<body>

