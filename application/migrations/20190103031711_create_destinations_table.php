<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_destinations_Table extends CI_Migration {

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
                            'type' => 'LONGTEXT'
                        ),
                        'short_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '100'
                        ),
                        'is_origin' => array(
                                'type' => 'TINYINT',
                                'constraint' => 3,
                                'default' => 0,
                                'comment' => '1 - true, 0 - false'
                        ),
                        'is_dropoff' => array(
                                'type' => 'TINYINT',
                                'constraint' => 3,
                                'default' => 0,
                                'comment' => '1 - true, 0 - false'
                        ),
                        'is_vanrental_origin' => array(
                                'type' => 'TINYINT',
                                'constraint' => 3,
                                'default' => 0,
                                'comment' => '1 - true, 0 - false'
                        ),
                        'is_vanrental_dropoff' => array(
                                'type' => 'TINYINT',
                                'constraint' => 3,
                                'default' => 0,
                                'comment' => '1 - true, 0 - false'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('destinations',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('destinations');
        }
}