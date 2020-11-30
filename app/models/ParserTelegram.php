<?php

namespace App\models;

class ParserTelegram {
    private $link;

    public function __construct($link) {
        $this->link = $link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function checkLink() {
        preg_match_all("/(https\:\/\/t\.me\/.+)/", $this->link, $matches);
        return isset($matches[1][0]) ? true : false;
    }

    public function getLink() {
        preg_match_all("/(https\:\/\/t\.me\/.+)/", $this->link, $matches);
        return isset($matches[1][0]) ? trim(trim($matches[1][0], '"')) : null;
    }

    private function getPage() {
        if(! $this->checkLink()) return null;
        return file_get_contents($this->link);
    }

    public function getName() {
        $page = $this->getPage();
        if(! $page) return null;
        preg_match_all("/dir=\"auto\">(.+)<\//", $page, $matches);
        return isset($matches[1][0]) ? trim(str_replace('</span>', '', $matches[1][0])) : null;
    }

    public function getAvatar() {
        $page = $this->getPage();
        if(! $page) return null;
        preg_match_all("/src=\"(.+)\"/", $page, $matches);
        return isset($matches[1][0]) ? trim($matches[1][0]) : null;
    }
}
