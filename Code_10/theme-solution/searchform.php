<?php $search = (isset($_GET['s'])) ? $_GET['s'] : null; ?>
<form role="search" action="<?php echo project_homeurl('/'); ?>">
  <label class="label" for="search"><?php echo (is_search()) ? '검색결과' : '검색어'; ?></label>
  <input class="search form-control" type="search" id="search" name="s" value="<?php echo $search; ?>" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
  <label class="submit"><input class="sr-only" type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>"></label>
</form>