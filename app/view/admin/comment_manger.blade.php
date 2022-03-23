<!doctype html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="<?php $this->asset('plugin/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->asset('plugin/fontawesome-pro-5.7.2/all.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('plugin/alertifyjs/alertify.rtl.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('admin/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('plugin/chartist-js/chartist.min.css'); ?>">
    <?php $this->partial('admin.favicon'); ?>
    <title>مدیریت نظرات</title>
    <style></style>
</head>
<body>
<?php $this->partial("admin.navbar", ["url" => "comment-manger"]); ?>
<?php $this->partial("admin.sidebar"); ?>
<article class="wrapper">

    <div class="col-12">
        <div class="card-main">
            <div class="card-header">
                <h2>لیست نظرات سایت</h2>
            </div>
            <div class="card-body">
                <div class="card-main main-border">
                    <div class="card-header clearfix">
                        دیدن همه نظر ها
                        <button onclick="seenAllComment('<?php $this->url('admin/seen-all-comment'); ?>')" class="btn btn-resize btn-success">بله</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-group">
                        <thead>
                        <tr>
                            <th>تعداد</th>
                            <th>نام کاربری نظر دهنده</th>
                            <th>کدام خبر</th>
                            <th>تاریخ ثبت نظر</th>
                            <th>وضیعیت نظر</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($allCommentCount > 0) { foreach ($allComments as $key => $allComment) {
                            if ($allComment['status'][0] == "unseen")
                                $classCss = "btn btn-resize btn-warning";
                            elseif ($allComment['status'][0] == "seen")
                                $classCss = "btn btn-resize btn-primary";
                            elseif ($allComment['status'][0] == "approved")
                                $classCss = "btn btn-resize btn-success";
                            ?>
                            <tr>
                                <td title="<?php echo $allComment['id'][0]; ?>"><?php echo intval($key) + 1; ?></td>
                                <td><?php echo $allComment['username']; ?></td>
                                <td><?php echo $allComment['title']; ?></td>
                                <td><?php echo formattedDateSql($allComment['created_at'][0]); ?></td>
                                <td><button class="<?php echo $classCss; ?> status" onclick="switchStatus('<?php $this->url('admin/switch-status-comment/'.$allComment['id'][0]); ?>', this)"><?php echo $allComment['status'][0]; ?></button></td>
                                <td class="single-line">
                                    <a onclick="editComment('<?php echo $this->url('admin/edit-comment/'.$allComment['id'][0]); ?>', '<?php echo $key; ?>')" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                                    <a onclick="openShowComment('<?php echo $this->url('admin/show-comment/'.$allComment['id'][0]); ?>')" class="btn btn-icon btn-info"><i class="fas fa-info"></i></a>
                                    <a onclick="deleteComment('<?php echo $this->url('admin/destroy-comment/'.$allComment['id'][0]); ?>')" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</article>
<script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
<script src="<?php $this->asset('admin/js/main.js'); ?>"></script>

<script>
    function switchStatus(url , x) {
        $.ajax({
            type: "get",
            url: url,
            success: function (result) {
                let resultArray = result.split("@");
                x.setAttribute("class", resultArray[0] + " status");
                alertify.set('notifier','position', 'top-left');
                $("#unseen-label").html(resultArray[1]);
                switch (resultArray[0].toString()) {
                    case "btn btn-resize btn-primary":
                        x.innerHTML = "seen";
                        alertify.success("نظر خوانده شد");
                        break;
                    case "btn btn-resize btn-success":
                        x.innerHTML = "approved";
                        alertify.success("نظر تایید شد");
                        break;
                    case "btn btn-resize btn-warning":
                        x.innerHTML = "unseen";
                        alertify.success("نظر ناخوانا شد");
                        break;
                }
            }
        });
    }
    function editComment(url, index) {
        let status = document.getElementsByClassName("status")[index].innerText;
        $.ajax({
            type: "get",
            url: url,
            success: function (result) {
                if (status === "unseen") {
                    hideModalFooter(false);
                } else {
                    hideModalFooter(true);
                }
                alertify.alert(
                    "ویرایش نظر",
                    result
                );
            }
        });
    }
    function openShowComment(url) {
        $.ajax({
            type: "get",
            url: url,
            success: function (result) {
                hideModalFooter(false);
                alertify.alert(
                    "متن نظر",
                    result
                );
            }
        });
    }
    function deleteComment(url) {
        hideModalFooter(false);
        alertify.confirm(
            "حذف نظر",
            "آیا از حذف این نظر اطمینان دارید؟",
            function () {
                $(location).attr("href", url);
            },
            function () {
                alertify.set('notifier','position', 'top-right');
                alertify.error("شما از حذف گروه منصرف شده اید");
            }
        );
    }
    function hideModalFooter(isAdd) {
        let head = document.getElementsByTagName("head")[0];
        let defaultStyle = "<style></style>";
        let style = "<style>.ajs-footer { display: none; }</style>"
        if (isAdd) {
            head.innerHTML = head.innerHTML.replace(defaultStyle, style);
        } else {
            head.innerHTML = head.innerHTML.replace(style, defaultStyle);
        }
    }
    function seenAllComment(url) {
        hideModalFooter(false);
        alertify.confirm(
            "دیدن همه نظرات",
            "آیا خوانا کردن همه نظرات اطمینان دارید؟",
            function () {
                $(location).attr("href", url);
            },
            function () {
                alertify.set('notifier','position', 'top-right');
                alertify.error("شما از حذف گروه منصرف شده اید");
            }
        );
    }
</script>
<?php if (isset($_SESSION['COMMENT_ERROR'])) { ?>
    <script>
        alertify.set('notifier','position', 'top-left');
        alertify.error("<?php echo $_SESSION['COMMENT_ERROR']; ?>");
        <?php unset($_SESSION['COMMENT_ERROR']); ?>
    </script>
<?php } ?>
</body>
</html>