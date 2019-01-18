<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_package_gallery_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'package_id' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE,
                        ),
                        'image_name' => array(
                            'type' => 'LONGTEXT'
                        ),
                        'image_title' => array(
                            'type' => 'LONGTEXT'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('package_gallery');
        }

        public function down()
        {
                $this->dbforge->drop_table('package_gallery');
        }
}