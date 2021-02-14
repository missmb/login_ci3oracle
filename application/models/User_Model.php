<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{
    public function Ticket()
    {
        $query = " SELECT T.TICKET_ID, T.ENTER, T.EXIT, T.LICENSE_PLATE, T.STNK, S.NAME, P.TYPE, A.AREA, ST.STATUS
                        FROM TICKET  T
                    JOIN USER_SYS S ON T.USER_ENTER = S.ID_USER
                    JOIN TRANSPORT P ON T.TRANSPORT_ID = P.TRANSPORT_ID
                    JOIN PARKING_AREA A ON T.PARKING_ID = A.PARKING_ID 
                    JOIN PARKING_STATUS ST ON T.STATUS = ST.STATUS_ID
                    ORDER BY T.ENTER DESC
                        ";
        return $this->db->query($query)->result_array();
    }
}
