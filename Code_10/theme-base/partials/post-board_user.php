<?php
$terms = get_the_terms(false, 'tax_board_user');
$term = ($terms) ? ('<span>[' . $terms[0]->name . ']</span>') : '';
echo '<tr>';
echo '<td>' . $term . ' <a href="' . project_permalink() . '">' . get_the_title() . '</a></td>';
echo '<td>' . get_the_date() . ' ' . get_the_time() . '</td>';
echo '</tr>';
