<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_sliders_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'image_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'header' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '500',
                        ),
                        'sub_header' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'button_text_first' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'button_link_first' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'button_text_second' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'button_link_second' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'is_featured' => array(
                                'type' => 'boolean',
                                'default' => false,
                        ),
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('sliders',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('sliders');
        }
}