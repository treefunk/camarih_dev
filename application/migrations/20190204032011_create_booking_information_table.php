<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_booking_information_Table extends CI_Migration {
        public function up()
        {
//             fullname: (string) "TEST"
// email: (string) "TEST@GMAIL.COM"
// phone: (string) "123"
// pickup_location: (string) "TEST"
// drop_location: (string) "DROP"
// flight_info: (string) "FLIGHT"
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'cart_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        // 'fullname' => array(
                        //     'type' => 'VARCHAR',
                        //     'constraint' => '255',
                        //     'null' => TRUE
                        // ),
                        // 'email' => array(
                        //     'type' => 'VARCHAR',
                        //     'constraint' => '255',
                        //     'null' => TRUE
                        // ),
                        // 'phone' => array(
                        //     'type' => 'VARCHAR',
                        //     'constraint' => '255',
                        //     'null' => TRUE
                        // ),
                        'pickup_location' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'drop_location' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'flight_info' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('booking_information');
        }

        public function down()
        {
                $this->dbforge->drop_table('booking_information');
        }
}