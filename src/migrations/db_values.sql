insert  into `users`(`id`,`name`,`email`,`password`,`user_role`,`remember_token`,`created_at`,`updated_at`) values
  (1,'admin','admin@example.com','$2y$10$JQXp3W.zDysIZYWeTWfttOaY65OB70lhnXLtuVoJJCMZAg5fJ0LTS',1,'7vlXwr7tiEudzClurrZZbBZ8W97KpLlHWEXRjrfRr2x3LvgFSBzHGTeWraTy','2017-06-10 07:00:32','2017-06-10 07:00:32');

/*Data for the table `menus` */
INSERT INTO `menus` (`id`, `name`, `is_active`, `parent`, `c_order`, `route`, `icon`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
  (1, 'Advance Settings', 'active', 0, 1, '', 'fa fa-wrench', 1, 1, '2016-05-19 05:23:55', '2017-01-12 18:38:35'),
  (3, 'Admin Menu', 'active', 1, 1, 'menus', 'fa fa-sliders', 1, 1, '2016-05-19 04:43:50', '2017-01-12 18:41:36'),
  (4, 'Admin Menu Order', 'active', 1, 2, 'menu_order', 'fa fa-sliders', 1, 1, '2016-05-19 05:24:12', '2017-01-12 18:41:48'),
  (5, 'Role Management', 'active', 1, 3, 'roles', 'fa fa-sliders', 1, 1, '2016-07-11 10:09:10', '2017-01-12 18:42:11'),
  (6, 'Set Permission', 'active', 1, 4, 'setpermission', 'fa fa-lock', 1, 1, '2016-05-24 05:25:53', '2017-01-12 18:38:49'),
  (8, 'Users', 'active', 1, 5, 'users', 'fa fa-user', 1, 0, '2018-09-28 14:31:22', '2018-09-28 14:31:22'),
  (9, 'Dashboard', 'active', 0, 0, 'home', 'fa fa-home', 1, 0, '2018-12-02 18:53:36', '2018-12-02 18:53:36');
  (10, 'App Settings', 'active', 1, 6, 'home', 'fa fa-wrench', 1, 1, '2018-12-02 18:53:36', '2018-12-02 18:53:36');

/*Data for the table `roles` */
INSERT INTO `roles` (`id`, `role`, `is_active`, `permission`, `is_admin`, `created_at`, `updated_at`) VALUES
  (1, 'Super Admin', 'active', '{"0":{"id":9,"text":"Dashboard","state":{"selected":true},"children":[{"id":"j9_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]},"1":{"id":1,"text":"Advance Settings","state":{"selected":true},"children":[{"id":3,"text":"Admin Menu","state":{"selected":true},"children":[{"id":"j3_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":4,"text":"Admin Menu Order","state":{"selected":true},"children":[{"id":"j4_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":5,"text":"Role Management","state":{"selected":true},"children":[{"id":"j5_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":6,"text":"Set Permission","state":{"selected":true},"children":[{"id":"j6_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":8,"text":"Users","state":{"selected":true},"children":[{"id":"j8_0","text":"Create","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_1","text":"Read","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_2","text":"Update","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_3","text":"Delete","state":{"selected":true},"icon":"fa fa-key text-danger fa-xs","children":null}]}]}}', 'yes', '2016-05-26 15:32:22', '2018-12-02 18:53:36'),
  (2, 'Admin', 'active', '{"0":{"id":9,"text":"Dashboard","state":{"selected":false},"children":[{"id":"j9_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},"1":{"id":1,"text":"Advance Settings","state":{"selected":false},"children":[{"id":3,"text":"Admin Menu","state":{"selected":false},"children":[{"id":"j3_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":4,"text":"Admin Menu Order","state":{"selected":false},"children":[{"id":"j4_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":5,"text":"Role Management","state":{"selected":false},"children":[{"id":"j5_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":6,"text":"Set Permission","state":{"selected":false},"children":[{"id":"j6_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":8,"text":"Users","state":{"selected":false},"children":[{"id":"j8_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]}]}}', 'yes', '2016-05-26 15:32:22', '2018-12-02 18:53:36'),
  (3, 'Consultant', 'active', '{"0":{"id":9,"text":"Dashboard","state":{"selected":false},"children":[{"id":"j9_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},"1":{"id":1,"text":"Advance Settings","state":{"selected":false},"children":[{"id":3,"text":"Admin Menu","state":{"selected":false},"children":[{"id":"j3_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":4,"text":"Admin Menu Order","state":{"selected":false},"children":[{"id":"j4_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":5,"text":"Role Management","state":{"selected":false},"children":[{"id":"j5_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":6,"text":"Set Permission","state":{"selected":false},"children":[{"id":"j6_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":8,"text":"Users","state":{"selected":false},"children":[{"id":"j8_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]}]}}', 'yes', '2016-05-26 15:32:22', '2018-12-02 18:53:36'),
  (4, 'Data captures', 'active', '{"0":{"id":9,"text":"Dashboard","state":{"selected":false},"children":[{"id":"j9_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},"1":{"id":1,"text":"Advance Settings","state":{"selected":false},"children":[{"id":3,"text":"Admin Menu","state":{"selected":false},"children":[{"id":"j3_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":4,"text":"Admin Menu Order","state":{"selected":false},"children":[{"id":"j4_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":5,"text":"Role Management","state":{"selected":false},"children":[{"id":"j5_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":6,"text":"Set Permission","state":{"selected":false},"children":[{"id":"j6_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":8,"text":"Users","state":{"selected":false},"children":[{"id":"j8_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]}]}}', 'yes', '2016-05-26 15:32:22', '2018-12-02 18:53:36'),
  (5, 'Clients', 'active', '{"0":{"id":9,"text":"Dashboard","state":{"selected":false},"children":[{"id":"j9_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j9_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},"1":{"id":1,"text":"Advance Settings","state":{"selected":false},"children":[{"id":3,"text":"Admin Menu","state":{"selected":false},"children":[{"id":"j3_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j3_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":4,"text":"Admin Menu Order","state":{"selected":false},"children":[{"id":"j4_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j4_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":5,"text":"Role Management","state":{"selected":false},"children":[{"id":"j5_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j5_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":6,"text":"Set Permission","state":{"selected":false},"children":[{"id":"j6_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j6_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]},{"id":8,"text":"Users","state":{"selected":false},"children":[{"id":"j8_0","text":"Create","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_1","text":"Read","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_2","text":"Update","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null},{"id":"j8_3","text":"Delete","state":{"selected":false},"icon":"fa fa-key text-danger fa-xs","children":null}]}]}}', 'no', '2016-05-26 15:32:22', '2018-12-02 18:53:36');