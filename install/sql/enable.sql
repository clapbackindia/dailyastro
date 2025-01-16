
-- SETTINGS

SET @iTypeOrder = (SELECT IFNULL(MAX(`order`), 0) + 1 FROM `sys_options_types` WHERE `group` = 'modules');
INSERT INTO `sys_options_types` (`group`, `name`, `caption`, `icon`, `order`) VALUES 
('modules', 'cb_dailyastro', '_cb_dailyastro_adm_stg_cpt_type', 'cb_dailyastro@modules/clapback/dailyastro/|std-icon.svg', @iTypeOrder);
SET @iTypeId = LAST_INSERT_ID();

INSERT INTO `sys_options_categories` (`type_id`, `name`, `caption`, `order` )  
VALUES (@iTypeId, 'cb_dailyastro_general', '_cb_dailyastro_adm_stg_cpt_category_general', 1);
SET @iCategoryId = LAST_INSERT_ID();

INSERT INTO `sys_options`(`category_id`, `name`, `caption`, `value`, `type`, `extra`, `check`, `check_error`, `order`) VALUES
(@iCategoryId, 'cb_dailyastro_repeat_times', '_cb_dailyastro_option_repeat_times', '3', 'digit', '', '', '', 1);

