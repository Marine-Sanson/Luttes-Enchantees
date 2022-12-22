<?php

Class UserManager extends AbstractManager
{
      public function connectAdmin(string $email) : array
      {
            $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
		$parameters = [
			'email' => $email
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$user = $result[0];
		
		return $user;
      }

      public function getAllUsersId() : array
      {
            $query = $this->db->prepare('SELECT id FROM users');
		$query->execute();
		$usersId = $query->fetchAll(PDO::FETCH_ASSOC);

		return $usersId;
      }

	public function getAllUsers() : array
	{
		$query = $this->db->prepare('SELECT * FROM users ORDER BY name');
		$query->execute();
		$users = $query->fetchAll(PDO::FETCH_ASSOC);

		return $users;
	}
}