<style>
    .nav li+.nav-header {
        margin-top: 9px;
        color: #333;
        font-weight: normal;
        font-size: 14px;
        cursor: pointer;
    }
    .nav li+.nav-header:hover{
        text-shadow: 0 -1px 0 rgba(0,0,0,0.2);
        background-color: #eee;
    }

    .nav .nav-header {
        margin-top: 9px;
        color: #777;
        font-weight: normal;
        font-size: 14px;
    }
    .mycollapse a{
        color: #333;
    }
    .nav > .active > a {
        border-radius:4px;
        text-shadow: 0 1px 0 rgba(0,0,0,.15);
        box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
    }
</style>
<!--
<ul class="nav nav-list bs-docs-sidenav affix">
<?php foreach ($category as $key => $cname) { ?>
                <li>
                    <a href="#dropdowns"><i class="icon-chevron-right"></i> <?php echo $cname; ?></a>
                </li>
<?php } ?>
</ul>
-->
<ul class="nav nav-list well">
    <li class="nav-header">功能导航</li>
    <?php foreach ($category as $key => $cname): ?>
        <li class="divider"></li>
        <li class="nav-header" data-toggle="collapse" data-target="#nav_<?php echo $key; ?>">
            <?php echo $cname; ?>
            <?php if (!empty($menus[$key])): ?>
                <?php if ($key == $ac): ?>
                    <i class="icon-chevron-down pull-right" ></i>
                <?php else: ?>
                    <i class="icon-chevron-right pull-right"></i>
                <?php endif; ?>
            <?php endif; ?>
        </li>
        <?php if (array_key_exists($key, $menus)): ?>
            <?php if ($key == $ac): ?>
                <?php echo CHtml::tag('ul', array('id' => 'nav_' . $key, 'class' => 'mycollapse nav nav-list collapse in')); ?>
            <?php else: ?>
                <?php echo CHtml::tag('ul', array('id' => 'nav_' . $key, 'class' => 'mycollapse nav nav-list collapse')); ?>
            <?php endif; ?>
            <?php foreach ($menus[$key] as $menu): ?>
                <?php $li_css_class = array(); ?>
                <?php if ($menu[1] == $am): ?>
                    <?php $li_css_class['class'] = 'active'; ?>
                <?php endif; ?>
                <?php echo CHtml::tag('li', $li_css_class); ?>
                <?php echo CHtml::link($menu[0], $menu[1]); ?>
                <?php echo CHtml::closeTag('li'); ?>
            <?php endforeach; ?>
            <?php echo CHtml::closeTag('ul'); ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
<script type="text/javascript">
    $('.mycollapse').on('show', function() {
        $(this).prev().children(':last').removeClass('icon-chevron-right').addClass('icon-chevron-down');
    });
    $('.mycollapse').on('hide', function() {
        $(this).prev().children(':last').removeClass('icon-chevron-down').addClass('icon-chevron-right');
    });
</script>