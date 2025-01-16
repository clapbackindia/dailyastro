-- Create daily astro messages table
CREATE TABLE IF NOT EXISTS `cb_daily_astro` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `message` text NOT NULL,
    `created` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default message
INSERT INTO `cb_daily_astro` (`id`, `message`, `created`) VALUES
(1, 'Welcome to Daily Astro!', UNIX_TIMESTAMP());

-- Remove any existing blocks first
DELETE FROM `sys_pages_blocks` WHERE `module` = 'cb_dailyastro';

-- Add Page Builder block
INSERT INTO `sys_pages_blocks` (`object`, `cell_id`, `module`, `title`, `title_system`, `designbox_id`, `visible_for_levels`, `type`, `content`, `text`, `text_updated`, `help`, `deletable`, `copyable`, `order`, `active`) VALUES
('sys_home', 0, 'cb_dailyastro', '_cb_dailyastro', '_cb_dailyastro_page_block_title_manage', 0, 2147483647, 'service', 'a:3:{s:6:"module";s:13:"cb_dailyastro";s:6:"method";s:9:"get_block";s:6:"params";a:0:{}}','',0,'', 1, 1, 0, 1);

-- STUDIO WIDGET

INSERT INTO `sys_std_pages`(`index`, `name`, `header`, `caption`, `icon`) VALUES
(3, 'cb_dailyastro', '_cb_dailyastro', '_cb_dailyastro', 'cb_dailyastro@modules/clapback/dailyastro/|std-icon.svg');

SET @iPageId = LAST_INSERT_ID();
SET @iParentPageId = (SELECT `id` FROM `sys_std_pages` WHERE `name` = 'home');
SET @iParentPageOrder = (SELECT IFNULL(MAX(`order`), 0) + 1 FROM `sys_std_pages_widgets` WHERE `page_id` = @iParentPageId);

INSERT INTO `sys_std_widgets` (`page_id`, `module`, `url`, `click`, `icon`, `caption`, `cnt_notices`, `cnt_actions`) VALUES
(@iPageId, 'cb_dailyastro', '{url_studio}module.php?name=cb_dailyastro', '', 'cb_dailyastro@modules/clapback/dailyastro/|std-icon.svg', '_cb_dailyastro', '', 'a:4:{s:6:"module";s:6:"system";s:6:"method";s:11:"get_actions";s:6:"params";a:0:{}s:5:"class";s:18:"TemplStudioModules";}');

INSERT INTO `sys_std_pages_widgets` (`page_id`, `widget_id`, `order`) VALUES
(@iParentPageId, LAST_INSERT_ID(), @iParentPageOrder);
