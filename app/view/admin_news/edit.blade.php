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
    <title>ویرایش خبر</title>
</head>
<body class="scroll-hidden">
@php($url = "news")
@include('partial.admin.navbar')
@include('partial.admin.sidebar')
<article class="wrapper">
    <div class="col-12">
        <div class="card-main">
            <div class="card-header">
                <h2>فرم ویرایش خبر</h2>
            </div>
            <div class="card-body">
                <form action="<?php $this->url('admin/news/update/'.$singleNews['id']); ?>" method="post" enctype="multipart/form-data" id="admin-news">
                    <div class="form-horizontal selectBox">
                        <label for="group_id">گروه خبر</label>
                        <select class="form-control" id="group_id" name="group_id">
                            <?php foreach ($groups as $group) { ?>
                            <option value="<?php echo $group['id']; ?>"><?php echo $group['title']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-horizontal no-wrap-md">
                        <label for="title">عنوان خبر</label>
                        <div class="editor">
                            <input type="text" class="form-control" id="title" name="title" placeholder="عنوان خبر را وارد کنید" value="<?php echo $singleNews['title']; ?>">
                        </div>
                    </div>
                    <div class="form-horizontal no-wrap-md">
                        <label for="summary">توضیح مختصر</label>
                        <div class="editor">
                            <textarea class="form-control resizable" id="summary" name="summary" placeholder="توضیح مختصر خبر را وارد کنید"><?php echo $singleNews['summary']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <label for="body">توضیح خبر</label>
                        <div class="editor">
                            <textarea class="form-control" id="body" name="body" placeholder="توضیح خبر را وارد کنید"><?php echo $singleNews['body']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <label for="image">تصویر خبر</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img class="img-outline offset-form" src="<?php echo $this->asset($singleNews['image']); ?>" alt="<?php echo $this->asset($singleNews['title']); ?>">
                    </div>
                    <div class="form-horizontal no-wrap-md">
                        <label for="shortcut">میانبر</label>
                        <div class="editor">
                            <input type="text" class="form-control" id="shortcut" name="shortcut" placeholder="میانبر خبر را وارد کنید" value="<?php echo $singleNews['shortcut']; ?>">
                        </div>
                    </div>
                    <div class="form-horizontal selectBox">
                        <label for="status">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            <option value="enable">قابل نمایش</option>
                            <option value="disable">غیر قابل نمایش</option>
                        </select>
                    </div>
                    <div class="form-horizontal">
                        <label for="main_page">صفحه اصلی</label>
                        <label class="switch">
                            <input type="checkbox" id="main_page" name="main_page">
                            <span class="check-mark"></span>
                        </label>
                    </div>
                    <div class="form-horizontal">
                        <input type="submit" class="btn btn-success offset-form" value="ذخیره اطلاعات">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card-main mt-1">
            <div class="card-body row">
                <a href="<?php $this->url('admin/news'); ?>" class="btn btn-primary mr-2">بازگشت</a>
            </div>
        </div>
    </div>
</article>
<script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
<script src="<?php $this->asset('plugin/resize/resize-textarea.js'); ?>"></script>
<script src="<?php $this->asset('plugin/jquery/jquery.validate.min.js'); ?>"></script>
<script src="<?php $this->asset('admin/js/form_valid.js'); ?>"></script>
<script>
    let body = CKEDITOR.replace("body", {
        height: "150px",
        language: "fa",
        extraPlugins: "editorplaceholder",
        editorplaceholder: $("#body").attr("placeholder")
    });
    $("#group_id").val("<?php echo $singleNews['group_id']; ?>").change();
    $("#status").val("<?php echo $singleNews['status']; ?>").change();
    let summery = document.getElementById("summary");
    summery.style.height = (summery.scrollHeight + 8) + "px";
    $("#main_page").prop("checked", <?php echo $singleNews['main_page']; ?>);
</script>
</body>

</html>