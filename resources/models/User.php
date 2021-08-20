<?php 
    class User{

        public function __construct(int $Id, string $Nickname, string $Email) {
            $this->id = $Id;
            $this->nickname = $Nickname;
            $this->email = $Email;
        }

        public int $id = 0;
        public string $nickname = "";
        public string $email = "";
    }

?>