<?php

use EntryModel as Entry;

interface EntryRepositoryInterface
{
	public function create($title, $content);

	public function update(Entry $entry);

	public function delete(Entry $entry);
}