<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $appsettings[0]['application_title'] }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ $appsettings[0]['favicon'] }}" rel="shortcut icon">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @livewireStyles
    <style>
    .popover-container {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .popover-content {
      visibility: hidden;
      width: 200px;
      background-color: #504d4d;
      color: #fff !important;
      text-align: left;
      border-radius: 6px;
      padding: 10px;
      position: absolute;
      z-index: 100;
      bottom: 125%; /* Position above the trigger */
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .popover-content::after {
      content: '';
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      border-width: 6px;
      border-style: solid;
      border-color: #333 transparent transparent transparent;
    }

    .popover-container:hover .popover-content {
      visibility: visible;
      opacity: 1;
    }
        .btn-close-white {
            filter: invert(1);
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        .rounded {
            border-radius: 0.5rem !important;
            border: none;
        }

        .cont {
            position: relative;
        }

        .popover-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            outline: none;
            position: relative;
            z-index: 1;
        }

        .popover {
            display: none;
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            width: 130px;
            z-index: 100;
        }

        .popover::before {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            border:none;
        }

        .popover-content {
            padding: 10px;
            color: #333;
        }

        /* Show popover on hover */
        .cont:hover .popover {
            display: block;
        }


        .video-div{
            border: 2px dashed #d3d3d3;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        /* for upload image */

        .file-uploader {
            border: 2px dashed #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            width: 100%;
        }
        .file-drop-area {
            padding: 20px;
            border: 2px dashed #007bff;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .file-drop-area:hover {
            background-color: #f1f1f1;
        }
        .file-drop-area.active {
            background-color: #e1e1e1;
        }
        .file-drop-area p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }
        .file-drop-area input[type="file"] {
            display: none;
        }
        .radius-10 {
    border-radius: 10px !important;
}

.border-info {
    border-left: 5px solid  #0dcaf0 !important;
}
.border-danger {
    border-left: 5px solid  #fd3550 !important;
}
.border-success {
    border-left: 5px solid  #15ca20 !important;
}
.border-warning {
    border-left: 5px solid  #ffc107 !important;
}


.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid rgba(0, 0, 0, 0);
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}
.bg-gradient-scooter {
    background: #17ead9;
    background: -webkit-linear-gradient(
45deg
 , #17ead9, #6078ea)!important;
    background: linear-gradient(
45deg
 , #17ead9, #6078ea)!important;
}
.widgets-icons-2 {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ededed;
    font-size: 27px;
    border-radius: 10px;
}
.rounded-circle {
    border-radius: 50%!important;
}
.text-white {
    color: #fff!important;
}
.ms-auto {
    margin-left: auto!important;
}
.bg-gradient-bloody {
    background: #f54ea2;
    background: -webkit-linear-gradient(
45deg
 , #f54ea2, #ff7676)!important;
    background: linear-gradient(
45deg
 , #f54ea2, #ff7676)!important;
}

.bg-gradient-ohhappiness {
    background: #00b09b;
    background: -webkit-linear-gradient(
45deg
 , #00b09b, #96c93d)!important;
    background: linear-gradient(
45deg
 , #00b09b, #96c93d)!important;
}

.bg-gradient-blooker {
    background: #ffdf40;
    background: -webkit-linear-gradient(
45deg
 , #ffdf40, #ff8359)!important;
    background: linear-gradient(
45deg
 , #ffdf40, #ff8359)!important;
}
.activity_body {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

