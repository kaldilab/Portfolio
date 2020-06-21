<?php $search = (isset($_GET['s'])) ? $_GET['s'] : null; ?>
<form role="search" action="<?php echo project_homeurl('/'); ?>">
  <input id="search" type="search" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" value="<?php echo $search; ?>" name="s" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
  <input type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
</form>