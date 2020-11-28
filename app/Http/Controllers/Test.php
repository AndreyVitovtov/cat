<?php

namespace App\Http\Controllers;

use App\models\ParserTelegram;
use App\models\ParserViber;

class Test extends Controller {
    public function index() {
        $parser = new ParserViber('https://invite.viber.com/?g2=AQABm0lluH6iC0qUcSvMoPTt6s08Oqkq8%2Fsfz33JIuf9bshZn2xiSH20MzTViMF0');
        return "<img src='".$parser->getAvatar()."'><br>".$parser->getName();

    }
}
