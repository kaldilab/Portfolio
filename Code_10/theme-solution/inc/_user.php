<?php
// change title field label
function acf_change_field_label_title($field)
{
  $field['label'] = "제목";
  return $field;
}
add_filter('acf/prepare_field/name=_post_title', 'acf_change_field_label_title');
function acf_change_field_label_content($field)
{
  $field['label'] = "내용";
  return $field;
}
add_filter('acf/prepare_field/name=_post_content', 'acf_change_field_label_content');

// change validate value
function acf_change_validate_value($valid, $value, $field)
{
  if (empty($value) && $field['required']) {
    $valid = '필수 항목입니다.';
  }
  return $valid;
}
add_filter('acf/validate_value', 'acf_change_validate_value', 10, 4);
// add_filter('acf/validate_value/name=_post_title', 'acf_change_validate_value', 10, 4);
// add_filter('acf/validate_value/name=_post_content', 'acf_change_validate_value', 10, 4);

// change validate message
function acf_change_validate_message()
{
  if (!is_admin()) {
    acf_localize_text(array(
      'Validation successful' => __('검증 성공!', 'acf'),
      'Validation failed' => __('검증 실패', 'acf'),
      '1 field requires attention' => __('필수 항목 1개가 누락되었습니다.', 'acf'),
      '%d fields require attention' => __('필수 항목 %d개가 누락되었습니다.', 'acf'),
    ));
  }
}
add_action('acf/enqueue_scripts', 'acf_change_validate_message', 10, 0);
