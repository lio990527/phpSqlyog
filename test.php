<?php 


$s = 'SELECT * FROM xyb_trial_class_student,xyb_trial_class where 1=1';
$s2 = "SELECT `xyb_trial_class_student`.*, `xyb_trial_class`.`id` AS `class_id`, `xyb_trial_class`.`name` AS `class_name`, `xyb_trial_class`.`total_count`, `xyb_trial_class`.`notify_uid`, `xyb_trial_class`.`contact_phone` AS `class_phone`, `xyb_trial_class`.`apply_need`, `xyb_trial_class`.`original_price`, `xyb_merchant`.`merchant_name`
FROM xyb_trial_class_student
,`xyb_trial_class`
,`xyb_merchant`
WHERE `xyb_trial_class_student`.`id` = '230' AND `xyb_trial_class`.`id` = `xyb_trial_class_student`.`class_id` AND `xyb_merchant`.`id` = `xyb_trial_class_student`.`merchant_id`
AND `xyb_trial_class_student`.`deleted_at` = 0";

var_dump(preg_replace('/.*\s*from\s+(\w+)\s*.*/i', '$1', $s));
preg_match('/.*\s*from\s+(\w+)\s*.*/i', $s, $res1);
var_dump($res1,'----');
var_dump(preg_replace('/.*\s*from\s+`?(\w+)`?\n?\s?\s*.*/i', '${1}', $s2));
preg_match('/from\s*`?(\w+)`?/i', $s2, $res);
var_dump($res);