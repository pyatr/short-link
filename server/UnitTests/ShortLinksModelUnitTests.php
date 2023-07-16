<?php

namespace Server;

use Server\ShortLinksModel;

class ShortLinksModelUnitTests
{
    public function __construct()
    {
        $this->testLinkInsertion();
        $this->testLinkUpdate();
        $this->testLinkDelete();
    }

    public function testLinkInsertion()
    {
        $shortLinksModel = new ShortLinksModel();
        $testLink = 'https://google.com';
        $shortLinksModel->addNewLink($testLink, 'awtdvjkx');
        if (!$shortLinksModel->doesLinkExist($testLink)) {
            echo 'Failed to add link</br>';
        }
    }

    public function testLinkUpdate()
    {
        $shortLinksModel = new ShortLinksModel();
        $testLink = 'https://google.com';
        if (!$shortLinksModel->doesLinkExist($testLink)) {
            echo 'Link does not exist</br>';
        }
        $newShortLink = '45676890';
        $shortLinksModel->updateLink($testLink, $newShortLink);
        if ($shortLinksModel->getShortLink($testLink) != $newShortLink) {
            echo "Failed to update link $testLink</br>";
        }
    }

    public function testLinkDelete()
    {
        $shortLinksModel = new ShortLinksModel();
        $testLink = 'https://google.com';
        if (!$shortLinksModel->doesLinkExist($testLink)) {
            echo 'Link does not exist</br>';
        }
        $shortLink = $shortLinksModel->getShortLink($testLink);
        $shortLinksModel->deleteLink($shortLink);
        if ($shortLinksModel->getShortLink($testLink) != '') {;
            echo "Failed to update link $testLink</br>";
        }
    }
}