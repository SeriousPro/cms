<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 07.03.2016
 * Time: 13:56
 */

/**
 * Class Parse - Text Parser/Filter for Printing
 */
class Parse
{

    /**
     * @var array List of allowed HTML-Tags for Parse::html.
     */
    var $allowedHtmlTags = [
        "hr","br","div","p","span","b","strong","i","em","a",
        "h1","h2","h3","h4","h5","h6","mark","del","ins","sub","sup",
        "img","map","area","q","blockquote","cite","abbr","address","bdo",
        "code","pre","kbd","samp","var","ul","ol","li","dl","dt","dd",
        "table","th","tr","td","caption","colgroup","col","thead","tbody","tfoot"
    ];

    /**
     * Parse BBCode To HTML.
     * @param $input_string string - string containing bbcode
     * @return string parsed to html $input_string
     */
    static function bbcode($input_string) {
        return nl2br($input_string);
        // TODO: write some bbcode parser.
    }

    /**
     * Filter unwanted HTML-Tags.
     * @param $input_string string - html format text
     * @return string filtered html format text from $input_string
     */
    static function html($input_string) {
        return strip_tags($input_string, Parse::$allowedHtmlTags);
    }

    /**
     * Parse Markdown to HTML.
     * @param $input_string string - markdown text
     * @return string parsed tp html $input_string
     */
    static function markdown($input_string) {
        $pd = new Parsedown();
        return $pd->text($input_string);
    }

    /**
     * Parse Markdown to HTML (Alias for markdown).
     * @param $input_string string - markdown text
     * @return string parsed to html $input_string
     */
    static function md($input_string) {
        return Parse::Markdown($input_string);
    }

    /**
     * Parse to Plain Text (replace htmlentities).
     * @param $input_string string
     * @return string html to print content of $input_string as plain text
     */
    static function plain($input_string) {
        return htmlentities($input_string);
    }

    /**
     * Parse by name and file endings.
     * @param $input_string string - string to be parsed
     * @param $input_type string - file ending/type of $input_string
     * return string parsed string
     */
    static function parse($input_string, $input_type) {
        $input_type = mb_strtolower($input_type);
        if (in_array($input_type, ["html", "htm", "html5", "xhtml", "text/html"])) {
            return Parse::html($input_string);
        }
        if (in_array($input_type, ["bbcode", "bbc"])) {
            return Parse::bbcode($input_string);
        }
        if (in_array($input_type, ["markdown", "md", "mdtext"])) {
            return Parse::markdown($input_string);
        }
        if (in_array($input_type, ["plain", "txt", "log", "text", "ttxt", "utxt", "text/plain"])) {
            return Parse::plain($input_string);
        }
    }

}