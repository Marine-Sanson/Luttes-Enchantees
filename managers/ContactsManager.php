<?php

class ContactsManager extends AbstractManager
{
      public function createNewContact(string $mail, string $object, string $content) : void
      {
            $query = $this->db->prepare('INSERT INTO contacts (mail, object, content)
		VALUES (:mail, :object, :content)');
		$parameters = [
			'mail' => $mail,
			'object' => $object,
			'content' => $content
			];
		$query->execute($parameters);
      }
}