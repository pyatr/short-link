<?php

namespace Server;

class ShortLinksController
{
    public function addNewLink($data): string
    {
        $newLink = $data['url_to_shorten'];
        $shortLink = $this->generateShortLink($newLink);
        if ((new ShortLinksModel())->addNewLink($newLink, $shortLink)){
            return $shortLink;
        }
        return "failed";
    }

    public function updateLink($data): void
    {
        $longLink = $data['long_link'];
        $newShortLink = $this->generateShortLink($longLink);
        (new ShortLinksModel())->updateLink($longLink, $newShortLink);
    }

    public function deleteLink($data): void
    {
        $shortLink = $data['short_link'];
        (new ShortLinksModel())->deleteLink($shortLink);
    }

    public function getAllLinks(): array
    {
        return (new ShortLinksModel())->getAllLinks();
    }

    public function getShortLink($data): string
    {
        $longLink = $data['long_link'];
        return (new ShortLinksModel())->getShortLink($longLink);
    }

    public function getLongLink($data): string
    {
        $longLink = $data['short_link'];
        return (new ShortLinksModel())->getLongLink($longLink);
    }

    private function generateShortLink(string $longLink): string
    {
        return substr(md5($longLink . mt_rand()), 0, 8);
    }
}