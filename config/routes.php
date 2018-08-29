<?
return [
  'news/([a-zA-Z]+)/([0-9]+)' => 'news/detail/$2',
  'news/([a-zA-Z]+)' => 'news/index/$1',
  'news' => 'news/index',
  '' => 'index/index',
];