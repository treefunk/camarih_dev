<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_vans_Table extends CI_Migration {

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
                        'image_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => true
                        ),
                        'description' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'seat_map' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '300'
                        ),
                        'num_of_vans' => array(
                            'type' => 'INT',
                            'null' => true,
                            'constraint' => '255'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('vans',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('vans');
        }
}