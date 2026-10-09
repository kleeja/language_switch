<?php
// Kleeja Plugin
// language_switch
// Version: 2.0
// Developer: Kleeja team

// Prevent illegal run
if (!defined('IN_PLUGINS_SYSTEM')) {
    exit();
}

// Plugin Basic Information
$kleeja_plugin['language_switch']['information'] = [
    // The casual name of this plugin, anything can a human being understands
    'plugin_title' => [
        'en' => 'Language Switcher',
        'ar' => 'مبدّل اللغة',
    ],
    // Who wrote this plugin?
    'plugin_developer' => 'Kleeja.net',
    // This plugin version
    'plugin_version' => '2.0',
    // Explain what is this plugin, why should I use it?
    'plugin_description' => [
        'en' =>
            'Adds a language menu to the top of every page, so visitors can browse your site in any language installed in Kleeja',
        'ar' => 'تضيف قائمة لغات إلى أعلى كل صفحة، ليتصفّح الزوار موقعك بأي لغة مثبّتة في كليجا',
    ],
    // Min version of Kleeja that's requiered to run this plugin
    'plugin_kleeja_version_min' => '4.0.0',
    // Max version of Kleeja that support this plugin, use 0 for unlimited
    'plugin_kleeja_version_max' => '4.9',
    // Should this plugin run before others?, 0 is normal, and higher number has high priority.
    // Its boot_common chooses the language, so it runs before the boot_common of the other plugins,
    // which may load their words there (kleeja_payment and video_player have 10)
    'plugin_priority' => 100,
];

//after installation message, you can remove it, it's not requiered
$kleeja_plugin['language_switch']['first_run']['ar'] = "
تضيف هذه الإضافة قائمة «اللغة» إلى أعلى كل صفحة من موقعك، تعرض كل لغة مثبّتة في كليجا، وتحفظ اختيار الزائر لمدة 30 يومًا.
<br>
<a href='../' target='_blank' rel='noopener'>افتح موقعك</a> -
<a href='./index.php?cp=s_help#help-language_switch'>دليل الإضافة</a> -
<a href='https://github.com/kleeja/language_switch/issues' target='_blank' rel='noopener'>الإبلاغ عن مشكلة</a>
";

$kleeja_plugin['language_switch']['first_run']['en'] = "
This plugin adds a Language menu to the top of every page of your site. It lists every language installed in Kleeja, and remembers the choice of each visitor for 30 days.
<br>
<a href='../' target='_blank' rel='noopener'>Open your site</a> -
<a href='./index.php?cp=s_help#help-language_switch'>Plugin guide</a> -
<a href='https://github.com/kleeja/language_switch/issues' target='_blank' rel='noopener'>Report a problem</a>
";

// Plugin Installation function.
// Nothing to add: the menu takes its title from the words of Kleeja, and shows each language under its own name
$kleeja_plugin['language_switch']['install'] = function ($plg_id) {};

// 2.0 is the version for Kleeja 4. The developer and the description that the old versions were installed with,
// the list of plugins shows them while the plugin is disabled.
// The query is a direct one: the core helpers run hooks, and the plugins are still loading.
// $kleeja_plugin isn't a global, Kleeja includes this file in a method, so the closure takes the information above with it
$kleeja_plugin['language_switch']['update'] = function ($old_version, $new_version) use ($kleeja_plugin) {
    global $SQL, $dbprefix;

    if (version_compare($old_version, '2.0', '<')) {
        $SQL->build([
            'UPDATE' => "{$dbprefix}plugins",
            'SET' => 'plg_author = :author, plg_dsc = :description',
            'WHERE' => 'plg_name = :name',
            'BIND' => [
                'author' => 'Kleeja.net',
                'description' => kleeja_html_encode(
                    $kleeja_plugin['language_switch']['information']['plugin_description']['en'],
                ),
                'name' => 'language_switch',
            ],
        ]);
    }
};

// Plugin Uninstallation, function to be called at unistalling.
// The plugin keeps nothing on the server. The choices stay in the cookies of the visitors, and Kleeja ignores them
$kleeja_plugin['language_switch']['uninstall'] = function ($plg_id) {};

// Plugin functions
$kleeja_plugin['language_switch']['functions'] = [
    // the language of the page: the one in ?lang= of the address, which is saved for the next pages,
    // or the one that was saved before. The configs of the group are merged already, and Kleeja loads
    // the words of $config['language'] after this hook, so the words and the direction of the page follow it
    'boot_common' => function ($args) {
        $languages = language_switch_get_languages();
        $chosen = ig('lang') ? (string) g('lang') : '';

        if (in_array($chosen, $languages, true)) {
            cookie()->set(LANGUAGE_SWITCH_COOKIE, $chosen, time() + LANGUAGE_SWITCH_DAYS * 86400);
        } else {
            $chosen = (string) cookie()->get(LANGUAGE_SWITCH_COOKIE);
        }

        // the choice of a language that was removed since, or nothing chosen: the language of the group
        if (!in_array($chosen, $languages, true)) {
            return;
        }

        // Kleeja copies the returned config to the page only after the last plugin of this hook,
        // and the plugins after this one read the global before that, so it is changed at once too
        global $config;
        $config['language'] = $chosen;

        $config_of_page = $args['config'];
        $config_of_page['language'] = $chosen;

        return ['config' => $config_of_page];
    },

    // the menu of the languages, in the navigation bar of the bootstrap style and of the styles built on it,
    // next to the menu of the color mode, and in a thin bar above the page in the other styles
    'Saaheader_func' => function ($args) {
        global $config, $lang;

        $languages = language_switch_get_languages();

        // nothing to switch to, or a page that the dragdrop style shows inside another site, without its menus
        if (count($languages) < 2 || ig('embedded')) {
            return;
        }

        $header = $args['header'];
        $label = htmlspecialchars($lang['LANGUAGE'] ?? 'Language');
        $menu = language_switch_menu($languages, $config['language'], $label);
        $added = 0;

        // before the item of the color mode and the comment above it, at the same indentation
        $header = preg_replace_callback(
            '/^([ \t]*)(?:<!--[^>]*-->\s*)?<li\b[^>]*>(?=\s*<button\b[^>]*\bid="colorModeToggle")/im',
            fn($match) => preg_replace('/^/m', $match[1], $menu) . "\n" . $match[0],
            $header,
            1,
            $added,
        );

        if (!$added) {
            $header = language_switch_add_bar($header, $languages, $config['language'], $label);
        }

        return compact('header');
    },

    // the guide of the plugin on the help page of the control panel, its words are in language/help_{code}.php
    'admin_help_guides' => function ($args) {
        $help_guides = $args['help_guides'];
        $words = language_switch_help_words();

        // the name of the plugin is the key, so Kleeja knows that the plugin has its guide, and shows its icon.
        // The plugin has no page, the guide links to Users & Groups, where the language of each group is set
        $help_guides['language_switch'] = [
            'group' => 'plugins',
            'title' => $words['LANGUAGE_SWITCH_HELP_TITLE'],
            'intro' => $words['LANGUAGE_SWITCH_HELP_INTRO'],
            'link' => './?cp=g_users',
            'link_title' => $words['LANGUAGE_SWITCH_HELP_LINK'],
            // tips and warnings are shown beside the others on wide screens
            'sections' => [
                language_switch_help_section($words, 'features', 'FEATURE'),
                language_switch_help_section($words, 'steps', 'STEP'),
                language_switch_help_section($words, 'faq', 'FAQ'),
                language_switch_help_section($words, 'tips', 'TIP'),
                language_switch_help_section($words, 'warnings', 'WARNING'),
            ],
        ];

        if (isset($help_guides['users'])) {
            $help_guides['users']['sections'][] = ['type' => 'text', 'text' => $words['LANGUAGE_SWITCH_HELP_NOTE']];
        }

        return compact('help_guides');
    },
];

/**
 * special functions
 */

if (!function_exists('language_switch_get_languages')) {
    // the cookie of the choice, Kleeja adds its cookie name before it. Versions 1.x used the same one
    define('LANGUAGE_SWITCH_COOKIE', 'sllang');
    // the days that a choice is remembered
    define('LANGUAGE_SWITCH_DAYS', 30);

    /**
     * the installed languages, the folders of lang/ that have the common words of Kleeja.
     * Their names go in addresses and in pages as they are, so a name can only have letters, digits, - and _
     * @return array
     */
    function language_switch_get_languages()
    {
        static $languages = null;

        if ($languages === null) {
            $languages = [];

            foreach ((array) @scandir(PATH . 'lang') as $folder) {
                if (
                    preg_match('/^[a-z0-9_-]+$/i', (string) $folder) &&
                    is_file(PATH . 'lang/' . $folder . '/common.php')
                ) {
                    $languages[] = $folder;
                }
            }
        }

        return $languages;
    }

    /**
     * the name of a language in that language, so a visitor finds theirs whatever the language of the page.
     * The languages that come with Kleeja are known, the others are named by the intl extension of PHP,
     * when the server has it, or by their code
     * @param  string $code the folder of the language
     * @return string
     */
    function language_switch_name($code)
    {
        $names = ['ar' => 'العربية', 'en' => 'English'];

        if (isset($names[$code])) {
            return $names[$code];
        }

        if (class_exists('Locale')) {
            $name = (string) Locale::getDisplayLanguage($code, $code);

            // intl gives the code back for a language that it doesn't know
            if ($name !== '' && strcasecmp($name, $code) !== 0) {
                return function_exists('mb_strtoupper')
                    ? mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1)
                    : ucfirst($name);
            }
        }

        return strtoupper($code);
    }

    /**
     * the link and the content of a language in the menu: its flag, when its folder has one, and its name.
     * The links go to the home page, a page that did something (a deleted file, a sign-out) isn't done again
     * @param  string $code    the folder of the language
     * @param  string $current the language of the page
     * @param  string $class   the classes of the link
     * @return string
     */
    function language_switch_link($code, $current, $class = '')
    {
        global $config;

        $icon = is_file(PATH . 'lang/' . $code . '/icon_16.png')
            ? '<img src="' . $config['siteurl'] . 'lang/' . $code . '/icon_16.png" width="16" height="16" alt="">'
            : '';

        return sprintf(
            '<a href="%s?lang=%s" lang="%s" hreflang="%s"%s%s>%s<span>%s</span></a>',
            $config['siteurl'],
            $code,
            $code,
            $code,
            $class === '' ? '' : ' class="' . $class . '"',
            $code == $current ? ' aria-current="true"' : '',
            $icon,
            htmlspecialchars(language_switch_name($code)),
        );
    }

    /**
     * the menu in the navigation bar of the bootstrap style, built like the menu of the color mode beside it
     * @param  array  $languages
     * @param  string $current   the language of the page
     * @param  string $label     the word "Language", ready for HTML
     * @return string
     */
    function language_switch_menu($languages, $current, $label)
    {
        $items = '';

        foreach ($languages as $code) {
            $class = 'dropdown-item d-flex align-items-center gap-2' . ($code == $current ? ' active' : '');
            $items .= "\n        <li>" . language_switch_link($code, $current, $class) . '</li>';
        }

        return <<<HTML
        <!-- language switch -->
        <li class="nav-item dropdown">
            <button type="button" class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="languageSwitchToggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{$label}" title="{$label}">
                <i class="fa-solid fa-language fa-fw" aria-hidden="true"></i>
                <span class="d-xl-none">{$label}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageSwitchToggle">{$items}
            </ul>
        </li>
        HTML;
    }

    /**
     * the bar of the languages above the page, for the styles that have no navigation bar of bootstrap.
     * It takes the font and the colors of the style, and follows the direction of the page
     * @param  string $header    the header of the page
     * @param  array  $languages
     * @param  string $current   the language of the page
     * @param  string $label     the word "Language", ready for HTML
     * @return string
     */
    function language_switch_add_bar($header, $languages, $current, $label)
    {
        $links = '';

        foreach ($languages as $code) {
            $links .= language_switch_link($code, $current) . "\n";
        }

        $style = <<<'CSS'
        <style>
            .language-switch { padding: 4px 16px; font-size: 13px; line-height: 1.5; background: rgba(128, 128, 128, .12); }
            .language-switch-links { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 4px 16px; max-width: 1200px; margin: 0 auto; }
            .language-switch a { display: inline-flex; align-items: center; gap: 6px; color: inherit; text-decoration: none; opacity: .75; }
            .language-switch a:hover, .language-switch a:focus-visible, .language-switch a[aria-current] { opacity: 1; }
            .language-switch a:hover, .language-switch a:focus-visible { text-decoration: underline; }
            .language-switch a[aria-current] { font-weight: 600; }
            .language-switch img { display: block; width: 16px; height: 16px; }
        </style>

        CSS;

        $bar =
            "\n<!-- language switch -->\n" .
            '<nav class="language-switch" aria-label="' .
            $label .
            '"><div class="language-switch-links">' .
            "\n" .
            $links .
            "</div></nav>\n<!-- language switch end -->";

        // the style goes in the head, or with the bar when the page has no head
        $head = stripos($header, '</head>');

        if ($head !== false) {
            $header = substr_replace($header, $style, $head, 0);
        } else {
            $bar = $style . $bar;
        }

        return preg_replace_callback('/<body\b[^>]*>/i', fn($match) => $match[0] . $bar, $header, 1);
    }

    /**
     * the words of the guide on the help page, in the language of the admin,
     * a word that the translation misses is shown in English
     * @return array
     */
    function language_switch_help_words()
    {
        global $config;

        $words = (array) require __DIR__ . '/language/help_en.php';
        $language = preg_replace('/[^a-z0-9_-]/i', '', (string) ($config['language'] ?? ''));
        $translation = __DIR__ . "/language/help_{$language}.php";

        if ($language !== '' && $language !== 'en' && file_exists($translation)) {
            // in its own line, Prettier drops the brackets of (require $translation) + $words
            $translated = require $translation;
            $words = (array) $translated + $words;
        }

        return $words;
    }

    /**
     * a section of the guide from its numbered words, like LANGUAGE_SWITCH_HELP_TIP_1, LANGUAGE_SWITCH_HELP_TIP_2 ..
     * its title, when it has its own, is LANGUAGE_SWITCH_HELP_TIP_TITLE
     * @param  array  $words
     * @param  string $type  how Kleeja shows it: features, steps, tips, warnings or faq
     * @param  string $name  the name of its words, LANGUAGE_SWITCH_HELP_{name}_1
     * @return array
     */
    function language_switch_help_section($words, $type, $name)
    {
        $prefix = 'LANGUAGE_SWITCH_HELP_' . $name;
        $section = ['type' => $type, 'title' => $words[$prefix . '_TITLE'] ?? '', 'items' => []];

        for ($n = 1; isset($words[$prefix . ($type == 'faq' ? '_Q_' : '_') . $n]); $n++) {
            $section['items'][] =
                $type == 'faq'
                    ? ['q' => $words[$prefix . '_Q_' . $n], 'a' => $words[$prefix . '_A_' . $n] ?? '']
                    : $words[$prefix . '_' . $n];
        }

        return $section;
    }
}
