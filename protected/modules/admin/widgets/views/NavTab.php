<ul class="nav nav-tabs" id="myTab">
  <?php
  foreach ($menus as $menu) {
    $li_css_class = array();
    if ($menu[1] == $current_menu) {
      $li_css_class['class'] = 'active';
    }
    echo CHtml::tag('li', $li_css_class);
    echo CHtml::link($menu[0], $menu[1]);
    echo CHtml::closeTag('li');
  }
  ?>
</ul>
