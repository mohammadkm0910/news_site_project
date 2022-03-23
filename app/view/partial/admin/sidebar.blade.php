<aside class="sidebar">
    <ul class="sidebar-list">
        <li class="<?php echo activePage('admin'); ?>">
            <a href="<?php $this->url('admin'); ?>">
                <i class="fas fa-tachometer-alt"></i>
                داشبورد
            </a>
        </li>
        <li class="<?php echo activePage('news'); ?>">
            <a href="<?php $this->url('admin/news'); ?>">
                <i class="fas fa-pager"></i>
                لیست خبر ها
            </a>
        </li>
        <li class="<?php echo activePage('groups'); ?>">
            <a href="<?php $this->url('admin/groups'); ?>">
                <i class="fas fa-layer-group"></i>
                لیست گروه ها
            </a>
        </li>
        <li class="<?php echo activePage('list-user'); ?>">
            <a href="<?php $this->url('admin/list-user'); ?>">
                <i class="fas fa-users"></i>
                لیست کاربران
            </a>
        </li>
        <li class="<?php echo activePage('comment-manger'); ?>">
            <a href="<?php $this->url('admin/comment-manger'); ?>">
                <i class="fas fa-comment-check"></i>
                مدیریت نظرات
            </a>
        </li>
        <li>
            <a href="<?php $this->url('/'); ?>">
                <i class="fas fa-home"></i>
                سایت اصلی
            </a>
        </li>
    </ul>
</aside>
