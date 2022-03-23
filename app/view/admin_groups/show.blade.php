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
    <title>جزئیات گروه</title>
</head>
<body>
    <?php $this->partial("admin.navbar", ["url" => "groups"]); ?>
    <?php $this->partial("admin.sidebar"); ?>
    <article class="wrapper">
        <div class="col-12">
            <div class="card-main">
                <div class="card-header">
                    <h2>جزئیات گروه</h2>
                </div>
                <div class="card-body">
                    <dl class="dl-horizontal">
                        <dt>عنوان گروه:</dt>
                        <dd><?php echo $group['title']; ?></dd>
                        <dt>تاریخ ایجاد:</dt>
                        <dd><?php echo formattedDateSql($group['created_at']); ?></dd>
                        <dt>تاریخ بروزرسانی:</dt>
                        <dd><?php echo formattedDateSql($group['updated_at']); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-main mt-1">
                <div class="card-body row">
                    <a href="<?php $this->url('admin/groups'); ?>" class="btn btn-info mr-2">بازگشت</a>
                    <a onclick="editGroup('<?php $this->url('admin/groups/edit/'.$group['id']); ?>')" class="btn btn-warning mr-2">بروزرسانی</a>
                </div>
            </div>
        </div>
    </article>
    <script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
    <script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
    <?php if (isset($_SESSION['ERROR_GROUP'])) { ?>
        <script>
            alertify.error("<?php echo $_SESSION['ERROR_GROUP']; ?>");
            <?php unset($_SESSION['ERROR_GROUP']); ?>
        </script>
    <?php } ?>
</body>
</html>