<?php

/*
 * Print man header
 */
$htpl = new Tpl("head", "home", ["title" => Lang::tr("home", __PLUGINS_DIR__."/home"), "description" => Lang::tr("a pretty basic homepage.", __PLUGINS_DIR__."/home")]);
$htpl->out();

/*
 * Print alternatives (languages)
 */
$translations = ["de", "en"];
if(count($translations) > 1) {
    foreach($translations as $lang) {
        if ($lang != $_SESSION['language']) {
            $atpl = new Tpl("alternatives", "home");
            $atpl->set("lang", $lang);
            $atpl->set("href", Url::site("l:$lang"));
            $atpl->out();
        }
    }
}
