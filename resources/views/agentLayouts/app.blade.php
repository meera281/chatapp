<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />         <!-- csrf-token -->

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

         <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
        <!-- J-query link -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>


        <style>
            body{
                background-color: #f4f7f6;
               
            }
            .card {
                background: #fff;
                transition: .5s;
                border: 0;
                margin-bottom: 30px;
                border-radius: .55rem;
                position: relative;
                width: 100%;
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
            }
            .chat-app .people-list {
                width: 280px;
                position: absolute;
                left: 0;
                top: 0;
                padding: 20px;
                z-index: 7
            }

            .chat-app .chat {
                margin-left: 280px;
                border-left: 1px solid #eaeaea
            }

            .people-list {
                -moz-transition: .5s;
                -o-transition: .5s;
                -webkit-transition: .5s;
                transition: .5s
            }

            .people-list .chat-list li {
                padding: 10px 0px;
                list-style: none;
                border-radius: 3px
            }

            .people-list .chat-list li:hover {
                background: #efefef;
                cursor: pointer
            }

            .people-list .chat-list li.active {
                background: #efefef
            }

            .people-list .chat-list li .name {
                font-size: 15px
            }

            .people-list .chat-list img {
                width: 45px;
                border-radius: 50%
            }

            .people-list img {
                float: left;
                border-radius: 50%
            }

            .people-list .about {
                float: left;
                padding-left: 8px
            }

            .people-list .status {
                color: #999;
                font-size: 13px
            }

            .chat .chat-header {
                padding: 15px 20px;
                border-bottom: 2px solid #f4f7f6
            }

            .chat .chat-header img {
                float: left;
                border-radius: 40px;
                width: 40px
            }

            .chat .chat-header .chat-about {
                float: left;
                padding-left: 10px
            }

            .chat .chat-history {
                padding: 20px;
                padding-bottom: 0px;
                border-bottom: 2px solid #fff
            }

            .chat .chat-history ul {
                padding: 0
            }

            .chat .chat-history ul li {
                list-style: none;
                /* margin-bottom: 30px */
            }

            .chat .chat-history ul li:last-child {
                margin-bottom: 0px
            }

            .chat .chat-history .message-data {
                margin-bottom: 5px
            }

            .chat .chat-history .message-data img {
                border-radius: 40px;
                width: 40px
            }

            .chat .chat-history .message-data-time {
                color: #434651;
                padding-left: 6px
            }

            .chat .chat-history .message {
                color: #444;
                padding: 8px 10px;
                line-height: 26px;
                font-size: 16px;
                border-radius: 7px;
                display: inline-block;
                position: relative
            }

            .chat .chat-history .message:after {
                bottom: 100%;
                left: 7%;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
                border-bottom-color: #fff;
                border-width: 10px;
                margin-left: -10px
            }

            .chat .chat-history .my-message {
                background: #efefef;
                margin-right:25%;
            }

            .chat .chat-history .my-message:after {
                bottom: 100%;
                left: 30px;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
                border-bottom-color: #efefef;
                border-width: 10px;
                margin-left: -10px
            }

            .chat .chat-history .other-message {
                background: #e8f1f3;
                text-align: right;
                margin-left:25%;
            }

            .chat .chat-history .other-message:after {
                border-bottom-color: #e8f1f3;
                left: 93%
            }

            .chat .chat-message {
                padding: 0px
            }

            .online,
            .offline,
            .me {
                margin-right: 2px;
                font-size: 8px;
                vertical-align: middle
            }

            .online {
                color: #86c541
            }

            .offline {
                color: #e47297
            }

            .me {
                color: #1d8ecd
            }

            .float-right {
                float: right
            }

            .clearfix:after {
                visibility: hidden;
                display: block;
                font-size: 0;
                content: " ";
                clear: both;
                height: 0
            }

            @media only screen and (max-width: 767px) {
                .chat-app .people-list {
                    height: 465px;
                    width: 100%;
                    overflow-x: auto;
                    background: #fff;
                    left: -400px;
                    display: none
                }
                .chat-app .people-list.open {
                    left: 0
                }
                .chat-app .chat {
                    margin: 0
                }
                .chat-app .chat .chat-header {
                    border-radius: 0.55rem 0.55rem 0 0
                }
                .chat-app .chat-history {
                    height: 300px;
                    overflow-x: auto
                }
            }

            @media only screen and (min-width: 768px) and (max-width: 992px) {
                .chat-app .chat-list {
                    height: 650px;
                    overflow-x: auto
                }
                .chat-app .chat-history {
                    height: 600px;
                    overflow-x: auto
                }
            }

            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
                .chat-app .chat-list {
                    height: 480px;
                    overflow-x: auto
                }
                .chat-app .chat-history {
                    height: calc(100vh - 350px);
                    overflow-x: auto
                }
            }
        </style>

    </head>


    <body class="hold-transition sidebar-mini" style="overflow-x:hidden;overflow-y:hidden;">
        <div class="wrapper">

            @include('agentLayouts.header')  
            @include('agentLayouts.sidebar') 
            @yield('agentcontent')
            @include('agentLayouts.footer') 

        </div>

    </body>

</html>