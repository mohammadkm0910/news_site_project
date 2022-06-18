<!doctype html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="<?php $this->asset('plugin/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->asset('plugin/fontawesome-pro-5.7.2/all.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('admin/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('plugin/chartist-js/chartist.min.css'); ?>">
    @include('partial.admin.favicon')
    <title>مدیریت</title>
</head>
<body>
@php($url = "news")
@include('partial.admin.navbar')
@include('partial.admin.sidebar')
<article class="wrapper">
    <div class="row">
        <div class="col-3 col-sm-6">
            <div class="card bg-success">
                <p><i class="fas fa-pager"></i></p>
                <h3>تعداد اخبار قابل نمایش</h3>
                <p><?php echo $count['news_show_count']; ?></p>
            </div>
        </div>
        <div class="col-3 col-sm-6">
            <div class="card bg-primary">
                <p><i class="fas fa-pager"></i></p>
                <h3>تعداد اخبار</h3>
                <p><?php echo $count['news_count']; ?></p>
            </div>
        </div>
        <div class="col-3 col-sm-6">
            <div class="card bg-warning">
                <p><i class="fas fa-layer-group"></i></p>
                <h3>تعداد نظرات تایید شده</h3>
                <p>20</p>
            </div>
        </div>
        <div class="col-3 col-sm-6">
            <div class="card bg-success">
                <p><i class="fas fa-layer-group"></i></p>
                <h3>تعداد گروه های خبری</h3>
                <p><?php echo $count['group_count']; ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card-main">
                <div class="card-header">
                    <h2>کاربران وب سایت</h2>
                </div>
                <div class="card-body row">
                    <div class="col-6">
                        <div class="card bg-danger">
                            <p><i class="fas fa-comment-alt"></i></p>
                            <h3>تعداد نظرات</h3>
                            <p>20</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-success">
                            <p><i class="fas fa-user"></i></p>
                            <h3>تعداد کاربران سایت</h3>
                            <p><?php echo $count['user_count']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card-main">
                <div class="card-header">
                    <h2>میزان استفاده از مرورگر ها</h2>
                </div>
                <div class="card-body">
                    <div class="browser-chart"></div>
                    <div class="list-browser">
                        <p class="opera"><span></span>اپرا</p>
                        <p class="firefox"><span></span>فایرفاکس</p>
                        <p class="chrome"><span></span>کروم</p>
                        <p class="safari"><span></span>سافاری</p>
                        <p class="order"><span></span>دیگر</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<script src="<?php $this->asset('plugin/chartist-js/chartist.min.js'); ?>"></script>
<script src="<?php $this->asset('admin/js/main.js'); ?>"></script>

<link rel="stylesheet" href=>
<script>
    new Chartist.Pie(".browser-chart", {
        series: [10, 30, 37, 18, 3]
    }, {
        donut: true,
        donutWidth: 30,
        donutSolid: true,
        startAngle: 270,
        showLabel: true
    });
</script>
</body>
</html>