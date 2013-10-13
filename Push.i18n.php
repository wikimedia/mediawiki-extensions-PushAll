<?php

/**
 * Internationalization file for the Push extension.
 *
 * @file Push.i18n.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'push-desc' => 'Lightweight extension to push content to other wikis',

	'right-push' => 'Use push functionality',
	'right-bulkpush' => 'Use bulk push functionality (i.e. Special:Push)',
	'right-pushadmin' => 'Modify push targets and push settings',

	'action-push' => 'push pages',
	'action-bulkpush' => 'bulk push pages',
	'action-pushadmin' => 'configure push',

	'group-pusher' => 'Pushers',
	'group-pusher-member' => '{{GENDER:$1|pusher}}',
	'grouppage-pusher' => '{{ns:project}}:Pushers',

	'group-bulkpusher' => 'Bulk pushers',
	'group-bulkpusher-member' => '{{GENDER:$1|bulk pusher}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Bulk pushers',

	'group-filepusher' => 'File pushers',
	'group-filepusher-member' => '{{GENDER:$1|file pusher}}',
	'grouppage-filepusher' => '{{ns:project}}:File pushers',

	'group-pusher.css'     => '/* CSS placed here will affect pushers only */', # only translate this message to other languages if you have to change it
	'group-pusher.js'      => '/* JS placed here will affect pushers only */', # only translate this message to other languages if you have to change it
	'group-bulkpusher.css' => '/* CSS placed here will affect bulkpushers only */', # only translate this message to other languages if you have to change it
	'group-bulkpusher.js'  => '/* JS placed here will affect bulkpushers only */', # only translate this message to other languages if you have to change it
	'group-filepusher.css' => '/* CSS placed here will affect filepushers only */', # only translate this message to other languages if you have to change it
	'group-filepusher.js'  => '/* JS placed here will affect filepushers only */', # only translate this message to other languages if you have to change it

	'push-err-captacha' => 'Could not push to $1 due to CAPTCHA.',
	'push-err-captcha-page' => 'Could not push page $1 to all targets due to CAPTCHA.',
	'push-err-authentication' => 'Authentication at $1 failed. $2',

	// Tab
	'push-tab-text' => 'Push',
	'push-button-text' => 'Push',
	'push-tab-desc' => 'This tab allows you to push the current revision of this page to one or more other wikis.',
	'push-button-pushing' => 'Pushing',
	'push-button-pushing-files' => 'Pushing files',
	'push-button-completed' => 'Push completed',
	'push-button-failed' => 'Push failed',
	'push-tab-title' => 'Push $1',
	'push-targets' => 'Push targets',
	'push-add-target' => 'Add target',
	'push-import-revision-message' => 'Pushed from $1.',
	'push-tab-no-targets' => 'There are no targets to push to. Please add some to your LocalSettings.php file.',
	'push-tab-push-to' => 'Push to $1',
	'push-remote-pages' => 'Remote pages',
	'push-remote-page-link' => '$1 on $2',
	'push-remote-page-link-full' => 'View $1 on $2',
	'push-targets-total' => 'There are a total of $1 {{PLURAL:$1|target|targets}}.',
	'push-button-all' => 'Push all',
	'push-tab-last-edit' => 'Last edit by $1 on $2 at $3.',
	'push-tab-not-created' => 'This page does not exist yet.',
	'push-tab-push-options' => 'Push options:',
	'push-tab-inc-templates' => 'Include templates',
	'push-tab-used-templates' => '(Used {{PLURAL:$2|template|templates}}: $1)',
	'push-tab-no-used-templates' => '(No templates are used on this page.)',
	'push-tab-inc-files' => 'Include embedded files',
	'push-tab-err-fileinfo' => 'Could not obtain which files are used on this page. None have been pushed.',
	'push-tab-err-filepush-unknown' => 'File push failed for an unknown reason.', 
	'push-tab-err-filepush' => 'File push failed: $1',	
	'push-tab-embedded-files' => 'Embedded files:',
	'push-tab-no-embedded-files' => '(No files are embedded in this page.)',
	'push-tab-files-override' => '{{PLURAL:$2|This file already exists|These files already exist}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|This template already exists|These templates already exist}}: $1',
	'push-tab-err-uploaddisabled' => 'Uploads are not enabled. Make sure $wgEnableUploads and $wgAllowCopyUploads are set to true in LocalSettings.php of the target wiki.',

	// Special page
	'special-push' => 'Push pages',
	'push-special-description' => 'This page enables you to push content of one or more pages to one or more MediaWiki wikis.

To push pages, enter the titles in the text box below, one title per line and hit push all. This can take a while to complete.',
	'push-special-pushing-desc' => 'Pushing $2 {{PLURAL:$2|page|pages}} to $1...',
	'push-special-button-text' => 'Push pages',
	'push-special-target-is' => 'Target wiki: $1',
	'push-special-select-targets' => 'Target wikis:',
	'push-special-item-pushing' => '$1: Pushing',
	'push-special-item-completed' => '$1: Push completed',
	'push-special-item-failed' => '$1: Push failed: $2',
	'push-special-push-done' => 'Push completed',
	'push-special-err-token-failed' => 'Could not obtain an edit token on the target wiki.',
	'push-special-err-pageget-failed' => 'Could not obtain local page content.',
	'push-special-err-push-failed' => 'Target wiki refused the pushed page.',
	'push-special-inc-files' => 'Include embedded files',
	'push-special-err-imginfo-failed' => 'Could not determine if any files needed to be pushed.',
	'push-special-obtaining-fileinfo' => '$1: Obtaining file information...',
	'push-special-pushing-file' => '$1: Pushing file $2...',
	'push-special-return' => 'Push more pages',

	// API
	'push-api-err-nocurl' => 'cURL is not installed.
Set $egPushDirectFileUploads to false on public wikis, or install cURL for private wikis',
	'push-api-err-nofilesupport' => 'The local MediaWiki does not have support for posting files.
On public wikis, set $egPushDirectFileUploads to false.
On private wikis, apply the patch linked from the Push documentation or update MediaWiki itself.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jeroen De Dauw
 * @author Nike
 * @author Purodha
 * @author Raymond
 * @author Shirayuki
 * @author Siebrand
 * @author Umherirrender
 * @author 아라
 */
$messages['qqq'] = array(
	'push-desc' => '{{desc|name=Push|url=http://www.mediawiki.org/wiki/Extension:Push}}',
	'right-push' => '{{doc-right|push}}',
	'right-bulkpush' => '{{doc-right|bulkpush}}',
	'right-pushadmin' => '{{doc-right|pushadmin}}',
	'action-push' => '{{doc-action|push}}',
	'action-bulkpush' => '{{doc-action|bulkpush}}',
	'action-pushadmin' => '{{doc-action|pushadmin}}',
	'group-pusher' => '{{doc-group|pusher}}',
	'group-pusher-member' => '{{doc-group|pusher|member}}',
	'grouppage-pusher' => '{{doc-group|pusher|page}}',
	'group-bulkpusher' => '{{doc-group|bulkpusher}}',
	'group-bulkpusher-member' => '{{doc-group|bulkpusher|member}}',
	'grouppage-bulkpusher' => '{{doc-group|bulkpusher|page}}',
	'group-filepusher' => '{{doc-group|filepusher}}',
	'group-filepusher-member' => '{{doc-group|filepusher|member}}',
	'grouppage-filepusher' => '{{doc-group|filepusher|page}}',
	'group-pusher.css' => '{{doc-group|pusher|css}}',
	'group-pusher.js' => '{{doc-group|pusher|js}}',
	'group-bulkpusher.css' => '{{doc-group|bulkpusher|css}}',
	'group-bulkpusher.js' => '{{doc-group|bulkpusher|js}}',
	'group-filepusher.css' => '{{doc-group|filepusher|css}}',
	'group-filepusher.js' => '{{doc-group|filepusher|js}}',
	'push-err-captacha' => 'Used as error message. Parameters:
* $1 - the push target name
See also:
* {{msg-mw|Push-err-captcha-page}}',
	'push-err-captcha-page' => 'Used as error message. Parameters:
* $1 - pagename
See also:
* {{msg-mw|Push-err-captacha}}',
	'push-err-authentication' => 'Parameters:
* $1 - wiki name
* $2 - optional detailed error message',
	'push-tab-text' => '{{Identical|Push}}',
	'push-button-text' => '{{Identical|Push}}',
	'push-button-pushing' => '{{Identical|Pushing}}',
	'push-tab-title' => 'Parameters:
* $1 - page title',
	'push-import-revision-message' => 'Parameters:
* $1 - site name',
	'push-tab-no-targets' => '{{doc-important|Do not translate "<code>LocalSettings.php</code>".}}',
	'push-tab-push-to' => 'Unused at this time. Parameters:
* $1 - ...',
	'push-remote-page-link' => 'Parameters:
* $1 - page name
* $2 - wiki name',
	'push-remote-page-link-full' => 'Parameters:
* $1 - page name
* $2 - wiki name',
	'push-targets-total' => 'Parameters:
* $1 - number of targets',
	'push-tab-last-edit' => 'Parameters:
* $1 - username
* $2 - date
* $3 - time',
	'push-tab-inc-templates' => 'This message is about a transfer of several data in one go. Templates can be a part of the transfer.',
	'push-tab-used-templates' => 'Parameters:
* $1 - list of templates
* $2 - number of templates',
	'push-tab-err-filepush-unknown' => 'Used as <code>$1</code> in {{msg-mw|Push-tab-err-filepush}}.',
	'push-tab-err-filepush' => 'Parameters:
* $1 - error message. Any one of the following messages:
** {{msg-mw|Push-tab-err-filepush-unknown}}
** {{msg-mw|Push-tab-err-uploaddisabled}}',
	'push-tab-embedded-files' => 'This message is about a transfer of several data in one go. Image files can be a part of the transfer.
{{Identical|Embedded file}}',
	'push-tab-files-override' => 'JavaScript message. Parameters:
* $1 - list of files (1 or more)
* $2 - number of files, for PLURAL support',
	'push-tab-template-override' => 'JavaScript message. Parameters:
* $1 - list of templates (1 or more)
* $2 - number of templates, for PLURAL support',
	'push-tab-err-uploaddisabled' => '{{doc-important|Do not translate "<code>$wgEnableUploads</code>", "<code>$wgAllowCopyUploads</code>" and "<code>LocalSettings.php</code>".}}
Used as <code>$1</code> in {{msg-mw|Push-tab-err-filepush}}.',
	'special-push' => '{{doc-special|Push}}',
	'push-special-pushing-desc' => 'Parameters:
* $1 - list of links (<code><nowiki>[targetURL targetName]</nowiki></code>)
* $2 - number of pages',
	'push-special-target-is' => 'Parameters:
* $1 - a push target
If there are 2 or more targets, the following message will be used instead of this message:
* {{msg-mw|push-special-select-targets}}',
	'push-special-select-targets' => 'Used when there are 2 or more targets.

This message is followed by checkboxes which allow to select the target wikis.

If there is 1 target, the following message will be used instead of this message:
* {{msg-mw|Push-special-target-is}}',
	'push-special-item-pushing' => 'Parameters:
* $1 - filename
{{Identical|Pushing}}',
	'push-special-item-completed' => 'Parameters:
* $1 - filename',
	'push-special-item-failed' => 'Parameters:
* $1 - page name
* $2 - error message',
	'push-special-obtaining-fileinfo' => 'Parameters:
* $1 - filename',
	'push-special-pushing-file' => 'Parameters:
* $1 - page name
* $2 - file name',
	'push-api-err-nocurl' => '{{doc-important|Do not translate "<code>$egPushDirectFileUploads</code>".}}',
	'push-api-err-nofilesupport' => '{{doc-important|Do not translate "<code>$egPushDirectFileUploads</code>".}}',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'push-desc' => 'Невялікае пашырэньне для распаўсюджваньня зьместу ў іншыя вікі',
	'right-push' => 'выкарыстаньне распаўсюджваньня', # Fuzzy
	'right-bulkpush' => 'выкарыстаньне групавога распаўсюджваньня', # Fuzzy
	'right-pushadmin' => 'зьмена мэтаў і наладаў распаўсюджваньня', # Fuzzy
	'push-err-captacha' => 'Немагчыма распаўсюдзіць у $1 з-за captcha.',
	'push-err-captcha-page' => 'Немагчыма распаўсюдзіць старонку $1 на ўсе мэты з-за captcha.',
	'push-err-authentication' => 'Немагчыма аўтэнтыфікаваць на $1. $2',
	'push-tab-text' => 'Распаўсюдзіць',
	'push-button-text' => 'Распаўсюдзіць',
	'push-tab-desc' => 'Гэтая закладка дазваляе Вам распаўсюджваць цяперашнюю вэрсію гэтай старонкі ў іншыя вікі.',
	'push-button-pushing' => 'Распаўсюджваньне',
	'push-button-pushing-files' => 'Распаўсюдзіць файлы',
	'push-button-completed' => 'Распаўсюджваньне скончанае',
	'push-button-failed' => 'Памылка распаўсюджваньня',
	'push-tab-title' => 'Распаўсюдзіць $1',
	'push-targets' => 'Мэты распаўсюджваньня',
	'push-add-target' => 'Дадаць мэту',
	'push-import-revision-message' => 'Распаўсюджаная з $1.',
	'push-tab-no-targets' => 'Няма мэтаў для распаўсюджаньня. Калі ласка, дадайце некаторыя ў Ваш файл LocalSettings.php.',
	'push-tab-push-to' => 'Распаўсюдзіць у $1',
	'push-remote-pages' => 'Аддаленыя старонкі',
	'push-remote-page-link' => '$1 на $2',
	'push-remote-page-link-full' => 'Паказаць $1 на $2',
	'push-targets-total' => 'Усяго $1 {{PLURAL:$1|мэта|мэты|мэтаў}}.',
	'push-button-all' => 'Распаўсюдзіць усе',
	'push-tab-last-edit' => 'Апошні раз рэдагавалася $1 $2 у $3.',
	'push-tab-not-created' => 'Гэтая старонка пакуль не існуе.',
	'push-tab-push-options' => 'Налады распаўсюджваньня:',
	'push-tab-inc-templates' => 'Уключыць шаблёны',
	'push-tab-used-templates' => '({{PLURAL:$2|Выкарыстаны шаблён|Выкарыстаныя шаблёны}}: $1)',
	'push-tab-no-used-templates' => '(На гэтай старонцы не выкарыстоўваюцца шаблёны.)',
	'push-tab-inc-files' => 'Уключыць убудаваныя файлы',
	'push-tab-err-fileinfo' => 'Немагчыма выявіць, якія файлы выкарыстоўваюцца на гэтай старонцы. Ні адзін ня быў распаўсюджаны.',
	'push-tab-err-filepush-unknown' => 'Немагчыма распаўсюдзіць файлы па невядомай прычыне.',
	'push-tab-err-filepush' => 'Немагчыма распаўсюдзіць файлы: $1',
	'push-tab-embedded-files' => 'Укладзеныя файлы:',
	'push-tab-no-embedded-files' => '(На гэтай старонцы няма укладзеных файлаў.)',
	'push-tab-files-override' => 'Гэтыя файлы ўжо існуюць: $1', # Fuzzy
	'push-tab-template-override' => 'Гэтыя шаблёны ўжо існуюць: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Загрузкі не дазволеныя. Упэўніцеся, што парамэтры $wgEnableUploads і $wgAllowCopyUploads маюць значэньне «true» у LocalSettings.php мэтавай вікі.',
	'special-push' => 'Распаўсюдзіць старонкі',
	'push-special-description' => 'Гэтая старонка дазваляе Вам распаўсюджваць зьмест адной ці болей старонак на адну ці некалькі іншых вікі, якія выкарыстоўваюць MediaWiki.

Для распаўсюджваньня старонак, увядзіце назвы ў тэкставым полі ніжэй, адну назву ў радок і націсьніце распаўсюдзіць усе. Гэта можа заняць некаторы час для выкананьня.',
	'push-special-pushing-desc' => 'Распаўсюджваньне $2 {{PLURAL:$2|старонкі|старонак|старонак}} у $1…',
	'push-special-button-text' => 'Распаўсюдзіць старонкі',
	'push-special-target-is' => 'Мэтавая вікі: $1',
	'push-special-select-targets' => 'Мэтавыя вікі:',
	'push-special-item-pushing' => '$1: Распаўсюджваньне',
	'push-special-item-completed' => '$1: Распаўсюджваньне скончанае',
	'push-special-item-failed' => '$1: Памылка распаўсюджваньня: $2',
	'push-special-push-done' => 'Распаўсюджваньне скончанае',
	'push-special-err-token-failed' => 'Немагчыма атрымаць ключ рэдагаваньня ў мэтавай вікі.',
	'push-special-err-pageget-failed' => 'Немагчыма атрымаць зьмест лякальнай старонкі.',
	'push-special-err-push-failed' => 'Мэтавая вікі адмовілася распаўсюджваць старонку.',
	'push-special-inc-files' => 'Уключыць убудаваныя файлы',
	'push-special-err-imginfo-failed' => 'Немагчыма вызначыць ці ёсьць файлы, якія патрабуюць распаўсюджваньня.',
	'push-special-obtaining-fileinfo' => '$1: Атрыманьне інфармацыі пра файл…',
	'push-special-pushing-file' => '$1: Распаўсюджваньне файла $2…',
	'push-special-return' => 'Распаўсюдзіць болей старонак',
	'push-api-err-nocurl' => 'cURL не ўсталяваны.
Устанавіце парамэтар $egPushDirectFileUploads у false ў публічнай вікі, ці ўсталюйце cURL на прыватнай вікі.',
	'push-api-err-nofilesupport' => 'Лякальная MediaWiki не падтрымлівае адпраўку файлаў.
Для публічных вікі ўстанавіце парамэтар $egPushDirectFileUploads у значэньне false.
У прыватных вікі трэба ўжыць выпраўленьне linkd з дакумэнтацыі Push, ці наўпрост абнавіць MediaWiki.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'push-add-target' => 'Добавяне на цел',
	'push-remote-pages' => 'Отдалечени страници',
	'push-remote-page-link' => '$1 в $2',
	'push-remote-page-link-full' => 'Преглеждане на $1 в $2',
	'push-targets-total' => 'Има общо $1 {{PLURAL:$1|цел|цели}}.',
	'push-tab-last-edit' => 'Последна редакция от $1 на $2 в $3.',
	'push-tab-not-created' => 'Тази страница все още не съществува.',
	'push-tab-inc-templates' => 'Включване на шаблоните',
	'push-tab-used-templates' => '({{PLURAL:$2|Използван шаблон|Използвани шаблони}}: $1)',
	'push-tab-no-used-templates' => '(На тази страница не са използвани шаблони.)',
	'push-tab-inc-files' => 'Включване на вградените файлове',
	'push-tab-embedded-files' => 'Използвани файлове:',
	'push-tab-no-embedded-files' => '(В тази страница не са включени файлове.)',
	'push-tab-files-override' => 'Следните файлове вече съществуват: $1', # Fuzzy
	'push-tab-template-override' => 'Следните шаблони вече съществуват: $1', # Fuzzy
	'push-special-target-is' => 'Целево уики: $1',
	'push-special-select-targets' => 'Целеви уикита:',
	'push-special-err-pageget-failed' => 'Не може да се извлече съдържанието на локалната страница.',
	'push-special-obtaining-fileinfo' => '$1: Получаване на информация за файла...',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'action-push' => 'bountañ ar pajennoù',
	'grouppage-pusher' => '{{ns:project}}:Bounterien',
	'group-filepusher' => 'Bounterioù pajennoù',
	'push-tab-text' => 'Bountañ',
	'push-button-text' => 'Bountañ',
	'push-button-pushing' => 'O vountañ',
	'push-button-pushing-files' => 'O vountañ ar restroù',
	'push-button-completed' => 'Echuet bountañ',
	'push-button-failed' => "Bountadenn c'hwitet",
	'push-tab-title' => 'Bountañ $1',
	'push-targets' => 'Gwennoù da vezañ bountet',
	'push-add-target' => 'Ouzhpennañ ur gwenn',
	'push-import-revision-message' => 'Bountet adalek $1.',
	'push-tab-no-targets' => "N'eus gwenn ebet da vountañ. Merkit kement-se en ho restr LocalSettings.php.",
	'push-tab-push-to' => 'Bountañ war-zu $1',
	'push-remote-pages' => 'Pajennoù a-bell',
	'push-remote-page-link' => '$1 war $2',
	'push-remote-page-link-full' => 'Gwelet $1 war $2',
	'push-targets-total' => '$1 {{PLURAL:$1|gwenn|gwenn}} zo en holl.',
	'push-button-all' => 'Bountañ pep tra',
	'push-tab-last-edit' => "Kemmet da ziwezhañ gant $1 d'an $2 da $3.",
	'push-tab-not-created' => "N'eus ket eus ar bajenn-se c'hoazh.",
	'push-tab-push-options' => 'Arventennoù bountañ :',
	'push-tab-inc-templates' => 'Lakaat ar patromoù e-barzh ivez',
	'push-tab-used-templates' => '({{PLURAL:$2|patrom|patromoù}}implijet : $1)',
	'push-tab-no-used-templates' => '(Ne vez implijet patrom ebet er bajenn-mañ)',
	'push-tab-inc-files' => 'Lakaat e-barzh restroù enframmet',
	'push-tab-err-fileinfo' => "N'esu ket bet gallet gouzout peseurt restroù a implijer er bajenn-mañ. N'eus bet bountet hini.",
	'push-tab-err-filepush-unknown' => "C'hwitet eo bet ar vountadenn ha n'ouzer ket perak.",
	'push-tab-err-filepush' => "C'hwitet eo bet bountañ ar restr : $1",
	'push-tab-embedded-files' => 'Restr enframmet :',
	'push-tab-no-embedded-files' => "(N'eus restr enframmet ebet er bajenn-mañ)",
	'push-tab-files-override' => 'Bez ez eus eus ar restroù-mañ dija : $1', # Fuzzy
	'push-tab-template-override' => 'Bez ez eus eus ar patromoù-mañ dija : $1', # Fuzzy
	'special-push' => 'Pajennoù da vountañ',
	'push-special-pushing-desc' => 'O vountañ $2 {{PLURAL:$2|pajenn|pajenn}} da $1...',
	'push-special-button-text' => 'Pajennoù da vountañ',
	'push-special-target-is' => 'Wiki buket: $1',
	'push-special-select-targets' => 'Wikioù buket:',
	'push-special-item-pushing' => '$1: O vountañ',
	'push-special-item-completed' => '$1: Echuet bountañ',
	'push-special-item-failed' => "$1: C'hwitet eo bet ar vountadenn: $2",
	'push-special-push-done' => 'Echuet bountañ',
	'push-special-err-token-failed' => "N'eus ket bet gallet tapout ur jedouer kemmañ war ar wiki buket.",
	'push-special-err-pageget-failed' => "N'eus ket bet gallet tapout boued ar bajenn lec'hel.",
	'push-special-err-push-failed' => "Nac'het eo bet ar bajenn vountet gant ar wiki buket.",
	'push-special-inc-files' => 'Lakaat e-barzh restroù enframmet',
	'push-special-err-imginfo-failed' => "N'haller ket didermenañ ha ret eo bountañ ur restr bennak.",
	'push-special-obtaining-fileinfo' => '$1: O tastum titouroù diwar-benn ar restr...',
	'push-special-pushing-file' => '$1: O vountañ ar restr $2...',
	'push-special-return' => "Bountañ muioc'h a bajennoù",
	'push-api-err-nocurl' => 'N\'eo ket staliet cURL.
Lakaat $egPushDirectFileUploads da <code>false</code> evit wikioù foran, pe staliañ cURL evit ar wikioù prevez',
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'push-err-authentication' => 'Autentificiranje na $1 nije uspjelo. $2',
	'push-tab-text' => 'Postavi',
	'push-button-text' => 'Postavi',
	'push-tab-desc' => 'Ovaj jezičak omogućava vam da postavite trenutno reviziju ove stranice na jednu ili više drugih wikija.',
	'push-targets' => 'Postavi ciljeve',
	'push-add-target' => 'Dodaj cilj',
	'push-remote-page-link' => '$1 na $2',
	'push-tab-inc-files' => 'Uključi umetnute datoteke',
	'push-tab-embedded-files' => 'Umetnute datoteke:',
	'push-special-target-is' => 'Ciljna wiki: $1',
	'push-special-select-targets' => 'Ciljne wiki:',
	'push-special-item-pushing' => '$1: Premještanje',
	'push-special-item-completed' => '$1: Premještanje završeno',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'push-button-all' => 'Массо дӀатардан',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'push-desc' => 'Ermöglicht den einfachen Transfer von Inhalten eines Wikis in ein anderes',
	'right-push' => 'Transferfunktionalität benutzen',
	'right-bulkpush' => 'Sammeltransferfunktionalität benutzen (z.&nbsp;B. Special:Push)',
	'right-pushadmin' => 'Transferziele und -einstellungen ändern',
	'action-push' => 'Seiten zu transferieren',
	'action-bulkpush' => 'Seiten gesammelt zu transferieren',
	'action-pushadmin' => 'Transfereinstellungen zu konfigurieren',
	'group-pusher' => 'Transferierer',
	'group-pusher-member' => '{{GENDER:$1|Transferierer|Transferiererin}}',
	'grouppage-pusher' => '{{ns:project}}:Transferierer',
	'group-bulkpusher' => 'Sammeltransferierer',
	'group-bulkpusher-member' => '{{GENDER:$1|Sammeltransferierer|Sammeltransferiererin}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Sammeltransferierer',
	'group-filepusher' => 'Dateitransferierer',
	'group-filepusher-member' => '{{GENDER:$1|Dateitransferierer|Dateitransferiererin}}',
	'grouppage-filepusher' => '{{ns:project}}:Dateitransferierer',
	'push-err-captacha' => 'Transfer nach $1 aufgrund eines CAPTCHAs nicht möglich.',
	'push-err-captcha-page' => 'Seite $1 konnte aufgrund von CAPTCHAs zu keinem der Ziele transferiert werden.',
	'push-err-authentication' => 'Authentifizierung auf $1 ist fehlgeschlagen. $2',
	'push-tab-text' => 'Transferieren',
	'push-button-text' => 'Transferieren',
	'push-tab-desc' => 'Dieser Reiter ermöglicht den Transfer des aktuellen Seiteninhalts in ein oder mehrere andere Wikis.',
	'push-button-pushing' => 'Transferiere',
	'push-button-pushing-files' => 'Transferiere Dateien',
	'push-button-completed' => 'Transfer abgeschlossen',
	'push-button-failed' => 'Transfer fehlgeschlagen',
	'push-tab-title' => 'Transferiere $1',
	'push-targets' => 'Transferziele',
	'push-add-target' => 'Transferziel hinzufügen',
	'push-import-revision-message' => 'Aus $1 transferiert.',
	'push-tab-no-targets' => 'Es sind keine Transferziele vorhanden. Es müssen welche in der Datei LocalSettings.php definiert werden.',
	'push-tab-push-to' => 'Transferiere nach $1',
	'push-remote-pages' => 'Entfernte Seiten',
	'push-remote-page-link' => 'Seite $1 auf Wiki $2',
	'push-remote-page-link-full' => 'Seite $1 auf Wiki $2 ansehen',
	'push-targets-total' => 'Es {{PLURAL:$1|ist|sind}} insgesamt $1 {{PLURAL:$1|Transferziel|Transferziele}} vorhanden.',
	'push-button-all' => 'Alle transferieren',
	'push-tab-last-edit' => 'Letzte Bearbeitung durch Benutzer $1 am $2 um $3 Uhr.',
	'push-tab-not-created' => 'Diese Seite ist nicht vorhanden.',
	'push-tab-push-options' => 'Transferoptionen:',
	'push-tab-inc-templates' => 'Vorlagen einbeziehen',
	'push-tab-used-templates' => '({{PLURAL:$2|Vorlage|Vorlagen}} eingesetzt: $1)',
	'push-tab-no-used-templates' => '(Auf dieser Seite werden keine Vorlagen eingesetzt.)',
	'push-tab-inc-files' => 'Eingebettete Dateien einbeziehen',
	'push-tab-err-fileinfo' => 'Es konnte nicht ermittelt werden, welche Dateien auf dieser Seite eingebunden sind. Es wurde keine transferiert.',
	'push-tab-err-filepush-unknown' => 'Dateitransfer ist aus unbekanntem Grund fehlgeschlagen.',
	'push-tab-err-filepush' => 'Dateitransfer fehlgeschlagen: $1',
	'push-tab-embedded-files' => 'Eingebettete Dateien:',
	'push-tab-no-embedded-files' => '(Auf dieser Seite gibt es keine eingebetteten Dateien.)',
	'push-tab-files-override' => '{{PLURAL:$2|Diese Datei ist|Diese Dateien sind}} bereits vorhanden: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Diese Vorlage ist|Diese Vorlagen sind}} bereits vorhanden: $1',
	'push-tab-err-uploaddisabled' => 'Das Hochladen von Dateien ist nicht möglich. Die Parameter <code>$wgEnableUploads</code> und <code>$wgAllowCopyUploads</code> müssen in der Datei LocalSettings.php des Zielwikis auf „true“ gesetzt werden.',
	'special-push' => 'Seiten transferieren',
	'push-special-description' => 'Diese Spezialseite ermöglicht es den Inhalt einer oder mehrerer Seiten zu einem oder mehreren anderen Wikis zu transferieren.

Um Seiten zu transferieren, sind deren Titel im Eingabefeld unten anzugeben (ein Titel pro Zeile). Klicke danach auf „{{int:push-special-button-text}}“. Es kann etwas dauern, bis der Transfer abgeschlossen ist.',
	'push-special-pushing-desc' => 'Transferiere $2 {{PLURAL:$2|Seite|Seiten}} nach $1 …',
	'push-special-button-text' => 'Seiten transferieren',
	'push-special-target-is' => 'Zielwiki: $1',
	'push-special-select-targets' => 'Zielwikis:',
	'push-special-item-pushing' => '$1: Transferiere …',
	'push-special-item-completed' => '$1: Transfer abgeschlossen',
	'push-special-item-failed' => '$1: Transfer fehlgeschlagen. $2',
	'push-special-push-done' => 'Transfer abgeschlossen',
	'push-special-err-token-failed' => 'Auf dem Zielwiki konnte der Bearbeitungstoken nicht abgerufen werden.',
	'push-special-err-pageget-failed' => 'Auf diesem Wiki konnte der Seiteninhalt nicht abgerufen werden.',
	'push-special-err-push-failed' => 'Das Zielwiki hat die zu transferierende Seite zurückgewiesen.',
	'push-special-inc-files' => 'Eingebettete Dateien einbeziehen',
	'push-special-err-imginfo-failed' => 'Es konnte nicht ermittelt werden, ob auch Dateien transferiert werden müssen.',
	'push-special-obtaining-fileinfo' => '$1: Dateiinformationen werden abrufen …',
	'push-special-pushing-file' => '$1: Transferiere Datei $2 …',
	'push-special-return' => 'Weitere Seiten transferieren',
	'push-api-err-nocurl' => 'cURL ist nicht installiert.
Der Parameter <code>$egPushDirectFileUploads</code> muss daher für alle öffentlichen Wikis auf false gesetzt werden. Alternativ cURL für alle nichtöffentlichen Wikis installieren.',
	'push-api-err-nofilesupport' => 'Die lokale MediaWiki-Installation unterstützt nicht das Hochladen von Dateien.
Auf öffentlichen Wikis muss der Parameter <code>$egPushDirectFileUploads</code> auf false gesetzt werden.
Auf nichtöffentlichen Wikis muss der über die Dokumentationsseite zu dieser Programmerweiterung erhältliche Patch angewendet oder die MediaWiki-Installation selbst aktualisiert werden.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'push-tab-no-used-templates' => '(Na pela dı şabloni çinyê)',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'right-push' => 'Authorisation to use push functionality.', # Fuzzy
	'right-bulkpush' => 'Authorisation to use bulk push functionality (ie Special:Push).', # Fuzzy
	'right-pushadmin' => 'Authorisation to modify push targets and push settings.', # Fuzzy
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Fitoschido
 */
$messages['es'] = array(
	'push-desc' => 'Extensión ligera para transferir contenidos a otros wikis',
	'right-push' => 'Autorización para usar la funcionalidad de transferencia.', # Fuzzy
	'right-bulkpush' => 'Autorización para usar la funcionalidad de transferencia en masa (es decir, Special:Push).', # Fuzzy
	'right-pushadmin' => 'Autorización para modificar los destinos y la configuración de las transferencias.', # Fuzzy
	'action-push' => 'transferir páginas',
	'action-bulkpush' => 'transferir páginas en bloque',
	'action-pushadmin' => 'configurar las transferencias',
	'group-pusher' => 'Impulsores',
	'group-pusher-member' => '{{GENDER:$1|impulsor|impulsora}}',
	'grouppage-pusher' => '{{ns:project}}:Impulsores',
	'group-bulkpusher' => 'Impulsores en bloque',
	'group-bulkpusher-member' => '{{GENDER:$1|impulsor|impulsora}} en bloque',
	'grouppage-bulkpusher' => '{{ns:project}}:Impulsores en bloque',
	'group-filepusher' => 'Impulsores de archivos',
	'group-filepusher-member' => '{{GENDER:$1|impulsor|impulsora}} de archivos',
	'grouppage-filepusher' => '{{ns:project}}:Impulsores de archivos',
	'push-err-captacha' => 'No se pudo transferir a $1 debido a un CAPTCHA.',
	'push-err-captcha-page' => 'No se pudo transferir la página "$1" a todos los destinos debido a un CAPTCHA.',
	'push-err-authentication' => 'Falló la autenticación en $1.  $2',
	'push-tab-text' => 'Transferir',
	'push-button-text' => 'Transferir',
	'push-tab-desc' => 'Esta pestaña permite transferir la revisión actual de esta página a uno o más wikis.',
	'push-button-pushing' => 'Transfiriendo',
	'push-button-pushing-files' => 'Transfiriendo ficheros',
	'push-button-completed' => 'Transferencia completada',
	'push-button-failed' => 'Error al transferir',
	'push-tab-title' => 'Transferir $1',
	'push-targets' => 'Destinos de la transferencia',
	'push-add-target' => 'Añadir destino',
	'push-import-revision-message' => 'Transferido desde $1.',
	'push-tab-no-targets' => 'No hay objetivos a los que transferir. Añada alguno en su archivo LocalSettings.php.',
	'push-tab-push-to' => 'Transferir a $1',
	'push-remote-pages' => 'Páginas remotas',
	'push-remote-page-link' => '$1 en $2',
	'push-remote-page-link-full' => 'Ver $1 en $2',
	'push-targets-total' => 'Hay un total de $1 {{PLURAL:$1|destino|destinos}}.',
	'push-button-all' => 'Transferir todo',
	'push-tab-last-edit' => 'Última edición realizada por $1 el $2 a las $3.',
	'push-tab-not-created' => 'Esta página no existe todavía.',
	'push-tab-push-options' => 'Opciones de transferencia:',
	'push-tab-inc-templates' => 'Incluir plantillas',
	'push-tab-used-templates' => '({{PLURAL:$2|Plantilla empleada|Plantillas empleadas}}: $1)',
	'push-tab-no-used-templates' => '(En esta página no se han empleado plantillas.)',
	'push-tab-inc-files' => 'Incluir archivos incrustados',
	'push-tab-err-fileinfo' => 'No se pudieron obtener los archivos empleados e​​n esta página. Ninguno de ellos fue transferido.',
	'push-tab-err-filepush-unknown' => 'Falló la transferencia del fichero por una causa desconocida',
	'push-tab-err-filepush' => 'Falló la transferencia del archivo: $1',
	'push-tab-embedded-files' => 'Archivos incrustados:',
	'push-tab-no-embedded-files' => '(No hay ningún archivo incrustado en esta página.)',
	'push-tab-files-override' => 'Estos archivos ya existen: $1', # Fuzzy
	'push-tab-template-override' => '{{PLURAL:$2|Esta plantilla ya existe|Estas plantillas ya existen}}: $1',
	'push-tab-err-uploaddisabled' => 'Las cargas no están habilitadas. Asegúrese de que las variables $wgEnableUploads y $wgAllowCopyUploads estén definidas con el valor "true" en el archivo LocalSettings.php del wiki de destino.',
	'special-push' => 'Transferir páginas',
	'push-special-description' => 'Esta página permite transferir el contenido de una o más páginas hasta uno o más wikis de MediaWiki.

Para transferir páginas, introduzca los títulos en la caja de texto de abajo (un título por línea) y haga clic en el botón Transferir todo. Esto puede tardar un tiempo hasta su finalización.',
	'push-special-pushing-desc' => 'Transfiriendo $2 {{PLURAL:$2|página|páginas}} hacia $1...',
	'push-special-button-text' => 'Transferir páginas',
	'push-special-target-is' => 'Wiki de destino: $1',
	'push-special-select-targets' => 'Wikis de destino:',
	'push-special-item-pushing' => '$1: Transfiriendo',
	'push-special-item-completed' => '$1: Transferencia completada',
	'push-special-item-failed' => '$1: Error en la transferencia: $2',
	'push-special-push-done' => 'Transferencia completada',
	'push-special-err-token-failed' => 'No se pudo obtener un "token" de edición en el wiki de destino.',
	'push-special-err-pageget-failed' => 'No se pudo obtener el contenido de la página local.',
	'push-special-err-push-failed' => 'El wiki de destino rechazó la página transferida.',
	'push-special-inc-files' => 'Incluir archivos incrustados',
	'push-special-err-imginfo-failed' => 'No se pudo determinar si hay algún archivo que necesite ser transferido.',
	'push-special-obtaining-fileinfo' => '$1: Obteniendo información del archivo...',
	'push-special-pushing-file' => '$1: Transfiriendo archivo $2...',
	'push-special-return' => 'Transferir más páginas',
	'push-api-err-nocurl' => 'cURL no está instalado.
Establezca $egPushDirectFileUploads como falso en los wikis públicos, o instale cURL en los wikis privados',
	'push-api-err-nofilesupport' => 'El MediaWiki local no tiene soporte para publicar archivos.
En los wikis públicos, establezca $egPushDirectFileUploads como "false".
En los wikis privados, aplique el parche linkd de la documentación de Push o actualice el propio MediaWiki.',
);

/** Finnish (suomi)
 * @author Tofu II
 */
$messages['fi'] = array(
	'push-add-target' => 'Lisää kohde',
);

/** French (français)
 * @author Gomoko
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'push-desc' => "Extension peu gourmande servant à pousser (''push'' en anglais) du contenu vers d'autres wikis",
	'right-push' => 'Utiliser la fonctionnalité de push.',
	'right-bulkpush' => 'Utiliser la fonctionnalité de push en masse (c’est-à-dire Special:Push).',
	'right-pushadmin' => 'Modifier les cibles et les paramètres de push.',
	'action-push' => 'pousser les pages',
	'action-bulkpush' => 'pousser les pages en masse',
	'action-pushadmin' => 'configurer la publication',
	'group-pusher' => 'Pousseurs',
	'group-pusher-member' => '{{GENDER:$1|pousseur}}',
	'grouppage-pusher' => '{{ns:project}}:Pousseurs',
	'group-bulkpusher' => 'Pousseurs en masse',
	'group-bulkpusher-member' => '{{GENDER:$1|pousseur en masse}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Pousseurs_en_masse',
	'group-filepusher' => 'Pousseurs de fichier',
	'group-filepusher-member' => '{{GENDER:$1|pousseur de fichier}}',
	'grouppage-filepusher' => '{{ns:project}}:Pousseurs_de_fichier',
	'push-err-captacha' => "Impossible de pousser vers $1 en raison d'un CAPTCHA.",
	'push-err-captcha-page' => 'Impossible de pousser la page $1 vers toutes les cibles en raison de CAPTCHA.',
	'push-err-authentication' => "Échec de l'authentification à $1. $2",
	'push-tab-text' => 'Pousser',
	'push-button-text' => 'Pousser',
	'push-tab-desc' => 'Cet onglet vous permet de pousser la révision actuelle de cette page vers un ou plusieurs autres wikis.',
	'push-button-pushing' => 'Poussée',
	'push-button-pushing-files' => 'Poussée des fichiers',
	'push-button-completed' => 'Poussée terminée',
	'push-button-failed' => 'Poussée échouée',
	'push-tab-title' => 'Pousser $1',
	'push-targets' => 'Cibles pour la poussée',
	'push-add-target' => "Ajout d'une cible",
	'push-import-revision-message' => 'Poussé depuis $1.',
	'push-tab-no-targets' => "Il n'y a pas de cible à pousser. S'il vous plaît ajoutez-en à votre fichier LocalSettings.php.",
	'push-tab-push-to' => 'Poussez vers $1',
	'push-remote-pages' => 'pages à distance',
	'push-remote-page-link' => '$1 sur $2',
	'push-remote-page-link-full' => 'Voir $1 sur $2',
	'push-targets-total' => 'Il ya un total de $1 {{PLURAL:$1|cible|cibles}}.',
	'push-button-all' => 'Pousser tout',
	'push-tab-last-edit' => 'Dernière modification par $1 sur $2 à $3.',
	'push-tab-not-created' => "Cette page n'existe pas encore.",
	'push-tab-push-options' => 'Paramètres de poussée:',
	'push-tab-inc-templates' => 'Inclure les modèles',
	'push-tab-used-templates' => '({{PLURAL:$2|modèle utilisé|modèles utilisés}}: $1)',
	'push-tab-no-used-templates' => '(Pas de modèle utilisé sur cette page.)',
	'push-tab-inc-files' => 'Inclure des fichiers joints',
	'push-tab-err-fileinfo' => "Pas pu obtenir quels fichiers sont utilisés sur cette page. Aucun n'été poussé.",
	'push-tab-err-filepush-unknown' => 'La poussée du fichier a échoué pour une raison inconnue.',
	'push-tab-err-filepush' => 'La poussée du fichier a échoué: $1',
	'push-tab-embedded-files' => 'Fichiers joints:',
	'push-tab-no-embedded-files' => '(Aucun fichier joint dans cette page.)',
	'push-tab-files-override' => '{{PLURAL:$2|Ce fichier existe|Ces fichiers existent}} déjà : $1',
	'push-tab-template-override' => '{{PLURAL:$2|Ce modèle existe|Ces modèles existent}} déjà : $1',
	'push-tab-err-uploaddisabled' => "Les téléchargements ne sont pas activés. Assurez-vous que \$wgEnableUploads et \$wgAllowCopyUploads sont mis à ''true'' dans le fichier LocalSettings.php du wiki cible.",
	'special-push' => 'Pages à pousser',
	'push-special-description' => "Cette page permet de pousser (''push'' en anglais) le contenu d'une ou plusieurs pages vers un ou plusieurs wikis de MediaWiki.

Pour pousser les pages, entrez les titres dans la zone de texte ci-dessous, un titre par ligne et cliquez sur ''Pousser tout''. Cela peut prendre un certain temps pour se terminer.",
	'push-special-pushing-desc' => 'Poussée de $2 {{PLURAL:$2|page|pages}} vers $1...',
	'push-special-button-text' => 'Pages à pousser',
	'push-special-target-is' => 'wiki cible: $1',
	'push-special-select-targets' => 'wikis cible:',
	'push-special-item-pushing' => '$1: poussée en cours',
	'push-special-item-completed' => '$1: Poussée terminée',
	'push-special-item-failed' => '$1: la poussée a échoué: $2',
	'push-special-push-done' => 'Poussée terminée',
	'push-special-err-token-failed' => "Pas pu obtenir un jeton d'édition sur le wiki cible.",
	'push-special-err-pageget-failed' => 'Pas pu obtenir le contenu de la page locale.',
	'push-special-err-push-failed' => 'Le wiki cible a refusé la page poussée.',
	'push-special-inc-files' => 'Inclure des fichiers joints',
	'push-special-err-imginfo-failed' => 'Impossible de déterminer si un fichier doit être poussé.',
	'push-special-obtaining-fileinfo' => "$1: Obtention d'informations sur le fichier...",
	'push-special-pushing-file' => '$1: pousser le fichier $2...',
	'push-special-return' => 'Pousser plus de pages',
	'push-api-err-nocurl' => 'cURL n\'est pas installé.
Mettre $​​egPushDirectFileUploads à <code>false</code> pour des wikis publics, ou installer cURL pour les wikis privés',
	'push-api-err-nofilesupport' => "Le MediaWiki local ne supporte pas le téléchargement de fichiers. 
Sur les wikis publics, mettre \$egPushDirectFileUploads à <code>false</code>.
Sur les wikis privés, appliquer le patch <code>linkd</code> tel qu'expliqué dans la documentation de ''Push'' ou mettre à jour MediaWiki.",
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'action-push' => 'poussar les pâges',
	'action-bulkpush' => 'poussar les pâges en massa',
	'group-pusher' => 'Poussors',
	'group-pusher-member' => 'pousso{{GENDER:$1|r|sa}}',
	'grouppage-pusher' => '{{ns:project}}:Poussors',
	'group-bulkpusher' => 'Poussors en massa',
	'group-bulkpusher-member' => 'pousso{{GENDER:$1|r|sa}} en massa',
	'grouppage-bulkpusher' => '{{ns:project}}:Poussors_en_massa',
	'group-filepusher' => 'Poussors de fichiér',
	'group-filepusher-member' => 'pousso{{GENDER:$1|r|sa}} de fichiér',
	'grouppage-filepusher' => '{{ns:project}}:Poussors_de_fichiér',
	'push-err-authentication' => 'Falyita de l’ôtenticacion a $1. $2',
	'push-tab-text' => 'Poussar',
	'push-button-text' => 'Poussar',
	'push-button-pushing' => 'Poussâ',
	'push-button-pushing-files' => 'Poussâ des fichiérs',
	'push-button-completed' => 'Poussâ chavonâ',
	'push-button-failed' => 'Poussâ pas reussia',
	'push-tab-title' => 'Poussar $1',
	'push-targets' => 'Cibes por la poussâ',
	'push-add-target' => 'Apondre una ciba',
	'push-import-revision-message' => 'Poussâ dês $1.',
	'push-tab-push-to' => 'Poussâd vers $1',
	'push-remote-pages' => 'Pâges a distance',
	'push-remote-page-link' => '$1 sur $2',
	'push-remote-page-link-full' => 'Vêre $1 dessus $2',
	'push-targets-total' => 'Y at una soma totâla de $1 cib{{PLURAL:$1|a|es}}.',
	'push-button-all' => 'Poussar tot',
	'push-tab-last-edit' => 'Dèrriér changement per $1 dessus $2 a $3.',
	'push-tab-not-created' => 'Ceta pâge ègziste p’oncor.',
	'push-tab-push-options' => 'Chouèx de poussâ :',
	'push-tab-inc-templates' => 'Encllure los modèlos',
	'push-tab-used-templates' => '({{PLURAL:$2|Modèlo utilisâ|Modèlos utilisâs}} : $1)',
	'push-tab-no-used-templates' => '(Gins de modèlo utilisâ sur ceta pâge.)',
	'push-tab-inc-files' => 'Encllure des fichiérs apondus',
	'push-tab-err-filepush-unknown' => 'La poussâ du fichiér at pas reussia por una rêson encognua.',
	'push-tab-err-filepush' => 'La poussâ du fichiér at pas reussia : $1',
	'push-tab-embedded-files' => 'Fichiérs apondus :',
	'push-tab-no-embedded-files' => '(Gins de fichiér apondu dens ceta pâge.)',
	'push-tab-files-override' => 'Cetos fichiérs ègzistont ja : $1', # Fuzzy
	'push-tab-template-override' => 'Cetos modèlos ègzistont ja : $1', # Fuzzy
	'special-push' => 'Pâges a poussar',
	'push-special-pushing-desc' => 'Poussâ de $2 pâge{{PLURAL:$2||s}} vers $1...',
	'push-special-button-text' => 'Pâges a poussar',
	'push-special-target-is' => 'Vouiqui ciba : $1',
	'push-special-select-targets' => 'Vouiquis ciba :',
	'push-special-item-pushing' => '$1 : poussâ en cors',
	'push-special-item-completed' => '$1 : poussâ chavonâ',
	'push-special-item-failed' => '$1 : la poussâ at pas reussia : $2',
	'push-special-push-done' => 'Poussâ chavonâ',
	'push-special-inc-files' => 'Encllure des fichiérs apondus',
	'push-special-pushing-file' => '$1 : poussar lo fichiér $2...',
	'push-special-return' => 'Poussar més de pâges',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'push-desc' => 'Extensión lixeira para empurrar contidos ata outros wikis',
	'right-push' => 'Usar a funcionalidade de empuxe',
	'right-bulkpush' => 'Usar a funcionalidade de empuxe en masa (é dicir, Special:Push)',
	'right-pushadmin' => 'Modificar os destinos e a configuración de empuxe',
	'action-push' => 'empurrar páxinas',
	'action-bulkpush' => 'empurrar páxinas en masa',
	'action-pushadmin' => 'configurar os empuxes',
	'group-pusher' => 'Impulsores',
	'group-pusher-member' => '{{GENDER:$1|impulsor|impulsora}}',
	'grouppage-pusher' => '{{ns:project}}:Impulsores',
	'group-bulkpusher' => 'Impulsores en bloque',
	'group-bulkpusher-member' => '{{GENDER:$1|impulsor|impulsora}} en bloque',
	'grouppage-bulkpusher' => '{{ns:project}}:Impulsores en bloque',
	'group-filepusher' => 'Impulsores de ficheiros',
	'group-filepusher-member' => '{{GENDER:$1|impulsor|impulsora}} de ficheiros',
	'grouppage-filepusher' => '{{ns:project}}:Impulsores de ficheiros',
	'group-pusher.css' => '/* O CSS que se coloque aquí afectará soamente aos impulsores */',
	'group-pusher.js' => '/* O JS que se coloque aquí afectará soamente aos impulsores */',
	'group-bulkpusher.css' => '/* O CSS que se coloque aquí afectará soamente aos impulsores en bloque */',
	'group-bulkpusher.js' => '/* O JS que se coloque aquí afectará soamente aos impulsores en bloque */',
	'group-filepusher.css' => '/* O CSS que se coloque aquí afectará soamente aos impulsores de ficheiros */',
	'group-filepusher.js' => '/* O JS que se coloque aquí afectará soamente aos impulsores de ficheiros */',
	'push-err-captacha' => 'Non se puido empurrar cara a $1 por mor do CAPTCHA.',
	'push-err-captcha-page' => 'Non se puido empurrar a páxina "$1" cara a todos os destinos por mor do CAPTCHA.',
	'push-err-authentication' => 'Fallou a autenticación en $1. $2',
	'push-tab-text' => 'Empurrar',
	'push-button-text' => 'Empurrar',
	'push-tab-desc' => 'Esta lapela permite empurrar a revisión actual desta páxina ata un ou máis wikis.',
	'push-button-pushing' => 'Empurrando',
	'push-button-pushing-files' => 'Empurrando os ficheiros',
	'push-button-completed' => 'Empuxe completado',
	'push-button-failed' => 'Erro no empuxe',
	'push-tab-title' => 'Empurrar "$1"',
	'push-targets' => 'Destinos para o empuxe',
	'push-add-target' => 'Engadir un destino',
	'push-import-revision-message' => 'Empurrado desde $1.',
	'push-tab-no-targets' => 'Non hai obxectivos ata os que empurrar. Engada algúns ao seu ficheiro LocalSettings.php.',
	'push-tab-push-to' => 'Empurrar a $1',
	'push-remote-pages' => 'Páxinas remotas',
	'push-remote-page-link' => '"$1" en $2',
	'push-remote-page-link-full' => 'Ollar "$1" en $2',
	'push-targets-total' => 'Hai un total de $1 {{PLURAL:$1|destino|destinos}}.',
	'push-button-all' => 'Empurrar todas',
	'push-tab-last-edit' => 'Última edición feita por $1 o $2 ás $3.',
	'push-tab-not-created' => 'Esta páxina aínda non existe.',
	'push-tab-push-options' => 'Opcións de empuxe:',
	'push-tab-inc-templates' => 'Incluír os modelos',
	'push-tab-used-templates' => '({{PLURAL:$2|Modelo empregado|Modelos empregados}}: $1)',
	'push-tab-no-used-templates' => '(Nesta páxina non se empregan modelos.)',
	'push-tab-inc-files' => 'Incluír ficheiros',
	'push-tab-err-fileinfo' => 'Non se puideron obter os ficheiros empregados ​​nesta páxina. Ningún deles foi empurrado.',
	'push-tab-err-filepush-unknown' => 'O empuxe do ficheiro fallou por unha razón descoñecida.',
	'push-tab-err-filepush' => 'O empuxe do ficheiro fallou: $1',
	'push-tab-embedded-files' => 'Ficheiros embelecidos:',
	'push-tab-no-embedded-files' => '(Non hai ningún ficheiro nesta páxina.)',
	'push-tab-files-override' => '{{PLURAL:$2|Este ficheiro xa existe|Estes ficheiros xa existen}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Este modelo xa existe|Estes modelos xa existen}}: $1',
	'push-tab-err-uploaddisabled' => 'As cargas non están habilitadas. Asegúrese de que as configuracións $wgEnableUploads e mais $wgAllowCopyUploads estean definidas como "true" no ficheiro LocalSettings.php do wiki de destino.',
	'special-push' => 'Empurrar as páxinas',
	'push-special-description' => 'Esta páxina permite empurrar o contido dunha ou máis páxinas ata un ou máis wikis de MediaWiki.

Para empurrar páxinas, insira os títulos na caixa de texto de embaixo (un título por liña) e prema no botón para empurralas todas. Isto pode levar uns intres ata que termine.',
	'push-special-pushing-desc' => 'Empurrando $2 {{PLURAL:$2|páxina|páxinas}} a $1...',
	'push-special-button-text' => 'Empurrar as páxinas',
	'push-special-target-is' => 'Wiki de destino: $1',
	'push-special-select-targets' => 'Wikis de destino:',
	'push-special-item-pushing' => '$1: Empurrando',
	'push-special-item-completed' => '$1: Empuxe completado',
	'push-special-item-failed' => '$1: Erro no empuxe: $2',
	'push-special-push-done' => 'Empuxe completado',
	'push-special-err-token-failed' => 'Non se puido obter un pase de edición no wiki de destino.',
	'push-special-err-pageget-failed' => 'Non se puido obter o contido actual da páxina local.',
	'push-special-err-push-failed' => 'O wiki de destino rexeitou a páxina empurrada.',
	'push-special-inc-files' => 'Incluír ficheiros',
	'push-special-err-imginfo-failed' => 'Non se puido determinar se hai algún ficheiro que necesite ser empurrado.',
	'push-special-obtaining-fileinfo' => '$1: Obtendo a información do ficheiro...',
	'push-special-pushing-file' => '$1: Empurrando o ficheiro "$2"...',
	'push-special-return' => 'Empurrar máis páxinas',
	'push-api-err-nocurl' => 'cURL non está instalado.
Poña $egPushDirectFileUploads como falso nos wikis públicos ou instale cURL nos wikis privados',
	'push-api-err-nofilesupport' => 'O MediaWiki local non ten soporte para publicar ficheiros.
En wikis públicos, defina $egPushDirectFileUploads como "false".
En wikis privados, aplique o parche linkd da documentación do Push ou actualice o propio MediaWiki.',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'push-desc' => 'Macht dr eifach Transfer vu Inhalt vun eme Wiki in e anders megli',
	'right-push' => 'Syten in anderi Wiki transferiere', # Fuzzy
	'right-bulkpush' => 'Syte gsammlet in anderi Wiki transferiere', # Fuzzy
	'right-pushadmin' => 'Transferyystellige un -ziil ändere', # Fuzzy
	'action-push' => 'Syte transferiere',
	'action-bulkpush' => 'Syte gsammlet transferiere',
	'action-pushadmin' => 'Transferyystellige konfiguriere',
	'group-pusher' => 'Transferierer',
	'group-pusher-member' => '{{GENDER:$1|Transferierer|Transferiereri}}',
	'grouppage-pusher' => '{{ns:project}}:Transferierer',
	'group-bulkpusher' => 'Sammeltransferierer',
	'group-bulkpusher-member' => '{{GENDER:$1|Sammeltransferierer|Sammeltransferiereri}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Sammeltransferierer',
	'group-filepusher' => 'Dateitransferierer',
	'group-filepusher-member' => '{{GENDER:$1|Dateitransferierer|Dateitransferiereri}}',
	'grouppage-filepusher' => '{{ns:project}}:Dateitransferierer',
	'push-err-captacha' => 'Transfer no $1 wäg eme CAPTCHA nit megli.',
	'push-err-captcha-page' => 'Syte $1 het wäge CAPTCHA zue keim vu dr Ziil chenne transferiert wäre.',
	'push-err-authentication' => 'Authentifizierig uf $1 isch fählgschlaa. $2',
	'push-tab-text' => 'Transferiere',
	'push-button-text' => 'Transferiere',
	'push-tab-desc' => 'Dää Ryter macht dr Transfer vum aktuälle Syteninhalt in ei oder mehreri  anderi Wiki megli.',
	'push-button-pushing' => 'Am Transferiere',
	'push-button-pushing-files' => 'Am Transferiere vu Dateie',
	'push-button-completed' => 'Transfer fertig',
	'push-button-failed' => 'Transfer fählgschlaa',
	'push-tab-title' => '$1 transferiere',
	'push-targets' => 'Transferziil',
	'push-add-target' => 'Transferziil zuefiege',
	'push-import-revision-message' => 'Us $1 transferiert.',
	'push-tab-no-targets' => 'S het no kei Transferziil. Tue zerscht e baar in dr Datei LocalSettings.php definiere.',
	'push-tab-push-to' => 'No $1 transferiere',
	'push-remote-pages' => 'Syten uuseneh',
	'push-remote-page-link' => '$1 uf $2',
	'push-remote-page-link-full' => '$1 uf $2 aaluege',
	'push-targets-total' => 'S git insgsamt $1 {{PLURAL:$1|Transferziil|Transferziil}}.',
	'push-button-all' => 'Alli transferiere',
	'push-tab-last-edit' => 'Letschti Bearbeitig dur dr Benutzer $1 am $2 am $3.',
	'push-tab-not-created' => 'Die Syte git s nit!',
	'push-tab-push-options' => 'Transferoptione:',
	'push-tab-inc-templates' => 'Vorlage mit yybinde',
	'push-tab-used-templates' => '({{PLURAL:$2|Vorlag|Vorlage}} yygsetzt: $1)',
	'push-tab-no-used-templates' => '(Uf däre Syte wäre kei Vorlagen yygsetzt.)',
	'push-tab-inc-files' => 'Yybetteti Dateie mit yybinde',
	'push-tab-err-fileinfo' => 'S het nit chenne ermittlet wäre, weli Dateien uf däre Syten yybunde sin. S sin keini transferiert wore.',
	'push-tab-err-filepush-unknown' => 'Dateitransfer isch us eme nit bekannte Grund fählgschlaa.',
	'push-tab-err-filepush' => 'Dateitransfer fählgschlaa: $1',
	'push-tab-embedded-files' => 'Yybetteti Dateie:',
	'push-tab-no-embedded-files' => '(Uf däre Syte git s kei yybetteti Dateie.)',
	'push-tab-files-override' => 'Die Dateie git s scho: $1', # Fuzzy
	'push-tab-template-override' => 'Die Vorlage git s scho: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'S Uffelade vu Dateien isch nit megli. D Parameter $wgEnableUploads un $wgAllowCopyUploads mien in dr Datei LocalSettings.php vum Ziilwiki uf „true“ gsetzt wäre.',
	'special-push' => 'Syte transferiere',
	'push-special-description' => 'Die Spezialsyte macht s megli dr Inhalt vu eire oder mehrere Syte zue eim oder mehrere andere Wikis z transferiere.

Go Syte transferiere sin d Titel vun ene im Yygabefäld unten aazgee (ei Titel pro Zyyle). Klick derno uf „{{int:push-special-button-text}}“. S cha ne Wyyli goh, bis dr Transfer abgschlossen isch.',
	'push-special-pushing-desc' => 'Am Transferiere vu $2 {{PLURAL:$2|Syte|Syte}} no $1 …',
	'push-special-button-text' => 'Syte transferiere',
	'push-special-target-is' => 'Ziilwiki: $1',
	'push-special-select-targets' => 'Ziilwiki:',
	'push-special-item-pushing' => '$1: Am Transferiere …',
	'push-special-item-completed' => '$1: Transfer abgschlosse',
	'push-special-item-failed' => '$1: Transfer fählgschlaa. $2',
	'push-special-push-done' => 'Transfer abgschlosse',
	'push-special-err-token-failed' => 'Uf em Ziilwiki het dr Bearbeitigs-Token nit chenne abgruefe wäre.',
	'push-special-err-pageget-failed' => 'Uf däm Wiki het dr Syteninhalt nit chenne abgruefe wäre.',
	'push-special-err-push-failed' => 'S Ziilwiki het d Syte, wu soll tranferiert wäre, zruckgwise.',
	'push-special-inc-files' => 'Yybetteti Dateie mit yybinde',
	'push-special-err-imginfo-failed' => 'S het nit chenne ermittlet wäre, eb au Dateie mien transferiert wäre.',
	'push-special-obtaining-fileinfo' => '$1: Am Abruefe vu Dateiinformatione …',
	'push-special-pushing-file' => '$1: Am Transferiere vu dr Datei $2 …',
	'push-special-return' => 'Meh Syte transferiere',
	'push-api-err-nocurl' => 'cURL isch nit installiert.
De Parameter $egPushDirectFileUploads muess wäge däm für alli öffentlichi Wikis uff "false" gsetzt werde. Alternativ cURL für alli nitöffentlichi Wikis installiere.',
	'push-api-err-nofilesupport' => 'Di lokali MediaWiki-Installation unterstützt s Uffelade vo Dateie nit.
Uff öffentliche Wikis muess de Parameter $egPushDirectFileUploads uff "false" gsetzt werde.
Uff nit-öffentliche Wikis muess de Patch aagwändet werde, wo über d Dokumentationssyte zu derre Softwareerwyyterig erhältli isch, oder d MediaWiki-Installation sälber muess aktualisiert werde.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'push-desc' => 'הרחבה קלילה לדחיפת תוכן לאתרי ויקי אחרים',
	'right-push' => 'לאשר שימוש בפעולת הדחיפה.', # Fuzzy
	'right-bulkpush' => 'לאשר שימוש בדחיפת דפים מרובים (למשל Special:Push)', # Fuzzy
	'right-pushadmin' => 'לאשר לשנות יעדי דחיפה ותצורת דחיפה.', # Fuzzy
	'push-err-captacha' => 'דחיפה ל{{GRAMMAR:תחילית|$1}} לא הצליחה בכלל CAPTCHA',
	'push-err-captcha-page' => 'דחיפת הדף $1 לכל היעדים לא התאפשרה בגלל CAPTCHA.',
	'push-err-authentication' => 'אימות ב{{GRAMMAR:תחילית|$1}} נכשל. $2',
	'push-tab-text' => 'דחיפה',
	'push-button-text' => 'דחיפה',
	'push-tab-desc' => 'הלשונית הזאת מאפשרת לך לדחוף את הגרסה הנוכחית של הדף לאתר ויקי אחד או יותר.',
	'push-button-pushing' => 'דחיפה',
	'push-button-pushing-files' => 'דחיפת קבצים',
	'push-button-completed' => 'הדחיפה הושלמה',
	'push-button-failed' => 'הדחיפה נכשלה',
	'push-tab-title' => 'לדחוף את $1',
	'push-targets' => 'יעדי דחיפה',
	'push-add-target' => 'הוספת יעד',
	'push-import-revision-message' => 'נדחף מ{{GRAMMAR:תחילית|$1}}',
	'push-tab-no-targets' => 'אין יעדים לדחיפה. אנא הוסיפו כמה יעדים לקובץ LocalSettings.php שלכם.',
	'push-tab-push-to' => 'לדחוף ל{{GRAMMAR:תחילית|$1}}',
	'push-remote-pages' => 'דפים מרוחקים',
	'push-remote-page-link' => '$1 באתר $2',
	'push-remote-page-link-full' => 'להציג $1 באתר $2',
	'push-targets-total' => 'יש {{PLURAL:$1|יעד אחד|$1 יעדים}} בסך הכול.',
	'push-button-all' => 'לדחוף הכול',
	'push-tab-last-edit' => 'עריכה אחרונה מאת $1 באתר $2 ב־$3.',
	'push-tab-not-created' => 'הדף הזה עדיין לא קיים.',
	'push-tab-push-options' => 'אפשרויות דחיפה:',
	'push-tab-inc-templates' => 'לכלול תבניות',
	'push-tab-used-templates' => '(נעשה שימוש ב{{PLURAL:$2|תבנית|תבניות}}: $1)',
	'push-tab-no-used-templates' => '(אין שימוש בתבניות בדף הזה.)',
	'push-tab-inc-files' => 'לכלול קבצים מוטבעים',
	'push-tab-err-fileinfo' => 'לא ברור באילו קבצים משתמש הדף. לא נדחף שום קובץ.',
	'push-tab-err-filepush-unknown' => 'דחיפת קובץ נכשלה מסיבה לא ידועה.',
	'push-tab-err-filepush' => 'דחיפת קובץ נכשלה: $1',
	'push-tab-embedded-files' => 'קבצים מוטבעים:',
	'push-tab-no-embedded-files' => '(אין קבצים מוטבעים בדף הזה.)',
	'push-tab-files-override' => 'הקבצים האלה כבר קיימים: $1', # Fuzzy
	'push-tab-template-override' => 'התבניות האלו כבר קיימות: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'העלאות אינן מופעלות. יש לוודא כי ערך המשתנים ‎$wgEnableUploads ו־‎$wgEnableUploads הוא true בוויקי היעד.',
	'special-push' => 'דחיפת דפים',
	'push-special-description' => 'הדף הזה מאפשר לכם לדחוף דף אחד או יותר לאתר ויקי אחד או יותר שמשתמש במדיה־ויקי.

כדי לדחוף דפים, הכניסו את כותרות הדפים לתיבת הטקסט להלן, כותרת אחת בכל שורה, ולחצו על הכפתור "לדחוף הכול". ביצוע הפעולה יכול לקחת זמן.',
	'push-special-pushing-desc' => 'דחיפה של {{PLURAL:$2|עמוד אחד|$2 עמודים}} ל{{GRAMMAR:תחילית|$1}}...',
	'push-special-button-text' => 'לדחוף דפים',
	'push-special-target-is' => 'אתר הוויקי המיועד: $1',
	'push-special-select-targets' => 'אתרי הוויקי המיועדים:',
	'push-special-item-pushing' => '$1: דחיפה',
	'push-special-item-completed' => '$1 דחיפה הושלמה',
	'push-special-item-failed' => '$1: דחיפה נכשלה: $2',
	'push-special-push-done' => 'הדחיפה הושלמה',
	'push-special-err-token-failed' => 'לא הצלחתי לקבל אסימון עריכה באתר הוויקי המיועד.',
	'push-special-err-pageget-failed' => 'כשל בקבלת תוכן הדף המקומי.',
	'push-special-err-push-failed' => 'אתר הוויקי המיועד סירב לקבל את הדף הנדחף.',
	'push-special-inc-files' => 'לכלול קבצים מוטבעים',
	'push-special-err-imginfo-failed' => 'לא ברור אם צריך לדחוף קבצים כלשהו.',
	'push-special-obtaining-fileinfo' => '$1: קבלת מידע על הקובץ...',
	'push-special-pushing-file' => '$1: דחיפת הקובץ $2...',
	'push-special-return' => 'לדחוף יותר דפים',
	'push-api-err-nocurl' => 'cURL לא מותקן.
הגדירו את המשתנה ‎$egPushDirectFileUploads כ־false באתרי ויקי ציבוריים, או התקינו את cURL באתרי ויקי פרטיים',
	'push-api-err-nofilesupport' => 'התקנת מדיה־ויקי מקומית לא תומכת בפעולת post על קבצים.
באתרי ויקי ציבוריים הגדירו את המשתנה ‎$egPushDirectFileUploads כ־false.
באתרי ויקי פרטיים התקינו את התיקון המקושר מהתיעוד של Push או שדרגו את תוכנת מדיה־ויקי עצמה.',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'push-desc' => 'Jednore rozšěrjenje za přenošowanje wobsaha do druhich wikijow',
	'right-push' => 'Awtorizacija za wužiwanje přenošowanskeje funkcionalnosće.', # Fuzzy
	'right-bulkpush' => 'Awtorizacija za wužiwanje přenošowanskeje funkcionalnosće z masami (t. j. Special:Push).', # Fuzzy
	'right-pushadmin' => 'Awtorizacije za změnjenje přenošowanskich cilow a přenošowanskich nastajenjow.', # Fuzzy
	'action-push' => 'Strony přenjesć',
	'action-bulkpush' => 'Strony z masami přenjesć',
	'action-pushadmin' => 'přenjesenje konfigurować',
	'group-pusher' => 'Přenošowarjo',
	'group-pusher-member' => '{{GENDER:$1|přenošowar|přenošowarka}}',
	'grouppage-pusher' => '{{ns:project}}:Přenošowarjo',
	'group-bulkpusher' => 'Masowi přenošowarjo',
	'group-bulkpusher-member' => '{{GENDER:$1|masowy přenošowar|masowa přenošowarka}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Masowi přenošowarjo',
	'group-filepusher' => 'Přenošowarjo datajow',
	'group-filepusher-member' => '{{GENDER:$1|přenošowar|přenošowarka}} datajow',
	'grouppage-filepusher' => '{{ns:project}}:Přenošowarjo datajow',
	'push-err-captacha' => 'Přenošowanje do $1 CAPTCHA dla njemóžno.',
	'push-err-captcha-page' => 'Strona $1 njeda so CAPTCHA dla do wšěch cilow přenjesć.',
	'push-err-authentication' => 'Awtentifikacija na $1 je so njeporadźiła. $2',
	'push-tab-text' => 'Přenjesć',
	'push-button-text' => 'Přenjesć',
	'push-tab-desc' => 'Tutón rajtark ći zmóžnja aktualnu wersiju tuteje strony do druhich wikijow přenjesć.',
	'push-button-pushing' => 'Přenošowanje',
	'push-button-pushing-files' => 'Dataje so přenošuja',
	'push-button-completed' => 'Přenjesenje zakónčene',
	'push-button-failed' => 'Přenjesenje je so njeporadźiło',
	'push-tab-title' => '$1 přenjesć',
	'push-targets' => 'Přenošowanske cile',
	'push-add-target' => 'Cil přidać',
	'push-import-revision-message' => 'Z $1 přenjeseny.',
	'push-tab-no-targets' => 'Njejsu žane přenošowanske cile. Prošu zapodaj je w dataji LocalSettings.php.',
	'push-tab-push-to' => 'Do $1 přenjesć',
	'push-remote-pages' => 'Zdalene strony',
	'push-remote-page-link' => '$1 w $2',
	'push-remote-page-link-full' => 'Stronu $1 na $2 sej wobhladać',
	'push-targets-total' => '{{PLURAL:$1|Je $1 strona|Stej $1 stronje|Su $1 strony|Je $1 stronow}}.',
	'push-button-all' => 'Wšě přenjesć',
	'push-tab-last-edit' => 'Poslednja změna wot wužiwarja $1, $2, $3.',
	'push-tab-not-created' => 'Tuta strona hišće njeeksistuje.',
	'push-tab-push-options' => 'Přenošowanske opcije:',
	'push-tab-inc-templates' => 'Předłohi zapřijeć',
	'push-tab-used-templates' => '({{PLURAL:$2|Wužita předłoha|Wužitej předłoze|Wužite předłohi|Wužite předłohi}}: $1)',
	'push-tab-no-used-templates' => '(Na tutej stronje so žane přełohi wužiwaja.)',
	'push-tab-inc-files' => 'Zasadźene dataje zapřijeć',
	'push-tab-err-fileinfo' => 'Njeda so zwěsćić, kotre dataje so na tutej stronje wužiwaja. Žana njeje so přenjesła.',
	'push-tab-err-filepush-unknown' => 'Přenjesenje dataje je so z njeznateje přičiny njeporadźiło.',
	'push-tab-err-filepush' => 'Přenjesenje dataje je so njeporadźiło: $1',
	'push-tab-embedded-files' => 'Zasadźene dataje:',
	'push-tab-no-embedded-files' => '(Žane zasadźene dataje na tutej stronje.)',
	'push-tab-files-override' => 'Tute dataje hižo eksistuja: $1', # Fuzzy
	'push-tab-template-override' => 'Tute předłohi hižo eksistuja: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Nahraća njejsu zmóžnjene, Staj $wgEnableUploads a $wgAllowCopyUploads w dataji LocalSettings.php ciloweho wikija na "true".',
	'special-push' => 'Strony přenjesć',
	'push-special-description' => 'Tuta strona ći zmóžnja wobsah stronow do druhich wikijow MediaWiki přenjesć.

Zo by strony přenjesł, zapodaj titule do slědowaceho tekstoweho pola, jedyn titul na linku a klikń potom na "Wšě přenjesć". Móže chwilku trać, doniž přenjesenje njeje zakónčene.',
	'push-special-pushing-desc' => '{{PLURAL:$2|Přenošuje so $2 strona|Přenošujetej so $2 stronje|Přenošuja so $2 strony|Přenošuje so $2 stronow}} do $1...',
	'push-special-button-text' => 'Strony přenjesć',
	'push-special-target-is' => 'Cilowy wiki: $1',
	'push-special-select-targets' => 'Cilowe wikije:',
	'push-special-item-pushing' => '$1: Přenošuje so',
	'push-special-item-completed' => '$1: Přenjesenje zakónčene',
	'push-special-item-failed' => '$1: Přenjesenje je so njeporadźiło: $2',
	'push-special-push-done' => 'Přenjesenje zakónčene',
	'push-special-err-token-failed' => 'Wobdźěłowanski token njeda so na cilowym wikiju wobstarać.',
	'push-special-err-pageget-failed' => 'Wobsah lokalneje strony njeda so wobstarać.',
	'push-special-err-push-failed' => 'Cilowy wiki je přenjesenu stronu wotpokazał.',
	'push-special-inc-files' => 'Zasadźene dataje zapřijeć',
	'push-special-err-imginfo-failed' => 'Njeda so zwěsćić, hač dataje dyrbja so přenjesć.',
	'push-special-obtaining-fileinfo' => '$1: Datajowe informacije so wobstaruja...',
	'push-special-pushing-file' => '$1: Dataja $2 so přenošuje...',
	'push-special-return' => 'Dalše strony přenjesć',
	'push-api-err-nocurl' => 'cURL njeje instalowany.
Staj $egPushDirectFileUploads na false na zjawnych wikijach abo instaluj cURL za priwatne wikije',
	'push-api-err-nofilesupport' => 'Lokalna instalacija MediaWiki njepodpěruje nahrawanje datajow.
Staj na zjawnych wikijach parameter $egPushDirectFileUploads na "false".
Na priwatnych wikijach nałož patch linkd z dokumentacije Push abo zaktualizuj MediaWiki.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'push-desc' => 'Extension simple pro transferer contento a altere wikis',
	'right-push' => 'Autorisation a usar le functionalitate de transferimento.', # Fuzzy
	'right-bulkpush' => 'Autorisation a usar le functionalitate de transferimento in massa (i.e. Special:Push).', # Fuzzy
	'right-pushadmin' => 'Autorisation a modificar destinationes e configurationes de transferimento.', # Fuzzy
	'action-push' => 'transferer paginas',
	'action-bulkpush' => 'transferer paginas in massa',
	'action-pushadmin' => 'configurar transferimento',
	'group-pusher' => 'Transferitores',
	'group-pusher-member' => '{{GENDER:$1||transferitor|transferitrice}}',
	'grouppage-pusher' => '{{ns:project}}:Transferitores',
	'group-bulkpusher' => 'Transferitores in massa',
	'group-bulkpusher-member' => '{{GENDER:$1|transferitor|transferitrice}} in massa',
	'grouppage-bulkpusher' => '{{ns:project}}:Transferitores_in_massa',
	'group-filepusher' => 'Transferitores de files',
	'group-filepusher-member' => '{{GENDER:$1|transferitor|transferitrice}} de files',
	'grouppage-filepusher' => '{{ns:project}}:Transferitores_de_files',
	'push-err-captacha' => 'Non poteva transferer a $1 a causa de un problema con le "captcha".',
	'push-err-captcha-page' => 'Non poteva transferer le pagina $1 a tote le destinationes proque un "captcha" esseva incontrate.',
	'push-err-authentication' => 'Authentication a $1 ha fallite. $2',
	'push-tab-text' => 'Transferer',
	'push-button-text' => 'Transferer',
	'push-tab-desc' => 'Iste scheda permitte transferer le version actual de iste pagina a un o plus altere wikis.',
	'push-button-pushing' => 'Transferimento in curso',
	'push-button-pushing-files' => 'Transfere files',
	'push-button-completed' => 'Transferimento complete',
	'push-button-failed' => 'Transferimento fallite',
	'push-tab-title' => 'Transferer $1',
	'push-targets' => 'Destinationes de transferimento',
	'push-add-target' => 'Adder destination',
	'push-import-revision-message' => 'Transferite ex $1.',
	'push-tab-no-targets' => 'Il non ha destinationes de transferimento. Per favor adde alcunes in tu file LocalSettings.php.',
	'push-tab-push-to' => 'Transferer a $1',
	'push-remote-pages' => 'Paginas remote',
	'push-remote-page-link' => '$1 in $2',
	'push-remote-page-link-full' => 'Vider $1 in $2',
	'push-targets-total' => 'Il ha un total de $1 {{PLURAL:$1|destination|destinationes}}.',
	'push-button-all' => 'Transferer totes',
	'push-tab-last-edit' => 'Ultime modification per $1 le $2 a $3.',
	'push-tab-not-created' => 'Iste pagina non existe ancora.',
	'push-tab-push-options' => 'Optiones de transferimento:',
	'push-tab-inc-templates' => 'Includer patronos',
	'push-tab-used-templates' => '({{PLURAL:$2|Patrono|Patronos}} usate: $1)',
	'push-tab-no-used-templates' => '(Nulle patrono es usate in iste pagina.)',
	'push-tab-inc-files' => 'Includer files incorporate',
	'push-tab-err-fileinfo' => 'Non poteva determinar qual files es usate in iste pagina. Nulle file ha essite transferite.',
	'push-tab-err-filepush-unknown' => 'Le transferimento ha fallite pro un ration incognite.',
	'push-tab-err-filepush' => 'Transferimento de file fallite: $1',
	'push-tab-embedded-files' => 'File incastrate',
	'push-tab-no-embedded-files' => '(Nulle file es incastrate in iste pagina.)',
	'push-tab-files-override' => 'Iste files ja existe: $1', # Fuzzy
	'push-tab-template-override' => 'Iste patronos ja exite: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Le incargamento non es activate. Assecura te que le variabiles $wgEnableUploads e $wgAllowCopyUploads sia specificate como "true" in le file LocalSettings.php del wiki de destination.',
	'special-push' => 'Transferer paginas',
	'push-special-description' => 'Iste pagina permitte transferer le contento de un o plus paginas a un o plus wikis MediaWiki.

Pro transferer paginas, entra le titulos in le quadro de texto hic infra, un titulo per linea, e preme "Transferer totes". Isto pote prender certe un tempore.',
	'push-special-pushing-desc' => 'Transfere $2 {{PLURAL:$2|pagina|paginas}} a $1...',
	'push-special-button-text' => 'Transferer paginas',
	'push-special-target-is' => 'Wiki de destination: $1',
	'push-special-select-targets' => 'Wikis de destination:',
	'push-special-item-pushing' => '$1: Transferimento in curso',
	'push-special-item-completed' => '$1: Transferimento complete',
	'push-special-item-failed' => '$1: Transferimento fallite: $2',
	'push-special-push-done' => 'Transferimento complete',
	'push-special-err-token-failed' => 'Non poteva obtener un indicio de modification in le wiki de destination.',
	'push-special-err-pageget-failed' => 'Non poteva obtener le contento del pagina local.',
	'push-special-err-push-failed' => 'Le wiki de destination refusava le pagina transferite.',
	'push-special-inc-files' => 'Includer files incastrate',
	'push-special-err-imginfo-failed' => 'Non poteva determinar si es necessari transferer files.',
	'push-special-obtaining-fileinfo' => '$1: Obtene informationes de file...',
	'push-special-pushing-file' => '$1: Transfere file $2...',
	'push-special-return' => 'Transferer plus paginas',
	'push-api-err-nocurl' => 'cURL non es installate.
Mitte $egPushDirectFileUploads a false in wikis public, o installa cURL pro wikis private',
	'push-api-err-nofilesupport' => 'Le MediaWiki local non ha supporto pro le incargamento de files.
In wikis public, mitte $egPushDirectFileUploads a false.
In wikis private, applica le patch ligate ab le documentation de Push o actualisa MediaWiki mesme.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'push-desc' => 'Ekstensi ringan untuk mendorong konten ke wiki lainnya',
	'right-push' => 'Otorisasi untuk menggunakan fungsi dorong.', # Fuzzy
	'right-bulkpush' => 'Otorisasi untuk menggunakan fungsi dorong massal (Special:Push).', # Fuzzy
	'right-pushadmin' => 'Otorisasi untuk memodifikasi target dan pengaturan dorong.', # Fuzzy
	'push-err-captacha' => 'Tidak dapat mendorong ke $1 karena captcha.',
	'push-err-captcha-page' => 'Tidak dapat mendorong halaman $1 ke semua target karena captcha.',
	'push-err-authentication' => 'Otentikasi pada $1 gagal. $2',
	'push-tab-text' => 'Dorong',
	'push-button-text' => 'Dorong',
	'push-tab-desc' => 'Tab ini mengizinkan Anda untuk mendorong revisi terbaru halaman ini ke satu atau lebih wiki lain.',
	'push-button-pushing' => 'Mendorong',
	'push-button-pushing-files' => 'Mendorong berkas',
	'push-button-completed' => 'Pendorongan selesai',
	'push-button-failed' => 'Pendorongan gagal',
	'push-tab-title' => 'Mendorong $1',
	'push-targets' => 'Target pendorongan',
	'push-add-target' => 'Tambahkan target',
	'push-import-revision-message' => 'Didorong dari $1.',
	'push-tab-no-targets' => 'Tidak ada target untuk pendorongan. Harap tambahkan beberapa berkas ke LocalSettings.php Anda.',
	'push-tab-push-to' => 'Dorong ke $1',
	'push-remote-pages' => 'Halaman luar',
	'push-remote-page-link' => '$1 pada $2',
	'push-remote-page-link-full' => 'Lihat $1 pada $2',
	'push-targets-total' => 'Total ada $1 {{PLURAL:$1|target|target}}.',
	'push-button-all' => 'Dorong semua',
	'push-tab-last-edit' => 'Suntingan terakhir oleh $1 pada $2 $3.',
	'push-tab-not-created' => 'Halaman ini belum ada.',
	'push-tab-push-options' => 'Pilihan dorongan:',
	'push-tab-inc-templates' => 'Sertakan templat',
	'push-tab-used-templates' => '({{PLURAL:$2|Templat|Templat}} yang digunakan: $1)',
	'push-tab-no-used-templates' => '(Tidak ada templat yang digunakan pada halaman ini.)',
	'push-tab-inc-files' => 'Sertakan berkas tersemat',
	'push-tab-err-fileinfo' => 'Tidak dapat mengetahui berkas mana yang digunakan pada halaman ini. Tidak ada yang didorong.',
	'push-tab-err-filepush-unknown' => 'Gagal mendorong berkas karena alasan yang tidak diketahui.',
	'push-tab-err-filepush' => 'Gagal mendorong berkas: $1',
	'push-tab-embedded-files' => 'Berkas tersemat:',
	'push-tab-no-embedded-files' => '(Tidak ada berkas yang tersemat pada halaman ini.)',
	'push-tab-files-override' => 'Berkas berikut telah ada: $1', # Fuzzy
	'push-tab-template-override' => 'Templat berikut telah ada: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Pengunggahan tidak aktif. Pastikan $wgEnableUploads dan $wgAllowCopyUploads disetel sebagai true dalam LocalSettings.php wiki target.',
	'special-push' => 'Dorong halaman',
	'push-special-description' => 'Halaman ini memungkinkan Anda untuk mendorong satu atau lebih halaman ke satu atau lebih wiki MediaWiki.

Untuk mendorong halaman, masukkan judul dalam kotak teks di bawah ini, satu judul per baris, dan tekan dorong semua. Proses ini dapat memakan waktu cukup lama.',
	'push-special-pushing-desc' => 'Mendorong $2 {{PLURAL:$2|halaman|halaman}} ke $1...',
	'push-special-button-text' => 'Dorong halaman',
	'push-special-target-is' => 'Wiki target: $1',
	'push-special-select-targets' => 'Wiki target:',
	'push-special-item-pushing' => '$1: Mendorong',
	'push-special-item-completed' => '$1: Pendorongan selesai',
	'push-special-item-failed' => '$1: Pendorongan gagal: $2',
	'push-special-push-done' => 'Pendorongan selesai',
	'push-special-err-token-failed' => 'Tidak dapat memperoleh token sunting pada wiki target.',
	'push-special-err-pageget-failed' => 'Tidak dapat memperoleh konten halaman lokal.',
	'push-special-err-push-failed' => 'Wiki target menolak laman yang didorong.',
	'push-special-inc-files' => 'Sertakan berkas tersemat',
	'push-special-err-imginfo-failed' => 'Tidak dapat menentukan apakah ada berkas yang perlu didorong.',
	'push-special-obtaining-fileinfo' => '$1: Mencari informasi berkas...',
	'push-special-pushing-file' => '$1: Mendorong berkas $2...',
	'push-special-return' => 'Dorong halaman lain',
	'push-api-err-nocurl' => 'cURL tidak diinstal.
Setel $egPushDirectFileUploads menjadi false pada wiki publik atau instal cURL untuk wiki pribadi',
	'push-api-err-nofilesupport' => 'MediaWiki lokal tidak memiliki dukungan untuk mengirim berkas.
Pada wiki publik, setel $egPushDirectFileUploads menjadi false.
Pada wiki pribadi, terapkan tambalan linkd dari dokumentasi Push atau perbarui MediaWiki itu sendiri.',
);

/** Italian (italiano)
 * @author Beta16
 * @author F. Cosoleto
 */
$messages['it'] = array(
	'push-remote-pages' => 'Pagine remote',
	'push-remote-page-link' => '$1 da $2',
	'push-remote-page-link-full' => 'Vedi $1 da $2',
	'push-tab-last-edit' => 'Ultima modifica di $1 il $2 alle $3.',
	'push-tab-not-created' => 'Questa pagina non esiste ancora.',
	'push-tab-inc-templates' => 'Includi i template',
	'push-tab-used-templates' => '({{PLURAL:$2|Usa|Usati}} template: $1)',
	'push-tab-no-used-templates' => '(Nessun template è utilizzato in questa pagina).',
	'push-tab-inc-files' => 'Includi file incorporati',
	'push-tab-embedded-files' => 'File incorporati:',
	'push-tab-no-embedded-files' => '(Nessun file è incorporato in questa pagina).',
	'push-tab-files-override' => '{{PLURAL:$2|Questo file esiste|Questi file esistono}} già: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Questo template esiste|Questi template esistono}} già: $1',
	'push-special-target-is' => 'Wiki di destinazione: $1',
	'push-special-select-targets' => 'Wiki di destinazione:',
	'push-api-err-nocurl' => "cURL non è installato.
Imposta \$egPushDirectFileUploads a 'false' sui wiki pubblici, o installa cURL per i wiki privati",
);

/** Japanese (日本語)
 * @author Ohgi
 * @author Shirayuki
 */
$messages['ja'] = array(
	'push-desc' => '他のウィキにコンテンツをプッシュする軽量な拡張機能',
	'right-push' => 'プッシュ機能を使用',
	'right-bulkpush' => '一括プッシュ機能 (Special:Push) を使用',
	'right-pushadmin' => 'プッシュの対象や設定を変更',
	'action-push' => 'ページのプッシュ',
	'action-bulkpush' => 'ページを一括プッシュ',
	'action-pushadmin' => 'プッシュの設定の変更',
	'group-pusher' => 'プッシュ担当者',
	'group-pusher-member' => '{{GENDER:$1|プッシュ担当者}}',
	'grouppage-pusher' => '{{ns:project}}:プッシュ担当者',
	'group-bulkpusher' => '一括プッシュ担当者',
	'group-bulkpusher-member' => '{{GENDER:$1|一括プッシュ担当者}}',
	'grouppage-bulkpusher' => '{{ns:project}}:一括プッシュ担当者',
	'group-filepusher' => 'ファイルプッシュ担当者',
	'group-filepusher-member' => '{{GENDER:$1|ファイルプッシュ担当者}}',
	'grouppage-filepusher' => '{{ns:project}}:ファイルプッシュ担当者',
	'group-pusher.css' => '/* ここに記述したCSSはプッシュ担当者のみに影響します */',
	'group-pusher.js' => '/* ここに記述したJSはプッシュ担当者のみに影響します */',
	'group-bulkpusher.css' => '/* ここに記述したCSSは一括プッシュ担当者のみに影響します */',
	'group-bulkpusher.js' => '/* ここに記述したJSは一括プッシュ担当者のみに影響します */',
	'group-filepusher.css' => '/* ここに記述したCSSはファイルプッシュ担当者のみに影響します */',
	'group-filepusher.js' => '/* ここに記述したJSはファイルプッシュ担当者のみに影響します */',
	'push-err-captacha' => 'CAPTCHA のため、$1 にプッシュできませんでした。',
	'push-tab-text' => 'プッシュ',
	'push-button-text' => 'プッシュ',
	'push-button-pushing' => 'プッシュ中',
	'push-button-pushing-files' => 'ファイルをプッシュ中',
	'push-button-completed' => 'プッシュ完了',
	'push-button-failed' => 'プッシュ失敗',
	'push-tab-title' => '$1 のプッシュ',
	'push-add-target' => '対象を追加',
	'push-tab-push-to' => '$1 へのプッシュ',
	'push-remote-pages' => '(リモート ページ)',
	'push-button-all' => 'すべてプッシュ',
	'push-tab-push-options' => 'プッシュのオプション:',
	'push-tab-inc-templates' => 'テンプレートを含める',
	'push-tab-err-filepush-unknown' => 'ファイルのプッシュが、不明な理由により失敗しました。',
	'push-tab-err-filepush' => 'ファイルのプッシュに失敗: $1',
	'push-tab-no-embedded-files' => '(このページにはファイルは埋め込まれていません。)',
	'push-tab-files-override' => '{{PLURAL:$2|以下のファイルは既に存在します}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|以下のテンプレートは既に存在します}}: $1',
	'push-tab-err-uploaddisabled' => 'アップロードが有効になっていません。アップロード先のウィキの LocalSettings.php で $wgEnableUploads および $wgAllowCopyUploads が true に設定されていることを確認してください。',
	'push-special-pushing-desc' => '$2 {{PLURAL:$2|件のページ}}を $1 にプッシュ中...',
	'push-special-button-text' => 'ページをプッシュ',
	'push-special-target-is' => '対象のウィキ: $1',
	'push-special-select-targets' => '対象のウィキ:',
	'push-special-item-pushing' => '$1: プッシュ中',
	'push-special-item-completed' => '$1: プッシュ完了',
	'push-special-item-failed' => '$1: プッシュに失敗しました: $2',
	'push-special-push-done' => 'プッシュ完了',
	'push-special-obtaining-fileinfo' => '$1: ファイル情報を取得中...',
	'push-special-pushing-file' => '$1: ファイル $2 をプッシュ中...',
	'push-special-return' => 'その他のページをプッシュ',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'push-tab-text' => 'განთავსება',
	'push-button-text' => 'განთავსება',
	'push-button-pushing' => 'თავსდება',
	'push-button-pushing-files' => 'განთავსებადი ფაილები',
	'push-button-completed' => 'განთავსება დასრულებულია',
	'push-button-failed' => 'განთავსება ვერ მოხერხდა',
	'push-tab-title' => 'განთავსება $1',
	'push-targets' => 'განთავსების მიზანი',
	'push-add-target' => 'მიზნის დამატება',
	'push-remote-pages' => 'გვერდების წაშლა',
	'push-remote-page-link' => '$1 $2-ზე',
	'push-remote-page-link-full' => 'იხილეთ $1 $2-ზე',
	'push-button-all' => 'ყველას განთავსება',
	'push-tab-not-created' => 'ეს გვერდი ჯერ არ არსებობს.',
	'push-tab-push-options' => 'განთავსების პარამეტრები:',
	'push-tab-inc-templates' => 'თარგების ჩართვა',
	'push-tab-used-templates' => '(გამოყენებულია {{PLURAL:$2|თარგი|თარგები}}: $1)',
	'push-tab-no-used-templates' => '(ამ გვერდზე თარგები არ გამოიყენება.)',
	'push-tab-embedded-files' => 'ჩადგმული ფაილები:',
	'push-tab-no-embedded-files' => '(ამ გვერდზე არ არის ჩადგმული ფაილები.)',
	'push-tab-files-override' => 'შემდეგი ფაილები უკვე არსებობენ: $1', # Fuzzy
	'push-tab-template-override' => 'შემდეგი თარგები უკვე არსებობენ: $1', # Fuzzy
	'special-push' => 'გვერდების განთავსება',
	'push-special-button-text' => 'გვერდების განთავსება',
	'push-special-target-is' => 'სამიზნო ვიკი: $1',
	'push-special-select-targets' => 'სამიზნო ვიკიები:',
	'push-special-item-pushing' => '$1: თავსდება',
	'push-special-item-completed' => '$1: განთავსება დასრულებულია',
	'push-special-item-failed' => '$1: განთავსება ვერ მოხერხდა: $2',
	'push-special-push-done' => 'განთავსება დასრულებულია',
	'push-special-obtaining-fileinfo' => '$1: ინფორმაციის მიღება ფაილზე...',
	'push-special-pushing-file' => '$1: თავსდება ფაილი $2...',
	'push-special-return' => 'მეტი გვერდის განთავსება',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'push-desc' => '다른 위키에 내용을 밀어넣는 가벼운 확장 기능',
	'right-push' => '밀기 기능을 사용하기',
	'right-bulkpush' => '대량 밀기 기능(즉 특수:밀기)를 사용하기',
	'right-pushadmin' => '밀기 대상과 밀기 설정 수정하기',
	'action-push' => '문서 밀기',
	'action-bulkpush' => '문서 대량 밀기',
	'action-pushadmin' => '밀기 구성',
	'group-pusher' => '미는자',
	'group-pusher-member' => '{{GENDER:$1|미는자}}',
	'grouppage-pusher' => '{{ns:project}}:미는자',
	'group-bulkpusher' => '대량 미는자',
	'group-bulkpusher-member' => '{{GENDER:$1|대량 미는자}}',
	'grouppage-bulkpusher' => '{{ns:project}}:대량 미는자',
	'group-filepusher' => '파일 미는자',
	'group-filepusher-member' => '{{GENDER:$1|파일 미는자}}',
	'grouppage-filepusher' => '{{ns:project}}:파일 미는자',
	'group-pusher.css' => '/* 이 CSS 설정은 미는자에만 적용됩니다 */',
	'group-pusher.js' => '/* 이 자바스크립트 설정은 미는자에만 적용됩니다 */',
	'group-bulkpusher.css' => '/* 이 CSS 설정은 대량 미는자에만 적용됩니다 */',
	'group-bulkpusher.js' => '/* 이 자바스크립트 설정은 대량 미는자에만 적용됩니다 */',
	'group-filepusher.css' => '/* 이 CSS 설정은 파일 미는자에만 적용됩니다 */',
	'group-filepusher.js' => '/* 이 자바스크립트 설정은 파일 미는자에만 적용됩니다 */',
	'push-err-captacha' => 'CAPTCHA(캡차)로 인해 $1(을)를 밀지 못했습니다.',
	'push-err-captcha-page' => 'CAPTCHA(캡차)로 인해 모든 대상에 $1(을)를 밀지 못했습니다.',
	'push-err-authentication' => '$1(을)를 인증하는 데 실패했습니다. $2',
	'push-tab-text' => '밀기',
	'push-button-text' => '밀기',
	'push-tab-desc' => '이 탭을 사용하면 하나 이상의 다른 위키에 이 문서의 현재 버전을 밀 수 있습니다.',
	'push-button-pushing' => '밀기',
	'push-button-pushing-files' => '파일 밀기',
	'push-button-completed' => '밀기 완료',
	'push-button-failed' => '밀기 실패',
	'push-tab-title' => '$1 밀기',
	'push-targets' => '대상 밀기',
	'push-add-target' => '대상 추가',
	'push-import-revision-message' => '$1(으)로부터 밀어냈습니다.',
	'push-tab-no-targets' => '미는 대상이 없습니다. LocalSetting.php 파일에 일부를 추가하세요.',
	'push-tab-push-to' => '$1(으)로 밀기',
	'push-remote-pages' => '원격 문서',
	'push-remote-page-link' => '$2의 $1',
	'push-remote-page-link-full' => '$2에 $1 보기',
	'push-targets-total' => '대상 총 $1개가 있습니다.',
	'push-button-all' => '모두 밀기',
	'push-tab-last-edit' => '$2 $3에 $1에 의해 마지막으로 편집했습니다.',
	'push-tab-not-created' => '이 문서가 존재하지 않습니다.',
	'push-tab-push-options' => '밀기 옵션:',
	'push-tab-inc-templates' => '틀 포함하기',
	'push-tab-used-templates' => '({{PLURAL:$2|틀}} 사용: $1)',
	'push-tab-no-used-templates' => '(이 문서에 틀을 사용하지 않았습니다.)',
	'push-tab-inc-files' => '포함한 파일 포함',
	'push-tab-err-fileinfo' => '이 문서에 사용되는 파일을 가져올 수 없습니다. 아무 것도 밀지 않았습니다.',
	'push-tab-err-filepush-unknown' => '알 수 없는 이유로 파일 밀기를 실패했습니다.',
	'push-tab-err-filepush' => '파일 밀기 실패: $1',
	'push-tab-embedded-files' => '포함한 파일:',
	'push-tab-no-embedded-files' => '(이 문서에 포함한 파일이 없습니다.)',
	'push-tab-files-override' => '{{PLURAL:$2|이 파일이 이미 존재합니다|이러한 파일이 이미 존재합니다}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|이 틀이 이미 존재합니다|이러한 틀이 이미 존재합니다}}: $1',
	'push-tab-err-uploaddisabled' => '올리기가 활성화되지 않았습니다. 대상 위키의 LocalSettings.php의 $wgEnableUploads와 $wgAllowCopyUploads 설정이 true로 되어있는지 확인하세요.',
	'special-push' => '문서 밀기',
	'push-special-description' => '이 문서에는 하나 이상의 MediaWiki 위키에 하나 이상의 문서의 밀 콘텐트가 있습니다.

문서를 밀려면 아래의 텍스트 상자에 한 줄에 하나의 제목을 입력하고 모두 밀기를 누루세요. 이를 완료하는 데 시간이 걸릴 수 있습니다.',
	'push-special-pushing-desc' => '$1(으)로 $2 문서를 미는 중...',
	'push-special-button-text' => '문서 밀기',
	'push-special-target-is' => '대상 위키: $1',
	'push-special-select-targets' => '대상 위키:',
	'push-special-item-pushing' => '$1: 미는 중',
	'push-special-item-completed' => '$1: 밀기 완료',
	'push-special-item-failed' => '$1: 밀기 실패: $2',
	'push-special-push-done' => '밀기 완료',
	'push-special-err-token-failed' => '대상 위키에 편집 토큰을 가져올 수 없습니다.',
	'push-special-err-pageget-failed' => '로컬 문서 콘텐트를 가져올 수 없습니다.',
	'push-special-err-push-failed' => '대상 위키에서 문서를 미는 것을 거부했습니다.',
	'push-special-inc-files' => '포함한 파일 포함',
	'push-special-err-imginfo-failed' => '밀어내야 할 어떠한 파일도 확인할 수 없습니다.',
	'push-special-obtaining-fileinfo' => '$1: 파일 정보를 가져오는 중...',
	'push-special-pushing-file' => '$1: $2 파일을 미는 중...',
	'push-special-return' => '더 많은 문서 밀기',
	'push-api-err-nocurl' => 'cURL를 설치하지 않았습니다.
공개 위키에서 $egPushDirectFileUploads를 false로 설정하거나 비공개 위키에 cURL을 설치하세요',
	'push-api-err-nofilesupport' => '로컬 MediaWiki에 파일을 게시하는 데에 지원이 없습니다.
공개 위키의 경우 $egPushDirectFileUploads를 false로 설정하세요.
비공개 위키의 경우 밀기 설명서 또는 MediaWiki 자체에서 업데이트하여 링크한 패치를 적용하세요.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'push-desc' => 'E eijfach Zohsazprojramm för Saache en ander Wikis erövver zo bränge.',
	'group-pusher' => 'Övverdraarer',
	'group-pusher-member' => '{{GENDER:$1|Övverdraarer}}',
	'grouppage-pusher' => '{{ns:project}}:Övverdraarer',
	'group-bulkpusher' => 'Maßßeövverdraarer',
	'group-bulkpusher-member' => '{{GENDER:$1|Maßßeövverdraarer}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Maßßeövverdraarer',
	'group-filepusher' => 'Datteijeövverdraarer',
	'group-filepusher-member' => '{{GENDER:$1|Datteijeövverdraarer}}',
	'grouppage-filepusher' => '{{ns:project}}:Datteijeövverdraarer',
	'group-pusher.css' => '/* Dat CSS heh aan dä Stell wirrek nur op de Siggeövverdraarer */',
	'group-pusher.js' => '/* Dat JavaSkrep heh aan dä Stell wirrek nur op de Siggeövverdraarer */',
	'group-bulkpusher.css' => '/* Dat CSS heh aan dä Stell wirrek nur op de Maßßeövverdraarer */',
	'group-bulkpusher.js' => '/* Dat JavaSkrep heh aan dä Stell wirrek nur op de Maßßeövverdraarer */',
	'group-filepusher.css' => '/* Dat CSS heh aan dä Stell wirrek nur op de Datteijeeövverdraarer */',
	'group-filepusher.js' => '/* Dat JavaSkrep heh aan dä Stell wirrek nur op de Datteijeövverdraarer */',
	'push-tab-text' => 'Övverdraare',
	'push-button-text' => 'Övverdraare',
	'push-remote-page-link' => '$1 {{GENDER:en+Dativ|{{ucfirst:$2}}}}',
	'push-remote-page-link-full' => 'De Sigg „$1“ {{GRAMMAR:em|{{ucfirst:$2}}}} beloore',
	'push-targets-total' => 'Es jitt ensjesamp {{PLURAL:$1|ei Ziel|$1 Ziele|kein Ziele}}.',
	'push-tab-not-created' => 'Di Sigg jidd_et noch nit!',
	'push-tab-inc-templates' => 'De Schablone metnämme',
	'push-tab-inc-files' => 'Enthallde Datteije metnämme',
	'push-tab-embedded-files' => 'Enthallde Datteije:',
	'push-special-inc-files' => 'Enthallde Datteije metnämme',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 * @author Soued031
 */
$messages['lb'] = array(
	'push-desc' => 'Erweiderung déi en einfachen Transfert (Push) vun Inhalt op aner Wikien erméiglecht',
	'right-push' => 'Push-Funktionalitéit ze benotzen',
	'right-bulkpush' => "Benotzt d'Funktionalitéit fir méi Säite mateneen an aner Wikien ze transferéieren (kuckt Special:Push)",
	'right-pushadmin' => 'Push-Ziler a Push-Astellungen änneren',
	'action-push' => 'Säite transferéieren',
	'action-bulkpush' => 'vill Säite mateneen ze transferéieren',
	'action-pushadmin' => 'Transfert astellen',
	'push-err-captacha' => 'Push op $1 konnt wéint dem Captcha net gemaach ginn.',
	'push-tab-text' => 'Push',
	'push-button-text' => 'Push',
	'push-button-pushing-files' => 'Fichiere ginn transferéiert',
	'push-button-completed' => 'Push ofgeschloss',
	'push-button-failed' => 'Push huet net funktionéiert',
	'push-tab-title' => '$1 transferéieren',
	'push-add-target' => 'Zil derbäisetzen',
	'push-tab-push-to' => 'Op $1 transferéieren',
	'push-remote-page-link' => '$1 op $2',
	'push-remote-page-link-full' => '$1 op $2 weisen',
	'push-targets-total' => 'Et gëtt am Ganzen $1 {{PLURAL:$1|Zil|Ziler}}.',
	'push-button-all' => 'All transferéieren',
	'push-tab-last-edit' => 'Lescht Ännerung vum $1 de(n) $2 ëm $3 Auer.',
	'push-tab-not-created' => 'Dës Säit gëtt et nach net',
	'push-tab-push-options' => 'Push-Optiounen',
	'push-tab-inc-templates' => 'Inklusiv Schablounen',
	'push-tab-used-templates' => '({{PLURAL:$2|Schabloun gëtt|Schabloune gi}} benotzt: $1)',
	'push-tab-no-used-templates' => '(Op dëser Säit gi keng Schabloune benotzt.)',
	'push-tab-inc-files' => 'Agebonne Fichieren abannen',
	'push-tab-embedded-files' => 'Agebonne Fichieren:',
	'push-tab-no-embedded-files' => '(An dëser Säit si keng Fichieren agebonn.)',
	'push-tab-files-override' => '{{PLURAL:$2|Dëse Fichier|Dës Fichiere}} gëtt et schonn: $1',
	'push-tab-template-override' => 'Dës {{PLURAL:$2|Schabloun|Schabloune}} gëtt et schonn: $1',
	'special-push' => 'Säiten transferéieren',
	'push-special-button-text' => 'Säite pushen',
	'push-special-target-is' => 'Zilwiki: $1',
	'push-special-select-targets' => 'Zielwikien:',
	'push-special-item-pushing' => '$1: Gett transferéiert...',
	'push-special-item-completed' => '$1: Transfert ofgeschloss',
	'push-special-item-failed' => '$1: Push huet net funktionéiert: $2',
	'push-special-push-done' => 'Transfert ofgeschloss',
	'push-special-err-push-failed' => 'Zilwiki huet déi transferéiert Säit refuséiert.',
	'push-special-inc-files' => 'Agebonne Fichieren abannen',
	'push-special-return' => 'Méi Säite pushen',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'push-desc' => 'Мал додаток за пренесување на содржини од едно на други викија',
	'right-push' => 'Употреба на функцијата за пренесување',
	'right-bulkpush' => 'Употреба на функцијата за групно пренесување (т.е. Special:Push).',
	'right-pushadmin' => 'Измена на одредниците и поставките за пренесување',
	'action-push' => 'пренеси страници',
	'action-bulkpush' => 'пренеси страници на големо',
	'action-pushadmin' => 'поставки за преносот',
	'group-pusher' => 'Префрлачи',
	'group-pusher-member' => '{{GENDER:$1|префрлач}}',
	'grouppage-pusher' => '{{ns:project}}:Префрлачи',
	'group-bulkpusher' => 'Префрлачи на големо',
	'group-bulkpusher-member' => '{{GENDER:$1|префрлач на големо}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Префрлачи_на_големо',
	'group-filepusher' => 'Префрлачки на податотеки',
	'group-filepusher-member' => '{{GENDER:$1|префрлач на податотеки}}',
	'grouppage-filepusher' => '{{ns:project}}:Префрлачи_на_податотеки',
	'group-pusher.css' => '/* Тука поставениот CSS ќе се применува само врз префрлачи */',
	'group-pusher.js' => '/* Тука поставениот JS ќе се применува само врз префрлачи */',
	'group-bulkpusher.css' => '/* Тука поставениот CSS ќе се применува само врз префрлачи на големо */',
	'group-bulkpusher.js' => '/* Тука поставениот JS ќе се применува само врз префрлачи на големо */',
	'group-filepusher.css' => '/* Тука поставениот CSS ќе се применува само врз префрлачи на податотеки */',
	'group-filepusher.js' => '/* Тука поставениот JS ќе се применува само врз префрлачи на податотеки */',
	'push-err-captacha' => 'Не можев да го пренесам $1 поради Captcha.',
	'push-err-captcha-page' => 'Не можев да ја пренесам страницата $1 на сите одредници заради Captcha.',
	'push-err-authentication' => 'Потврдувањето на $1 не успеа. $2',
	'push-tab-text' => 'Пренеси',
	'push-button-text' => 'Пренеси',
	'push-tab-desc' => 'Ова јазиче ви овозможува да ја пренесете тековната ревизија на страницава на едно или повеќе викија',
	'push-button-pushing' => 'Пренесувам',
	'push-button-pushing-files' => 'Пренесувам податотеки',
	'push-button-completed' => 'Преносот заврши',
	'push-button-failed' => 'Преносот не успеа',
	'push-tab-title' => 'Пренеси - $1',
	'push-targets' => 'Одредници за преносот',
	'push-add-target' => 'Додај одредница',
	'push-import-revision-message' => 'Пренесено од $1.',
	'push-tab-no-targets' => 'Нема одредници во кои би се извршил преносот. Додајте места во вашата податотека LocalSettings.php.',
	'push-tab-push-to' => 'Пренеси во $1',
	'push-remote-pages' => 'Далечински страници',
	'push-remote-page-link' => '$1 на $2',
	'push-remote-page-link-full' => 'Преглед на $1 на $2',
	'push-targets-total' => 'Има вкупно $1 {{PLURAL:$1|одредница|одредници}}.',
	'push-button-all' => 'Пренеси сè',
	'push-tab-last-edit' => 'Последна измена од $1 на $2 во $3 ч.',
	'push-tab-not-created' => 'Оваа страница сè уште не постои.',
	'push-tab-push-options' => 'Поставки за преносот:',
	'push-tab-inc-templates' => 'Вклучи шаблони',
	'push-tab-used-templates' => '({{PLURAL:$2|Шаблон|Шаблони}} во употреба: $1)',
	'push-tab-no-used-templates' => '(На страницава не се користат шаблони.)',
	'push-tab-inc-files' => 'Вклучи вматнати податотеки',
	'push-tab-err-fileinfo' => 'Не можев да востановам кои податотеки се користат на страницава. Затоа не преместив ниедна.',
	'push-tab-err-filepush-unknown' => 'Пренесувањето на податотеката не успеа од непознати причини.',
	'push-tab-err-filepush' => 'Пренесувањето на податотеката не успеа: $1',
	'push-tab-embedded-files' => 'Вметнати податотеки:',
	'push-tab-no-embedded-files' => '(Во страницава нема вметнати податотеки.)',
	'push-tab-files-override' => '{{PLURAL:$2|Податотеката веќе постои|Веќе постојат следниве податотеки}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Шаблонот веќе постои|Следниве шаблони веќе постојат}}: $1',
	'push-tab-err-uploaddisabled' => 'Подигањето не е овозможено. Наместете ги $wgEnableUploads и $wgAllowCopyUploads на „true“ во LocalSettings.php на целното вики.',
	'special-push' => 'Пренесување страници',
	'push-special-description' => 'Оваа страница ви овозможува да пренесете содржини од една или повеќе страници од едно вики во едно или повеќе викија што работат на МедијаВики.

За да пренесете, внесете ги насловите во полето подолу, по едно во секој ред, па стиснете на „Пренеси сè“. Ова може да потрае.',
	'push-special-pushing-desc' => 'Пренесувам $2 {{PLURAL:$2|страница|страници}} во $1...',
	'push-special-button-text' => 'Пренеси страници',
	'push-special-target-is' => 'Целно вики: $1',
	'push-special-select-targets' => 'Целни викија:',
	'push-special-item-pushing' => '$1: Преместување',
	'push-special-item-completed' => '$1: Преносот заврши',
	'push-special-item-failed' => '$1: Преносот не успеа: $2',
	'push-special-push-done' => 'Преносот заврши',
	'push-special-err-token-failed' => 'Не можев да ја добијам шифрата на уредувањето на целното вики.',
	'push-special-err-pageget-failed' => 'Не можев да ја добијам содржината на локалната страница.',
	'push-special-err-push-failed' => 'Целното вики ја одби пренесената страница.',
	'push-special-inc-files' => 'Вклучи вметнати податотеки',
	'push-special-err-imginfo-failed' => 'Не можев да утврдам дали треба да се пренесат податотеки.',
	'push-special-obtaining-fileinfo' => '$1: Преземам податотечни податоци...',
	'push-special-pushing-file' => '$1: Ја пренесувам податотеката $2...',
	'push-special-return' => 'Пренеси уште страници',
	'push-api-err-nocurl' => 'cURL не е инсталиран.
Наместете го $egPushDirectFileUploads на „false“ на јавните викија, или пак инсталирајте го cURL на приватните викија',
	'push-api-err-nofilesupport' => 'Локалниот МедијаВики нема поддршка за објавување на податотеки.
На јавни викија, наместете го $egPushDirectFileUploads на „false“.
На приватни викија, ставете ја поправката linkd од документацијата на Push или подновете го самиот МедијаВики.',
);

/** Dutch (Nederlands)
 * @author Krinkle
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'push-desc' => "Lichtgewichtuitbreiding om inhoud naar andere wiki's te sturen",
	'right-push' => 'Pushfunctionaliteit gebruiken',
	'right-bulkpush' => 'Mag en masse pushfunctionaliteit gebruiken ({{#Special:Push}}).',
	'right-pushadmin' => "Mag doelwiki's en instellingen voor het versturen van inhoud aanpassen.",
	'action-push' => "pagina's te verzenden",
	'action-bulkpush' => "massaal pagina's te verzenden",
	'action-pushadmin' => 'verzenden in te stellen',
	'group-pusher' => 'Pushers',
	'group-pusher-member' => '{{GENDER:$1|pusher}}',
	'grouppage-pusher' => '{{ns:project}}:Pushers',
	'group-bulkpusher' => 'Bulkpushers',
	'group-bulkpusher-member' => '{{GENDER:$1|bulkpusher}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Bulkpushers',
	'group-filepusher' => 'Bestandspushers',
	'group-filepusher-member' => '{{GENDER:$1|bestandspusher}}',
	'grouppage-filepusher' => '{{ns:project}}:Bestandspushers',
	'push-err-captacha' => 'Het was niet mogelijk inhoud te verzenden naar $1 omdat de andere wiki een captchaoplossing heeft gevraagd.',
	'push-err-captcha-page' => "Het was niet mogelijk de pagina $1 naar alle doelwiki's te verzenden omdat er om een captchaoplossing is gevraagd.",
	'push-err-authentication' => 'Het aanmelden bij $1 is mislukt. $2',
	'push-tab-text' => 'Verzenden',
	'push-button-text' => 'Verzenden',
	'push-tab-desc' => "Via dit tabblad kunt u de inhoud van de huidige versie van deze pagina naar een of meer andere wiki's verzenden.",
	'push-button-pushing' => 'Bezig met verzenden',
	'push-button-pushing-files' => 'Bezig met het versturen van bestanden',
	'push-button-completed' => 'Het verzenden is voltooid',
	'push-button-failed' => 'Het verzenden is mislukt',
	'push-tab-title' => 'Bezig met het verzenden van $1',
	'push-targets' => "Doelwiki's",
	'push-add-target' => 'Doelwiki toevoegen',
	'push-import-revision-message' => 'Verzonden vanuit $1.',
	'push-tab-no-targets' => "Er zijn geen beschikbare doelwiki's. Voeg deze eerst toe aan uw LocalSettings.php-bestand.",
	'push-tab-push-to' => 'Verzenden naar $1',
	'push-remote-pages' => "Pagina's in andere wiki's",
	'push-remote-page-link' => '$1 op $2',
	'push-remote-page-link-full' => '$1 op $2 bekijken',
	'push-targets-total' => "Er {{PLURAL:$1|is één doelwiki|zijn $1 doelwiki's}}.",
	'push-button-all' => 'Alles verzenden',
	'push-tab-last-edit' => 'Laatste bewerking door $1 op $2 om $3.',
	'push-tab-not-created' => 'Deze pagina bestaat nog niet.',
	'push-tab-push-options' => 'Verzendinstellingen:',
	'push-tab-inc-templates' => 'Sjablonen ook verzenden',
	'push-tab-used-templates' => '{{PLURAL:$2|Gebruikt sjabloon|Gebruikte sjablonen}}: $1',
	'push-tab-no-used-templates' => 'Er worden geen sjablonen gebruikt op deze pagina.',
	'push-tab-inc-files' => 'Ingesloten bestanden bijsluiten',
	'push-tab-err-fileinfo' => 'Het was niet mogelijk vast te stellen welke bestanden op deze pagina gebruikt worden. Er zijn geen bestanden verstuurd.',
	'push-tab-err-filepush-unknown' => 'Het versturen van een bestand is om onbekende reden mislukt.',
	'push-tab-err-filepush' => 'Het versturen van een bestand is mislukt: $1',
	'push-tab-embedded-files' => 'Ingesloten bestanden:',
	'push-tab-no-embedded-files' => 'Er zijn geen ingesloten bestanden op deze pagina.',
	'push-tab-files-override' => '{{PLURAL:$2|Dit bestand bestaat|Deze bestanden bestaan}} al: $1',
	'push-tab-template-override' => 'Deze {{PLURAL:$2|sjabloon bestaat|sjablonen bestaan}} al: $1',
	'push-tab-err-uploaddisabled' => 'Uploaden is niet ingeschakeld. Zorg ervoor dat $wgEnableUploads en $wgAllowCopyUploads zijn ingesteld op "waar" in LocalSettings.php van de doelwiki.',
	'special-push' => "Pagina's verzenden",
	'push-special-description' => "Via deze pagina kunt u de inhoud van een of meer pagina's naar een of meer MediaWiki-wiki's verzenden.

Voer paginanamen in het onderstaande invoerveld in om pagina's te kunnen verzenden.
Voer iedere paginanaam in op een nieuwe regel en klik op \"Alles verzenden\".
Het verzenden kan enige tijd kosten.",
	'push-special-pushing-desc' => "Bezig met het verzenden van {{PLURAL:$2|één pagina|$2 pagina's}} naar $1...",
	'push-special-button-text' => "Pagina's verzenden",
	'push-special-target-is' => 'Doelwiki: $1',
	'push-special-select-targets' => "Doelwiki's:",
	'push-special-item-pushing' => '$1: bezig met verzenden',
	'push-special-item-completed' => '$1: het verzenden is voltooid',
	'push-special-item-failed' => '$1: het verzenden is mislukt: $2',
	'push-special-push-done' => 'Het verzenden is afgerond',
	'push-special-err-token-failed' => 'Het was niet mogelijk een bewerkingstoken te verkrijgen van de doelwiki.',
	'push-special-err-pageget-failed' => 'Het was niet mogelijk de inhoud van de lokale pagina te verkrijgen.',
	'push-special-err-push-failed' => 'De doelwiki heeft de verzonden pagina niet geaccepteerd.',
	'push-special-inc-files' => 'Ingesloten bestanden bijsluiten',
	'push-special-err-imginfo-failed' => 'Het was niet mogelijk vast te stellen of er bestanden meegestuurd moeten worden.',
	'push-special-obtaining-fileinfo' => '$1: bestandsgegevens aan het ophalen...',
	'push-special-pushing-file' => '$1: bestand $2 aan het verzenden...',
	'push-special-return' => "Meer pagina's verzenden",
	'push-api-err-nocurl' => 'cURL is niet geïnstalleerd.
Stel op publieke wiki\'s $egPushDirectFileUploads in op "false" of installeer cURL in een besloten wiki.',
	'push-api-err-nofilesupport' => 'De lokale MediaWiki heeft geen ondersteuning voor het doorsturen van bestanden. 
Stel op openbare wiki\'s $egPushDirectFileUploads in op "false".
Voer de patch waarnaar wordt verwezen in de documentatie van Push uit op besloten wiki\'s of werk MediaWiki zelf bij.',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'push-desc' => "Extension pas gaire gromanda que servís a butar (''push'' en anglés) de contengut cap d'autres wikis",
	'right-push' => 'Utilizar la foncionalitat de push.',
	'right-bulkpush' => 'Utilizar la foncionalitat de push en massa (es a dire Special:Push).',
	'right-pushadmin' => 'Modificar las ciblas e los paramètres de push.',
	'action-push' => 'butar las paginas',
	'action-bulkpush' => 'butar las paginas en massa',
	'action-pushadmin' => 'configurar la publicacion',
	'group-pusher' => 'Butaires',
	'group-pusher-member' => '{{GENDER:$1|butaire|butaira}}',
	'grouppage-pusher' => '{{ns:project}}:Butaires',
	'group-bulkpusher' => 'Butaires en massa',
	'group-bulkpusher-member' => '{{GENDER:$1|Butaire en massa|Butaira en massa}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Butaires_en_massa',
	'group-filepusher' => 'Butaires de fichièr',
	'group-filepusher-member' => '{{GENDER:$1|butaire de fichièr|butaira de fichièr}}',
	'grouppage-filepusher' => '{{ns:project}}:Butaires_de_fichièr',
	'push-err-captacha' => "Impossible de butar cap a $1 en rason d'un CAPTCHA.",
	'push-err-captcha-page' => 'Impossible de butar la pagina $1 cap a totas las ciblas en rason de CAPTCHA.',
	'push-err-authentication' => "Fracàs de l'autentificacion a $1. $2",
	'push-tab-text' => 'Butar',
	'push-button-text' => 'Butar',
	'push-tab-desc' => "Aqueste onglet vos permet de butar la revision actuala d'aquesta pagina cap a un o mantun wiki mai.",
	'push-button-pushing' => 'Butada',
	'push-button-pushing-files' => 'Butada dels fichièrs',
	'push-button-completed' => 'Butada acabada',
	'push-button-failed' => 'Butada fracassada',
	'push-tab-title' => 'Butar $1',
	'push-targets' => 'Ciblas per la butada',
	'push-add-target' => "Apondon d'una cible",
	'push-import-revision-message' => 'Butat dempuèi $1.',
	'push-tab-no-targets' => 'I a pas cap de cibla de butar. Sens vos comandar, apondètz-ne a vòstre fichièr LocalSettings.php.',
	'push-tab-push-to' => 'Butatz cap a $1',
	'push-remote-pages' => 'paginas a distància',
	'push-remote-page-link' => '$1 sus $2',
	'push-remote-page-link-full' => 'Veire $1 sus $2',
	'push-targets-total' => 'I a un total de $1 {{PLURAL:$1|cibla|ciblas}}.',
	'push-button-all' => 'Butar tot',
	'push-tab-last-edit' => 'Darrièra modificacion per $1 sus $2 a $3.',
	'push-tab-not-created' => 'Aquesta pagina existís pas encara.',
	'push-tab-push-options' => 'Paramètres de butada :',
	'push-tab-inc-templates' => 'Inclure los modèls',
	'push-tab-used-templates' => '({{PLURAL:$2|modèl utilizat|modèls utilizats}} : $1)',
	'push-tab-no-used-templates' => '(Cap de modèl pas utilizat sus aquesta pagina.)',
	'push-tab-inc-files' => 'Inclure de fichièrs junts',
	'push-tab-err-fileinfo' => "Impossible d'obténer quins fichièrs son utilizats sus aquesta pagina. Cap d'eles son pas estat butats.",
	'push-tab-err-filepush-unknown' => 'La butada del fichièr a fracassat per una rason desconeguda.',
	'push-tab-err-filepush' => 'La butada del fichièr a fracassat : $1',
	'push-tab-embedded-files' => 'Fichièrs junts :',
	'push-tab-no-embedded-files' => '(Pas cap de fichièr junt dins aquesta pagina.)',
	'special-push' => 'Paginas de butar',
	'push-special-pushing-desc' => 'Butada de $2 {{PLURAL:$2|pagina|paginas}} cap a $1...',
	'push-special-button-text' => 'Paginas de butar',
	'push-special-target-is' => 'wiki cibla : $1',
	'push-special-select-targets' => 'wikis ciblas :',
	'push-special-item-pushing' => '$1 : butada en cors',
	'push-special-item-completed' => '$1 : Butada acabada',
	'push-special-item-failed' => '$1 : la butada a fracassat : $2',
	'push-special-push-done' => 'Butada acabada',
	'push-special-obtaining-fileinfo' => "$1: Obtencion d'informacions sul fichièr...",
	'push-special-pushing-file' => '$1: butar lo fichièr $2...',
	'push-special-return' => 'Butar mai de paginas',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'push-tab-text' => 'Iwadraache',
	'push-button-text' => 'Iwadraache',
	'push-button-pushing' => "Iwadraach's",
	'push-button-pushing-files' => 'Iwadraach Dadaije',
	'push-button-completed' => 'Iwadraach isch ferdisch',
	'push-button-failed' => 'Iwadraach hod ned gklabd',
	'push-tab-title' => 'Iwadraach $1',
	'push-import-revision-message' => 'Vun $1 iwadraache.',
	'push-tab-no-targets' => "S'hod kä Ziel fade Iwadraach. Seds des mol in doine LocalSettings.php Dadai.",
	'push-tab-push-to' => "Iwadraach's noch $1",
	'push-remote-page-link' => 'Said $1 uffm Wiki $2',
	'push-remote-page-link-full' => 'Guggda $1 uffm Wiki $2 oa',
	'push-button-all' => 'Iwadraach alles',
	'push-tab-last-edit' => 'Ledschd Ännarung vum Benudza $1 om $2 um $3 Uhr.',
	'push-tab-not-created' => 'Die Said hods noch ned.',
	'push-tab-err-fileinfo' => "Ma wes ned, wasfa Dadaije do oigbunde sin. S'isch nix iwadraache worre.",
	'push-tab-err-filepush-unknown' => 'Dadai iwadraache hod ned gklabd un ma wes ned warum.',
	'push-tab-err-filepush' => 'Dadai hod ned iwadraache were kenne: $1',
	'push-tab-no-embedded-files' => '(Uff der Said hods kä Dadaije.)',
	'push-tab-files-override' => 'Die Dadaije hods schun: $1', # Fuzzy
	'push-tab-template-override' => 'Die Vorlaache hods schun: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'S\'Hochlaade vun Dadaije gehd ned. Schdell sischa, das <code>$wgEnableUploads</code> un <code>$wgAllowCopyUploads</code> inde Dadai LocalSettings.php vum Zielwiki uff „true“ schdehd.',
	'special-push' => 'Saide iwadraache',
	'push-special-pushing-desc' => 'Iwadraach $2 {{PLURAL:$2|Said|Saide}} noch $1 …',
	'push-special-button-text' => 'Saide iwadraache',
	'push-special-target-is' => 'Zielwiki: $1',
	'push-special-select-targets' => 'Zielwikis:',
	'push-special-item-pushing' => '$1: Iwadraache …',
	'push-special-item-completed' => '$1: Iwadraach isch ferdisch',
	'push-special-item-failed' => '$1: Iwadraach hod net gklabd. $2',
	'push-special-push-done' => 'Iwadraach isch ferdisch',
	'push-special-pushing-file' => '$1: Iwadraach Dadai $2 …',
	'push-special-return' => 'Mea Saide iwaddraache',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Matma Rex
 */
$messages['pl'] = array(
	'push-desc' => 'Lekkie rozszerzenie by przesunąć treść na inne wiki',
	'right-push' => 'Autoryzacja do używania funkcji przesuwania.', # Fuzzy
	'right-bulkpush' => 'Autoryzacja do wykorzystania funkcji przesuwania hurtowego (tj. Special:Push).', # Fuzzy
	'right-pushadmin' => 'Upoważnienie do zmiany celów i ustawień przesuwania.', # Fuzzy
	'action-push' => 'przesuwania stron',
	'action-bulkpush' => 'hurtowego przesuwania stron',
	'action-pushadmin' => 'konfigurowania przesuwania',
	'group-pusher' => 'Przesuwacze',
	'group-pusher-member' => '{{GENDER:$1|przesuwacz|przesuwaczka}}',
	'grouppage-pusher' => '{{ns:project}}:Przesuwacze',
	'group-bulkpusher' => 'Przesuwacze hurtowi',
	'group-bulkpusher-member' => '{{GENDER:$1|przesuwacz hurtowy|przesuwaczka hurtowa}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Przesuwacze hurtowi',
	'group-filepusher' => 'Przesuwacze plików',
	'group-filepusher-member' => '{{GENDER:$1|przesuwacz plików|przesuwaczka plików}}',
	'grouppage-filepusher' => '{{ns:project}}:Przesuwacze plików',
	'push-err-captacha' => 'Nie można przesunąć do $1 ze względu na captchę.',
	'push-err-captcha-page' => 'Nie można przesunąć strony $1 do żadnego celu ze względu na captchę.',
	'push-err-authentication' => 'Uwierzytelnianie w $1 nie powiodło się. $2',
	'push-tab-text' => 'Przesuń',
	'push-button-text' => 'Przesuń',
	'push-tab-desc' => 'Ta zakładka pozwala na umieszczenie aktualnej wersji tej strony na jednej lub wielu innych wiki.',
	'push-button-pushing' => 'Przesuwanie...',
	'push-button-pushing-files' => 'Przesuwanie plików',
	'push-button-completed' => 'Przesuwanie zakończone',
	'push-button-failed' => 'Przesuwanie nie powiodło się',
	'push-tab-title' => 'Przesuń $1',
	'push-targets' => 'Cele przesuwania',
	'push-add-target' => 'Dodaj cel',
	'push-import-revision-message' => 'Przesunięto z $1.',
	'push-tab-no-targets' => 'Nie ma żadnych celów, do których można by przesuwać. Dodaj je w swoim pliku LocalSettings.php.',
	'push-tab-push-to' => 'Przesuń do $1',
	'push-remote-pages' => 'Zdalne strony',
	'push-remote-page-link' => '$1 na $2',
	'push-remote-page-link-full' => 'Zobacz $1 na $2',
	'push-targets-total' => 'Istniej{{PLURAL:$1|e|ą|e}} w sumie $1 {{PLURAL:$1|cel|cele|celów}}.',
	'push-button-all' => 'Przesuń wszystkie',
	'push-tab-last-edit' => 'Ostatnia edycja autorstwa $1 na stronie $2: $3.',
	'push-tab-not-created' => 'Ta strona jeszcze nie istnieje.',
	'push-tab-push-options' => 'Opcje przesuwania:',
	'push-tab-inc-templates' => 'Dołącz szablony',
	'push-tab-used-templates' => '(Wykorzystywan{{PLURAL:$2|y szablon|e szablony}}: $1)',
	'push-tab-no-used-templates' => '(Na tej stronie nie są wykorzystywane żadne szablony.)',
	'push-tab-inc-files' => 'Dołącz osadzone pliki',
	'push-tab-err-fileinfo' => 'Nie udało się ustalić, jakie pliki są wykorzystywane na tej stronie. Nie przesunięto żadnych.',
	'push-tab-err-filepush-unknown' => 'Przesuwanie pliku nie powiodło się z nieznanego powodu.',
	'push-tab-err-filepush' => 'Przesuwanie pliku nie powiodło się: $1',
	'push-tab-embedded-files' => 'Osadzone pliki:',
	'push-tab-no-embedded-files' => '(Na tej stronie nie ma osadzonych żadnych plików.)',
	'push-tab-files-override' => 'Te pliki już istnieją: $1', # Fuzzy
	'push-tab-template-override' => 'Te szablony już istnieją: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Przesyłanie plików jest wyłączone. Upewnij się, że ustawienia $wgEnableUploads i $wgAllowCopyUploads w pliku konfiguracyjnym LocalSettings.php wiki docelowej ustawione na true.',
	'special-push' => 'Przesuń strony',
	'push-special-description' => 'Ta strona pozwala umieścić zawartość jednej lub wielu stron na jednej lub wielu innych stronach internetowych typu wiki opartych na silniku MediaWiki.

Aby „przesunąć” strony, wpisz ich tytuły w polu tekstowym poniżej (jeden tytuł w jednej linii) i wciśnij przycisk „Przesuń wszystkie”. Może to zająć dłuższą chwilę.',
	'push-special-pushing-desc' => 'Przesuwanie $2 {{PLURAL:$2|strony|stron}} do $1...',
	'push-special-button-text' => 'Przesuń strony',
	'push-special-target-is' => 'Docelowa wiki: $1',
	'push-special-select-targets' => 'Docelowe wiki:',
	'push-special-item-pushing' => '$1: Przesuwanie',
	'push-special-item-completed' => '$1: Przesuwanie zakończone',
	'push-special-item-failed' => '$1: Przesuwanie nie powiodło się: $2',
	'push-special-push-done' => 'Przesuwanie zakończone',
	'push-special-err-token-failed' => 'Nie można uzyskać tokenu edycyjnego na docelowej wiki.',
	'push-special-err-pageget-failed' => 'Nie udało się uzyskać lokalnej zawartości strony.',
	'push-special-err-push-failed' => 'Docelowa wiki odrzuciła przesuwaną stronę.',
	'push-special-inc-files' => 'Dołącz osadzone pliki',
	'push-special-err-imginfo-failed' => 'Nie udało się określić, czy jakiekolwiek pliki powinny zostać przesunięte.',
	'push-special-obtaining-fileinfo' => '$1: Pobieranie informacji o pliku...',
	'push-special-pushing-file' => '$1: Przesuwanie pliku $2...',
	'push-special-return' => 'Przesuń więcej stron',
	'push-api-err-nocurl' => 'cURL nie jest zainstalowany.
Na publicznej wiki ustaw parametr $egPushDirectFileUploads na wartość false, na prywatnej wiki zainstaluj cURL.',
	'push-api-err-nofilesupport' => 'Lokalne MediaWiki nie obsługuje przesyłania plików.
Na publicznej wiki ustaw parametr $egPushDirectFileUploads na wartość false.
Na prywatnej wiki zastosuj patch linkd z dokumentacji rozszerzenia Push lub zaktualizuj MediaWiki.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'push-desc' => "Estension legera për possé dël contnù vers d'àutre wiki",
	'right-push' => 'Autorisassion a dovré la funsion ed gionté.', # Fuzzy
	'right-bulkpush' => 'Autorisassion a dovré la funsion ëd possé a caterve (visadì Special:Push).', # Fuzzy
	'right-pushadmin' => "Autorisassion a modifiché le motere e j'ampostassion dël possé.", # Fuzzy
	'action-push' => 'possé le pàgine',
	'action-bulkpush' => 'possé le pàgine a baron',
	'action-pushadmin' => 'configuré la publicassion',
	'group-pusher' => 'Possonador',
	'group-pusher-member' => '{{GENDER:$1|possonador}}',
	'grouppage-pusher' => '{{ns:project}}:Possonador',
	'group-bulkpusher' => 'Possonador a baron',
	'group-bulkpusher-member' => '{{GENDER:$1|possonador a baron}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Possonador a baron',
	'group-filepusher' => "Possonador d'archivi",
	'group-filepusher-member' => "{{GENDER:$1|possonador d'archivi}}",
	'grouppage-filepusher' => "{{ns:project}}:Possonador d'archivi",
	'push-err-captacha' => 'As peul pa possesse vers $1 a motiv dij caràter tërboj.',
	'push-err-captcha-page' => 'As peul pa possesse la pàgina $1 vers tute le destinassion a motiv dij CARÀTER TËRBOJ.',
	'push-err-authentication' => 'Autenticassion a $1 falìa. $2',
	'push-tab-text' => 'Gionta',
	'push-button-text' => 'Gionta',
	'push-tab-desc' => "Costa scheda a-j përmët ëd possé la revision corenta ëd costa pàgina vers un-a o pi d'àutre wiki.",
	'push-button-pushing' => 'Gionté',
	'push-button-pushing-files' => "Possé dj'archivi",
	'push-button-completed' => 'Posson completà',
	'push-button-failed' => 'Posson falì',
	'push-tab-title' => 'Gionta $1',
	'push-targets' => 'Motera për ël posson',
	'push-add-target' => 'Gionta ëd na motera',
	'push-import-revision-message' => 'Giontà da $1.',
	'push-tab-no-targets' => "A-i è gnun-e destinassion da possé. Për piasì, ch'a na gionta quaidun-e a sò archivi LocalSettings.php.",
	'push-tab-push-to' => 'Gionta a $1',
	'push-remote-pages' => 'Pàgine a distansa',
	'push-remote-page-link' => '$1 dzor $2',
	'push-remote-page-link-full' => 'Varda $1 dzor $2',
	'push-targets-total' => 'A-i é un total ëd $1 {{PLURAL:$1|destinassion}}.',
	'push-button-all' => 'Gionta tut',
	'push-tab-last-edit' => 'Ùltima modìfica ëd $1 dzor $2 a $3.',
	'push-tab-not-created' => "Sta pàgina-sì a esist pa anco'.",
	'push-tab-push-options' => 'Opsion ëd posson:',
	'push-tab-inc-templates' => 'Ciapa andrinta jë stamp',
	'push-tab-used-templates' => '(Stamp {{PLURAL:$2|dovrà}}: $1)',
	'push-tab-no-used-templates' => '(Gnun-i stamp a son dovrà dzora a sta pàgina.)',
	'push-tab-inc-files' => "Comprende dj'archivi ancorporà",
	'push-tab-err-fileinfo' => "A l'é nen podù otense che archivi a son dovrà dzora a costa pàgina. Gnun a l'é stàit possà.",
	'push-tab-err-filepush-unknown' => "Ël posson dl'archivi a l'é falì për na rason nen conossùa.",
	'push-tab-err-filepush' => "Ël posson dl'archivi a l'é falì: $1",
	'push-tab-embedded-files' => 'Archivi ancorporà:',
	'push-tab-no-embedded-files' => '(Gnun archivi a son ancorporà an costa pàgina.)',
	'push-tab-files-override' => 'Sti archivi a esisto già: $1', # Fuzzy
	'push-tab-template-override' => 'Sti stamp a esisto già: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Ij cariagi a son pa abilità. Sigurte che $wgEnableUploads e $wgAllowCopyUploads a sio ampostà an LocalSettings.php dla wiki destinassion.',
	'special-push' => 'Pàgine da possé',
	'push-special-description' => "Costa pàgina a lo abìlita a possé ël contnù d'un-a o pi pàgine vers un-a o pi wiki ëd MediaWiki.

Për possé le pàgine, ch'a buta ij tìtoj ant la zòna ëd test sì-sota, un tìtol për linia e ch'a sgnaca ansima a «Possé tut». Për livré sòn a peul andeje dël temp.",
	'push-special-pushing-desc' => 'Posson ëd $2 {{PLURAL:$2|pàgina|pàgine}} vers $1...',
	'push-special-button-text' => 'Pàgine da possé',
	'push-special-target-is' => 'Wiki ëd destinassion: $1',
	'push-special-select-targets' => 'Wiki ëd destinassion:',
	'push-special-item-pushing' => '$1: Gionté',
	'push-special-item-completed' => '$1: Posson completà',
	'push-special-item-failed' => "$1: ël posson a l'é falì: $2",
	'push-special-push-done' => 'Posson completà',
	'push-special-err-token-failed' => 'As peul pa otense un geton ëd modìfica dzor la wiki ëd destinassion.',
	'push-special-err-pageget-failed' => 'As peul pa otense ël contnù dla pàgina local.',
	'push-special-err-push-failed' => 'La wiki destinassion a arfuda la pàgina possà.',
	'push-special-inc-files' => "Comprende dj'archivi ancorporà",
	'push-special-err-imginfo-failed' => "As peul pa determinesse se n'archivi a dev esse possà.",
	'push-special-obtaining-fileinfo' => "$1: Oteniment d'anformassion an sl'archivi...",
	'push-special-pushing-file' => "$1: possé l'archivi $2...",
	'push-special-return' => "Possé pi 'd pàgine",
	'push-api-err-nocurl' => 'cURL a l\'é pa istalà.
Amposté $egPushDirectFileUploads a fàuss për le wiki pùbliche, o anstalé cURL për le wiki privà',
	'push-api-err-nofilesupport' => 'La MediaWiki local a manten nen la spedission d\'archivi.
Dzora le wiki pùbliche, amposté $egPushDirectFileUploads a fàuss.
Dzora le wiki privà, apliché ël pachèt linkd da la documentassion ëd Possé o agiorné MediaWiki midema.',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 */
$messages['pt'] = array(
	'push-desc' => 'Uma extensão ligeira para replicação externa de conteúdos para outras wikis',
	'right-push' => 'Autorização para usar a funcionalidade de replicação para o exterior.', # Fuzzy
	'right-bulkpush' => 'Autorização para usar a funcionalidade de replicação para o exterior em bloco (isto é, a página Special:Push).', # Fuzzy
	'right-pushadmin' => 'Autorização para modificar os destinos e a configuração da replicação para o exterior.', # Fuzzy
	'group-pusher' => 'Replicadores para o exterior',
	'group-pusher-member' => 'Replicador para o exterior', # Fuzzy
	'grouppage-pusher' => '{{ns:project}}:Replicadores_para_o_exterior',
	'group-bulkpusher' => 'Replicadores em bloco para o exterior',
	'group-bulkpusher-member' => 'Replicador em bloco para o exterior', # Fuzzy
	'grouppage-bulkpusher' => '{{ns:project}}:Replicadores_em_bloco_para_o_exterior',
	'group-filepusher' => 'Replicadores de ficheiros para o exterior',
	'group-filepusher-member' => 'Replicador de ficheiros para o exterior', # Fuzzy
	'grouppage-filepusher' => '{{ns:project}}:Replicadores_de_ficheiros_para_o_exterior',
	'push-err-captacha' => 'Não foi possível fazer a replicação para $1 devido ao captcha.',
	'push-err-captcha-page' => 'Não foi possível replicar a página $1 para todos os destinos devido ao captcha.',
	'push-err-authentication' => 'A autenticação na $1 falhou. $2',
	'push-tab-text' => 'Replicação',
	'push-button-text' => 'Replicar',
	'push-tab-desc' => 'Este separador permite-lhe fazer a replicação para o exterior da última versão desta página para uma ou mais wikis.',
	'push-button-pushing' => 'A replicar',
	'push-button-pushing-files' => 'A replicar ficheiros',
	'push-button-completed' => 'Replicação terminada',
	'push-button-failed' => 'A replicação falhou',
	'push-tab-title' => 'Replicar $1',
	'push-targets' => 'Destinos da replicação',
	'push-add-target' => 'Adicionar destino',
	'push-import-revision-message' => 'Replicada de $1.',
	'push-tab-no-targets' => 'Não existem destinos para a replicação. Acrescente-os ao ficheiro LocalSettings.php.',
	'push-tab-push-to' => 'Replicar para $1',
	'push-remote-pages' => 'Páginas remotas',
	'push-remote-page-link' => '$1 na $2',
	'push-remote-page-link-full' => 'Ver $1 na $2',
	'push-targets-total' => 'Há {{PLURAL:$1|$1 destino|um total de $1 destinos}}.',
	'push-button-all' => 'Replicar para todos',
	'push-tab-last-edit' => 'Última edição de $1 a $2 às $3.',
	'push-tab-not-created' => 'Esta página ainda não existe.',
	'push-tab-push-options' => 'Opções da replicação para o exterior:',
	'push-tab-inc-templates' => 'Incluir predefinições',
	'push-tab-used-templates' => '({{PLURAL:$2|Predefinição usada|Predefinições usadas}}: $1)',
	'push-tab-no-used-templates' => '(Esta página não contém predefinições)',
	'push-tab-inc-files' => 'Incluir ficheiros incorporados',
	'push-tab-err-fileinfo' => 'Não foi possível determinar que ficheiros são usados nesta página. Não foi replicado nenhum ficheiro.',
	'push-tab-err-filepush-unknown' => 'A replicação externa do ficheiro falhou por uma razão desconhecida.',
	'push-tab-err-filepush' => 'A replicação externa do ficheiro falhou: $1',
	'push-tab-embedded-files' => 'Ficheiros incorporados:',
	'push-tab-no-embedded-files' => '(Não há nenhum ficheiro incorporado nesta página).',
	'push-tab-files-override' => 'Estes ficheiros já existem: $1', # Fuzzy
	'push-tab-template-override' => 'Estas predefinições já existem: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Os uploads não foram possibilitados. Certifique-se que $wgEnableUploads e $wgAllowCopyUploads estão definidas como "true" no ficheiro LocalSettings.php da wiki de destino.',
	'special-push' => 'Replicação externa de páginas',
	'push-special-description' => 'Esta página permite-lhe fazer a replicação externa de uma ou mais páginas, para uma ou mais wikis MediaWiki.

Para fazer a replicação externa de páginas, introduza os respectivos títulos na caixa de texto abaixo, um título por linha e clique "Replicar todas". A operação pode demorar algum tempo.',
	'push-special-pushing-desc' => 'A replicar $2 {{PLURAL:$2|página|páginas}} para a $1...',
	'push-special-button-text' => 'Replicar páginas',
	'push-special-target-is' => 'Wiki de destino: $1',
	'push-special-select-targets' => 'Wikis de destino:',
	'push-special-item-pushing' => '$1: A replicar',
	'push-special-item-completed' => '$1: Replicação terminada',
	'push-special-item-failed' => '$1: A replicação falhou: $2',
	'push-special-push-done' => 'Replicação terminada',
	'push-special-err-token-failed' => 'Não foi possível obter uma chave de edição na wiki de destino.',
	'push-special-err-pageget-failed' => 'Não foi possível obter o conteúdo da página local.',
	'push-special-err-push-failed' => 'A wiki de destino recusou a página.',
	'push-special-inc-files' => 'Incluir ficheiros incorporados',
	'push-special-err-imginfo-failed' => 'Não foi possível determinar se é necessário replicar algum ficheiro.',
	'push-special-obtaining-fileinfo' => '$1: A obter as informações do ficheiro...',
	'push-special-pushing-file' => '$1: A replicar o ficheiro $2...',
	'push-special-return' => 'Replicar mais páginas',
	'push-api-err-nocurl' => 'O cURL não está instalado.
Defina $egPushDirectFileUploads como "false" nas wikis públicas, ou instale o cURL para wikis privadas',
	'push-api-err-nofilesupport' => 'O MediaWiki local não tem suporte para a publicação de ficheiros.
Nas wikis públicas, defina $egPushDirectFileUploads como "false".
Nas wikis privadas, aplique o patch referido na documentação do Push, ou atualize o próprio MediaWiki.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Jaideraf
 * @author Luckas
 */
$messages['pt-br'] = array(
	'push-desc' => 'Uma extensão leve para a replicação de conteúdo para outros wikis',
	'right-push' => 'Autorização para usar a funcionalidade de replicação externa.', # Fuzzy
	'right-bulkpush' => 'Autorização para usar a funcionalidade de replicação externa em bloco (Special:Push).', # Fuzzy
	'right-pushadmin' => 'Autorização para modificar os destinos e a configuração da replicação externa.', # Fuzzy
	'action-push' => 'enviar páginas',
	'action-bulkpush' => 'enviar páginas em lote',
	'action-pushadmin' => 'configurar envio',
	'group-pusher' => 'Replicadores',
	'group-pusher-member' => '{{GENDER:$1|replicador|replicadora}}',
	'grouppage-pusher' => '{{ns:project}}:Replicadores',
	'group-bulkpusher' => 'Replicadores em lote',
	'group-bulkpusher-member' => '{{GENDER:$1|replicador em lote|replicadora em lote}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Replicadores em lote',
	'group-filepusher' => 'Replicadores de arquivos',
	'group-filepusher-member' => '{{GENDER:$1|replicador de arquivo|replicadora de arquivo}}',
	'grouppage-filepusher' => '{{ns:project}}:Replicadores de arquivos',
	'push-err-captacha' => 'Não foi possível replicar para $1 devido ao captcha.',
	'push-err-captcha-page' => 'Não foi possível replicar a página $1 para todos os destinos devido ao captcha.',
	'push-err-authentication' => 'A autenticação em $1 falhou. $2',
	'push-tab-text' => 'Replicar',
	'push-button-text' => 'Replicar',
	'push-tab-desc' => 'Esta opção permite-lhe fazer a replicação externa da última versão desta página para um ou mais wikis.',
	'push-button-pushing' => 'Replicando',
	'push-button-pushing-files' => 'Replicando arquivos',
	'push-button-completed' => 'Concluído',
	'push-button-failed' => 'A replicação falhou',
	'push-tab-title' => 'Replicar $1',
	'push-targets' => 'Destinos da replicação',
	'push-add-target' => 'Adicionar destino',
	'push-import-revision-message' => 'Replicado de $1.',
	'push-tab-no-targets' => 'Não existem destinos para a replicação. Por favor, acrescente-os ao arquivo LocalSettings.php.',
	'push-tab-push-to' => 'Replicar em $1',
	'push-remote-pages' => 'Páginas remotas',
	'push-remote-page-link' => '$1 em $2',
	'push-remote-page-link-full' => 'Ver $1 em $2',
	'push-targets-total' => 'Há {{PLURAL:$1|$1 destino|um total de $1 destinos}}.',
	'push-button-all' => 'Replicar em todos',
	'push-tab-last-edit' => 'Última edição de $1 em $2 às $3.',
	'push-tab-not-created' => 'Esta página ainda não existe.',
	'push-tab-push-options' => 'Opções da replicação externa:',
	'push-tab-inc-templates' => 'Incluir predefinições',
	'push-tab-used-templates' => '({{PLURAL:$2|Predefinição utilizada|Predefinições utilizadas}}: $1)',
	'push-tab-no-used-templates' => '(Não há predefinições sendo utilizadas nesta página)',
	'push-tab-inc-files' => 'Incluir arquivos incorporados',
	'push-tab-err-fileinfo' => 'Não foi possível determinar quais arquivos são utilizados nesta página. Não foi replicado nenhum arquivo.',
	'push-tab-err-filepush-unknown' => 'A replicação externa do arquivo falhou por uma razão desconhecida.',
	'push-tab-err-filepush' => 'A replicação externa do arquivo falhou: $1',
	'push-tab-embedded-files' => 'Arquivos incorporados:',
	'push-tab-no-embedded-files' => '(Não há arquivos incorporados nesta página).',
	'push-tab-files-override' => 'Esses arquivos já existem: $1', # Fuzzy
	'push-tab-template-override' => 'Essas predefinições já existem: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Os uploads não foram habilitados. Certifique-se que $wgEnableUploads e $wgAllowCopyUploads estão definidas como "true" no arquivo LocalSettings.php do wiki de destino.',
	'special-push' => 'Replicação externa',
	'push-special-description' => 'Esta página permite-lhe fazer a replicação externa de uma ou mais páginas, para um ou mais wikis.

Para fazer a replicação externa de páginas, introduza seus respectivos títulos na caixa de texto abaixo, um título por linha e clique em "Replicar todas". A operação pode demorar algum tempo.',
	'push-special-pushing-desc' => 'Replicando $2 {{PLURAL:$2|página|páginas}} para $1...',
	'push-special-button-text' => 'Replicar páginas',
	'push-special-target-is' => 'Wiki de destino: $1',
	'push-special-select-targets' => 'Wikis de destino:',
	'push-special-item-pushing' => '$1: Replicando',
	'push-special-item-completed' => '$1: Replicação concluída',
	'push-special-item-failed' => '$1: A replicação falhou: $2',
	'push-special-push-done' => 'Replicação concluída',
	'push-special-err-token-failed' => 'Não foi possível obter uma chave de edição no wiki de destino.',
	'push-special-err-pageget-failed' => 'Não foi possível obter o conteúdo da página local.',
	'push-special-err-push-failed' => 'O wiki de destino recusou a página.',
	'push-special-inc-files' => 'Incluir arquivos incorporados',
	'push-special-err-imginfo-failed' => 'Não foi possível determinar se é necessário replicar algum arquivo.',
	'push-special-obtaining-fileinfo' => '$1: Obtendo informações do arquivo...',
	'push-special-pushing-file' => '$1: Replicando o arquivo $2...',
	'push-special-return' => 'Replicar mais páginas',
	'push-api-err-nocurl' => 'O cURL não está instalado.
Defina $egPushDirectFileUploads como "false" nos wikis públicos, ou instale o cURL para wikis privados',
	'push-api-err-nofilesupport' => 'O MediaWiki local não tem suporte para a publicação de arquivos.
Nos wikis públicos, defina $egPushDirectFileUploads como "false".
Nos wikis privados, aplique o patch referido na documentação do Push ou atualize o próprio MediaWiki.',
);

/** Romanian (română)
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'push-add-target' => 'Adaugă o țintă',
	'push-remote-pages' => 'Pagini la distanță',
	'push-tab-embedded-files' => 'Fișiere încorporate:',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'push-tab-text' => 'Spinge',
	'push-button-text' => 'Spinge',
	'push-tab-title' => 'Spinge $1',
	'push-add-target' => "Aggiunge 'na destinazione",
	'push-tab-push-to' => 'Spinge sus a $1',
	'push-remote-pages' => 'Pàggene remote',
	'push-remote-page-link' => '$1 sus a $2',
	'push-remote-page-link-full' => 'Vide $1 sus a $2',
	'push-targets-total' => "Stonne 'nu totale de $1 {{PLURAL:$1|destinazione|destinaziune}}.",
	'push-button-all' => 'Cazze tutte',
	'push-tab-last-edit' => "Urteme cangiamende de $1 'u $2 a le $3.",
	'push-tab-not-created' => "Sta pàgene non g'esiste angore.",
	'push-special-target-is' => 'Uicchi de destinazione: $1',
	'push-special-select-targets' => 'Uicchi de destinazione:',
);

/** Russian (русский)
 * @author DCamer
 * @author Lockal
 * @author MaxSem
 * @author Okras
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'push-desc' => 'Небольшое расширение для помещения содержимого в другие вики',
	'right-push' => 'Использовать функцию размещения в других вики-проектах',
	'right-bulkpush' => 'Использовать массовый перенос (например, Служебная:Push)',
	'right-pushadmin' => 'Изменять цели и настройки переноса',
	'action-push' => 'перенос страниц',
	'action-bulkpush' => 'массовый перенос страниц',
	'action-pushadmin' => 'настройку переноса',
	'group-pusher' => 'Переносящие',
	'group-pusher-member' => '{{GENDER:$1|переносящий|переносящая}}',
	'grouppage-pusher' => '{{ns:project}}:Переносящие',
	'group-bulkpusher' => 'Массово переносящие',
	'group-bulkpusher-member' => '{{GENDER:$1|массовый переносчик}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Массово переносящие',
	'group-filepusher' => 'Переносящие файлы',
	'group-filepusher-member' => '{{GENDER:$1|переносящий файлы|переносящая файлы}}',
	'grouppage-filepusher' => '{{ns:project}}:Переносящие файлы',
	'push-err-captacha' => 'Не удалось разместить на $1 из-за капчи.',
	'push-err-captcha-page' => 'Невозможно разместить страницу $1 по всем целям из-за CAPTCHA.',
	'push-err-authentication' => 'Сбой аутентификации в $1. $2',
	'push-tab-text' => 'Разместить',
	'push-button-text' => 'Разместить',
	'push-tab-desc' => 'Эта вкладка позволяет разместить текущею версию этой страницы на одну или нескольких других вики.',
	'push-button-pushing' => 'Размещение',
	'push-button-pushing-files' => 'Размещаемые файлы',
	'push-button-completed' => 'Размещение завершено',
	'push-button-failed' => 'Размещение не удалось',
	'push-tab-title' => 'Размещение $1',
	'push-targets' => 'Направление размещения',
	'push-add-target' => 'Добавить направление',
	'push-import-revision-message' => 'Перенесено из $1.',
	'push-tab-no-targets' => 'Отсутствует направления размещения. Пожалуйста, добавьте их в файл LocalSettings.php.',
	'push-tab-push-to' => 'Размещение на $1',
	'push-remote-pages' => 'Удалённые страницы',
	'push-remote-page-link' => '$1 на $2',
	'push-remote-page-link-full' => 'Просмотреть $1 на $2',
	'push-targets-total' => 'Всего $1 {{PLURAL:$1|направление|направления}}.',
	'push-button-all' => 'Разместить все',
	'push-tab-last-edit' => 'Последняя правка $1 $2 в $3.',
	'push-tab-not-created' => 'Этой страницы ещё не существует.',
	'push-tab-push-options' => 'Настройки размещения:',
	'push-tab-inc-templates' => 'Включать шаблоны',
	'push-tab-used-templates' => '({{PLURAL:$2|Шаблон|Шаблоны}}: $1)',
	'push-tab-no-used-templates' => '(На этой странице нет шаблонов)',
	'push-tab-inc-files' => 'Включая встроенные файлы',
	'push-tab-err-fileinfo' => 'Не удалось установить какие файлы используются на этой странице. Ни один не был размещён.',
	'push-tab-err-filepush-unknown' => 'сбой размещения файлов по неизвестной причине.',
	'push-tab-err-filepush' => 'Сбой размещения файла. $1',
	'push-tab-embedded-files' => 'Встроенные файлы:',
	'push-tab-no-embedded-files' => '(На этой странице нет встроенных файлов.)',
	'push-tab-files-override' => '{{PLURAL:$2|Этот файл уже существует|Следующие файлы уже существуют}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Этот шаблон уже существует|Следующие шаблоны уже существуют}}: $1',
	'push-tab-err-uploaddisabled' => 'Загрузки не включены. Убедитесь, что параметры $wgEnableUploads и $wgAllowCopyUploads в файле настроек LocalSettings.php установлены в true.',
	'special-push' => 'Разместить страницы',
	'push-special-description' => 'Эта страница позволяет разместить содержимое одной или нескольких страниц на одну или несколько других вики-сайтов на движке MediaWiki.

Для того, чтобы разместить страницы, введите названия в текстовом поле ниже, один заголовок на строку, и нажмите «Разместить все». Это может занять некоторое время.',
	'push-special-pushing-desc' => 'Размещение $2 {{PLURAL:$2|страницы|страниц}} на $1...',
	'push-special-button-text' => 'Разместить страницы',
	'push-special-target-is' => 'Целевой вики-сайт: $1',
	'push-special-select-targets' => 'Целевые вики-сайты:',
	'push-special-item-pushing' => '$1: Размещение',
	'push-special-item-completed' => '$1: Размещение завершено',
	'push-special-item-failed' => '$1: Размещение не удалось: $2',
	'push-special-push-done' => 'Размещение завершено',
	'push-special-err-token-failed' => 'Не удалось получить маркер редактирование на целевом вики-сайте.',
	'push-special-err-pageget-failed' => 'Не удалось получить локальное содержимое страницы.',
	'push-special-err-push-failed' => 'Целевой вики-сайт отказался разместить страницу.',
	'push-special-inc-files' => 'Включая встроенные файлы',
	'push-special-err-imginfo-failed' => 'Не удалось определить, есть ли файлы для размещения.',
	'push-special-obtaining-fileinfo' => '$1: Получение сведений о файлах…',
	'push-special-pushing-file' => '$1: Размещение файла $2…',
	'push-special-return' => 'Разместить другие страницы',
	'push-api-err-nocurl' => 'cURL не установлен.
На общедоступной вики установите параметр $egPushDirectFileUploads в значение false, или установите cURL на частной вики.',
	'push-api-err-nofilesupport' => 'Локальная MediaWiki не поддерживает отправку файлов. 
На общедоступной вики установите параметр $egPushDirectFileUploads в значение false.
На частной вики примените патч linkd из документации Push или обновите саму MediaWiki.',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'action-push' => 'තෙරපුම් පිටු',
	'action-bulkpush' => 'පිටු තොග පිටින් තෙරපන්න',
	'action-pushadmin' => 'තෙරපුම හැඩගස්වන්න',
	'group-pusher' => 'තෙරපන්නෝ',
	'group-pusher-member' => '{{GENDER:$1|තෙරපන්නා}}',
	'grouppage-pusher' => '{{ns:project}}:තෙරපන්නෝ',
	'group-bulkpusher' => 'තොග පිටින් තෙරපන්නෝ',
	'group-bulkpusher-member' => '{{GENDER:$1|තොග පිටින් තෙරපන්නා}}',
	'grouppage-bulkpusher' => '{{ns:project}}:තොග පිටින් තෙරපන්නෝ',
	'group-filepusher' => 'ගොනු තෙරපන්නෝ',
	'group-filepusher-member' => '{{GENDER:$1|ගොනු තෙරපන්නා}}',
	'grouppage-filepusher' => '{{ns:project}}:ගොනු තෙරපන්නෝ',
	'push-err-authentication' => '$1 හිදී සහතික කිරීම අසාර්ථකයි. $2',
	'push-tab-text' => 'තෙරපන්න',
	'push-button-text' => 'තෙරපන්න',
	'push-button-pushing' => 'තෙරපමින්',
	'push-button-pushing-files' => 'ගොනු තෙරපමින්',
	'push-button-completed' => 'තෙරපීම සම්පූර්ණයි',
	'push-button-failed' => 'තෙරපීම අසාර්ථකයි',
	'push-tab-title' => '$1 තෙරපන්න',
	'push-targets' => 'තෙරපුම් ඉලක්කයන්',
	'push-add-target' => 'ඉලක්කයක් එක් කරන්න',
	'push-import-revision-message' => '$1 වෙතින් තෙරපන ලදී.',
	'push-tab-push-to' => '$1 වෙත තෙරපන්න',
	'push-remote-pages' => 'දුරස්ථ පිටු',
	'push-remote-page-link' => '$1 මත $2',
	'push-remote-page-link-full' => '$1 $2 මත නරඹන්න',
	'push-button-all' => 'සියල්ලම තෙරපන්න',
	'push-tab-last-edit' => 'අවසන් සංස්කරණය $2 $3 හිදී $1 විසිනි.',
	'push-tab-not-created' => 'මෙම පිටුව තවමත් නොපවතියි.',
	'push-tab-push-options' => 'තෙරපුම් විකල්පයන්:',
	'push-tab-inc-templates' => 'සැකිලි ඇතුළත් කරන්න',
	'push-tab-inc-files' => 'කා වැද්දූ ගොනු අඩංගු කරන්න',
	'push-tab-err-filepush' => 'ගොනු තෙරපීම අසාර්ථකයි: $1',
	'push-tab-embedded-files' => 'කා වැද්දූ ගොනු:',
	'push-tab-files-override' => 'මෙම ගොනු දැනටමත් පවතියි: $1', # Fuzzy
	'push-tab-template-override' => 'මෙම සැකිලි දැනටමත් පවතියි: $1', # Fuzzy
	'special-push' => 'තෙරපුම් පිටු',
	'push-special-button-text' => 'තෙරපුම් පිටු',
	'push-special-target-is' => 'ඉලක්කගත විකිය: $1',
	'push-special-select-targets' => 'ඉලක්කගත විකියන්:',
	'push-special-item-pushing' => '$1: තෙරපමින්',
	'push-special-item-completed' => '$1: තෙරපීම සම්පූර්ණයි',
	'push-special-item-failed' => '$1: තෙරපීම අසාර්ථකයි: $2',
	'push-special-push-done' => 'තෙරපීම සම්පූර්ණයි',
	'push-special-inc-files' => 'කා වැද්දූ ගොනු අඩංගු කරන්න',
	'push-special-obtaining-fileinfo' => '$1: ගොනුවේ තොරතුරු ලබාගනිමින්...',
	'push-special-pushing-file' => '$1: $2 ගොනුව තෙරපමින්...',
	'push-special-return' => 'තවත් පිටු තෙරපන්න',
);

/** Swahili (Kiswahili)
 * @author Stephenwanjau
 */
$messages['sw'] = array(
	'push-add-target' => 'Ongeza lengo',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'action-push' => 'பக்கங்களைத் தள்ளு',
	'action-bulkpush' => 'பக்கங்களை மொத்தமாக தள்ளு',
	'action-pushadmin' => 'தள்ளலை கட்டமை',
	'group-pusher' => 'தள்ளுபவர்கள்',
	'group-pusher-member' => '{{GENDER:$1|தள்ளுபவர்}}',
	'grouppage-pusher' => '{{ns:project}}:தள்ளுபவர்கள்',
	'group-bulkpusher' => 'மொத்தமாக தள்ளுபவர்கள்',
	'group-bulkpusher-member' => '{{GENDER:$1|மொத்தமாக தள்ளுபவர்}}',
	'grouppage-bulkpusher' => '{{ns:project}}:மொத்தமாக தள்ளுபவர்கள்',
	'group-filepusher' => 'கோப்பு தள்ளுபவர்கள்',
	'group-filepusher-member' => '{{GENDER:$1|கோப்பு தள்ளுபவர்}}',
	'grouppage-filepusher' => '{{ns:project}}:கோப்பு தள்ளுபவர்கள்',
	'push-err-captacha' => 'captcha காரணமாக $1க்கு தள்ள இயலவில்லை.',
	'push-err-captcha-page' => 'CAPTCHA காரணமாக பக்கம் $1ஐ அனைத்து இலக்குகளுக்கும் தள்ள இயலவில்லை.',
	'push-err-authentication' => '$1ல் உறுதிப்படுத்துதல் தோல்வியடைந்தது. $2',
	'push-tab-text' => 'தள்ளு',
	'push-button-text' => 'தள்ளு',
	'push-tab-desc' => 'இந்த தத்தல் உங்களை இந்தப் பக்கத்தின் நடப்பு பதிப்பை ஒன்று அல்லது அதற்கு மேற்பட்ட மற்ற விக்கிகளுக்கு தள்ள அனுமதிக்கும்.',
	'push-button-pushing' => 'தள்ளுகிறது',
	'push-button-pushing-files' => 'கோப்புகளைத் தள்ளுகிறது',
	'push-button-completed' => 'தள்ளல் முடிவடைந்தது',
	'push-button-failed' => 'தள்ளல் தோல்வியடைந்தது',
	'push-tab-title' => '$1 ஐ தள்ளு',
	'push-targets' => 'தள்ளல் இலக்குகள்',
	'push-add-target' => 'இலக்கைச் சேர்',
	'push-import-revision-message' => '$1லிருந்து தள்ளப்பட்டது.',
	'push-tab-no-targets' => 'தள்ளுவதற்கு இலக்கு ஏதுமில்லை. தயவுசெய்து உங்கள் LocalSettings.php கோப்பில் சிலவற்றை சேர்க்கவும்.',
	'push-tab-push-to' => '$1க்கு தள்ளு',
	'push-remote-page-link' => '$2ல் $1',
	'push-remote-page-link-full' => '$2ல் $1ஐ காண்க',
	'push-targets-total' => 'மொத்தமாக $1 {{PLURAL:$1|இலக்கு உள்ளது|இலக்குகள் உள்ளன}}.',
	'push-button-all' => 'அனைத்தையும் தள்ளு',
	'push-tab-not-created' => 'இந்தப் பக்கம் இல்லை.',
	'push-tab-push-options' => 'தள்ளல் விருப்பத்தேர்வுகள்:',
	'push-tab-inc-templates' => 'வார்ப்புருக்களையும் உள்ளடக்கு',
	'push-tab-used-templates' => '({{PLURAL:$2|வார்ப்புரு|வார்ப்புருக்கள்}}: $1 பயன்படுத்தப்பட்டது)',
	'push-tab-no-used-templates' => '(இந்தப் பக்கத்தில் வார்ப்புருக்கள் எதுவும் பயன்படுத்தப்படவில்லை.)',
	'push-tab-err-filepush-unknown' => 'கோப்பு தள்ளல் அறியாத காரணத்திற்காக தோல்வியடைந்தது.',
	'push-tab-err-filepush' => 'கோப்பு தள்ளல் தோல்வியடைந்தது: $1',
	'push-tab-files-override' => 'இந்த கோப்புகள் ஏற்கனவே உள்ளன: $1', # Fuzzy
	'push-tab-template-override' => 'இந்த் வார்ப்புருக்கள் ஏற்கனவே உள்ளன: $1', # Fuzzy
	'special-push' => 'பக்கங்களைத் தள்ளு',
	'push-special-pushing-desc' => '$2 {{PLURAL:$2|பக்கத்தை|பக்கங்களை}} $1க்கு தள்ளுகிறது...',
	'push-special-button-text' => 'பக்கங்களைத் தள்ளு',
	'push-special-target-is' => 'இலக்கு விக்கி: $1',
	'push-special-select-targets' => 'இலக்கு விக்கிகள்:',
	'push-special-item-pushing' => '$1:தள்ளுகிறது',
	'push-special-item-completed' => '$1: தள்ளல் முடிவடைந்தது',
	'push-special-item-failed' => '$1: தள்ளல் தோல்வியடைந்தது : $2',
	'push-special-push-done' => 'தள்ளல் முடிவடைந்தது',
	'push-special-err-token-failed' => 'இலக்கு விக்கியில் தொகுத்தல் வில்லையைப் பெற இயலவில்லை.',
	'push-special-err-pageget-failed' => 'உள் விக்கி பக்க உள்ளடக்கத்தை பெற இயலவில்லை.',
	'push-special-err-push-failed' => 'இலக்கு விக்கி தள்ளப்பட்ட பக்கத்தை மறுத்துள்ளது.',
	'push-special-obtaining-fileinfo' => '$1: கோப்பு விவரங்கள் பெறப்படுகிறது...',
	'push-special-pushing-file' => '$1: கோப்பு $2 தள்ளப்படுகிறது...',
	'push-special-return' => 'மேலும் பக்கங்களைத் தள்ளு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'push-special-target-is' => 'లక్ష్యిత వికీ: $1',
	'push-special-select-targets' => 'లక్ష్యిత వికీలు:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'push-desc' => 'Dugtong na magaang ang timbang upang maitulak ang nilalaman sa ibang mga wiki',
	'right-push' => 'Kapahintulutan upang magamit ang tungkulin ng pagtulak.', # Fuzzy
	'right-bulkpush' => 'Kapahintulutan upang gamitin ang tungkulin ng pabunton na pagtutulak (iyon ay Natatangi:Itulak).', # Fuzzy
	'right-pushadmin' => 'Kapahintulutan upang baguhin ang mga pinupukol ng pagtulak at mga katakdaan sa pagtulak.', # Fuzzy
	'action-push' => 'itulak ang mga pahina',
	'action-bulkpush' => 'maramihang pagtutulak ng mga pahina',
	'action-pushadmin' => 'isaayos ang pagtulak',
	'group-pusher' => 'Mga manunulak',
	'group-pusher-member' => '{{GENDER:$1|tagatulak}}',
	'grouppage-pusher' => '{{ns:project}}:Mga tagapagtulak',
	'group-bulkpusher' => 'Mga tagapagtulak na maramihan',
	'group-bulkpusher-member' => '{{GENDER:$1|tagatulak na buntunan}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Tagapagtulak na buntunan',
	'group-filepusher' => 'Mga tagatulak ng talaksan',
	'group-filepusher-member' => '{{GENDER:$1|tagapagtulak ng talaksan}}',
	'grouppage-filepusher' => '{{ns:project}}:Tagapagtulak ng talaksan',
	'group-pusher.css' => '/* Ang inilagay na Mga Pilas ng Estilong Lumalagaslas (Cascading Style Sheets o CSS) dito ay makakaapekto lamang sa mga tagapagtulak */',
	'group-pusher.js' => '/* Ang JavaScript o JS na inilagay dito ay makakaapekto lamang sa mga tagapagtulak */',
	'group-bulkpusher.css' => '/* Ang inilagay na Mga Pilas ng Estilong Lumalagaslas (Cascading Style Sheets o CSS) dito ay makakaapekto lamang sa mga tagapagtulak ng bunton */',
	'group-bulkpusher.js' => '/* Ang JavaScript o JS na inilagay dito ay makakaapekto lamang sa mga tagapagtulak ng bunton */',
	'group-filepusher.css' => '/* Ang inilagay na Mga Pilas ng Estilong Lumalagaslas (Cascading Style Sheets o CSS) dito ay makakaapekto lamang sa mga tagapagtulak ng talaksan */',
	'group-filepusher.js' => '/* Ang JavaScript o JS na inilagay dito ay makakaapekto lamang sa mga tagapagtulak ng talaksan */',
	'push-err-captacha' => 'Hindi maitulak sa $1 dahil sa captcha.',
	'push-err-captcha-page' => 'Hindi maitulak ang pahinang $1 papunta sa lahat ng mga pinupukol dahil sa CAPTCHA.',
	'push-err-authentication' => 'Nabigo ang pagpapatotoo doon sa $1. $2',
	'push-tab-text' => 'Itulak',
	'push-button-text' => 'Itulak',
	'push-tab-desc' => 'Ang laylay na ito ay nagpapahintulot sa iyong maitulak ang pangkasalukuyang rebisyon ng pahinang ito papunta sa isa o marami pang mga wiki.',
	'push-button-pushing' => 'Itinutulak',
	'push-button-pushing-files' => 'Itinutulak ang mga talaksan',
	'push-button-completed' => 'Nabuo na ang pagtulak',
	'push-button-failed' => 'Nabigo ang pagtulak',
	'push-tab-title' => 'Itulak ang $1',
	'push-targets' => 'Itulak ang mga pinupukol',
	'push-add-target' => 'Idagdag ang pinupukol',
	'push-import-revision-message' => 'Itinulak mula sa $1.',
	'push-tab-no-targets' => 'Walang mga pinupukol na mapagtutulakan. Mangyaring magdagdag ng ilan sa iyong talaksan ng LocalSettings.php.',
	'push-tab-push-to' => 'Itulak sa $1',
	'push-remote-pages' => 'Malalayong mga pahina',
	'push-remote-page-link' => '$1 na nasa $2',
	'push-remote-page-link-full' => 'Tingnan ang $1 na nasa $2',
	'push-targets-total' => 'May isang kabuuan ng $1 {{PLURAL:$1|pinupukol|mga pinupukol}}.',
	'push-button-all' => 'Itulak lahat',
	'push-tab-last-edit' => 'Huling pamamatnugot ni $1 sa $2 sa ganap na $3.',
	'push-tab-not-created' => 'Hindi pa umiiral ang pahinang ito.',
	'push-tab-push-options' => 'Mga mapagpipilian sa pagtutulak:',
	'push-tab-inc-templates' => 'Isama ang mga suleras',
	'push-tab-used-templates' => '(Ginagamit na {{PLURAL:$2|suleras|mga suleras}}: $1)',
	'push-tab-no-used-templates' => '(Walang ginagamit na mga suleras sa pahinang ito.)',
	'push-tab-inc-files' => 'Isama ang ibinaong mga talaksan',
	'push-tab-err-fileinfo' => 'Hindi makamtan kung anong mga talaksan ang ginagamit sa pahinang ito. Wala pang mga naitutulak.',
	'push-tab-err-filepush-unknown' => 'Nabigo ang pagtulak dahil sa hindi nalalamang dahilan.',
	'push-tab-err-filepush' => 'Nabigo ang pagtulak sa talaksan: $1',
	'push-tab-embedded-files' => 'Ibinaong mga talaksan:',
	'push-tab-no-embedded-files' => '(Walang nakabaong mga talaksan sa loob ng pahinang ito.)',
	'push-tab-files-override' => 'Umiiral na ang mga talaksang ito: $1', # Fuzzy
	'push-tab-template-override' => 'Umiiral na ang mga suleras na ito: $1', # Fuzzy
	'push-tab-err-uploaddisabled' => 'Hindi pinagagana ang mga pagkakargang papaitaas. Tiyaking nakatakda ang $wgEnableUploads at $wgAllowCopyUploads sa totoo sa loob ng LocalSettings.php ng pinupukol na wiki.',
	'special-push' => 'Itulak ang mga pahina',
	'push-special-description' => 'Nagbibigay-daan ang pahinang ito upang maitulak ang nilalaman ng isa o marami pang mga pahina papunta sa isa o marami pang mga wiki ng MediaWiki.

Upang makapagtulak ng mga pahina, ipasok ang mga pamagat sa loob ng kahon ng tekstong nasa ibaba, isang pamagat bawat guhit at sapulin ang itulak lahat. Maaaring maging matagal ito bago mabuo.',
	'push-special-pushing-desc' => 'Itinutulak ang $2 {{PLURAL:$2|pahina|mga pahina}} papunta sa $1...',
	'push-special-button-text' => 'Itulak ang mga pahina',
	'push-special-target-is' => 'Pinupukol na wiki: $1',
	'push-special-select-targets' => 'Pinupukol na mga wiki:',
	'push-special-item-pushing' => '$1: Itinutulak',
	'push-special-item-completed' => '$1: Nabuo ang pagtulak',
	'push-special-item-failed' => '$1: Nabigo ang pagtulak: $2',
	'push-special-push-done' => 'Nabuo na ang pagtulak',
	'push-special-err-token-failed' => 'Hindi makakuha ng isang kahalip ng pamamatnugot sa ibabaw ng pinupukol na wiki.',
	'push-special-err-pageget-failed' => 'Hindi makuha ang katutubong nilalaman ng pahina.',
	'push-special-err-push-failed' => 'Tinanggihan ng pinupukol na wiki ang itinulak na pahina.',
	'push-special-inc-files' => 'Isama ang ibinaong mga talaksan',
	'push-special-err-imginfo-failed' => 'Hindi matukoy kung may anumang mga talaksan na kailangang itulak.',
	'push-special-obtaining-fileinfo' => '$1: Kinukuha ang kabatiran ng talaksan...',
	'push-special-pushing-file' => '$1: Itinutulak ang talaksang $2...',
	'push-special-return' => 'Magtulak ng marami pang mga pahina',
	'push-api-err-nocurl' => 'Hindi naitalaga ang cURL.
Itakda ang $egPushDirectFileUploads upang maging mali sa pangmadlang mga wiki, o italaga ang cURL para sa pribadong mga wiki',
	'push-api-err-nofilesupport' => 'Ang katutubong MediaWiki ay walang pagtangkilik para sa pagpapaskil ng mga talaksan.
Sa pangmadlang mga wiki, itakda ang $egPushDirectFileUploads sa mali.
Sa pribadong mga wiki, ilapat ang pantapal na nakakawing mula sa dokumentasyon ng Itulak o isapanahon mismo ang MediaWiki.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Base
 * @author Steve.rusyn
 * @author SteveR
 */
$messages['uk'] = array(
	'push-desc' => 'Невелике розширення для поширення вмісту до інших вікі',
	'right-push' => 'Використовувати функцію поширення',
	'right-bulkpush' => 'Використовувати функції масового поширення (тобто Special:Push).',
	'right-pushadmin' => 'Змінити цілі та налаштування поширення',
	'action-push' => 'сторінки поширення',
	'action-bulkpush' => 'сторінки масового поширення',
	'action-pushadmin' => 'налаштувати поширення',
	'group-pusher' => 'Поширювачі',
	'group-pusher-member' => '{{GENDER:$1|поширювач|поширювачка}}',
	'grouppage-pusher' => '{{ns:project}}:Поширювачі',
	'group-bulkpusher' => 'Масові поширювачі',
	'group-bulkpusher-member' => '{{GENDER:$1|масовий поширювач|масова поширювачка}}',
	'grouppage-bulkpusher' => '{{ns:project}}:Масові поширювачі',
	'group-filepusher' => 'Поширювачі файлів',
	'group-filepusher-member' => '{{GENDER:$1|файловий поширювач|файлова поширювачка}}',
	'grouppage-filepusher' => '{{ns:project}}:Файлові поширювачі',
	'push-err-captacha' => 'Не може поширити до $1  через капчу.',
	'push-err-captcha-page' => 'Не може поширити сторінку $1 до всіх цілей через капчу.',
	'push-err-authentication' => 'Авторизація на $1 не вдалася. $2',
	'push-tab-text' => 'Помістити',
	'push-button-text' => 'Помістити',
	'push-tab-desc' => 'Ця вкладка дозволяє розмістити поточну версію цієї сторінки на одну або декількох інших вікі.',
	'push-button-pushing' => 'Поширення',
	'push-button-pushing-files' => 'Поширювані файли',
	'push-button-completed' => 'Поширення завершено',
	'push-button-failed' => 'Поширення не вдалося',
	'push-tab-title' => 'Поширення $1',
	'push-targets' => 'Цілі поширення',
	'push-add-target' => 'Додати ціль',
	'push-import-revision-message' => 'Поширено від $1.',
	'push-tab-no-targets' => 'Немає цілей для поширення. Будь ласка, додайте до вашого файлу LocalSettings.php.',
	'push-tab-push-to' => 'Поширити на $1',
	'push-remote-pages' => 'Віддалені сторінки',
	'push-remote-page-link' => '$1 на $2',
	'push-remote-page-link-full' => 'Перегляд $1 на $2',
	'push-targets-total' => 'Всього $1 {{PLURAL:$1|ціль|цілі|цілей}}.',
	'push-button-all' => 'Поширити усе',
	'push-tab-last-edit' => 'Останнє редагування від $1 на $2 о $3.',
	'push-tab-not-created' => 'Ця сторінка ще не існує.',
	'push-tab-push-options' => 'Параметри поширення:',
	'push-tab-inc-templates' => 'Включати шаблони',
	'push-tab-used-templates' => '(Використано {{PLURAL:$2|шаблон|шаблони|шаблонів}}: $1)',
	'push-tab-no-used-templates' => '(Шаблони не використовуються на цій сторінці.)',
	'push-tab-inc-files' => 'Включати вбудовані файли',
	'push-tab-err-fileinfo' => 'Не вдалося отримати які файли використовуються на цій сторінці. Жодний не був розміщений.',
	'push-tab-err-filepush-unknown' => 'Збій поширення файлу з невідомої причини.',
	'push-tab-err-filepush' => 'Збій поширення файлу: $1',
	'push-tab-embedded-files' => 'Вбудовані файли:',
	'push-tab-no-embedded-files' => '(Немає файлів вбудованих у цю сторінку).',
	'push-tab-files-override' => '{{PLURAL:$2|Цей файл вже існує|Ці файли вже існують}}: $1',
	'push-tab-template-override' => '{{PLURAL:$2|Цей шаблон вже існує|Ці шаблони вже існують}}: $1',
	'push-tab-err-uploaddisabled' => 'Завантаження не увімкнені. Переконайтеся, що параметри $wgEnableUploads і $wgAllowCopyUploads у файлі налаштувань LocalSettings.php задані як true.',
	'special-push' => 'Поширити сторінки',
	'push-special-description' => 'Ця сторінка дозволяє поширити вміст однієї або декількох сторінок на одне або декілька інших вікі на рушії Медіавікі.

Для того, щоб поширити сторінки, введіть назви в текстовому полі нижче, один заголовок на рядок та натисніть кнопку «Поширити все». Це може зайняти деякий час.',
	'push-special-pushing-desc' => 'Поширення $2 {{PLURAL:$2|сторінки|сторінок}} на $1...',
	'push-special-button-text' => 'Поширити сторінки',
	'push-special-target-is' => 'Цільова вікі: $1',
	'push-special-select-targets' => 'Цільові вікі:',
	'push-special-item-pushing' => '$1: Поширення',
	'push-special-item-completed' => '$1: Поширення завершено',
	'push-special-item-failed' => '$1: Збій поширення: $2',
	'push-special-push-done' => 'Поширення завершено',
	'push-special-err-token-failed' => 'Не вдалося отримати маркер редагування на цільовій вікі.',
	'push-special-err-pageget-failed' => 'Неможливо отримати локальний вміст сторінок.',
	'push-special-err-push-failed' => 'Цільова вікі відмовилася розмістити сторінку.',
	'push-special-inc-files' => 'Включати вбудовані файли',
	'push-special-err-imginfo-failed' => 'Не вдалося визначити, чи є будь-які файли для поширення.',
	'push-special-obtaining-fileinfo' => '$1: Отримання відомостей про файл...',
	'push-special-pushing-file' => '$1: Поширення файлу $2...',
	'push-special-return' => 'Поширити більше сторінок',
	'push-api-err-nocurl' => 'cURL не встановлено.
Задайте значення $egPushDirectFileUploads як false для громадських вікі або установіть cURL для приватних вікі',
	'push-api-err-nofilesupport' => 'Локальна Медіавікі не підтримує відправку файлів.
На загальнодоступній вікі задайте параметру $egPushDirectFileUploads значення false.
На приватній вікі застосуйте патч, пов\'язаний з документацією про поширення або поновіть саму Медіавікі.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'push-tab-last-edit' => 'לעצטע רעדאקטירונג דורך $1 אום $2 $3.',
	'push-tab-not-created' => 'דער בלאט עקזיסטירט נאך נישט.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Kuailong
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'push-desc' => 'Lightweight扩展推送内容到其他wiki',
	'right-push' => '授权使用推送功能。', # Fuzzy
	'right-bulkpush' => '授权使用批量推送功能（在Special:Push）。', # Fuzzy
	'right-pushadmin' => '授权修改推送目标和推送设置。', # Fuzzy
	'action-push' => '推送页面',
	'action-bulkpush' => '批量推送页面',
	'action-pushadmin' => '配置推送',
	'group-pusher' => '推送者',
	'group-pusher-member' => '{{GENDER:$1|推送者}}',
	'grouppage-pusher' => '{{ns:project}}:推送者',
	'group-bulkpusher' => '批量推送者',
	'group-bulkpusher-member' => '{{GENDER:$1|批量推送者}}',
	'grouppage-bulkpusher' => '{{ns:project}}:批量推送者',
	'group-filepusher' => '文件推送者',
	'group-filepusher-member' => '{{GENDER:$1|文件推送者}}',
	'grouppage-filepusher' => '{{ns:project}}:文件推送者',
	'push-err-captacha' => '由于验证码，无法推送到 $1。',
	'push-err-captcha-page' => '由于验证码，无法推送页面 $1 到所有目标。',
	'push-err-authentication' => '在 $1 身份验证失败。$2',
	'push-tab-text' => '推送',
	'push-button-text' => '推送',
	'push-add-target' => '新增目标',
	'push-tab-not-created' => '此页面尚不存在。',
	'push-tab-inc-templates' => '包含模板',
	'push-tab-no-used-templates' => '（本页面未使用模板。）',
	'push-special-select-targets' => '目标wiki：',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'push-add-target' => '新增目標',
	'push-tab-inc-templates' => '包含模板',
);
