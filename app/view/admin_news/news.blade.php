<!DOCTYPE html>
<html lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php $this->asset('plugin/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->asset('plugin/fontawesome-pro-5.7.2/all.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('plugin/alertifyjs/alertify.rtl.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('admin/css/style.css'); ?>">
    <?php $this->partial('admin.favicon'); ?>
    <title>خبر ها</title>
</head>

<body>
    <?php $this->partial("admin.navbar", ["url" => "news"]); ?>
    <?php $this->partial("admin.sidebar"); ?>
    <article class="wrapper">
        <div class="col-12">
            <div class="card-main">
                <div class="card-header clearfix">
                    <h2>لیست خبر ها</h2>
                    <a href="<?php $this->url('admin/news/create'); ?>" class="btn btn-success">ایجاد خبر جدید</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive resizable">
                        <table class="table-page">
                            <thead>
                                <tr>
                                    <th>تعداد</th>
                                    <th>تصویر</th>
                                    <th>عنوان گروه</th>
                                    <th>عنوان</th>
                                    <th>بازدید</th>
                                    <th>صفحه اصلی</th>
                                    <th>قابل نمایش</th>
                                    <th>نویسنده</th>
                                    <th>تاریخ ایجاد</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($newsCount > 0) { foreach ($news as $k => $n) {
                                $mainNewClass = $n['main_page'] ? "fas fa-check-square" : "fas fa-square";
                                $statusNewsClass = $n['status'] == "enable" ? "fas fa-eye" : "fas fa-eye-slash";
                                ?>
                                <tr>
                                    <td title="<?php echo $n['id'][0]; ?>"><?php echo intval($k) + 1; ?></td>
                                    <td><img class="img-outline" src="<?php $this->asset($n['image']); ?>" alt="<?php echo $n['title'][0]; ?>"></td>
                                    <td><?php echo $n['title'][1]; ?></td>
                                    <td class="title"><?php echo $n['title'][0]; ?></td>
                                    <td><?php echo $n['visit']; ?></td>
                                    <td class="check"><i class="<?php echo $mainNewClass; ?>"></i></td>
                                    <td class="eye"><i class="<?php echo $statusNewsClass; ?>"></i></td>
                                    <td><?php echo $n['username']; ?></td>
                                    <td><?php echo formattedDateSql($n['created_at'][0]); ?></td>
                                    <td class="single-line">
                                        <a href="<?php $this->url('admin/news/edit/'.$n['id'][0]); ?>" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?php $this->url('admin/news/show/'.$n['id'][0]); ?>" class="btn btn-icon btn-info"><i class="fas fa-info"></i></a>
                                        <a class="btn btn-icon btn-danger" onclick="deleteNews('<?php $this->url('admin/news/destroy/'.$n['id'][0]); ?>')"><i class="fas fa-trash"></i></a>
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
    <script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
    <script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
    <script>
        function deleteNews(url) {
            alertify.confirm(
                "حذف صفحه",
                "آیا از حذف این صفحه اطمینان دارید؟",
                function () {
                    $(location).attr("href", url);
                },
                function () {
                    alertify.error("شما از حذف صفحه منصرف شده اید");
                }
            );
        }
    </script>
</body>

</html>