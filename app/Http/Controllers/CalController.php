<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalController extends Controller
{
    public function index(){

        print "<h1>".date("F")."</h1>";
        print "Today :" .date("Y/m/d");
        print "<br><table border=1><tr>";

        $arrayweeks = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
            foreach($arrayweeks as $value){
                print "<th>". $value . "</th>";
            }

        print "</tr>";


    }
}
