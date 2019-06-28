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
            border: none;
            padding: 0;
            margin: 0;
            background-color: #eef8f0;
        }
        .head {
            display: inline-block;
            width: 100%;
            height: 14em;
            background-color: #01d372;
            text-align: center;
        }
        .head-image {
            display: inline-block;
            width: 8em;
            height: 8em;
            position: relative;
            top: -3em;
        }

        .head-body {
            position: relative;
            display: inline-block;
            width: 96%;
            height: 15em;
            margin-top: 4em;
            border-radius: 5px;
            background-image: url("https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=542772945,3876586751&fm=26&gp=0.jpg");
        }
        .head-title {
            width: 100%;
            text-align: center;
            position: relative;
            top: -3.2em;
        }
        .head-content {
            display: flex;
            width: 100%;
        }
        .head-content-flex {
            height: 5.5em;
            flex: 1;
            position: relative;
            top: -3em;
            text-align: center;
            justify-content: center;
            align-content: center;
        }
        .pad-1 {
            margin-top: 1em;
        }
        .head-title p {
            margin: 0;
        }
        .bold {
            font-weight: 500;
        }
        .font-18 {
            font-size: 1.1em;
        }
        .font-14 {
            font-size: 0.9em;
        }
        .gray {
            color: gray;
        }
        .img {
            width: 100%;
        }
        .content {
            display: inline-block;
            width: 100%;
            padding: 0 1em;
            margin-top: 2.2em;
            line-height: 3em;
            font-size: 1.2em;
            background-color: #FFFFFF;
        }
        a:visited {
            text-decoration-line: none;
        }
        .pad-bottom{
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .img-title {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        .grade {
            display: inline-block;
            width: 4em;
            height: 1.6em;
            line-height: 1.6em;
            border: 1px solid #01d372;
            background-color: #01d372;
            position: absolute;
            right: 0;
            z-index: 2;
            top: 1.8em;
            border-top-left-radius:2em;
            border-bottom-left-radius:2em;
		    text-align: left;
		    padding-left: 0.8em;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
<div class="head">
    <div class="head-body" >
        <div style="width: 100%"><div id="grade" onclick="window.location.href = 'grade'" class="grade">打分</div></div>
        <div class="head-image" >
            <img class="img" src="http://img.sccnn.com/bimg/338/49439.jpg" alt="">
        </div>
        <div class="head-title">
            <p class="font-18 bold">李某某家庭</p>
            <p class="gray font-14">2020年段先进荣誉</p>
        </div>
        <div class="head-content">
            <div class="head-content-flex">
                <div class="content-text pad-1">300</div>
                <div class="content-text font-14 gray">打分次数</div>
            </div>
            <div class="head-content-flex">
                <div class="content-text pad-1">48</div>
                <div class="content-text font-14 gray">当前积分</div>
            </div>
            <div class="head-content-flex" onclick="window.location.href = 'list'">
                <div class="content-text pad-1">148</div>
                <div class="content-text font-14 gray">当前排名</div>
            </div>
        </div>
    </div>
</div>
<span class="content" onclick="window.location.href = 'rank'">
    <div class="row">
        <div class="col-md-9 col-xs-9"><span href="#">他的打分记录
                <span class="badge" style="background-color: green">42</span></span>
        </div>
        <div class="col-md-3 col-xs-3" style="line-height: 3em;text-align: right"><span style="vertical-align: middle" class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
    </div>
</span>
<div style="padding: 1em">
    <div class="row" style="background-color: #FFFFFF">
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
        <div class="col-xs-4 pad-bottom">
            <img src="http://img1.imgtn.bdimg.com/it/u=677835708,1097135857&fm=26&gp=0.jpg" alt="..." class="img-thumbnail">
            <span class="img-title">先进家庭</span>
        </div>
    </div>
</div>

</body>
</html>