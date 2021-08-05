<?php


namespace Grimm;

/**
 * @property string entry
 */
trait TextWithLetterLinks
{
    public function text($linkToFrontend = false): string
    {
        $urlBuilder = $linkToFrontend ? fn($letterId) => route('frontend') . "#/letters/$letterId"
            : fn($letterId) => route('letters.show', ['letter' => $letterId]);

        return preg_replace_callback(
            '/#([A-Z0-9]{3,})#/',
            fn($m) => '[<a href="' . $urlBuilder($m[1]) . '">Brief #' . $m[1] . '</a>]',
            $this->entry
        );
    }
}