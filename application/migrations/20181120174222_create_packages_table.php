<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_packages_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '300'         
                        ),
                        'destination_id' => array(
                                'type' => 'INT',
                                'constraint' => '100'         
                        ),
                        'is_day_tour' => array(
                                'type' => 'INT',
                                'constraint' => '1',
                                'default' => 0         
                        ),
                        'package_tour_id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'default' => 0         
                        ),
                        'minimum_count' => array(
                                'type' => 'INT',
                                'constraint' => '3',
                                'default' => 1      
                        ),
                        'image_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => true
                        ),
                        'rate' => array(
                                'type' => 'DOUBLE'
                        ),
                        'is_featured' => array(
                                'type' => 'boolean',
                                'default' => false,
                        ),
                        'status' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => 'active'       
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('packages',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('packages');
        }
}