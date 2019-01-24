<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_seat_plan_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'cart_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE,
                        ),
                        'name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '500'
                        ),
                        'birth_date' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '200'
                        ),
                        'seat_num' => array(
                            'type' => 'INT',
                            'constraint' => '200'
                        ),
                        'discount' => array(
                            'type' => 'TINYINT',
                            'constraint' => '10',
                            'default' => 0
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('seat_plan');
        }

        public function down()
        {
                $this->dbforge->drop_table('seat_plan');
        }
}