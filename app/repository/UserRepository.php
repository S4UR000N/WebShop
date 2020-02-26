<?php

// namespace
namespace app\repository;

// class
class UserRepository extends BaseRepository
{
    public function selectOneById($user_id) {
        $queryUser = $this->con->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
        $queryUser->execute([$user_id]);
        $user = $queryUser->fetchAll(\PDO::FETCH_ASSOC);
        return $user;
    }
	public function selectOneByName($user_name) {
        $query = $this->con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
        $query->execute([$user_name]);
        $query = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
	}
	public function selectOneByEmail($user_email)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE user_email = ? LIMIT 1");
        $query->execute([$user_email]);
        $query = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
	}
	public function changePassword($user_id, $user_change_password) {
        $original_pass = $this->con->prepare("SELECT users.user_password FROM users WHERE user_id = ?");
        $original_pass->execute([$user_id]);
        $original_pass = $original_pass->fetchAll(\PDO::FETCH_ASSOC);
        if(!password_verify($user_change_password, $original_pass[0]['user_password']))
        {
            $user_change_password = password_hash($user_change_password, PASSWORD_BCRYPT);
            $query = $this->con->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
            $query = $query->execute([$user_change_password, $user_id]);
            if($query) {
                return true;
            }
            return false;
        }
        return false;
	}
	public function saveUser(\app\model\UserModel $user) {
		$statement = $this->con->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (:user_name, :user_email, :user_password)");

		$user_name = $user->getUserName();
		$user_email = $user->getUserEmail();
		$user_password = $user->getUserPassword();

		$statement->bindParam(':user_name', $user_name);
		$statement->bindParam(':user_email', $user_email);
		$statement->bindParam(':user_password', $user_password);

		$statement->execute();
	}
	public function removeAccount($user_id) {
		$files = $this->con->query("SELECT * FROM files WHERE user_id = '$user_id'");
		$this->con->query("DELETE FROM files WHERE user_id = '$user_id'; DELETE FROM users WHERE user_id = '$user_id';");
		$result = $this->con->query("SELECT * FROM users WHERE user_id = '$user_id'")->fetch();
		if(!$result) {
			// Remove Files from File System
			foreach ($files as $file) { unlink("uploads/" . $_SESSION['user_id'] . $file['file_name']); }
			return true;
		}
		return false;
	}
}
