<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_testimonials_Table extends CI_Migration {

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
                        'title' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'testimonial' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '500',
                        ),
                        'name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                        'occupation' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500',
                        ),
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('testimonials');
        }

        public function down()
        {
                $this->dbforge->drop_table('testimonials');
        }
}