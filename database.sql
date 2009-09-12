CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `email` varchar(140) NOT NULL default '',
  `regdate` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `lastdate` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `forgot` (
  `username` varchar(30) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `email` varchar(140) NOT NULL default '',
  `regdate` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default ''
);