<?php
class M_keys extends CI_Model{
	protected $methods = [
            'index_put' => ['level' => 10, 'limit' => 10],
            'index_delete' => ['level' => 10],
            'level_post' => ['level' => 10],
            'regenerate_post' => ['level' => 10],
        ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert a key into the database
     *
     * @access public
     * @return void
     */
    public function insert_key($level = 1,$ignore_limits = 1)
    {
        // Build a new key
        $key = $this->_generate_key();

        // If no key level provided, provide a generic key

        // Insert the new key
        if ($this->_insert_key($key, ['level' => $level, 'ignore_limits' => $ignore_limits]))
        {
            return json_encode(array('status' => TRUE,'key' => $key));
        }
        else
        {
            return json_encode(array('status' => FALSE,'message' => 'Could not save the key'));;
        }
    }

    /**
     * Remove a key from the database to stop it working
     *
     * @access public
     * @return void
     */
    public function delete_key($key)
    {

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            return json_encode(array('status' => FALSE,'message' => 'Invalid API key'));
        }

        // Destroy it
        $this->_delete_key($key);

        // Respond that the key was destroyed
        return json_encode(array('status' => TRUE,'message' => 'API key was deleted'));
    }

    /**
     * Change the level
     *
     * @access public
     * @return void
     */
    public function update_level($key, $new_level)
    {

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            return json_encode(array('status' => FALSE,'message' => 'Invalid API key'));
        }

        // Update the key level
        if ($this->_update_key($key, ['level' => $new_level]))
        {
            return json_encode(array('status' => TRUE,'message' => 'API key was updated'));
        }
        else
        {
            return json_encode(array('status' => FALSE,'message' => 'Could not update the key level'));
        }
    }

    /**
     * Suspend a key
     *
     * @access public
     * @return void
     */
    public function suspend_key($key)
    {

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            return json_encode(array('status' => FALSE,'message' => 'Invalid API key'));
        }

        // Update the key level
        if ($this->_update_key($key, ['level' => 0]))
        {
            return json_encode(array('status' => TRUE,'message' => 'API key was suspended'));
        }
        else
        {
        	return json_encode(array('status' => FALSE,'message' => 'Could not suspend the user'));
        }
    }

    /**
     * Regenerate a key
     *
     * @access public
     * @return void
     */
    public function regenerate_key($old_key)
    {
        $key_details = $this->_get_key($old_key);

        // Does this key exist?
        if (!$key_details)
        {
            // It doesn't appear the key exists
            return json_encode(array('status' => FALSE,'message' => 'Invalid API key'));
        }

        // Build a new key
        $new_key = $this->_generate_key();

        // Insert the new key
        if ($this->_insert_key($new_key, ['level' => $key_details->level, 'ignore_limits' => $key_details->ignore_limits]))
        {
            // Suspend old key
            $this->_update_key($old_key, ['level' => 0]);

            return json_encode(array('status' => TRUE,'key' => $new_key));
        }
        else
        {
        	return json_encode(array('status' => FALSE,'message' => 'Could not save the key'));
        }
    }

    /* Helper Methods */

    private function _generate_key()
    {
        do
        {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE)
            {
                $salt = hash('sha256', time() . mt_rand());
            }

            $new_key = substr($salt, 0, 40);
        }
        while ($this->_key_exists($new_key));

        return $new_key;
    }

    private function _get_key($key)
    {
        return $this->db
            ->where('key', $key)
            ->get('keys')
            ->row();
    }

    private function _key_exists($key)
    {
        return $this->db
            ->where('key', $key)
            ->count_all_results('keys') > 0;
    }

    private function _insert_key($key, $data)
    {
        $data['key'] = $key;
        $data['date_created'] = function_exists('now') ? now() : time();

        return $this->db
            ->set($data)
            ->insert('keys');
    }

    private function _update_key($key, $data)
    {
        return $this->db
            ->where('key', $key)
            ->update('keys', $data);
    }

    private function _delete_key($key)
    {
        return $this->db
            ->where('key', $key)
            ->delete('keys');
    }
		
}
?>