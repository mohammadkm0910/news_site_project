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
    <title>گروه های خبری</title>
</head>

<body>
    <?php $this->partial("admin.navbar", ["url" => "groups"]); ?>
    <?php $this->partial("admin.sidebar"); ?>
    <article class="wrapper">
        <div class="card-main">
            <div class="card-header clearfix">
                <h2>لیست گروه های خبری</h2>
                <button onclick="createGroup()" class="btn btn-success">ایجاد گروه جدید</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-group">
                        <thead>
                        <tr>
                            <th>تعداد</th>
                            <th>عنوان</th>
                            <th>تاریخ ایجاد</th>
                            <th>تاریخ بروزرسانی</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($groups as $key => $group) {
                            $id = $group['id'];
                            ?>
                            <tr>
                                <td title="<?php echo $id; ?>"><?php echo intval($key) + 1; ?></td>
                                <td><?php echo $group['title']; ?></td>
                                <td><?php echo formattedDateSql($group['created_at']); ?></td>
                                <td><?php echo formattedDateSql($group['updated_at']); ?></td>
                                <td class="single-line">
                                    <a onclick="editGroup('<?php $this->url('admin/groups/edit/'.$id); ?>')" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="<?php $this->url('admin/groups/show/'.$id); ?>" class="btn btn-icon btn-info"><i class="fas fa-info"></i></a>
                                    <a onclick="deleteGroup('<?php $this->url('admin/groups/destroy/'.$id); ?>')" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </article>
    <script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
    <script src="<?php $this->asset('admin/js/main.js'); ?>"></script>
    <script>
        function deleteGroup(url) {
            alertify.confirm(
                "حذف گروه",
                "آیا از حذف این گروه اطمینان دارید؟",
                function () {
                    $(location).attr("href", url);
                },
                function () {
                    alertify.error("شما از حذف گروه منصرف شده اید");
                }
            ).set('basic', false);
        }
        function createGroup() {
            $.ajax({
                type: "GET",
                url: "<?php $this->url('admin/groups/create'); ?>",
                success: function (result) {
                    alertify.confirm(
                        "ایجاد گروه جدید",
                        result,
                        function () {},
                        function () {}
                    ).set('basic', true);
                }
            });
        }
    </script>
    <?php if (isset($_SESSION['ERROR_GROUP'])) { ?>
        <script>
            alertify.error("<?php echo $_SESSION['ERROR_GROUP']; ?>");
            <?php unset($_SESSION['ERROR_GROUP']); ?>
        </script>
    <?php } ?>
</body>

</html>