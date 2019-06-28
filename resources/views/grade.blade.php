<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}">
    <script src="{{ asset('public/js/jquery.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.js') }}"></script>
    <title>Document</title>
    <style>
        body{
            font-size: 18px;
            line-height: 20px;
        }
        label{
            margin:10px;
        }
        .a-radio{
            display: none;
        }
        .b-radio{
            display: inline-block;
            border:1px solid #ccc;
            width:16px;
            height: 16px;
            border-radius:2px;
            vertical-align: middle;
            margin-right: 5px;
            position: relative;
        }
        .b-radio:before{
            content: '';
            font-size: 0;
            width: 10px;
            height: 10px;
            /*background: rgb(143, 188, 238);*/
            background-color: #280fea;
            position: absolute;
            left:50%;
            top:50%;
            margin-left: -5px;
            margin-top: -5px;
            border-radius: 2px;
            display: none;
        }
        .a-radio:checked~.b-radio:before{
            display: block;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="page-header">
        <h1>月度打分 <small>李某某</small></h1>
    </div>
    <div>
        <label>
            <input type="radio" name="grade" id="" class="a-radio" checked>
            <span class="b-radio"></span>优（分值0.5分）
        </label>
    </div>
    <div>
        <label>
            <input type="radio" name="grade" id="" class="a-radio">
            <span class="b-radio"></span>良（分值0.3分）
        </label>
    </div>
    <div>
        <label>
            <input type="radio" name="grade" id="" class="a-radio">
            <span class="b-radio"></span>中（分值0.1分）
        </label>
    </div>
    <div>
        <label>
            <input type="radio" name="grade" id="" class="a-radio">
            <span class="b-radio"></span>差（分值0分）
        </label>
    </div>
    <div>
        <textarea class="form-control" rows="3" placeholder="请输入此次打分备注"></textarea>
    </div>
    <br>
    <div>
        <button type="button" class="btn btn-primary btn-lg btn-block">提交</button>
    </div>

</div>
</body>
</html>