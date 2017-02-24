<?php
class PokemonGo_Bot
{
    public $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "root", "pokemongo_bot");
        if ($this->mysqli->connect_errno) {
            die("Connect Error : " . $this->mysqli->connect_error);
        }
    }

    function __destruct()
    {
        $this->mysqli->close();
    }

    function safe_string($str)
    {
        return $this->mysqli->real_escape_string($str);
    }

    function password_hash($pw)
    {
        for($i=0; $i<256; $i++)
            $pw = md5(md5("snowboard_h@ck_ggu|gam".$i . $this->safe_string($pw) . "fl*g_i@_fla+g|@!~" . $i));

        return $pw;
    }

    /*
     * LOGIN WEBSITE
     */
    function account_register($id, $pw, $ip)
    {
        $id = $this->safe_string($id);
        $pw = $this->password_hash($pw);
        $ip = $this->safe_string($ip);

        $query = "insert into account(id, pw, ip) values('$id', '$pw', '$ip');";
        return $this->mysqli->query($query);
    }

    function login($id, $pw)
    {
        $id = $this->safe_string($id);
        $pw = $this->password_hash($pw);

        $query = "select idx from account where id='$id' and pw='$pw'";
        $result = $this->mysqli->query($query);

        $flag = $result->num_rows == 1;
        $result->close();
        return $flag; // if selected one time success
    }

    /*
     * BOT WEBSITE
     */

    function get_idx($id)
    {
        $query = "select idx from account where id='$id'";
        $result = $this->mysqli->query($query);
        if($result->num_rows != 1) {
            $result->close();
            die("FAIL TO GETTING IDX");
        }

        $idx = $result->fetch_object()->idx;
        $result->close();
        return $idx;
    }

    function bot_account_register($idx, $email, $pw, $hash_key)
    {
        $email = $this->safe_string($email);
        $pw = base64_encode($pw);
        $hash_key = base64_encode($this->safe_string($hash_key));

        $query = "insert into bot_account(idx, email, pw, hashkey, config_flag) values($idx, '$email', '$pw', '$hash_key', false);";
        return $this->mysqli->query($query);
    }

    function is_exist_bot_account($idx)
    {
        $query = "select idx from bot_account where idx='$idx'";
        $result = $this->mysqli->query($query);
        $flag = $result->num_rows == 1;
        $result->close();
        return $flag;
    }

    function get_bot_email($idx)
    {
        $query = "select email from bot_account where idx='$idx'";
        $result = $this->mysqli->query($query);
        if($result->num_rows != 1) {
            $result->close();
            die("FAIL TO GETTING EMAIL");
        }

        $data = $result->fetch_object()->email;
        $result->close();
        return $data;
    }

    function get_bot_pw($idx)
    {
        $query = "select pw from bot_account where idx='$idx'";
        $result = $this->mysqli->query($query);
        if($result->num_rows != 1) {
            $result->close();
            die("FAIL TO GETTING EMAIL");
        }

        $data = base64_decode($result->fetch_object()->pw);
        $result->close();
        return $data;
    }

    function get_bot_hashkey($idx)
    {    
        $query = "select hashkey from bot_account where idx='$idx'";
        $result = $this->mysqli->query($query);
        if($result->num_rows != 1) {
            $result->close();
            die("FAIL TO GETTING HASHKEY");
        }

        $data = $result->fetch_object()->hashkey;
        $result->close();
        return base64_decode($data);
    }

    function get_bot_config_flag($idx)
    {
        $query = "select config_flag from bot_account where idx='$idx'";
        $result = $this->mysqli->query($query);
        if($result->num_rows != 1) {
            $result->close();
            return false;
        }

        $data = $result->fetch_object()->config_flag;
        $result->close();
        return $data; 
    }

    function set_bot_config_flag($idx)
    {
        $query = "update bot_account set config_flag = true where idx ='$idx'";
        $this->mysqli->query($query);
    }
}
?>
