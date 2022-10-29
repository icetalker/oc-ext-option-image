<?php
class ModelExtensionOtherOptionImageRadio extends Model {

    protected $table = "product_option_value";

	public function install() {
		$create_table = "ALTER TABLE `" . DB_PREFIX . $this->table . "` ADD COLUMN `option_image` varchar(255) DEFAULT NULL;";
		$this->db->query($create_table);
		
	}

	public function uninstall() {
		$drop_table = "ALTER TABLE `" . DB_PREFIX . $this->table . "` DROP COLUMN `option_image`;";
		$this->db->query($drop_table);
        $this->deleteData();
	}

    protected function deleteData() {

        $query_options = 'SELECT option_id from `' . DB_PREFIX . 'option` where type = image_radio';
		$query = $this->db->query($query_options);

        $option_ids = $query->rows['option_id'];
        if(!$option_ids)return;

        $options = '';
        foreach($option_ids as $id){
            $options .= $id . ',';
        }

        $this->db->query('DELETE from ' . DB_PREFIX . 'option` WHERE option_id IN(' . $options . ');');
        $this->db->query('DELETE from ' . DB_PREFIX . 'option_description` WHERE option_id IN(' . $options. ');');


        $this->db->query('DELETE from ' . DB_PREFIX . 'option_value` WHERE option_id IN(' . $options . ');');
        $this->db->query('DELETE from ' . DB_PREFIX . 'option_value` WHERE option_id IN(' . $options . ');');

        $this->db->query('DELETE from ' . DB_PREFIX . 'product_option` WHERE option_id IN(' . $options . ');');
        $this->db->query('DELETE from ' . DB_PREFIX . 'product_option_value` WHERE option_id IN(' . $options . ');');


    }


}