<?php

use EntryModel as Entry;
use TopicModel as Topic;
use UserModel as User;

class EntryRepository implements EntryRepositoryInterface
{
	/**
	 * static instance
	 */
	private static $entryRepository = null;


	/**
	 * Empty constructor for singleton
	 */
	public function __construct()
	{
	}

	/**
	 *  Singleton returns the one instance
	 */
	public static function getInstance()
	{
		if (self::$entryRepository == null) {
			self::$entryRepository = new EntryRepository();
		}

		return self::$entryRepository;
	}

	/**
	 * Creates a new Object and the reference to Topic
	 * @param $title
	 * @param $content
	 * @param UserModel $user
	 * @param TopicModel $topic
	 * @return $this|null
	 */
	public function create($title, $content, User $user, Topic $topic)
	{
		// Check if Entry already exists
		if (!$this->checkIfTitleExists($title)) {
			$entry = new Entry($title, $content, $user->getId(), $topic->getId());

			// Return saved entry
			return $entry->save();
		} else {
			return null;
		}
	}

	/**
	 * Updates an existing Object
	 * @param EntryModel $entry
	 * @return $this
	 */
	public function update(Entry $entry)
	{
		return $entry->save();
	}

	/**
	 * Deletes an Object
	 * @param EntryModel $entry
	 */
	public function delete(Entry $entry)
	{
		$entry->delete();
	}

	/**
	 * Checks if Title already exists
	 * @param $title
	 * @return bool
	 */
	public function checkIfTitleExists($title)
	{
		// Define query
		$sql = "SELECT * FROM entry WHERE title =:title";

		// Prepare database and execute Query
		$query = Database::getInstance()->prepare($sql);
		$query->execute(array(':title' => $title));
		$row = $query->fetch();

		if (!empty($row)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns an Object by the id
	 * @param $id
	 * @return EntryModel|null
	 */
	public function getById($id)
	{
		// Define query
		$sql = "SELECT * FROM entry WHERE id =:id";

		// Prepare database and execute Query
		$query = Database::getInstance()->prepare($sql);
		$query->execute(array(':id' => $id));
		$row = $query->fetch();

		if (!empty($row)) {
			return new Entry($row['title'], $row['content'], $row['user_id'], $row['topic_id'], $row['id']);
		} else {
			return null;
		}
	}

	/**
	 * Returns an array with all existing objects
	 * @return array|null
	 */
	public function getAll()
	{
		// Define query
		$sql = "SELECT * FROM entry";

		// Prepare database and execute Query
		$query = Database::getInstance()->prepare($sql);
		$query->execute();
		$rows = $query->fetchAll();

		if (!empty($rows)) {
			$objectArray = array();

			foreach ($rows as $row) {
				array_push($objectArray, new Entry($row['title'], $row['content'], $row['user_id'], $row['topic_id'], $row['id']));
			}

			return $objectArray;
		} else {
			return null;
		}
	}

	/**
	 * Returns Array of all Entries of certain Topic
	 * @param TopicModel $topic
	 * @return array|null
	 */
	public function getAllEntryByTopic(Topic $topic)
	{
		// Define query
		$sql = "SELECT * FROM enty WHERE topic_id= :topic_id";

		// Prepare database and execute Query
		$query = Database::getInstance()->prepare($sql);
		$query->execute(array(':topic_id' => $topic->getId()));
		$rows = $query->fetchAll();

		if (!empty($rows)) {
			$objectArray = array();

			foreach ($rows as $row) {
				array_push($objectArray, new Entry($row['title'], $row['content'], $row['user_id'], $row['topic_id'], $row['id']));
			}

			return $objectArray;
		} else {
			return null;
		}
	}

	/**
	 * Returns Array of all Entries of certain Topic
	 * @param UserModel $user
	 * @return array|null
	 */
	public function getAllEntryByUser(User $user)
	{
		// Define query
		$sql = "SELECT * FROM enty WHERE user_id= :user_id";

		// Prepare database and execute Query
		$query = Database::getInstance()->prepare($sql);
		$query->execute(array(':user_id' => $user->getId()));
		$rows = $query->fetchAll();

		if (!empty($rows)) {
			$objectArray = array();

			foreach ($rows as $row) {
				array_push($objectArray, new Entry($row['title'], $row['content'], $row['user_id'], $row['topic_id'], $row['id']));
			}

			return $objectArray;
		} else {
			return null;
		}
	}
} 