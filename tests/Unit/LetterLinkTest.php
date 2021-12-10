<?php

namespace Tests\Unit;

use Grimm\LetterApparatus;
use Grimm\LetterComment;
use Grimm\TextWithLetterLinks;
use Tests\TestCase;

class LetterLinkTest extends TestCase
{

    /** @test */
    public function it_can_find_links_and_convert_them()
    {
        /** @var TextWithLetterLinks $comment */
        $comment = new LetterComment();
        $comment->entry = 'Lesen Sie mehr in #001#';

        $url = route('letters.show', ['letter' => '001']);

        $this->assertEquals("Lesen Sie mehr in [<a href=\"$url\">Brief #001</a>]", $comment->text());

        /** @var TextWithLetterLinks $apparatus */
        $apparatus = new LetterApparatus();
        $apparatus->entry = '#101A# ist ein sehr spannender Brief';

        $url = route('letters.show', ['letter' => '101A']);

        $this->assertEquals("[<a href=\"$url\">Brief #101A</a>] ist ein sehr spannender Brief", $apparatus->text());
    }

    /** @test */
    public function it_can_create_links_for_frontend()
    {
        /** @var TextWithLetterLinks $apparatus */
        $apparatus = new LetterApparatus();
        $apparatus->entry = '#101A# ist ein sehr spannender Brief';

        $url = route('frontend') . "#/letters/101A";

        $this->assertEquals("[<a href=\"$url\">Brief #101A</a>] ist ein sehr spannender Brief", $apparatus->text(true));
    }
}
