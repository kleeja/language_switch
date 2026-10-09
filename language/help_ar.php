<?php
//
// language_switch, its guide on the help page of the control panel
// Arabic
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
// The keys are the ones of help_en.php, a key that is missing here is shown in English.
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/ar/
//  - a <code> that begins or ends with a symbol has dir="ltr", or the symbol moves to the other side
//

return [
    'LANGUAGE_SWITCH_HELP_TITLE' => 'مبدّل اللغة',
    'LANGUAGE_SWITCH_HELP_INTRO' =>
        'دع زوارك يختارون لغة موقعك. تضيف الإضافة قائمة «اللغة» إلى أعلى كل صفحة، تضم كل لغة مثبّتة في كليجا، وتحفظ اختيار كل زائر لمدة 30 يومًا.',
    'LANGUAGE_SWITCH_HELP_LINK' => 'لغات المجموعات',

    //
    // what the plugin does
    //
    'LANGUAGE_SWITCH_HELP_FEATURE_1' =>
        'تعرض كل لغة موجودة في مجلد <code>lang</code> في كليجا، وكل لغة باسمها في لغتها، مثل العربية أو English. وتظهر في القائمة تلقائيًا أي لغة تضيفها لاحقًا.',
    'LANGUAGE_SWITCH_HELP_FEATURE_2' =>
        'في ستايل Bootstrap والستايلات المبنية عليه، تظهر القائمة في شريط التنقل بجانب قائمة <strong>وضع الألوان</strong>. أما الستايلات الأخرى فتعرض اللغات في شريط رفيع أعلى الصفحة.',
    'LANGUAGE_SWITCH_HELP_FEATURE_3' =>
        'تحفظ الاختيار في الكوكيز، فتظهر كل صفحة يفتحها الزائر بعد ذلك بتلك اللغة، ومن اليمين إلى اليسار في العربية.',
    'LANGUAGE_SWITCH_HELP_FEATURE_4' => 'يرى الزائر الذي لم يختر لغة لغةَ مجموعته، كما لو لم تكن الإضافة مثبّتة.',

    //
    // how to add a language
    //
    'LANGUAGE_SWITCH_HELP_STEP_TITLE' => 'إضافة لغة',
    'LANGUAGE_SWITCH_HELP_STEP_1' => 'احصل على حزمة اللغة، وهي مجلد يحمل رمز اللغة، مثل <code>fr</code> للفرنسية.',
    'LANGUAGE_SWITCH_HELP_STEP_2' =>
        'ارفع المجلد إلى مجلد <code>lang</code> في كليجا، فيصبح في هذا المثال <code dir="ltr">lang/fr/</code>. ويجب أن يحتوي على الملف <code>common.php</code>.',
    'LANGUAGE_SWITCH_HELP_STEP_3' => 'افتح أي صفحة من موقعك، وستجد اللغة الجديدة في القائمة.',
    'LANGUAGE_SWITCH_HELP_STEP_4' =>
        'لتجعلها اللغة التي يراها الزوار أولًا، اجعلها لغة مجموعة الزوار، عبر <strong>تعديل البيانات</strong> في <strong>الأعضاء والمجموعات</strong>، أو عبر <strong>إعدادات سريعة</strong> في <strong>بداية لوحة كليجا</strong>.',

    //
    // common questions
    //
    'LANGUAGE_SWITCH_HELP_FAQ_Q_1' => 'لا تظهر القائمة في موقعي، فما السبب؟',
    'LANGUAGE_SWITCH_HELP_FAQ_A_1' =>
        'لا تظهر القائمة إلا عند تثبيت لغتين على الأقل، ويجب أن يحتوي مجلد كل لغة على الملف <code>common.php</code>. وتأكد كذلك من أن الإضافة مفعّلة في <strong>إضافات برمجية</strong>.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_2' => 'هل يغيّر الاختيار لغة لوحة التحكم أيضًا؟',
    'LANGUAGE_SWITCH_HELP_FAQ_A_2' =>
        'نعم. يسري الاختيار على كل صفحة يعرضها كليجا في ذلك المتصفح، ومنها لوحة التحكم. ولاستخدام لوحة التحكم بلغة أخرى، اختر تلك اللغة من القائمة في موقعك.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_3' => 'هل أستطيع وضع رابط لموقعي بلغة محددة؟',
    'LANGUAGE_SWITCH_HELP_FAQ_A_3' =>
        'نعم. أضف <code dir="ltr">lang=</code> ورمز اللغة إلى أحد عناوين موقعك، مثل <code dir="ltr">https://example.com/?lang=ar</code>. ويحتفظ الزائر الذي يتبع الرابط بتلك اللغة، كما لو اختارها من القائمة.',
    'LANGUAGE_SWITCH_HELP_FAQ_Q_4' => 'ماذا يحدث عند حذف الإضافة؟',
    'LANGUAGE_SWITCH_HELP_FAQ_A_4' =>
        'تختفي القائمة، ويعود كل زائر إلى رؤية لغة مجموعته. ولا تحتفظ الإضافة بأي بيانات على خادمك.',

    //
    // beside the guide
    //
    'LANGUAGE_SWITCH_HELP_TIP_1' =>
        'النصوص التي تكتبها بنفسك في <strong>شروط الخدمة</strong> و<strong>هيدر وفوتر إضافي</strong> لا تُترجم. إن كان زوارك يتحدثون عدة لغات، فاكتبها بكل منها.',
    'LANGUAGE_SWITCH_HELP_TIP_2' =>
        'يأتي كليجا بالعربية والإنجليزية. وقبل أن تتيح لغة أخرى، تأكد من أن حزمتها مكتملة ومخصصة لإصدار كليجا الذي تستخدمه.',

    'LANGUAGE_SWITCH_HELP_WARNING_1' =>
        'يُعرض على زوارك كل مجلد في <code>lang</code> يحتوي على <code>common.php</code>. احذف مجلدات اللغات الناقصة أو التي لم تعد تستخدمها، وإلا رأى الزوار صفحات تنقصها بعض الكلمات.',
    'LANGUAGE_SWITCH_HELP_WARNING_2' =>
        'حزمة اللغة شيفرة PHP تعمل في كل صفحة تُعرض بتلك اللغة، فلا تثبّت إلا الحزم القادمة من مصادر تثق بها.',

    //
    // in the guide of Users & Groups, where the language of each group is set
    //
    'LANGUAGE_SWITCH_HELP_NOTE' =>
        'تتيح إضافة <strong>مبدّل اللغة</strong> للزوار اختيار لغة غير لغة مجموعتهم. <a href="#help-language_switch">اقرأ دليلها</a>.',
];
