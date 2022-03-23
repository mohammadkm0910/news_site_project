<div class="card-main main-border">
    <div class="card-header">
        <h2>فرم ایجاد گروه جدید</h2>
    </div>
    <div class="card-body">
        <form method="post" action="<?php $this->url('admin/groups/store'); ?>">
            <div class="form-horizontal">
                <label for="title">عنوان گروه</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="عنوان گروه را وارد کنید">
            </div>
            <div class="form-horizontal main-border">
                <input type="submit" class="btn btn-success offset-form" value="ذخیره اطلاعات">
                <a href="<?php $this->url('admin/groups'); ?>" class="btn btn-info mr-2">بازگشت</a>
            </div>
        </form>
    </div>
</div>

