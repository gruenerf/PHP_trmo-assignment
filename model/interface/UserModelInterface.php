<?php

interface UserModelInterface extends BaseModelInterface
{
	public function getName();

	public function setName($name);

	public function getPassword();

	public function setPassword($password);

	public function getRole();

	public function setRole($role);
}