-- Drop daily astro messages table
DROP TABLE IF EXISTS `cb_daily_astro`;

-- Remove Page Builder block
DELETE FROM `sys_pages_blocks` WHERE `module` = 'cb_dailyastro';


-- STUDIO WIDGET

DELETE FROM `tp`, `tw`, `tpw`
USING `sys_std_pages` AS `tp`, `sys_std_widgets` AS `tw`, `sys_std_pages_widgets` AS `tpw`
WHERE `tp`.`id` = `tw`.`page_id` AND `tw`.`id` = `tpw`.`widget_id` AND `tp`.`name` = 'cb_dailyastro';

