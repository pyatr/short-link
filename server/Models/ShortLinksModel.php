<?php

namespace Server;

class ShortLinksModel extends AbstractModel
{
    private string $longLinkEntry = 'long_link';
    private string $shortLinkEntry = 'short_link';
    private string $creationDateEntry = 'creation_date';

    public function __construct()
    {
        $this->tableName = 'short_links';
        parent:: __construct();
    }

    public function addNewLink(string $longLink, string $shortLink): bool
    {
        if (!$this->doesLinkExist($longLink)) {
            $this->insert([$this->longLinkEntry, $this->shortLinkEntry], [$longLink, $shortLink]);
            return true;
        }
        return false;
    }

    public function updateLink(string $longLink, string $newShortLink): void
    {
        $this->update([$this->shortLinkEntry], [$newShortLink], [$this->longLinkEntry, '=', "'$longLink'"]);
    }

    public function deleteLink(string $shortLink): void
    {
        $this->delete([$this->shortLinkEntry, '=', "'$shortLink'"]);
    }

    public function getAllLinks(): array
    {
        return $this->select();
    }

    public function doesLinkExist(string $longLink): bool
    {
        return count($this->select(['*'], [$this->longLinkEntry, '=', "'$longLink'"])) > 0;
    }

    public function getShortLink(string $longLink): string
    {
        return ($this->select([$this->shortLinkEntry], [$this->longLinkEntry, '=', "'$longLink'"]))[0][$this->longLinkEntry];
    }

    public function getLongLink(string $shortLink): string
    {
        return ($this->select([$this->longLinkEntry], [$this->shortLinkEntry, '=', "'$shortLink'"]))[0][$this->longLinkEntry];
    }
}