<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_package_itineraries_Table extends CI_Migration {

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
                        'title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '300'         
                        ),
                        'time' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => true
                        ),
                        'description' => array(
                                'type' => 'LONGTEXT'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('package_itineraries',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('package_itineraries');
        }
}