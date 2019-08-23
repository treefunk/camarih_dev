<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tour_inquiries_Table extends CI_Migration {

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
                        'name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '300'         
                        ),
                        'mobile' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '300'         
                        ),
                        'email_address' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '300'         
                        ),
                        'status' => array(
                            'type' => 'INT',
                            'constraint' => '1',
                            'default' => 0
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('tour_inquiries',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('tour_inquiries');
        }
}