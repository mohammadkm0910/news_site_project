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
@php($url = "list-user")
@include('partial.admin.navbar')
@include('partial.admin.sidebar')
<article class="wrapper">
    <div class="col-12">
        <div class="card-main">
            <div class="card-header">
                <h2>لیست کاربران سایت</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-group">
                        <thead>
                        <tr>
                            <th>تعداد</th>
                            <th>نام کاربری</th>
                            <th>ایمیل کاربر</th>
                            <th>تاریخ ثبت نام</th>
                            <th>نوع دسترسی</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($allUsers as $key => $allUser ) {
                            $titleUser = \Core\Service::loginUser() == $allUser ? "مدیر سایت" : null;
                            ?>
                            <tr <?php if ($titleUser != null) { ?> title="مدیر سایت" <?php } ?>>
                                <td title="<?php echo $allUser['id']; ?>"><?php echo intval($key) + 1; ?></td>
                                <td><?php echo $allUser['username']; ?></td>
                                <td><?php echo $allUser['email']; ?></td>
                                <td><?php echo formattedDateSql($allUser['created_at']); ?></td>
                                <?php if ($allUser['permission'] == "admin") { ?>
                                    <th><a href="<?php $this->url('admin/switch-user/'.$allUser['id']); ?>" class="btn btn-resize btn-danger">تبدیل به کاربر</a></th>
                                <?php } else { ?>
                                    <th><a href="<?php $this->url('admin/switch-user/'.$allUser['id']); ?>" class="btn btn-resize btn-primary">تبدیل به مدبر</a></th>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</article>
<script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
</body>
</html>