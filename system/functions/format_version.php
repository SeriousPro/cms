<?php
/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 22.03.2016
 * Time: 15:47
 */

/**
 * Function to format version numbers into a readable format.
 * @param $version int version number
 * @return string formatted version
 */
function format_version($version) {
    $major = floor($version / 1000000);
    $minor = floor($version / 10000 ) % 100;
    $revision = $version % 10000;

    /**
     * Formats the Revision.
     * @return string formatted revision
     */
    $rev = function () use ($revision) {
        $revision_beta = floor($revision / 100);
        $revision_alpha = $revision % 100;

        if($revision_alpha > 0) {
            return " ALPHA R$revision_alpha";
        } elseif ($revision_beta > 0) {
            return " BETA R$revision_beta";
        } else {
            return "";
        }
    };

    return "v".$major.".".($minor < 10 ? "0".$minor : $minor).$rev();
}