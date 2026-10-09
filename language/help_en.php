<?php
//
// language_switch, its guide on the help page of the control panel
// English
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
//  - a list is numbered: LANGUAGE_SWITCH_HELP_TIP_1, LANGUAGE_SWITCH_HELP_TIP_2 ... it ends at the first missing number,
//    so an item can be added or removed without touching the code
//  - LANGUAGE_SWITCH_HELP_{LIST}_TITLE is the title of the list, a list without it takes the title that Kleeja gives its type
//  - questions and answers are LANGUAGE_SWITCH_HELP_FAQ_Q_1 and LANGUAGE_SWITCH_HELP_FAQ_A_1
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/en/
//  - the 30 days are LANGUAGE_SWITCH_DAYS of init.php
//

return [
    'LANGUAGE_SWITCH_HELP_TITLE' => 'Language Switcher',
    'LANGUAGE_SWITCH_HELP_INTRO' =>
        'Let your visitors choose the language of your site. The plugin adds a Language menu to the top of every page, with every language installed in Kleeja, and remembers the choice of each visitor for 30 days.',
    'LANGUAGE_SWITCH_HELP_LINK' => 'Languages of the groups',

    //
    // what the plugin does
    //
    'LANGUAGE_SWITCH_HELP_FEATURE_1' =>
        'Lists every language in the <code>lang</code> folder of Kleeja, each under its own name, such as English or العربية. A language that you add later appears in the menu by itself.',
    'LANGUAGE_SWITCH_HELP_FEATURE_2' =>
        'In the Bootstrap style and the styles built on it, the menu sits in the navigation bar, next to the <strong>Color mode</strong> menu. Other styles show the languages in a thin bar above the page.',
    'LANGUAGE_SWITCH_HELP_FEATURE_3' =>
        'Saves the choice in a cookie, so every page that the visitor opens next is shown in that language, from right to left for Arabic.',
    'LANGUAGE_SWITCH_HELP_FEATURE_4' =>
        'A visitor who hasn\'t chosen a language sees the language of their group, as without the plugin.',

    //
    // how to add a language
    //
    'LANGUAGE_SWITCH_HELP_STEP_TITLE' => 'Add a language',
    'LANGUAGE_SWITCH_HELP_STEP_1' =>
        'Get the language pack: a folder named with the code of the language, such as <code>fr</code> for French.',
    'LANGUAGE_SWITCH_HELP_STEP_2' =>
        'Upload the folder into the <code>lang</code> folder of Kleeja, to <code>lang/fr/</code> in this example. It must contain the file <code>common.php</code>.',
    'LANGUAGE_SWITCH_HELP_STEP_3' => 'Open any page of your site. The new language is in the menu.',
    'LANGUAGE_SWITCH_HELP_STEP_4' =>
        'To make it the language that visitors see first, make it the language of the Guests group, with <strong>Edit data</strong> in <strong>Users & Groups</strong>, or with <strong>Quick Actions</strong> on the <strong>Dashboard</strong>.',

    //
    // common questions
    //
    'LANGUAGE_SWITCH_HELP_FAQ_Q_1' => 'The menu doesn\'t appear on my site. Why?',
    'LANGUAGE_SWITCH_HELP_FAQ_A_1' =>
        'The menu appears only when at least two languages are installed, and the folder of each one must contain <code>common.php</code>. Also check that the plugin is enabled in <strong>Plugins</strong>.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_2' => 'Does the choice change the language of the control panel too?',
    'LANGUAGE_SWITCH_HELP_FAQ_A_2' =>
        'Yes. The choice applies to every page that Kleeja shows in that browser, the control panel included. To use the control panel in another language, choose that language from the menu on your site.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_3' => 'Can I link to my site in a given language?',
    'LANGUAGE_SWITCH_HELP_FAQ_A_3' =>
        'Yes. Add <code>lang=</code> and the code of the language to an address of your site, such as <code>https://example.com/?lang=ar</code>. A visitor who follows the link keeps that language, as if they had chosen it from the menu.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_4' => 'What happens when I delete the plugin?',
    'LANGUAGE_SWITCH_HELP_FAQ_A_4' =>
        'The menu disappears, and every visitor sees the language of their group again. The plugin keeps nothing on your server.',

    //
    // beside the guide
    //
    'LANGUAGE_SWITCH_HELP_TIP_1' =>
        'The texts that you write yourself, in <strong>Terms</strong> and <strong>Extra Templates</strong>, aren\'t translated. If your visitors speak several languages, write them in each of them.',
    'LANGUAGE_SWITCH_HELP_TIP_2' =>
        'Kleeja comes in English and Arabic. Before you offer another language, check that its pack is complete and made for your version of Kleeja.',

    'LANGUAGE_SWITCH_HELP_WARNING_1' =>
        'Every folder in <code>lang</code> that contains <code>common.php</code> is offered to your visitors. Delete the folders of languages that are incomplete or that you no longer use, or visitors will see pages with missing words.',
    'LANGUAGE_SWITCH_HELP_WARNING_2' =>
        'A language pack is PHP code that runs on every page shown in that language. Install only packs from sources that you trust.',

    //
    // in the guide of Users & Groups, where the language of each group is set
    //
    'LANGUAGE_SWITCH_HELP_NOTE' =>
        'With the <strong>Language Switcher</strong> plugin, visitors can choose a language other than the one of their group. <a href="#help-language_switch">Read its guide</a>.',
];
