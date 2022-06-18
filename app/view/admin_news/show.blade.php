<!DOCTYPE html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php $this->asset('plugin/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php $this->asset('plugin/ckeditor/ckeditor.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->asset('plugin/fontawesome-pro-5.7.2/all.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('admin/css/style.css'); ?>">
    @include('partial.admin.favicon')
    <style>
        .cke_inner .cke_top .cke_toolbox {
            display: none;
        }
    </style>
    <title>جزئیات خبر</title>
</head>
<body>
@php($url = "news")
@include('partial.admin.navbar')
@include('partial.admin.sidebar')
<article class="wrapper">
    <div class="col-12">
        <div class="card-main">
            <div class="card-header">
                <h2>جزیئات صفحه</h2>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <?php
                    $mainNewClass = $singleNews['main_page'] ? "fas fa-check-square" : "fas fa-square";
                    $statusNewsClass = $singleNews['status'] == "enable" ? "fas fa-eye" : "fas fa-eye-slash";
                    ?>
                    <dt>عنوان گروه:</dt>
                    <dd><?php echo $singleNews['title'][1]; ?></dd>
                    <dt>عنوان خبر:</dt>
                    <dd><?php echo $singleNews['title'][0]; ?></dd>
                    <dt>توضیح مختصر خبر:</dt>
                    <dd class="text-justify"><?php echo $singleNews['summary']; ?></dd>
                    <dt><label for="body">توضیح خبر</label></dt>
                    <dd>
                        <textarea id="body"><?php echo $singleNews['body']; ?></textarea>
                    </dd>
                    <dt>تصویر:</dt>
                    <dd>
                        <img src="<?php echo $this->asset($singleNews['image']); ?>"
                             alt="<?php echo $singleNews['title'][0]; ?>" class="img-shadow">
                    </dd>
                    <dt>بازدید:</dt>
                    <dd><?php echo $singleNews['visit']; ?></dd>
                    <dt>اسلایدر:</dt>
                    <dd class="check"><i class="<?php echo $mainNewClass; ?>"></i></dd>
                    <dt>قابل نمایش:</dt>
                    <dd class="eye"><i class="<?php echo $statusNewsClass; ?>"></i></dd>
                    <dt>تاریخ ایجاد خبر:</dt>
                    <dd><?php echo formattedDateSql($singleNews['created_at'][0]); ?></dd>
                    <dt>تاریخ ویرایش خبر:</dt>
                    <dd><?php echo formattedDateSql($singleNews['updated_at'][0]); ?></dd>
                    <dt>میانبر خبر:</dt>
                    <dd><?php echo $singleNews['shortcut'] ?? "مینابری برای این خبر وارد نشده"; ?></dd>
                    <dt>نویسنده خبر:</dt>
                    <dd><?php echo $singleNews['username']; ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card-main mt-1">
            <div class="card-body row">
                <a href="<?php $this->url('admin/news'); ?>" class="btn btn-info mr-2">بازگشت</a>
                <a href="<?php $this->url('admin/news/edit/'.$singleNews['id'][0]); ?>" class="btn btn-warning mr-2">بروزرسانی</a>
            </div>
        </div>
    </div>
</article>
<script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
<script>
    CKEDITOR.replace("body", {
        language: "fa",
        readOnly: true,
    });
</script>
</body>
</html>